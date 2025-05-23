<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SingleProductController extends Controller
{
    public function show($id)
    {
        $productDetails = DB::connection('academyfence')
            ->table('productsqry')
            ->where('id', $id)
            ->select
            ('product_name','item_no', 'desc_short', 'price', 'id', 'size', 'size2', 
            'size3', 'color', 'style', 'speciality', 'spacing', 'coating', 
            'weight_lbs','material', 'free_shipping', 'special_shipping', 
            'amount_per_box', 'img_large', 'img_small', 'weight_lbs','maj_cat_name', 
            'majorcategories_id','categories_id','ship_length', 'ship_width', 'ship_height',
            'product_assoc', 'product_relatives')
            ->first();
            
    
        $productVariations = DB::connection('academyfence')
            ->table('productsqry')
            ->where('categories_id', $productDetails->categories_id)
            ->where('style', $productDetails->style)
            ->where('speciality', $productDetails->speciality)
            ->where('spacing', $productDetails->spacing)
            ->where('coating', $productDetails->coating)
            ->select('size', 'size2', 'size3', 'color', 'id')
            ->get();
    
        $productOptions = DB::connection('academyfence')
            ->table('productsqry')
            ->where('categories_id', $productDetails->categories_id)
            ->where('style', $productDetails->style)
            ->where('speciality', $productDetails->speciality)
            ->where('spacing', $productDetails->spacing)
            ->where('coating', $productDetails->coating)
            ->select('size', 'size2', 'size3', 'color', 'id')
            ->get() 
            ->map(function ($option) use ($id) {
                return [
                    'value' => $option->id,
                    'text' => $option->size . ' - ' . ucfirst($option->color),
                    'selected' => $option->id == $id
                ];
            });

        // Process associated products from product_assoc field
        $associatedSections = [];
        if (!empty($productDetails->product_assoc)) {
            $assocData = $productDetails->product_assoc;
            $sections = [];
            $currentTitle = null;
            $currentItems = [];
            
            // Split the string using comma as delimiter
            $parts = explode(',', $assocData);
            
            foreach ($parts as $part) {
                // Check if it's a section title (enclosed in --)
                if (preg_match('/--(.+?)--/', $part, $matches)) {
                    // If we already have a title and items, save them
                    if ($currentTitle !== null && count($currentItems) > 0) {
                        $sections[] = [
                            'title' => $currentTitle,
                            'items' => $currentItems
                        ];
                        $currentItems = []; // Reset items array
                    }
                    $currentTitle = $matches[1]; // Save the new title
                } else {
                    // It's an item number, add to current section
                    $currentItems[] = trim($part);
                }
            }
            
            // Add the last section if it exists
            if ($currentTitle !== null && count($currentItems) > 0) {
                $sections[] = [
                    'title' => $currentTitle,
                    'items' => $currentItems
                ];
            }
            
            // Now fetch all these products from database
            foreach ($sections as $section) {
                $sectionProducts = DB::connection('academyfence')
                    ->table('productsqry')
                    ->whereIn('item_no', $section['items'])
                    ->select('id', 'item_no', 'product_name', 'size', 'color', 'price', 'img_small')
                    ->get();
                
                if ($sectionProducts->count() > 0) {
                    $associatedSections[] = [
                        'title' => $section['title'],
                        'products' => $sectionProducts
                    ];
                }
            }
        }
        
        // Process related products from product_relatives field
        $relatedProducts = [];
        if (!empty($productDetails->product_relatives)) {
            $relItemNos = explode(',', $productDetails->product_relatives);
            $relItemNos = array_map('trim', $relItemNos);
            
            $relatedProducts = DB::connection('academyfence')
                ->table('productsqry')
                ->whereIn('item_no', $relItemNos)
                ->select('id', 'item_no', 'product_name', 'price', 'img_small', 'img_large')
                ->get();
        }

        // Fetch French Gothic Posts from demodb
        $frenchGothicPosts = DB::connection('academyfence')
            ->table('productsqry')
            ->where('parent', 'like', 'AFCGWP')
            ->where('size', 'like', '4in x 4in%')
            ->select('item_no', 'product_name', 'size', 'color', 'price')
            ->get();

        // Fetch Flat Posts from demodb
        $flatPosts = DB::connection('academyfence')
            ->table('productsqry')
            ->where('parent', 'like', 'AFCFWP')
            ->where('size', 'like', '4in x 4in%')
            ->select('item_no', 'product_name', 'size', 'color', 'price')
            ->get();

        // Fetch Flat Posts 5x5 from demodb
        $flatPosts5x5 = DB::connection('academyfence')
            ->table('productsqry')
            ->where('item_no', 'like', 'PSFL5%')
            ->where('size', 'like', '5in x 5in%')
            ->select('item_no', 'product_name', 'size', 'color', 'price')
            ->get();

        // Fetch Single Gate from demodb
        $singleGate = DB::connection('academyfence')
            ->table('productsqry')
            ->where('spacing', $productDetails->spacing)
            ->where('style', $productDetails->style)
            ->where('speciality', $productDetails->speciality)
            ->select('item_no', 'product_name', 'size', 'color', 'price')
            ->get();

        $inventoryDetails = DB::table('inventory_details')
            ->where('product_id', $id)
            ->select('in_stock_hq', 'in_stock_warehouse', 'inventory_ordered', 'inventory_expected_date')
            ->first();

        return view('products.single-product', [
            'productDetails' => $productDetails,
            'productOptions' => $productOptions,
            'frenchGothicPosts' => $frenchGothicPosts,
            'flatPosts' => $flatPosts,
            'flatPosts5x5' => $flatPosts5x5,
            'inventoryDetails' => $inventoryDetails,
            'productVariations' => $productVariations,
            'singleGate' => $singleGate,
            'associatedSections' => $associatedSections,
            'relatedProducts' => $relatedProducts
        ]);
    }

    public function fetchProductDetails($id)
    {
        $productDetails = DB::connection('academyfence')
            ->table('productsqry')
            ->where('id', $id)
            ->select(
                'product_name',
                'item_no',
                'desc_short',
                'price',
                'id',
                'size',
                'size2',
                'size3',
                'color',
                'style',
                'speciality',
                'spacing',
                'coating',
                'free_shipping',
                'special_shipping',
                'amount_per_box',
                'img_large',
                'img_small',
                'weight_lbs',
                'majorcategories_id',
                'maj_cat_name',
                'material',
                'ship_length',
                'ship_width',
                'ship_height',
                'product_assoc',
                'product_relatives'
                )
            ->first();
        return response()->json($productDetails);
    }
}
