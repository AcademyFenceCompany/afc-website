<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WoodPostCapsController extends Controller
{
    public function index(Request $request, $style = null)
    {
        // Category ID for Wood Post Caps
        $categoryId = 82;

        // Fetch products from the database
        $query = DB::connection('academyfence')
            ->table('productsqry')
            ->where('categories_id', $categoryId)
            ->where('enabled', 1);

        $products = $query->get();

        // Define parent codes and their display names
        $parentGroups = [
            'AFCWPCP' => 'Standard Pyramid',
            'AFCWPCPD' => 'Ball Top',
            'AFCWPCPC' => 'Ball Only',
            'AFCWPCF' => 'Standard Flat',
            'AFCWPCFD' => 'Dentil Flat',
            'AFCWPCFC' => 'Copper Flat',
            'AFCWPCB3' => '3" Ball',
            'AFCWPCBD3' => '3" Ball Dentil',
            'AFCWPCB5' => '5" Ball',
            'AFCWPCBC5' => 'Copper 5" Ball',
        ];

        // Default image path
        $defaultImage = url('storage/products/default.png');

        // Process products and group by parent
        $productsByParent = [];
        $productData = [];

        foreach ($products as $product) {
            // Get parent code
            $parentCode = $product->parent ?? '';

            // Skip if not a valid parent code
            if (!isset($parentGroups[$parentCode])) {
                continue;
            }

            // Initialize parent group if not exists
            if (!isset($productsByParent[$parentCode])) {
                $productsByParent[$parentCode] = [];
            }

            // Add product to the appropriate parent group
            $productsByParent[$parentCode][] = $product;

            // Store product data for easy access
            $productData[$product->id] = [
                'image' => $product->img_large ? url('storage/products/' . $product->img_large) : $defaultImage,
                'price' => $product->price ?? 0,
                'name' => $product->product_name ?? '',
                'item_no' => $product->item_no ?? '',
                'size' => $product->size ?? '',
                'alt_length' => $product->alt_length ?? '',
                'size2' => $product->size2 ?? '',
            ];
        }

        // Get one representative product for each parent group for the main view
        $representativeProducts = [];

        foreach ($parentGroups as $code => $name) {
            if (isset($productsByParent[$code]) && !empty($productsByParent[$code])) {
                $representativeProducts[$code] = $productsByParent[$code][0];
            }
        }

        // If a specific style is requested, filter products
        $currentStyle = null;
        if ($style && isset($parentGroups[$style])) {
            $currentStyle = $style;

            // We're still returning all products, but marking which one is selected
            return view('categories.woodpostcaps', [
                'representativeProducts' => $representativeProducts,
                'productsByParent' => $productsByParent,
                'productData' => $productData,
                'currentStyle' => $currentStyle,
                'parentGroups' => $parentGroups,
                'defaultImage' => $defaultImage,
                'selectedParent' => $style
            ]);
        }

        // Return the view with the grouped products
        return view('categories.woodpostcaps', [
            'representativeProducts' => $representativeProducts,
            'productsByParent' => $productsByParent,
            'parentGroups' => $parentGroups,
            'productData' => $productData,
            'defaultImage' => $defaultImage
        ]);
    }
}
