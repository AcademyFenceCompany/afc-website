<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class WoodFenceController extends Controller
{
    public function index()
    {
        // Get direct subcategories of Wood Fence (parent_id = 16)
        $subcategories = DB::table('family_categories')
            ->where('parent_category_id', 16)
            ->whereNotIn('family_category_id', [16]) // Exclude Wood Fence itself
            ->get()
            ->map(function ($subcategory) {
                // Fetch spacing options for each subcategory
                $spacingOptions = DB::table('product_details')
                    ->where('family_category_id', $subcategory->family_category_id)
                    ->whereNotNull('spacing')
                    ->distinct()
                    ->pluck('spacing');
    
                $subcategory->spacing_options = $spacingOptions;
                return $subcategory;
            });
    
        return view('categories.woodfence', ['subcategories' => $subcategories]);
    }

    public function getProductsBySpacing($subcategoryId, $spacing)
{
    $formattedSpacing = urldecode($spacing); // Decode spacing value

    // Fetch all child categories of the selected subcategory
    $childCategories = DB::table('family_categories')
        ->where('parent_category_id', $subcategoryId)
        ->pluck('family_category_id'); // Get child IDs
        // dd($childCategories, \DB::getQueryLog()); 
    // Fetch products that belong to the child categories and match the spacing
    $styles = ['Straight on Top', 'Concave', 'Convex'];
    $specialities = ['Slant Ear', 'Gothic Point', 'French Gothic'];

    $styleGroups = [];

    foreach ($styles as $style) {
      
        // Query starts here
        $products = DB::table('products')
            ->join('product_details', 'products.product_id', '=', 'product_details.product_id')
            ->join('product_media', 'products.product_id', '=', 'product_media.product_id')
            ->whereIn('products.subcategory_id', $childCategories) // Filter by child categories
            ->where('product_details.spacing', $formattedSpacing) // Filter by spacing
            ->where('product_details.style', $style) // Filter by style
            ->whereIn('product_details.speciality', $specialities) // Filter by specialities
            ->select(
                'products.*',
                'product_details.*',
                'product_media.general_image as image'
            )
            ->get()
            
            ->groupBy('speciality');

        $styleGroups[] = [
            'style' => $style,
            'products' => $products,
        ];
    }
    // Log the final styleGroups array
    return view('categories.woodfence-specs', ['styleGroups' => $styleGroups]);
}
}
