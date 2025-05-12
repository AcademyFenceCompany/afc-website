<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChainLinkFenceController extends Controller
{
    public function main()
    {
        // Get chain link fence parent groups
        $parentGroups = [
            [
                'title' => '4ft Complete Chain Link Fence',
                'code' => 'AFCCLC4',
                'image' => url('storage/products/4ft.jpg'),
                'description' => 'Complete 4ft chain link fence system with all necessary components.'
            ],
            [
                'title' => '5ft Complete Chain Link Fence',
                'code' => 'AFCCLC5',
                'image' => url('storage/products/5ft.jpg'),
                'description' => 'Complete 5ft chain link fence system with all necessary components.'
            ],
            [
                'title' => '6ft Complete Chain Link Fence',
                'code' => 'AFCCLC6',
                'image' => url('storage/products/6ft.jpg'),
                'description' => 'Complete 6ft chain link fence system with all necessary components.'
            ]
        ];

        // Get chain link categories from the database
        $chainlinkCategories = DB::connection('mysql_second')
            ->table('categories')
            ->where('majorcategories_id', 17)
            ->where('web_enabled', 1)
            ->select('id', 'cat_name as family_category_name', 'cat_desc_long', 'seo_name')
            ->get();

        $formattedCategories = [];
        foreach ($chainlinkCategories as $category) {
            $formattedCategories[] = [
                'family_category_id' => $category->id,
                'family_category_name' => $category->family_category_name,
                'cat_desc_long' => $category->cat_desc_long,
                'seo_name' => $category->seo_name,
            ];
        }

        return view('categories.chainlink.main', [
            'parentGroups' => $parentGroups,
            'chainlink_categories' => collect($formattedCategories),
            'headerImage' => url('storage/products/chainlinkmain_1.jpg')
        ]);
    }

    public function heightCategory($height, $system = 1)
    {
        if (!in_array($height, ['4ft', '5ft', '6ft'])) {
            abort(404);
        }

        $system = (int) $system;
        if ($system < 1 || $system > 5) {
            $system = 1;
        }

        $fallbackImages = [
            1 => 'chainlinks/chainlink_fence_galvframe_g.gif',
            2 => 'chainlinks/galvframe_blackwire.gif',
            3 => 'chainlinks/blackframe_blackwire.gif',
            4 => 'chainlinks/galvframe_blackwirepc.gif',
            5 => 'chainlinks/blackframe_blackwirepc.gif',
        ];

        $systems = [
            1 => [
                'name' => 'System 1',
                'frame' => 'Galvanized Pipe',
                'wire' => 'Galv 2" Mesh-9 Ga',
                'description' => 'Galv/Galv-2x4',
                'parent_suffix' => '',
                'image' => null,
                'type' => 'Standard',
            ],
            2 => [
                'name' => 'System 2',
                'frame' => 'Galvanized Pipe',
                'wire' => 'Blk 2" Mesh-9 Ga',
                'description' => 'Galv/Vinyl-2x4',
                'parent_suffix' => 'S2',
                'image' => null,
                'type' => 'Standard',
            ],
            3 => [
                'name' => 'System 3',
                'frame' => 'Vinyl Coated Pipe',
                'wire' => 'Blk 2" Mesh-9 Ga',
                'description' => 'Vinyl/Vinyl-2x4',
                'parent_suffix' => 'S3',
                'image' => null,
                'type' => 'Standard',
            ],
            4 => [
                'name' => 'System 4',
                'frame' => 'Galvanized Pipe',
                'wire' => 'Blk 1 1/4" Mesh-11 Ga',
                'description' => 'Galv/Vinyl-1 1/4',
                'parent_suffix' => 'S4',
                'image' => null,
                'type' => 'Non-Climbable',
            ],
            5 => [
                'name' => 'System 5',
                'frame' => 'Vinyl Coated Pipe',
                'wire' => 'Blk 1 1/4" Mesh-11 Ga',
                'description' => 'Vinyl/Vinyl-1 1/4',
                'parent_suffix' => 'S5',
                'image' => null,
                'type' => 'Non-Climbable',
            ],
        ];

        $baseParentCode = 'AFCCLC' . substr($height, 0, 1);

        foreach ($systems as $id => &$sys) {
            $parentCode = $baseParentCode . $sys['parent_suffix'];
            
            // More flexible search for system images
            $query = DB::connection('mysql_second')
                ->table('productsqry');
                
            // For System 1, use exact parent match
            if ($id == 1) {
                $query->where('parent', 'like', $parentCode . '%');
            } else {
                // For Systems 2-5, try alternative search patterns
                $heightNumber = substr($height, 0, 1);
                $systemNumber = $id;
                $query->where(function($q) use ($parentCode, $heightNumber, $systemNumber) {
                    $q->where('parent', 'like', $parentCode . '%')
                      // Try searching by height and system in product name
                      ->orWhere('product_name', 'like', "%{$heightNumber}ft%system {$systemNumber}%")
                      ->orWhere('product_name', 'like', "%{$heightNumber}' %system {$systemNumber}%")
                      // Try searching by system type in style field
                      ->orWhere('style', 'like', "%sys{$systemNumber}%")
                      ->orWhere('style', 'like', "%system{$systemNumber}%");
                });
            }
            
            $img = $query->whereNotNull('img_large')
                ->where('img_large', '!=', '')
                ->orderBy('id')
                ->value('img_large');

            $sys['image'] = $img
                ? url('storage/products/' . $img)
                : url('storage/products/' . $fallbackImages[$id]);
        }
        unset($sys);

        $parentCode = $baseParentCode . ($system > 1 ? $systems[$system]['parent_suffix'] : '');

        $heightPrefix = strtolower(substr($height, 0, 1));

        $frameTypes = [
            1 => 'galv',
            2 => 'galv',
            3 => 'vinyl',
            4 => 'galv',
            5 => 'vinyl',
        ];

        $stylePattern = $heightPrefix . 'ftsys' . $system;
        $terminalPostPattern = $heightPrefix . 'ftsys' . $frameTypes[$system];

        Log::info("Searching for products with patterns: {$stylePattern}, {$terminalPostPattern}");

        $products = DB::connection('mysql_second')
            ->table('products')
            ->where(function ($query) use ($stylePattern, $terminalPostPattern) {
                $query->where('style', 'LIKE', "%{$stylePattern}%")
                      ->orWhere('style', 'LIKE', "%{$terminalPostPattern}%");
            })
            ->where('enabled', 1)
            ->get();

        Log::info("Found " . $products->count() . " products for {$height} System {$system}");

        $productCategories = [
            'fence_section' => 'Fence Custom Complete (Price per Linear Foot)',
            'terminal_posts' => 'Terminal Posts',
            'gates' => 'Gates w/hardware',
        ];

        $productGroups = [];
        foreach ($productCategories as $key => $name) {
            $productGroups[$key] = ['title' => $name, 'products' => []];
        }

        foreach ($products as $product) {
            $product->img_url = $product->img_large 
                ? url('storage/products/' . $product->img_large) 
                : ($product->img_small 
                    ? url('storage/products/' . $product->img_small) 
                    : url('storage/products/default.png'));

            $style = strtolower($product->style ?? '');
            $productName = strtolower($product->product_name ?? '');

            $category = null;
            if (strpos($style, 'gate') !== false || strpos($productName, 'gate') !== false || strpos($productName, 'walk') !== false || strpos($productName, 'drive') !== false) {
                $category = 'gates';
            } elseif (strpos($style, 'post') !== false || strpos($style, 'terminal') !== false || strpos($productName, 'post') !== false || strpos($productName, 'terminal') !== false || strpos($productName, 'corner') !== false || strpos($productName, 'end post') !== false) {
                $category = 'terminal_posts';
            } else {
                $category = 'fence_section';
            }

            if ($category !== null && isset($productGroups[$category])) {
                $productGroups[$category]['products'][] = $product;
            }
        }

        foreach ($productGroups as $key => $group) {
            if (empty($group['products'])) {
                unset($productGroups[$key]);
            }
        }

        return view('categories.chainlink.height', [
            'height' => $height,
            'system' => $system,
            'systems' => $systems,
            'productGroups' => $productGroups,
            'pageTitle' => "{$height} Chain Link Fence - {$systems[$system]['description']}"
        ]);
    }
}
