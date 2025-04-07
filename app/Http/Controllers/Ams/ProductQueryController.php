<?php

namespace App\Http\Controllers\Ams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductQueryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 50);

        $allProducts = DB::connection('mysql_second')
            ->table('products')
            ->leftJoin('categories', 'products.categories_id', '=', 'categories.id')
            ->leftJoin('majorcategories', 'categories.majorcategories_id', '=', 'majorcategories.id')
            ->select(
                'products.id',
                'products.product_name',
                'products.item_no',
                'products.price',
                'products.enabled as web_enabled',
                'products.inv_orange',
                'products.img_small',
                'categories.cat_name as category_name',
                'categories.id as category_id',
                'majorcategories.cat_name as major_category_name'
            )
            ->when($search, fn ($q) => $q->where('products.product_name', 'like', "%{$search}%"))
            ->orderBy('majorcategories.cat_name')
            ->orderBy('categories.cat_name')
            ->orderBy('products.product_name')
            ->get();

        $grouped = [];

        foreach ($allProducts as $product) {
            $major = $product->major_category_name ?: 'No Major Category';
            $cat = $product->category_name ?: 'Uncategorized';
            $catId = $product->category_id;

            if (!isset($grouped[$major][$cat])) {
                $grouped[$major][$cat] = [
                    'category_id' => $catId,
                    'products' => [],
                ];
            }

            $grouped[$major][$cat]['products'][] = $product;
        }

        // Paginate each category's products
        foreach ($grouped as $major => &$categories) {
            foreach ($categories as $catName => &$catGroup) {
                $pageKey = 'page_' . $catGroup['category_id'];
                $page = request()->input($pageKey, 1);
                $collection = collect($catGroup['products']);
                $paginator = new LengthAwarePaginator(
                    $collection->forPage($page, $perPage),
                    $collection->count(),
                    $perPage,
                    $page,
                    ['pageName' => $pageKey]
                );
                $catGroup['paginator'] = $paginator;
            }
        }

        return view('ams.product-query.index', [
            'productTree' => $grouped,
            'search' => $search,
            'perPage' => $perPage,
        ]);
    }
    public function loadCategory($id)
{
    $productsQuery = DB::connection('mysql_second')
        ->table('products')
        ->leftJoin('categories', 'products.categories_id', '=', 'categories.id')
        ->select('products.*', 'categories.cat_name')
        ->where('categories.id', $id);

    $products = $productsQuery->paginate(10);

    return view('ams.product-query._products', compact('products'));
}

public function edit($id)
{
    $product = DB::connection('mysql_second')
        ->table('products')
        ->leftJoin('categories', 'products.categories_id', '=', 'categories.id')
        ->select(
            'products.*', 
            'categories.cat_name', 
            'categories.id as category_id',
            'products.enabled as web_enabled'
        )
        ->where('products.id', $id)
        ->first();

    $categories = DB::connection('mysql_second')->table('categories')->pluck('cat_name', 'id');

    return view('ams.product-query.edit', compact('product', 'categories'));
}

public function update(Request $request, $id)
{
    // Map web_enabled to enabled for database update
    $data = $request->only(['product_name', 'item_no', 'price', 'desc_short', 'categories_id']);
    
    // Handle web_enabled separately to map it to the correct database column
    if ($request->has('web_enabled')) {
        $data['enabled'] = $request->input('web_enabled');
    }

    if ($request->hasFile('img_large')) {
        $filename = time() . '.' . $request->img_large->extension();
        $request->img_large->storeAs('public/products', $filename);
        $data['img_large'] = $filename;
    }
    
    DB::connection('mysql_second')
        ->table('products')
        ->where('id', $id)
        ->update($data);

    return redirect()->route('ams.product-query.index')->with('success', 'Product updated.');
}

    /**
     * Search products by ID, item number, or name
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        $searchType = $request->input('search_type', 'all');
        
        if (empty($query)) {
            return redirect()->route('ams.product-query.index');
        }
        
        $productsQuery = DB::connection('mysql_second')
            ->table('products')
            ->leftJoin('categories', 'products.categories_id', '=', 'categories.id')
            ->leftJoin('majorcategories', 'categories.majorcategories_id', '=', 'majorcategories.id')
            ->select(
                'products.id',
                'products.product_name',
                'products.item_no',
                'products.price',
                'products.enabled as web_enabled',
                'products.inv_orange',
                'products.desc_short',
                'products.img_small',
                'products.img_large',
                'categories.cat_name as category_name',
                'categories.id as category_id',
                'majorcategories.cat_name as major_category_name'
            );
            
        // Apply search filters based on search type
        if ($searchType == 'id') {
            $productsQuery->where('products.id', $query);
        } elseif ($searchType == 'item_no') {
            $productsQuery->where('products.item_no', 'like', "%{$query}%");
        } elseif ($searchType == 'name') {
            $productsQuery->where('products.product_name', 'like', "%{$query}%");
        } else {
            // Search all fields
            $productsQuery->where(function($q) use ($query) {
                $q->where('products.id', 'like', "%{$query}%")
                  ->orWhere('products.item_no', 'like', "%{$query}%")
                  ->orWhere('products.product_name', 'like', "%{$query}%");
            });
        }
        
        $products = $productsQuery->orderBy('products.product_name')->paginate(20);
        
        return view('ams.product-query.search-results', [
            'products' => $products,
            'query' => $query,
            'searchType' => $searchType
        ]);
    }
}
