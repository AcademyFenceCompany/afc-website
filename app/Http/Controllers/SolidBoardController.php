<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolidBoardController extends Controller
{
    /**
     * Show the list of solid board options by style and speciality
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Always use category ID 7 for solid board
        $categoryId = 7;
        
        // Get the category
        $category = DB::connection('mysql_second')
            ->table('categories')
            ->where('id', $categoryId)
            ->first();
            
        if (!$category) {
            return redirect()->route('woodfence')->with('error', 'Category not found');
        }
        
        // Create product ID map for solid board styles and specialities
        $productIdMap = [
            'Straight On Top' => [
                'Slant Ear' => 'product/3028',
                'Gothic Point' => 'product/3150',
                'French Gothic' => 'product/3220'
            ],
            'Concave' => [
                'Flat Picket' => 'product/3118',
                'Gothic Point' => 'product/3167',
                'French Gothic' => 'product/3236'
            ],
            'Convex' => [
                'Flat Picket' => 'product/3135',
                'Gothic Point' => 'product/3176',
                'French Gothic' => 'product/3253'
            ]
        ];
        
        // Extract all product IDs from the map
        $productIds = [];
        foreach ($productIdMap as $style => $specialities) {
            foreach ($specialities as $speciality => $productLink) {
                $parts = explode('/', $productLink);
                if (count($parts) == 2 && $parts[0] === 'product') {
                    $productIds[] = $parts[1];
                }
            }
        }
        
        // Get products from the database that match the IDs in our map
        try {
            $products = DB::connection('mysql_second')
                ->table('productsqry')
                ->whereIn('id', $productIds)
                ->where('enabled', 1)
                ->get();
                
            if ($products->isEmpty()) {
                // Fall back to querying all products in the category
                $products = DB::connection('mysql_second')
                    ->table('productsqry')
                    ->where('categories_id', $categoryId)
                    ->where('enabled', 1)
                    ->get();
            }
        } catch (\Exception $e) {
            // Fallback to products table if productsqry view doesn't exist
            $products = DB::connection('mysql_second')
                ->table('products')
                ->whereIn('id', $productIds)
                ->where('enabled', 1)
                ->get();
                
            if ($products->isEmpty()) {
                // Fall back to querying all products in the category
                $products = DB::connection('mysql_second')
                    ->table('products')
                    ->where('categories_id', $categoryId)
                    ->where('enabled', 1)
                    ->get();
            }
        }
        
        // Create a simple map of product data by ID
        $productMap = [];
        foreach ($products as $product) {
            $productMap[$product->id] = [
                'image' => $product->img_large ? url('storage/products/' . $product->img_large) : url('storage/products/default.png'),
                'item_no' => $product->item_no ?? ''
            ];
        }
        
        // Define the preferred styles and their order
        $styleOrder = ['Straight On Top', 'Concave', 'Convex'];
        
        return view('categories.solidboard', [
            'category' => [
                'id' => $category->id,
                'name' => $category->cat_name,
                'description' => $category->cat_desc_long ?? 'No description available',
                'seo_name' => $category->seo_name,
                'image' => $category->image ? url('storage/categories/' . $category->image) : url('storage/categories/default.png'),
            ],
            'productMap' => $productMap,
            'productIdMap' => $productIdMap,
            'styleOrder' => $styleOrder,
            'defaultImage' => url('storage/products/default.png')
        ]);
    }
}
