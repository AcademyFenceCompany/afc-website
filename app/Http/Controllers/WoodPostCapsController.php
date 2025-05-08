<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WoodPostCapsController extends Controller
{
    public function index(Request $request, $style = null)
    {
        $categoryId = 82;

        // Define parent codes and their display names
        $parentGroups = [
            'AFCWPCP' => 'Standard Pyramid',
            'AFCWPCPD' => 'Dentil Pyramid',
            'AFCWPCPC' => 'Copper Pyramid',
            'AFCWPCF' => 'Standard Flat',
            'AFCWPCFD' => 'Dentil Flat',
            'AFCWPCFC' => 'Copper Flat',
            'AFCWPCB3' => '3" Ball',
            'AFCWPCBD3' => '3" Ball Dentil',
            'AFCWPCB5' => '5" Ball',
            'AFCWPCBC5' => 'Copper 5" Ball',
        ];

        // Slug-to-parent-code map
        $slugToParentCode = [
            'standard-pyramid' => 'AFCWPCP',
            'dentil-pyramid' => 'AFCWPCPD',
            'copper-pyramid' => 'AFCWPCPC',
            'standard-flat' => 'AFCWPCF',
            'dentil-flat' => 'AFCWPCFD',
            'copper-flat' => 'AFCWPCFC',
            '3-ball' => 'AFCWPCB3',
            '3-ball-dentil' => 'AFCWPCBD3',
            '5-ball' => 'AFCWPCB5',
            '5-ball-copper' => 'AFCWPCBC5',
        ];

        $defaultImage = url('storage/products/default.png');

        // Fetch products
        $products = DB::connection('mysql_second')
            ->table('productsqry')
            ->where('categories_id', $categoryId)
            ->where('enabled', 1)
            ->get();

        // Group products by parent code
        $productsByParent = [];
        $productData = [];

        foreach ($products as $product) {
            $parentCode = $product->parent ?? '';
            if (!isset($parentGroups[$parentCode]))
                continue;

            $productsByParent[$parentCode][] = $product;

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

        // Representative product for each type
        $representativeProducts = [];
        foreach ($parentGroups as $code => $name) {
            if (!empty($productsByParent[$code])) {
                $representativeProducts[$code] = $productsByParent[$code][0];
            }
        }

        // Breadcrumbs setup
        $breadcrumbs = [
            ['name' => 'Wood Fence', 'url' => '/wood-fence'],
            ['name' => 'Wood Post Caps', 'url' => '/wood-fence/wood-post-caps'],
        ];

        $selectedParent = null;

        if ($style && isset($slugToParentCode[$style])) {
            $selectedParent = $slugToParentCode[$style];

            // Add final breadcrumb dynamically
            $breadcrumbs[] = [
                'name' => $parentGroups[$selectedParent],
                'url' => $request->url()
            ];
        }

        return view('categories.woodpostcaps', [
            'representativeProducts' => $representativeProducts,
            'productsByParent' => $productsByParent,
            'productData' => $productData,
            'parentGroups' => $parentGroups,
            'defaultImage' => $defaultImage,
            'selectedParent' => $selectedParent,
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}
