<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoardonBoardController extends Controller
{
    /**
     * Show the board on board options by style and spacing
     *
     * @param Request $request
     * @param string|null $spacing
     * @return \Illuminate\View\View
     */
    public function index(Request $request, $spacing = null)
    {
        // Always use category ID 8 for board on board
        $categoryId = 8;
        
        // Get the category
        $category = DB::connection('mysql_second')
            ->table('categories')
            ->where('id', $categoryId)
            ->first();
            
        if (!$category) {
            return redirect()->route('woodfence')->with('error', 'Category not found');
        }
        
        // Get available spacings from products
        $spacings = DB::connection('mysql_second')
            ->table('productsqry')
            ->where('categories_id', $categoryId)
            ->where('enabled', 1)
            ->select('spacing')
            ->distinct()
            ->whereNotNull('spacing')
            ->get()
            ->pluck('spacing')
            ->filter()
            ->toArray();
        
        // Remove duplicates and sort
        $spacings = array_unique($spacings);
        sort($spacings);
        
        // Default spacing if none provided
        if (empty($spacing) && !empty($spacings)) {
            $spacing = $spacings[0];
        }
        
        // Store the current spacing for the view
        $currentSpacing = $spacing;
        
        // Get all products for this category
        try {
            $query = DB::connection('mysql_second')
                ->table('productsqry')
                ->where('categories_id', $categoryId)
                ->where('enabled', 1);
            
            if ($spacing) {
                $query->where(function($q) use ($spacing) {
                    $q->where('spacing', $spacing);
                });
            }
            
            $products = $query->get();
        } catch (\Exception $e) {
            // Fallback to products table if productsqry view doesn't exist
            $query = DB::connection('mysql_second')
                ->table('products')
                ->where('categories_id', $categoryId)
                ->where('enabled', 1);
                
            if ($spacing) {
                $query->where(function($q) use ($spacing) {
                    $q->where('spacing', $spacing);
                });
            }
            
            $products = $query->get();
        }
        
        // Group products by style and speciality
        $productsByStyle = [];
        $productData = [];
        $productIdMap = [];
        
        // Define the preferred styles and their order
        $styleOrder = ['Straight On Top', 'Concave', 'Convex'];
        
        // Define speciality filters
        $specialityFilters = [
            'Straight On Top' => ['Slant Ear', 'Gothic Point', 'French Gothic'],
            'Concave' => ['Flat picket', 'Gothic Point', 'French Gothic'],
            'Convex' => ['Flat picket', 'Gothic Point', 'French Gothic']
        ];
        
        // Initialize productsByStyle with empty arrays for each style and speciality
        foreach ($styleOrder as $style) {
            $productsByStyle[$style] = [];
            foreach ($specialityFilters[$style] as $speciality) {
                $productsByStyle[$style][$speciality] = [];
            }
        }
        
        foreach ($products as $product) {
            $style = $product->style ?? 'Standard';
            $speciality = $product->speciality ?? ($product->speciality ?? 'Standard');
            
            // Clean up style and speciality values - using independent if statements to catch all matches
            if (stripos($style, 'straight') !== false) {
                $style = 'Straight On Top';
            } 
            if (stripos($style, 'concave') !== false) {
                $style = 'Concave';
            } 
            if (stripos($style, 'convex') !== false) {
                $style = 'Convex';
            }
            
            // Determine speciality - using separate if statements to avoid conflicts
            $matchedSpeciality = null;
            
            if (stripos($speciality, 'french') !== false) {
                $matchedSpeciality = 'French Gothic';
            } 
            else if (stripos($speciality, 'gothic') !== false) {
                $matchedSpeciality = 'Gothic Point';
            }
            else if (stripos($speciality, 'ear') !== false || stripos($speciality, 'slant') !== false) {
                $matchedSpeciality = 'Slant Ear';
            }
            else if (stripos($speciality, 'flat') !== false) {
                $matchedSpeciality = 'Flat picket';
            }
            
            // If we matched a speciality, use it
            if ($matchedSpeciality) {
                $speciality = $matchedSpeciality;
            }
            
            // Apply speciality filter
            if (!in_array($style, $styleOrder) || !in_array($speciality, $specialityFilters[$style] ?? [])) {
                continue;
            }
            
            if (count($productsByStyle[$style][$speciality]) < 3) {
                $productsByStyle[$style][$speciality][] = $product;
            }
            
            // Store product data by ID
            $productData[$product->id] = [
                'image' => $product->img_large ? url('storage/products/' . $product->img_large) : url('storage/products/default.png'),
                'item_no' => $product->item_no ?? '',
                'price' => $product->price ?? 0
            ];
            
            // Build the product ID map dynamically - use the first product encountered for each style/speciality
            if (!isset($productIdMap[$style])) {
                $productIdMap[$style] = [];
            }
            
            if (!isset($productIdMap[$style][$speciality])) {
                $productIdMap[$style][$speciality] = 'product/' . $product->id;
            }
        }
        
        return view('categories.boardonboard', [
            'category' => [
                'id' => $category->id,
                'name' => $category->cat_name,
                'description' => $category->cat_desc_long ?? 'No description available',
                'seo_name' => $category->seo_name,
                'image' => $category->image ? url('storage/categories/' . $category->image) : url('storage/categories/default.png'),
            ],
            'productsByStyle' => $productsByStyle,
            'productData' => $productData,
            'productIdMap' => $productIdMap,
            'styleOrder' => $styleOrder,
            'spacings' => $spacings,
            'currentSpacing' => $currentSpacing,
            'defaultImage' => url('storage/products/default.png')
        ]);
    }
}
