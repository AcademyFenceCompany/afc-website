<?php

namespace App\Http\Controllers\Ams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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

        // Get the page from the request
        $page = request()->input('page', 1);
        
        // Paginate with 10 items per page
        $products = $productsQuery->paginate(10, ['*'], 'page', $page);
        
        // Make sure we don't duplicate the category_id parameter in pagination links
        $products->appends(request()->except(['page', 'category_id']));
        
        // Pass the category ID to the view for proper link generation
        return view('ams.product-query._products', [
            'products' => $products,
            'categoryId' => $id
        ]);
    }

    public function create()
    {
        $categories = DB::connection('mysql_second')->table('categories')
            ->orderBy('majorcategories_id')
            ->orderBy('cat_name')
            ->pluck('cat_name', 'id');
        
        return view('ams.product-query.create', [
            'categories' => $categories
        ]);
    }
    
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'product_name' => 'required|string|max:255',
            'item_no' => 'required|string|max:50',
            'price' => 'required|numeric',
            'categories_id' => 'required|exists:mysql_second.categories,id',
            'img_small' => 'nullable|image|max:2048',
            'img_large' => 'nullable|image|max:2048',
        ]);
        
        // Only include fields that exist in the database
        $allowedFields = [
            'product_name', 'item_no', 'seo_name', 'categories_id', 
            'desc_short', 'desc_long', 'price', 'list', 'cost', 'ws_price',
            'color', 'size', 'size2', 'size3', 'display_size_2','parent', 'weight_lbs', 'material', 'style', 'speciality', 
            'spacing', 'coating', 'gauge', 'enabled', 'img_small', 'img_large',
            'meta_title', 'meta_description', 'meta_keywords', 'product_assoc', 'ship_width', 'ship_height', 'ship_length', 'amount_per_box'
        ];
        
        $data = array_intersect_key($request->except(['_token', 'img_small', 'img_large']), 
                                   array_flip($allowedFields));
        
        // Generate SEO name if not provided
        if (empty($data['seo_name'])) {
            $data['seo_name'] = Str::slug($data['product_name']);
        }
        
        // Handle image uploads
        if ($request->hasFile('img_small')) {
            $smallImage = $request->file('img_small');
            $smallImageName = time() . '_small.' . $smallImage->getClientOriginalExtension();
            $smallImage->storeAs('public/products', $smallImageName);
            $data['img_small'] = $smallImageName;
        }

        if ($request->hasFile('img_large')) {
            $largeImage = $request->file('img_large');
            $largeImageName = time() . '_large.' . $largeImage->getClientOriginalExtension();
            $largeImage->storeAs('public/products', $largeImageName);
            $data['img_large'] = $largeImageName;
        }

        // Insert product into database
        $productId = DB::connection('mysql_second')->table('products')->insertGetId($data);

        return redirect()->route('ams.product-query.edit', $productId)
            ->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = DB::connection('mysql_second')->table('products')
            ->where('id', $id)
            ->first();

        if (!$product) {
            return redirect()->route('ams.product-query.index')
                ->with('error', 'Product not found.');
        }

        $categories = DB::connection('mysql_second')->table('categories')
            ->orderBy('majorcategories_id')
            ->orderBy('cat_name')
            ->pluck('cat_name', 'id');

        // Get category details for shippable status
        $category = DB::connection('mysql_second')->table('categories')
            ->where('id', $product->categories_id)
            ->first();

        // Add shippable status from category to product object
        $product->shippable = $category ? $category->shippable : 0;

        return view('ams.product-query.edit', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'product_name' => 'required|string|max:255',
            'item_no' => 'required|string|max:50',
            'price' => 'required|numeric',
            'categories_id' => 'required|exists:mysql_second.categories,id',
            'img_small' => 'nullable|image|max:2048',
            'img_large' => 'nullable|image|max:2048',
        ]);

        // Get existing product
        $product = DB::connection('mysql_second')->table('products')
            ->where('id', $id)
            ->first();

        if (!$product) {
            return redirect()->route('ams.product-query.index')
                ->with('error', 'Product not found.');
        }

        // Only include fields that exist in the database
        $allowedFields = [
            'product_name', 'item_no', 'seo_name', 'categories_id', 
            'desc_short', 'desc_long', 'price', 'list', 'cost', 'ws_price',
            'color', 'size', 'size2', 'size3', 'display_size_2','parent', 'weight_lbs', 'material', 'style', 'speciality', 
            'spacing', 'coating', 'gauge', 'enabled', 'img_small', 'img_large',
            'meta_title', 'meta_description', 'meta_keywords', 'product_assoc', 'ship_width', 'ship_height', 'ship_length', 'amount_per_box'
        ];
        
        // Get all input data first before filtering
        $inputData = $request->except(['_token', 'img_small', 'img_large', 'old_product_name']);
        
        // Now filter to only allowed fields
        $data = array_intersect_key($inputData, array_flip($allowedFields));
        
        // Generate SEO name if not provided
        if (empty($data['seo_name'])) {
            $data['seo_name'] = Str::slug($data['product_name']);
        }

        // Handle image uploads
        if ($request->hasFile('img_small')) {
            // Delete old image if exists
            if ($product->img_small) {
                Storage::delete('public/products/' . $product->img_small);
            }
            
            $smallImage = $request->file('img_small');
            $smallImageName = time() . '_small.' . $smallImage->getClientOriginalExtension();
            $smallImage->storeAs('public/products', $smallImageName);
            $data['img_small'] = $smallImageName;
        }

        if ($request->hasFile('img_large')) {
            // Delete old image if exists
            if ($product->img_large) {
                Storage::delete('public/products/' . $product->img_large);
            }
            
            $largeImage = $request->file('img_large');
            $largeImageName = time() . '_large.' . $largeImage->getClientOriginalExtension();
            $largeImage->storeAs('public/products', $largeImageName);
            $data['img_large'] = $largeImageName;
        }

        // Update product in database
        DB::connection('mysql_second')->table('products')
            ->where('id', $id)
            ->update($data);

        return redirect()->route('ams.product-query.edit', $id)
            ->with('success', 'Product updated successfully.');
    }
    
    public function destroy($id)
    {
        $product = DB::connection('mysql_second')->table('products')
            ->where('id', $id)
            ->first();

        if (!$product) {
            return redirect()->route('ams.product-query.index')
                ->with('error', 'Product not found.');
        }

        // Delete product images
        if ($product->img_small) {
            Storage::delete('public/products/' . $product->img_small);
        }
        
        if ($product->img_large) {
            Storage::delete('public/products/' . $product->img_large);
        }

        // Delete product from database
        DB::connection('mysql_second')->table('products')
            ->where('id', $id)
            ->delete();

        return redirect()->route('ams.product-query.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function deleteImage($id, $type)
    {
        if (!in_array($type, ['img_small', 'img_large'])) {
            return redirect()->route('ams.product-query.edit', $id)
                ->with('error', 'Invalid image type.');
        }

        $product = DB::connection('mysql_second')->table('products')
            ->where('id', $id)
            ->first();

        if (!$product) {
            return redirect()->route('ams.product-query.index')
                ->with('error', 'Product not found.');
        }

        // Delete image file
        if ($product->$type) {
            Storage::delete('public/products/' . $product->$type);
        }

        // Update product record to remove image reference
        DB::connection('mysql_second')->table('products')
            ->where('id', $id)
            ->update([$type => null]);

        return redirect()->route('ams.product-query.edit', $id)
            ->with('success', 'Image deleted successfully.');
    }

    /**
     * Duplicate a product
     */
    public function duplicate($id)
    {
        // Get existing product
        $originalProduct = DB::connection('mysql_second')->table('products')
            ->where('id', $id)
            ->first();

        if (!$originalProduct) {
            return redirect()->route('ams.product-query.index')
                ->with('error', 'Product not found.');
        }

        // Convert to array and remove the ID to create a new product
        $newProduct = (array) $originalProduct;
        unset($newProduct['id']);
        
        // Modify the product name to indicate it's a duplicate
        $newProduct['product_name'] = $newProduct['product_name'] . ' (Copy)';
        
        // If there's an SEO name, update it too
        if (!empty($newProduct['seo_name'])) {
            $newProduct['seo_name'] = $newProduct['seo_name'] . '-copy';
        }
        
        // If there's an item number, modify it slightly
        if (!empty($newProduct['item_no'])) {
            $newProduct['item_no'] = $newProduct['item_no'] . '-C';
        }
        
        // Handle images - we don't duplicate the files, just reference the same ones
        // The user can update these later if needed
        
        // Insert the new product
        $newProductId = DB::connection('mysql_second')->table('products')
            ->insertGetId($newProduct);
            
        return redirect()->route('ams.product-query.edit', $newProductId)
            ->with('success', 'Product duplicated successfully. You can now edit the copy.');
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
