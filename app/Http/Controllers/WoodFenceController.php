<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;


class WoodFenceController extends Controller
{
    public function index()
    {
        // Fetch Wood Fence Subcategories
        $woodFenceSubcategories = DB::table('family_categories')
            ->where('parent_category_id', 16) // Wood Fence parent category
            ->select('family_category_id', 'family_category_name', 'category_description')
            ->get();

        $subcategoriesWithSpacing = [];
        foreach ($woodFenceSubcategories as $subcategory) {
            $image = DB::table('general_media')
                ->where('family_category_id', $subcategory->family_category_id)
                ->value('image');

            $spacingOptions = DB::table('product_details')
                ->where('family_category_id', $subcategory->family_category_id)
                ->whereNotNull('spacing')
                ->distinct()
                ->pluck('spacing');

            $subcategoriesWithSpacing[] = [
                'id' => $subcategory->family_category_id,
                'name' => $subcategory->family_category_name,
                'description' => $subcategory->category_description ?? 'No description',
                'image' => $image ?? '/default.png',
                'spacing_options' => $spacingOptions,
            ];
        }

        return view('categories.woodfence', ['subcategories' => $subcategoriesWithSpacing]);
    }
    public function getProductsGroupedByStyle($subcategoryId, $spacing, $showAll = false)
    {
       $formattedSpacing = str_replace('_', ' ', $spacing);
       $defaultPicketStyles = ['Slant Ear', 'Gothic Point', 'French Gothic'];
       
       $validCombos = DB::table('products')
           ->join('product_details', 'products.product_id', '=', 'product_details.product_id')
           ->select('style', 'speciality') 
           ->where([
               ['subcategory_id', $subcategoryId],
               ['spacing', $formattedSpacing]
           ]);
    
       if (!$showAll) {
           $validCombos->whereIn('speciality', $defaultPicketStyles);
       }
    
       $validCombos = $validCombos->distinct()->get();
    
       $styleGroups = [];
       foreach ($validCombos->groupBy('style') as $style => $combos) {
           $styleProducts = [];
           foreach ($combos as $combo) {
               $product = DB::table('products')
                   ->join('product_details', 'products.product_id', '=', 'product_details.product_id')
                   ->join('product_media', 'products.product_id', '=', 'product_media.product_id')
                   ->where([
                       ['products.subcategory_id', $subcategoryId],
                       ['product_details.spacing', $formattedSpacing],
                       ['product_details.style', $combo->style],
                       ['product_details.speciality', $combo->speciality]
                   ])
                   ->first();
    
               if ($product) {
                   $styleProducts[] = $product;
               }
           }
    
           if (!empty($styleProducts)) {
               $styleGroups[] = [
                   'style' => $style,
                   'products' => $styleProducts,
                   'showAll' => $showAll
               ];
           }
       }
    
       return view('categories.woodfence-specs', ['styleGroups' => $styleGroups]);
    }


}
