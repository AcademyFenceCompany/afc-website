<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ProductByMeshSizeController extends Controller
{
    public function showMeshSizeProducts(Request $request)
    {
        // Get the mesh size and coating parameters and decode them
        $meshSize = urldecode($request->input('meshSize')); 
        $coating = urldecode($request->input('coating'));
        
        // Get all welded wire products first
        $allWeldedWireProducts = DB::connection('mysql_second')
            ->table('productsqry')
            ->where('majorcategories_id', 44)
            ->where('enabled', 1)
            ->get();
            
        // Log all coatings available in the database for debugging
        $availableCoatings = $allWeldedWireProducts->pluck('coating')->unique()->values();
        Log::info('All available coatings in database:', $availableCoatings->toArray());
            
        // Filter products by the specified mesh size
        $meshSizeProducts = $allWeldedWireProducts->filter(function($product) use ($meshSize) {
            return strcasecmp($product->size2, $meshSize) === 0;
        })->values();
        
    
        
        // Apply coating filter based on selection
        if (strtolower($coating) == strtolower('Vinyl PVC')) {
            // Filter for Vinyl/PVC products
            $meshSize_products = $meshSizeProducts->filter(function($product) {
                $productCoating = strtolower($product->coating);
                return strpos($productCoating, 'vinyl') !== false || 
                       strpos($productCoating, 'pvc') !== false;
            })->values();
            
            Log::info('Filtered Vinyl/PVC products', [
                'count' => $meshSize_products->count(),
                'sample' => $meshSize_products->take(3)->map(function($p) {
                    return ['id' => $p->id, 'coating' => $p->coating];
                })
            ]);
        } 
        elseif (strtolower($coating) == strtolower('Galvanized')) {
            // Filter for Galvanized products - expand matching patterns
            $meshSize_products = $meshSizeProducts->filter(function($product) {
                // Check if coating field contains galvanized variants
                if (!empty($product->coating)) {
                    $productCoating = strtolower($product->coating);
                    if (strpos($productCoating, 'galv') !== false ||
                        strpos($productCoating, 'zinc') !== false ||
                        $productCoating == 'g' ||
                        $productCoating == 'g90') {
                        return true;
                    }
                }
                
                // If coating is null or empty, check product name for galvanized indicators
                if (empty($product->coating)) {
                    $productName = strtolower($product->product_name);
                    return strpos($productName, 'galv') !== false ||
                           strpos($productName, 'gaw') !== false ||
                           strpos($productName, 'g90') !== false;
                }
                
                return false;
            })->values();
            
            Log::info('Filtered Galvanized products', [
                'count' => $meshSize_products->count(),
                'sample' => $meshSize_products->take(3)->map(function($p) {
                    return ['id' => $p->id, 'coating' => $p->coating];
                })
            ]);
            
            // If no galvanized products found, log all coatings for this mesh size
            if ($meshSize_products->isEmpty()) {
                Log::warning('No galvanized products found for mesh size: ' . $meshSize, [
                    'all_coatings_for_mesh' => $meshSizeProducts->pluck('coating')->unique()->values()
                ]);
            }
        }
        else {
            // Default to all products with this mesh size
            $meshSize_products = $meshSizeProducts;
        }
        
        // Add image URL paths for convenience
        $meshSize_products = $meshSize_products->map(function($product) {
            $product->img_url = $product->img_large 
                ? url('storage/products/' . $product->img_large) 
                : url('storage/products/default.jpg');
            return $product;
        });
        
        // Group products by mesh size (size2) and gauge (size3) combination
        $groupedByMeshAndGauge = $meshSize_products->groupBy(function($product) {
            return $product->size2 . ', ' . $product->size3;
        });


        $kproduct = DB::connection('mysql_second')
        ->table('productsqry')
        ->where('categories_id', 50)
        ->where('enabled', 1)
        ->get();
        
    // Add image URLs for the products
    $kproduct = $kproduct->map(function($product) {
        $product->img_url = $product->img_large 
            ? url('storage/products/' . $product->img_large) 
            : url('storage/products/default.jpg');
        return $product;
    });
    

        
        return view('categories.wwf-product', [
            'meshSize_products' => $meshSize_products,
            'groupedByGauge' => $groupedByMeshAndGauge,
            'knockinpostproducts' => $kproduct,
        ]);
    }


}
