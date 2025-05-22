<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockadeFenceController extends Controller
{
    public function index(Request $request)
    {
        // Category ID for Stockade Fence
        $categoryId = 5;
        
        // Fetch products from the database
        $query = DB::connection('academyfence')
            ->table('productsqry')
            ->where('categories_id', $categoryId)
            ->where('enabled', 1);
            
        $products = $query->get();
        
        // Define specific product IDs to show
        $specificProductId = 2608;
        
        // Default image path
        $defaultImage = url('storage/products/default.png');
        
        // Process products and group by speciality from database
        $productsByspeciality = [];
        $productData = [];
        $specialityOrder = [];
        
        foreach ($products as $product) {
            // Get speciality directly from database
            $productspeciality = $product->speciality ?? 'Standard';
            
            // Skip empty specialties
            if (empty($productspeciality)) {
                $productspeciality = 'Standard';
            }
            
            // Add speciality to order list if not already there
            if (!in_array($productspeciality, $specialityOrder)) {
                $specialityOrder[] = $productspeciality;
            }
            
            // Initialize speciality group if not exists
            if (!isset($productsByspeciality[$productspeciality])) {
                $productsByspeciality[$productspeciality] = [];
            }
            
            // Only add the specific product ID we want to show
            if ($product->id == $specificProductId) {
                // Update the description to match the required format if it doesn't already have it
                if (!empty($product->desc_short) && !preg_match('/Section Top Style:/i', $product->desc_short)) {
                    $product->desc_short = "Section Top Style: Straight\nHeights: 4ft, 5ft, 6ft, 8ft\nPicket Style: Tongue & Groove\nSpacing: None\nPickets Per Section: 34\nPicket Width: 3in";
                }
                $productsByspeciality[$productspeciality][] = $product;
            }
            
            // Store product data for easy access
            $productData[$product->id] = [
                'image' => $product->img_large ? url('storage/products/' . $product->img_large) : $defaultImage,
                'price' => $product->price ?? 0,
                'name' => $product->product_name ?? '',
                'description' => $product->desc_short ?? '',
                'height' => $this->extractHeight($product->product_name, $product->desc_short),
                'width' => $this->extractWidth($product->product_name, $product->desc_short)
            ];
        }
        
        // If we don't have the specific product in any speciality, add it to the first speciality
        $foundSpecificProduct = false;
        foreach ($productsByspeciality as $speciality => $specialityProducts) {
            foreach ($specialityProducts as $product) {
                if ($product->id == $specificProductId) {
                    $foundSpecificProduct = true;
                    break 2;
                }
            }
        }
        
        if (!$foundSpecificProduct && !empty($products)) {
            // Find the specific product
            $specificProduct = $products->firstWhere('id', $specificProductId);
            
            // If not found, use the first product
            if (!$specificProduct && count($products) > 0) {
                $specificProduct = $products[0];
            }
            
            // Add to the first speciality if we have one
            if ($specificProduct && !empty($specialityOrder)) {
                $firstspeciality = $specialityOrder[0];
                $productsByspeciality[$firstspeciality][] = $specificProduct;
            }
        }
        
        // Return the view with the grouped products
        return view('categories.stockade', [
            'productsByspeciality' => $productsByspeciality,
            'specialityOrder' => $specialityOrder,
            'productData' => $productData,
            'defaultImage' => $defaultImage
        ]);
    }
    
    /**
     * Extract height information from product name or description
     */
    private function extractHeight($name, $description)
    {
        $height = '';
        
        // Check in name
        if (preg_match('/(\d+(?:\.\d+)?)\s*(?:ft|foot|feet|\')/i', $name, $matches)) {
            $height = $matches[0];
        }
        // Check in description
        elseif (preg_match('/height[:\s]*(\d+(?:\.\d+)?)\s*(?:ft|foot|feet|\')/i', $description, $matches)) {
            $height = $matches[1] . ' ft';
        }
        elseif (preg_match('/(\d+(?:\.\d+)?)\s*(?:ft|foot|feet|\')\s*high/i', $description, $matches)) {
            $height = $matches[0];
        }
        
        return $height;
    }
    
    /**
     * Extract width information from product name or description
     */
    private function extractWidth($name, $description)
    {
        $width = '';
        
        // Check in name
        if (preg_match('/(\d+(?:\.\d+)?)\s*(?:ft|foot|feet|\')\s*wide/i', $name, $matches)) {
            $width = $matches[0];
        }
        // Check in description
        elseif (preg_match('/width[:\s]*(\d+(?:\.\d+)?)\s*(?:ft|foot|feet|\')/i', $description, $matches)) {
            $width = $matches[1] . ' ft';
        }
        elseif (preg_match('/(\d+(?:\.\d+)?)\s*(?:ft|foot|feet|\')\s*wide/i', $description, $matches)) {
            $width = $matches[0];
        }
        
        return $width;
    }
}
