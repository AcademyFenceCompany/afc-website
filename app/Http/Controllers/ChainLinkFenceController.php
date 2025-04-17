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
            ->where('majorcategories_id', 17) // Chain Link fence major category ID
            ->where('web_enabled', 1)
            ->select('id', 'cat_name as family_category_name', 'cat_desc_long', 'seo_name')
            ->get();
            
        // Format the categories with images
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
        // Validate height parameter
        if (!in_array($height, ['4ft', '5ft', '6ft'])) {
            abort(404);
        }
        
        // Validate system parameter
        $system = (int)$system;
        if ($system < 1 || $system > 5) {
            $system = 1; // Default to System 1
        }
        
        // Define the systems
        $systems = [
            1 => [
                'name' => 'System 1',
                'description' => 'Galv Wire 2" + Galv Frame',
                'parent_suffix' => '' // Default system uses base parent code
            ],
            2 => [
                'name' => 'System 2',
                'description' => 'Vinyl Wire 2" + Galv Frame',
                'parent_suffix' => 'S2'
            ],
            3 => [
                'name' => 'System 3',
                'description' => 'Vinyl Wire 2" + Color Coated Frame',
                'parent_suffix' => 'S3'
            ],
            4 => [
                'name' => 'System 4',
                'description' => 'Pool Code Vinyl Wire 1 1/4" + Galv Frame',
                'parent_suffix' => 'S4'
            ],
            5 => [
                'name' => 'System 5',
                'description' => 'Pool Code Vinyl Wire 1 1/4" + Color Coated Frame',
                'parent_suffix' => 'S5'
            ]
        ];
        
        // Get parent code based on height
        $parentCode = '';
        if ($height === '4ft') {
            $parentCode = 'AFCCLC4';
        } elseif ($height === '5ft') {
            $parentCode = 'AFCCLC5';
        } elseif ($height === '6ft') {
            $parentCode = 'AFCCLC6';
        }
        
        // Add system suffix if not system 1
        if ($system > 1) {
            $parentCode .= $systems[$system]['parent_suffix'];
        }
        
        // Get products for this height and system by parent value
        $products = DB::connection('mysql_second')
            ->table('productsqry')
            ->where('parent', 'LIKE', "{$parentCode}%")
            ->where('enabled', 1)
            ->select('id', 'product_name', 'item_no', 'price', 'desc_short', 'desc_long', 'img_small', 'img_large', 'color', 'size', 'material', 'style', 'product_assoc', 'parent')
            ->get();
            
        // Define specific product IDs for each system
        $systemProductIds = [
            1 => [
                'fence_section' => [2720],
                'terminal_posts' => [2721, 2722],
                'gates' => [2877, 2878, 2879, 3029, 3053, 3057]
            ],
            2 => [
                'fence_section' => [2723],
                'terminal_posts' => [2721, 2722],
                'gates' => [2880, 2881, 2882, 3060, 3063, 3065]
            ],
            3 => [
                'fence_section' => [2726],
                'terminal_posts' => [2741, 2732],
                'gates' => [2887, 2888, 2889, 3070, 3072, 3074]
            ],
            4 => [
                'fence_section' => [2744],
                'terminal_posts' => [2721, 2722],
                'gates' => [2898, 2900, 2902, 3079, 3081, 3083]
            ],
            5 => [
                'fence_section' => [2730],
                'terminal_posts' => [2741, 2732],
                'gates' => [2908, 2910, 2912, 3087, 3088, 3090]
            ]
        ];
        
        // Define product categories
        $productCategories = [
            'fence_section' => 'Fence Section (Price per Linear Foot)',
            'terminal_posts' => 'Terminal Posts',
            'gates' => 'Gates w/hardware',
        ];
        
        // Group products by category
        $productGroups = [];
        foreach ($productCategories as $categoryKey => $categoryName) {
            $productGroups[$categoryKey] = [
                'title' => $categoryName,
                'products' => []
            ];
        }
        
        // Process each product
        foreach ($products as $product) {
            // Add image URL
            $product->img_url = $product->img_large 
                ? url('storage/products/' . $product->img_large) 
                : ($product->img_small 
                    ? url('storage/products/' . $product->img_small) 
                    : url('storage/products/default.png'));
            
            // Determine product category based on ID
            $category = null; // Default to null (no category)
            
            // Check if product is a gate
            if (isset($systemProductIds[$system]['gates']) && in_array($product->id, $systemProductIds[$system]['gates'])) {
                $category = 'gates';
            }
            // Check other categories
            else {
                foreach (['fence_section', 'terminal_posts'] as $cat) {
                    if (isset($systemProductIds[$system][$cat]) && in_array($product->id, $systemProductIds[$system][$cat])) {
                        $category = $cat;
                        break;
                    }
                }
            }
            
            // Only add product if it belongs to a defined category
            if ($category !== null && isset($productGroups[$category])) {
                $productGroups[$category]['products'][] = $product;
            }
        }
        
        // Remove empty categories
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
    
    /**
     * Determine the product type based on its attributes
     * 
     * @param object $product
     * @return string
     */
    private function determineProductType($product)
    {
        $name = strtolower($product->product_name);
        
        if (strpos($name, 'post') !== false) {
            return 'Posts';
        } elseif (strpos($name, 'gate') !== false) {
            return 'Gates';
        } elseif (strpos($name, 'fabric') !== false || strpos($name, 'mesh') !== false) {
            return 'Fabric & Mesh';
        } elseif (strpos($name, 'rail') !== false) {
            return 'Rails';
        } elseif (strpos($name, 'fitting') !== false || strpos($name, 'hardware') !== false) {
            return 'Fittings & Hardware';
        } else {
            return 'Other Components';
        }
    }
}
