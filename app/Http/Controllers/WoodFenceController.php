<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class WoodFenceController extends Controller
{
    public function index()
    {
        // Fetch direct subcategories for Wood Fence
        $woodFenceSubcategories = DB::table('family_categories')
            ->where('parent_category_id', 16) 
            ->where('family_category_name', 'not like', '%Wood%Fence%')
            ->select('family_category_id', 'family_category_name', 'category_description')
            ->get();

        // Recursive Child Fetching Logic with Images and Descriptions
        $subcategoriesWithSpacing = [];
        foreach ($woodFenceSubcategories as $subcategory) {
            // Fetch image and description for the current subcategory
            $image = DB::table('general_media')
                ->where('subcategory_id', $subcategory->family_category_id)
                ->where('purpose', 'LIKE', '%Wood Fence General page%')
                ->value('image');

            // Fetch child categories
            $childCategories = DB::table('family_categories')
                ->where('parent_category_id', $subcategory->family_category_id)
                ->select('family_category_id', 'family_category_name')
                ->get();

            $childrenWithSpacing = [];
            foreach ($childCategories as $child) {
                $spacingOptions = DB::table('product_details')
                    ->where('family_category_id', $child->family_category_id)
                    ->whereNotNull('spacing')
                    ->distinct()
                    ->pluck('spacing');

                if ($spacingOptions->isNotEmpty()) {
                    $childrenWithSpacing[] = [
                        'name' => $child->family_category_name,
                        'id' => $child->family_category_id,
                        'spacing_options' => $spacingOptions
                    ];
                }
            }

            // Add subcategories, images, descriptions, and their children
            $subcategoriesWithSpacing[] = [
                'name' => $subcategory->family_category_name,
                'id' => $subcategory->family_category_id,
                'description' => $subcategory->category_description ?? 'No description available', // Default empty description
                'image' => $image ?? '/default.png', // Default image fallback
                'spacing_options' => $this->fetchSpacingOptions($subcategory->family_category_id),
                'children' => $childrenWithSpacing
            ];
        }

        return view('categories.woodfence', ['subcategories' => $subcategoriesWithSpacing]);
    }


public function getProductsGroupedByStyle($subcategoryId, $spacing)
    {
    // Format the spacing value
    $formattedSpacing = str_replace('_', ' ', $spacing);

    // Define styles and picket styles
    $styles = ['Straight on Top', 'Concave', 'Convex'];
    $picketStyles = ['Slant Ear', 'Gothic Point', 'French Gothic'];

    // Initialize results array
    $styleGroups = [];

    foreach ($styles as $style) {
        $styleData = [
            'style' => $style,
            'products' => [],
        ];

        foreach ($picketStyles as $picketStyle) {
            $product = DB::table('products')
                ->join('family_categories', 'products.subcategory_id', '=', 'family_categories.family_category_id')
                ->join('product_details', 'products.product_id', '=', 'product_details.product_id')
                ->join('product_media', 'products.product_id', '=', 'product_media.product_id')
                ->where('products.subcategory_id', $subcategoryId)
                ->where('product_details.style', $style)
                ->where('product_details.speciality', $picketStyle)
                ->where('product_details.spacing', $formattedSpacing)
                ->select('products.product_id', 'products.*', 'product_details.*', 'product_media.*')
                ->get();

    if (!$product) {
        \Log::info("No product found", [
            'style' => $style,
            'picket_style' => $picketStyle,
            'spacing' => $formattedSpacing,
        ]);
    } else {
        $styleData['products'][] = $product;
    }
        }

        $styleGroups[] = $styleData;
    }

    if (empty(array_filter($styleGroups, fn($group) => !empty($group['products'])))) {
        return view('categories.woodfence-specs', [
            'styleGroups' => $styleGroups,
            'message' => 'No products found for the selected spacing.'
        ]);
    }
    return view('categories.woodfence-specs', ['styleGroups' => $styleGroups]);
}

public function getProductsGroupWoSpacing($subcategoryId)
{
    $styles = ['Straight on Top', 'Concave', 'Convex'];
    $picketStyles = ['Slant Ear', 'Gothic Point', 'French Gothic'];
    $sizes = ['6 ft. H x 8 ft. W', '4 ft. H x 8 ft. W'];

    // Initialize results array
    $styleGroups = [];

    foreach ($styles as $style) {
        $styleData = [
            'style' => $style,
            'products' => [],
        ];

        foreach ($picketStyles as $picketStyle) {
            // Fetch the first matching product for the style, picket style, and spacing
            $product = DB::table('products')
                ->join('product_details', 'products.product_id', '=', 'product_details.product_id')
                ->join('product_media', 'products.product_id', '=', 'product_media.product_id')
                ->where('products.subcategory_id', $subcategoryId)
                ->where('product_details.style', $style)
                ->where('product_details.speciality', $picketStyle)
                ->whereIn('product_details.size1', $sizes)
                ->select('products.*', 'product_details.*', 'product_media.*')
                ->first();

            // Debug for each style and picket style
    if (!$product) {
        \Log::info("No product found", [
            'style' => $style,
            'picket_style' => $picketStyle,
        ]);
    } else {
        $styleData['products'][] = $product;
    }
        }

        $styleGroups[] = $styleData;
    }
    // Check if no products were found
    if (empty(array_filter($styleGroups, fn($group) => !empty($group['products'])))) {
        return view('categories.woodfence-specs', [
            'styleGroups' => $styleGroups,
            'message' => 'No products found for the selected spacing.'
        ]);
    }

    // Pass data to the view
    return view('categories.woodfence-specs', ['styleGroups' => $styleGroups]);
}


    private function fetchSpacingOptions($categoryId)
    {
        return DB::table('product_details')
            ->where('family_category_id', $categoryId)
            ->whereNotNull('spacing')
            ->distinct()
            ->pluck('spacing');
    }

    public function show($subcategoryId, $spacing)
    {
        // Get the subcategory details
        $subcategory = DB::table('family_categories')
            ->where('family_category_id', $subcategoryId)
            ->first();

        // Get products for this subcategory and spacing
        $products = DB::table('products')
            ->join('product_details', 'products.product_id', '=', 'product_details.product_id')
            ->join('product_media', 'products.product_id', '=', 'product_media.product_id')
            ->join('shipping_details', 'products.product_id', '=', 'shipping_details.product_id')
            ->where('products.family_category_id', $subcategoryId)
            ->where('product_details.spacing', str_replace('_', ' ', $spacing))
            ->select(
                'products.product_id',
                'products.item_no',
                'products.product_name',
                'products.description',
                'products.price_per_unit',
                'product_details.size1',
                'product_details.size2',
                'product_details.size3',
                'product_details.style',
                'product_details.speciality',
                'product_details.material',
                'product_details.spacing',
                'product_details.color',
                'product_media.large_image',
                'shipping_details.weight'
            )
            ->get();

        return view('categories.woodfence-specs', [
            'subcategory' => $subcategory,
            'products' => $products,
            'spacing' => str_replace('_', ' ', $spacing)
        ]);
    }

}
