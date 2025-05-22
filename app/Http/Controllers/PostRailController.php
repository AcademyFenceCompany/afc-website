<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostRailController extends Controller
{
    public function index(Request $request, $style = null)
    {
        // Category ID for Post and Rail
        $categoryId = 161;
        
        // Fetch products from the database
        $query = DB::connection('academyfence')
            ->table('productsqry')
            ->where('categories_id', $categoryId)
            ->where('enabled', 1);
            
        $products = $query->get();
        
        // Define the styles and their order
        $styleOrder = ['Round Rail', 'Split Rail'];
        
        // Define specific product IDs for each style
        $styleProductIds = [
            'Round Rail' => [43719, 43723],
            'Split Rail' => [2611, 2616]
        ];
        
        // Initialize productsByStyle with empty arrays for each style
        $productsByStyle = [];
        foreach ($styleOrder as $styleName) {
            $productsByStyle[$styleName] = [];
        }
        
        // Default image path
        $defaultImage = url('storage/products/default.png');
        
        // Process products and group by style
        $productData = [];
        
        foreach ($products as $product) {
            // Extract style from product data
            $productStyle = $product->style ?? '';
            
            // Normalize style names
            if (stripos($productStyle, 'round') !== false) {
                $productStyle = 'Round Rail';
            } elseif (stripos($productStyle, 'split') !== false) {
                $productStyle = 'Split Rail';
            }
            
            // If style is not in our predefined list, skip it
            if (!in_array($productStyle, $styleOrder)) {
                continue;
            }
            
            // Check if product ID is in the allowed list for this style
            if (!in_array($product->id, $styleProductIds[$productStyle])) {
                continue;
            }
            
            // Add product to the appropriate style group
            $productsByStyle[$productStyle][] = $product;
            
            // Store product data for easy access
            $productData[$product->id] = [
                'image' => $product->img_large ? url('storage/products/' . $product->img_large) : $defaultImage,
                'price' => $product->price ?? 0,
                'name' => $product->product_name ?? '',
                'description' => $product->desc_short ?? '',
                'rails' => $this->extractRailCount($product->product_name, $product->desc_short),
                'end_type' => $this->extractEndType($product->product_name, $product->desc_short)
            ];
        }
        
        // If a specific style is requested, filter products
        $currentStyle = null;
        if ($style) {
            // Normalize the requested style
            if (stripos($style, 'round') !== false) {
                $currentStyle = 'Round Rail';
            } elseif (stripos($style, 'split') !== false) {
                $currentStyle = 'Split Rail';
            }
            
            // If the style is valid, only show products for that style
            if ($currentStyle && isset($productsByStyle[$currentStyle])) {
                $filteredProducts = $productsByStyle[$currentStyle];
                
                return view('categories.postrail-products', [
                    'products' => $filteredProducts,
                    'productData' => $productData,
                    'currentStyle' => $currentStyle,
                    'defaultImage' => $defaultImage
                ]);
            }
        }
        
        // Return the view with the grouped products
        return view('categories.postrail', [
            'productsByStyle' => $productsByStyle,
            'styleOrder' => $styleOrder,
            'productData' => $productData,
            'defaultImage' => $defaultImage
        ]);
    }
    
    /**
     * Extract the number of rails from product name or description
     */
    private function extractRailCount($name, $description)
    {
        $combined = $name . ' ' . $description;
        
        if (preg_match('/\b([2-3])\s*rail\b/i', $combined, $matches)) {
            return $matches[1] . ' rail';
        }
        
        return 'Available in 2 or 3 rail';
    }
    
    /**
     * Extract the end type from product name or description
     */
    private function extractEndType($name, $description)
    {
        $combined = $name . ' ' . $description;
        
        if (stripos($combined, 'paddle') !== false || stripos($combined, 'scarf') !== false) {
            return 'Paddle / Scarfed End';
        }
        
        return '';
    }
}
