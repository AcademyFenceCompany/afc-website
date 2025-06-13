<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\ShoppingCart; // Assuming you have a ShoppingCart model

class ProductByMeshSizeController extends Controller
{
    public function showMeshSizeProducts(Request $request, $coating = null, $meshSize = null)
    {
        // Handle both route types: path parameters from new routes and query parameters from legacy route
        if ($coating === null && $meshSize === null) {
            // Legacy route with query parameters
            $meshSize = urldecode($request->input('meshSize'));
            $coating = urldecode($request->input('coating'));
            $meshSize = str_replace('+', ' ', $meshSize); // Normalize '+' to space for query params too
        } else {
            // New route with path parameters
            $meshSize = urldecode($meshSize);
            $coating = urldecode($coating);
            $meshSize = str_replace('+', ' ', $meshSize); // Normalize '+' to space for path params
        }
        
        // Normalize the meshSize from URL/request for robust comparison
        $normalizedUrlMeshSize = strtolower($meshSize);
        $normalizedUrlMeshSize = str_replace([' ', '.'], '', $normalizedUrlMeshSize);
        
        // Get all welded wire products first
        $allWeldedWireProducts = DB::connection('academyfence')
            ->table('productsqry')
            ->where('majorcategories_id', 44)
            ->where('enabled', 1)
            ->get();
            
        // Log all coatings available in the database for debugging
        $availableCoatings = $allWeldedWireProducts->pluck('coating')->unique()->values();
        Log::info('All available coatings in database:', $availableCoatings->toArray());
            
        // Filter products by the specified mesh size
        $meshSizeProducts = $allWeldedWireProducts->filter(function($product) use ($normalizedUrlMeshSize) {
            if (empty($product->size2)) {
                return false;
            }
            // Normalize database mesh size for robust comparison
            $normalizedDbMeshSize = strtolower($product->size2);
            $normalizedDbMeshSize = str_replace([' ', '.'], '', $normalizedDbMeshSize);
            
            return $normalizedDbMeshSize === $normalizedUrlMeshSize;
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
        
        // Normalize products' display_size_2 values to improve consistency
        $meshSize_products = $meshSize_products->map(function($product) {
            // Normalize display_size_2: trim whitespace, replace multiple spaces with single space
            if (isset($product->display_size_2)) {
                $product->display_size_2 = trim(preg_replace('/\s+/', ' ', $product->display_size_2));
            }
            return $product;
        });
        
        // Group products by normalized display_size_2 for easier and more efficient organization
        $groupedByDisplay = $meshSize_products->groupBy(function($product) {
            // Use display_size_2 with fallback to size2, normalize to lowercase for consistent comparison
            $displaySize = $product->display_size_2 ?? $product->size2;
            return strtolower(trim($displaySize));
        });

        $kproduct = DB::connection('academyfence')
        ->table('productsqry')
        ->where('categories_id', 50)
        ->where('parent','AFCHDFP')
        ->where('enabled', 1)
        ->orderBy('weight_lbs','asc')
        ->get();
        
    // Add image URLs for the products
    $kproduct = $kproduct->map(function($product) {
        $product->img_url = $product->img_large 
            ? url('storage/products/' . $product->img_large) 
            : url('storage/products/default.jpg');
        return $product;
    });
    

        
        // Create breadcrumb data for the view with clear naming
        $baseUrl = url('/weldedwire');
        
        // Format the coating name for better display
        $formattedCoating = ucwords(strtolower($coating));
        
        // Format the mesh size to ensure consistent display
        $formattedMeshSize = is_string($meshSize) ? trim($meshSize) : '';
        
        $breadcrumbs = [
            ['name' => 'Welded Wire', 'url' => $baseUrl],
            ['name' => $formattedCoating, 'url' => $baseUrl . '/' . urlencode($coating)],
            ['name' => $formattedMeshSize, 'url' => '#']
        ];
        
        //Development: Log the grouped categories for debugging
        $majCategories = \DB::table('majorcategories')->where('enabled', 1)->get();
        $subCategories = \DB::table('categories')->where('majorcategories_id', 1)->get();
        $shoppingCart = new ShoppingCart();
        $cart = $shoppingCart->getCart();

        // If the mesh size is empty, we can skip adding it to breadcrumbs
        return view('categories.wwf-product', [
            'meshSize_products' => $meshSize_products,
            'groupedByGauge' => $groupedByDisplay,
            'knockinpostproducts' => $kproduct,
            'vinylPipingProducts' => $this->getVinylBlackFencePiping(),
            'cedarPostProducts' => $this->getRoundCedarFencePosts(),
            'postDriverProducts' => $this->getBazookaPostDrivers(),
            'treatedPostProducts' => $this->getPressureTreatedPosts(),
            'breadcrumbs' => $breadcrumbs, 
            'majCategories' => $majCategories,
            'subCategories' => $subCategories,  
            'cart' => $cart
        ]);
    }

    /**
     * Get Vinyl Black Fence Piping products
     * 
     * @return \Illuminate\Support\Collection
     */
    private function getVinylBlackFencePiping()
    {
        $products = DB::connection('academyfence')
            ->table('productsqry')
            ->where('categories_id', 205)
            ->where('color', 'like', 'vinyl')
            ->where('size', 'like', '1 5/8in x%')
            ->where('product_name', 'like', 'Residential Tubing%')
            ->where('weight_lbs', '>', 0)
            ->orderBy('id', 'asc')
            ->get();
        
        // Add image URL paths for convenience
        $products = $products->map(function($product) {
            $product->img_url = $product->img_large 
                ? url('storage/products/' . $product->img_large) 
                : url('storage/products/default.jpg');
            return $product;
        });

        return $products;
    }

    /**
     * Get Round Cedar Non Tapered Wood Fence Post products
     * 
     * @return \Illuminate\Support\Collection
     */
    private function getRoundCedarFencePosts()
    {
        $products = DB::connection('academyfence')
            ->table('productsqry')
            ->where('categories_id', 163)
            ->where('parent', 'like', 'afcrwp')
            ->where('enabled', 1)
            ->where('weight_lbs', '>', 0)
            ->orderBy('size', 'asc')
            ->get();
        
        // Add image URL paths for convenience
        $products = $products->map(function($product) {
            $product->img_url = $product->img_large 
                ? url('storage/products/' . $product->img_large) 
                : url('storage/products/default.jpg');
            return $product;
        });

        return $products;
    }

    /**
     * Get Bazooka Knock-In Post Driver products
     * 
     * @return \Illuminate\Support\Collection
     */
    private function getBazookaPostDrivers()
    {
        $products = DB::connection('academyfence')
            ->table('productsqry')
            ->where('item_no', 'WWFBPDR')
            ->where('enabled', 1)
            ->get();
        
        // Add image URL paths for convenience
        $products = $products->map(function($product) {
            $product->img_url = $product->img_large 
                ? url('storage/products/' . $product->img_large) 
                : url('storage/products/default.jpg');
            return $product;
        });

        return $products;
    }

    /**
     * Get Round Pressure Treated Fence Post products
     * 
     * @return \Illuminate\Support\Collection
     */
    private function getPressureTreatedPosts()
    {
        $products = DB::connection('academyfence')
            ->table('productsqry')
            ->where('item_no', 'PSRWFT')
            ->where('enabled', 1)
            ->get();
        
        // Add image URL paths for convenience
        $products = $products->map(function($product) {
            $product->img_url = $product->img_large 
                ? url('storage/products/' . $product->img_large) 
                : url('storage/products/default.jpg');
            return $product;
        });

        return $products;
    }
}
