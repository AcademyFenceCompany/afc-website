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
                'frame' => 'Galvanized Pipe',
                'wire' => 'Galv 2" Mesh-9 Ga',
                'description' => 'Galv/Galv-2x4',
                'parent_suffix' => '', // Default system uses base parent code
                'image' => url('storage/products/chainlinks/chainlink_fence_galvframe_g.gif'),
                'type' => 'Standard',
            ],
            2 => [
                'name' => 'System 2',
                'frame' => 'Galvanized Pipe',
                'wire' => 'Blk 2" Mesh-9 Ga',
                'description' => 'Galv/Vinyl-2x4',
                'parent_suffix' => 'S2',
                'image' => url('storage/products/chainlinks/galvframe_blackwire.gif'),
                'type' => 'Standard',
            ],
            3 => [
                'name' => 'System 3',
                'frame' => 'Vinyl Coated Pipe',
                'wire' => 'Blk 2" Mesh-9 Ga',
                'description' => 'Vinyl/Vinyl-2x4',
                'parent_suffix' => 'S3',
                'image' => url('storage/products/chainlinks/blackframe_blackwire.gif'),
                'type' => 'Standard',
            ],
            4 => [
                'name' => 'System 4',
                'frame' => 'Galvanized Pipe',
                'wire' => 'Blk 1 1/4" Mesh-11 Ga',
                'description' => 'Galv/Vinyl-1 1/4',
                'parent_suffix' => 'S4',
                'image' => url('storage/products/chainlinks/galvframe_blackwirepc.gif'),
                'type' => 'Non-Climbable',
            ],
            5 => [
                'name' => 'System 5',
                'frame' => 'Vinyl Coated Pipe',
                'wire' => 'Blk 1 1/4" Mesh-11 Ga',
                'description' => 'Vinyl/Vinyl-1 1/4',
                'parent_suffix' => 'S5',
                'image' => url('storage/products/chainlinks/blackframe_blackwirepc.gif'),
                'type' => 'Non-Climbable',
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
        
        // Define style patterns for each system and height
        $heightPrefix = strtolower(substr($height, 0, 1)); // Get first character of height (4, 5, or 6)
        
        // Define frame types for each system
        $frameTypes = [
            1 => 'galv', // System 1: Galvanized frame and wire
            2 => 'galv', // System 2: Galvanized frame, black wire
            3 => 'vinyl', // System 3: Vinyl frame and wire
            4 => 'galv', // System 4: Galvanized frame, black wire (non-climbable)
            5 => 'vinyl', // System 5: Vinyl frame and wire (non-climbable)
        ];
        
        // Style pattern for the current height and system
        $stylePattern = $heightPrefix . 'ftsys' . $system;
        
        // Terminal post style pattern based on frame type for the current system
        $terminalPostPattern = $heightPrefix . 'ftsys' . $frameTypes[$system];
        
        // Log the patterns we're searching for
        \Illuminate\Support\Facades\Log::info("Searching for products with patterns: {$stylePattern}, {$terminalPostPattern}");
        
        // Get products for this height and system using style patterns
        $products = DB::connection('mysql_second')
            ->table('productsqry')
            ->where(function($query) use ($stylePattern, $terminalPostPattern) {
                // Match by style pattern for the specific height and system
                $query->where('style', 'LIKE', "%{$stylePattern}%")
                    // Or match terminal posts by frame type for this height
                    ->orWhere('style', 'LIKE', "%{$terminalPostPattern}%");
            })
            ->where('enabled', 1)
            ->select('id', 'product_name', 'item_no', 'price', 'desc_short', 'desc_long', 
                    'img_small', 'img_large', 'color', 'size', 'material', 'style', 
                    'product_assoc', 'parent')
            ->get();
            
        // Log how many products were found
        \Illuminate\Support\Facades\Log::info("Found " . $products->count() . " products for {$height} System {$system}");
        
        // Define product categories
        $productCategories = [
            'fence_section' => 'Fence Custom Complete (Price per Linear Foot)',
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
            
            // Determine product category based on style pattern and product name
            $category = null;
            
            // Convert style and product name to lowercase for easier matching
            $style = strtolower($product->style ?? '');
            $productName = strtolower($product->product_name ?? '');
            
            // Check for gates first (they're most specific)
            if (strpos($style, 'gate') !== false || 
                strpos($productName, 'gate') !== false ||
                strpos($productName, 'walk') !== false ||
                strpos($productName, 'drive') !== false) {
                $category = 'gates';
            }
            // Check for terminal posts
            elseif (strpos($style, 'post') !== false || 
                   strpos($style, 'terminal') !== false ||
                   strpos($productName, 'post') !== false ||
                   strpos($productName, 'terminal') !== false ||
                   strpos($productName, 'corner') !== false ||
                   strpos($productName, 'end post') !== false) {
                $category = 'terminal_posts';
            }
            // Default to fence section for remaining products
            else {
                $category = 'fence_section';
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
