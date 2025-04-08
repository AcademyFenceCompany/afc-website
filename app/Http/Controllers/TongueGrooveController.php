<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TongueGrooveController extends Controller
{
    /**
     * Show the tongue and groove options by speciality
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Always use category ID 4 for tongue and groove
        $categoryId = 4;
        
        // Get the category
        $category = DB::connection('mysql_second')
            ->table('categories')
            ->where('id', $categoryId)
            ->first();
            
        if (!$category) {
            return redirect()->route('woodfence')->with('error', 'Category not found');
        }
        
        // Get all products for this category
        try {
            $query = DB::connection('mysql_second')
                ->table('productsqry')
                ->where('categories_id', $categoryId)
                ->where('enabled', 1);
            
            $products = $query->get();
        } catch (\Exception $e) {
            // Fallback to products table if productsqry view doesn't exist
            $query = DB::connection('mysql_second')
                ->table('products')
                ->where('categories_id', $categoryId)
                ->where('enabled', 1);
                
            $products = $query->get();
        }
        
        // Group products by speciality
        $productsBySpeciality = [];
        $productData = [];
        
        // Define the preferred specialities and their order
        $specialityOrder = ['Diagonal Lattice Top', 'Square Lattice Top', 'Solid Top'];
        
        // Initialize productsBySpeciality with empty arrays for each speciality
        foreach ($specialityOrder as $speciality) {
            $productsBySpeciality[$speciality] = [];
        }
        
        foreach ($products as $product) {
            $speciality = $product->specialty ?? ($product->speciality ?? 'Standard');
            
            // Clean up speciality values - using independent if statements to catch all matches
            if (stripos($speciality, 'diagonal') !== false && stripos($speciality, 'lattice') !== false) {
                $speciality = 'Diagonal Lattice Top';
            } 
            if (stripos($speciality, 'square') !== false && stripos($speciality, 'lattice') !== false) {
                $speciality = 'Square Lattice Top';
            } 
            if (stripos($speciality, 'solid') !== false && stripos($speciality, 'top') !== false) {
                $speciality = 'Solid Top';
            }
          
            
            // If speciality is not in our predefined list, skip it
            if (!in_array($speciality, $specialityOrder)) {
                continue;
            }
            
            // Limit to 3 products per speciality
            if (count($productsBySpeciality[$speciality]) < 3) {
                $productsBySpeciality[$speciality][] = $product;
            }
            
            // Store product data by ID
            $productData[$product->id] = [
                'image' => $product->img_large ? url('storage/products/' . $product->img_large) : url('storage/products/default.png'),
                'item_no' => $product->item_no ?? '',
                'price' => $product->price ?? 0
            ];
        }
        
        return view('categories.tonguegroove', [
            'category' => $category,
            'productsBySpeciality' => $productsBySpeciality,
            'productData' => $productData,
            'specialityOrder' => $specialityOrder,
            'defaultImage' => url('storage/products/default.png')
        ]);
    }
}
