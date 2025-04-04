<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SingleProductController extends Controller
{
    public function show($id)
    {
       
        $productDetails = DB::connection('mysql_second')
            ->table('productsqry')
            ->where('id', $id)
            ->select
            ('product_name','item_no', 'desc_short', 'price', 'id', 'size', 'size2', 
            'size3', 'color', 'style', 'speciality', 'spacing', 'coating', 
            'weight_lbs','material', 'free_shipping', 'special_shipping', 
            'amount_per_box', 'img_large', 'img_small', 'weight_lbs','maj_cat_name', 
            'majorcategories_id','categories_id','ship_length', 'ship_width', 'ship_height' )
            ->first();
            
    
        $productVariations = DB::connection('mysql_second')
            ->table('productsqry')
            ->where('categories_id', $productDetails->categories_id)
            ->where('style', $productDetails->style)
            ->where('speciality', $productDetails->speciality)
            ->where('spacing', $productDetails->spacing)
            ->where('coating', $productDetails->coating)
            ->select('size', 'size2', 'size3', 'color', 'id')
            ->get();
    
        $productOptions = DB::connection('mysql_second')
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
        // Fetch French Gothic Posts from demodb
        $frenchGothicPosts = DB::connection('mysql_second')
            ->table('productsqry')
            ->where('parent', 'like', 'AFCGWP')
            ->where('size', 'like', '4in x 4in%')
            ->select('item_no', 'product_name', 'size', 'color', 'price')
            ->get();

        // Fetch Flat Posts from demodb
        $flatPosts = DB::connection('mysql_second')
            ->table('productsqry')
            ->where('parent', 'like', 'AFCFWP')
            ->where('size', 'like', '4in x 4in%')
            ->select('item_no', 'product_name', 'size', 'color', 'price')
            ->get();

        // Fetch Flat Posts 5x5 from demodb
        $flatPosts5x5 = DB::connection('mysql_second')
            ->table('productsqry')
            ->where('item_no', 'like', 'PSFL5%')
            ->where('size', 'like', '5in x 5in%')
            ->select('item_no', 'product_name', 'size', 'color', 'price')
            ->get();

        // Fetch Single Gate from demodb
        $singleGate = DB::connection('mysql_second')
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
            'singleGate' => $singleGate
        ]);
    }

    public function fetchProductDetails($id)
    {
        $productDetails = DB::connection('mysql_second')
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
                'img_large',
                'img_small',
                'weight_lbs',
                'majorcategories_id',
                'maj_cat_name',
                'material',
                'ship_length',
                'ship_width',
                'ship_height'
                )
            ->first();
        return response()->json($productDetails);
    }
}
