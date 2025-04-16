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
    
    public function heightCategory($height)
    {
        // Validate height parameter
        if (!in_array($height, ['4ft', '5ft', '6ft'])) {
            abort(404);
        }
        
        // Get parent code based on height
        $parentCode = '';
        if ($height === '4ft') {
            $parentCode = 'AFCCLC4';
        } elseif ($height === '5ft') {
            $parentCode = 'AFCCLC5';
        } elseif ($height === '6ft') {
            $parentCode = 'AFCCLC6';
        }
        
        // Get products for this height by parent value
        $products = DB::connection('mysql_second')
            ->table('productsqry')
            ->where('parent', 'LIKE', "{$parentCode}%")
            ->where('enabled', 1)
            ->select('id', 'product_name', 'item_no', 'price', 'desc_short', 'desc_long', 'img_small', 'img_large', 'color', 'size', 'material', 'style', 'product_assoc', 'parent')
            ->get();
            
        // Group products by type
        $groupedProducts = [];
        
        foreach ($products as $product) {
            // Add image URL
            $product->img_url = $product->img_large 
                ? url('storage/products/' . $product->img_large) 
                : ($product->img_small 
                    ? url('storage/products/' . $product->img_small) 
                    : url('storage/products/default.png'));
                    
            // Determine product type based on name or other attributes
            $type = $this->determineProductType($product);
            
            if (!isset($groupedProducts[$type])) {
                $groupedProducts[$type] = [
                    'title' => $type,
                    'products' => []
                ];
            }
            
            $groupedProducts[$type]['products'][] = $product;
        }
        
        return view('categories.chainlink.height', [
            'height' => $height,
            'productGroups' => $groupedProducts,
            'pageTitle' => "{$height} Chain Link Fence Products"
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
