<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderCategoryController extends Controller
{
    public function ajaxGetCategories()
    {
        try {
            // Get major categories from mysql_second
            $majorCategories = DB::connection('mysql_second')
                ->table('majorcategories')
                ->where('enabled', 1)
                ->orderBy('id')
                ->get();
                
            $result = [];
            
            foreach ($majorCategories as $majorCategory) {
                $categoryGroup = [
                    'id' => $majorCategory->id,
                    'name' => $majorCategory->cat_name,
                    'subcategories' => []
                ];
                
                // Get categories for this major category
                $categories = DB::connection('mysql_second')
                    ->table('categories')
                    ->where('active', 1)
                    ->where('majorcategories_id', $majorCategory->id)
                    ->orderBy('id')
                    ->get();
                    
                foreach ($categories as $category) {
                    $categoryGroup['subcategories'][] = [
                        'id' => $category->id,
                        'name' => $category->cat_name
                    ];
                }
                
                $result[] = $categoryGroup;
            }
            
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Error fetching categories: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load categories: ' . $e->getMessage()], 500);
        }
    }
    
    public function ajaxGetProducts($categoryId)
    {
        try {
            // Get products for the specified category from mysql_second
            $products = DB::connection('mysql_second')
                ->table('products')
                ->select(
                    'products.id',
                    'products.product_name',
                    'products.item_no',
                    'products.price',
                    'products.desc_short',
                    'products.img_small',
                    'products.weight'
                )
                ->where('products.categories_id', $categoryId)
                ->where('products.enabled', 1)
                ->orderBy('products.product_name')
                ->get();
                
            return response()->json($products);
        } catch (\Exception $e) {
            Log::error('Error fetching products: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load products: ' . $e->getMessage()], 500);
        }
    }
    
    public function ajaxGetProductDetails($productId)
    {
        try {
            // Get detailed product information from mysql_second
            $product = DB::connection('mysql_second')
                ->table('products')
                ->select(
                    'products.id',
                    'products.product_name',
                    'products.item_no',
                    'products.price',
                    'products.desc_short',
                    'products.desc_long',
                    'products.img_small',
                    'products.img_large',
                    'products.weight',
                    'products.size',
                    'products.color'
                )
                ->where('products.id', $productId)
                ->first();
                
            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }
            
            return response()->json($product);
        } catch (\Exception $e) {
            Log::error('Error fetching product details: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load product details: ' . $e->getMessage()], 500);
        }
    }
    
    public function ajaxSearchProducts(Request $request)
    {
        try {
            $query = $request->input('query');
            
            if (empty($query)) {
                return response()->json([]);
            }
            
            // Search products by name or item number from mysql_second
            $products = DB::connection('mysql_second')
                ->table('products')
                ->select(
                    'products.id',
                    'products.product_name',
                    'products.item_no',
                    'products.price',
                    'products.desc_short',
                    'products.img_small',
                    'products.weight'
                )
                ->where(function($q) use ($query) {
                    $q->where('products.product_name', 'like', "%{$query}%")
                      ->orWhere('products.item_no', 'like', "%{$query}%");
                })
                ->where('products.enabled', 1)
                ->orderBy('products.product_name')
                ->limit(20)
                ->get();
                
            return response()->json($products);
        } catch (\Exception $e) {
            Log::error('Error searching products: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to search products: ' . $e->getMessage()], 500);
        }
    }
}
