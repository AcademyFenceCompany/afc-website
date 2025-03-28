<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SingleProductController extends Controller
{
    public function show($id)
    {
        $productDetails = DB::table('products')
            ->join('product_details', 'products.product_id', '=', 'product_details.product_id')
            ->join('product_media', 'products.product_id', '=', 'product_media.product_id')
            ->leftJoin('shipping_details', 'products.product_id', '=', 'shipping_details.product_id') // Changed to leftJoin
            ->where('products.product_id', $id)
            ->select(
                'products.product_name',
                'products.item_no',
                'products.description',
                'products.price_per_unit',
                'products.subcategory_id',
                'product_details.*',
                'product_media.general_image',
                'product_media.large_image',
                'product_media.small_image',
                'shipping_details.*'
            )
            ->first();

        $productVariations = DB::table('products')
            ->join('product_details', 'product_details.product_id', '=', 'products.product_id')
            ->where('products.subcategory_id', $productDetails->subcategory_id)
            ->select(
                'product_details.size1',
                'product_details.size2',
                'product_details.size3',
                'product_details.color',
                'products.product_id',
            )
            ->get();


        // Dynamically fetch options based on style, speciality, and category
        $productOptions = DB::table('products as p')
            ->join('family_categories as fc', 'p.subcategory_id', '=', 'fc.family_category_id')
            ->join('product_details as pd', 'p.product_id', '=', 'pd.product_id')
            // ->where('pd.style', $productDetails->style)
            // ->where('pd.speciality', $productDetails->speciality)
            ->where('pd.size2', $productDetails->size2)
            ->where('pd.size3', $productDetails->size3)
            ->where('p.subcategory_id', $productDetails->family_category_id)
            ->select('p.product_id', 'pd.size1', 'pd.color')
            ->distinct()
            ->get()
            ->map(function ($option) use ($id) {
                return [
                    'value' => $option->product_id,
                    'text' => $option->size1 . ' - ' . ucfirst($option->color),
                    'selected' => $option->product_id == $id
                ];
            });

        $associatedProducts = DB::table('product_associations')
            ->join('products', 'product_associations.associated_product', '=', 'products.product_id')
            ->where('product_associations.product_id', $id)
            ->select('products.product_id', 'products.product_name', 'products.price_per_unit')
            ->get();

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

        $inventoryDetails = DB::table('inventory_details')
            ->where('product_id', $id)
            ->select('in_stock_hq', 'in_stock_warehouse', 'inventory_ordered', 'inventory_expected_date')
            ->first();

        return view('products.single-product', [
            'productDetails' => $productDetails,
            'productOptions' => $productOptions,
            'associatedProducts' => $associatedProducts,
            'frenchGothicPosts' => $frenchGothicPosts,
            'flatPosts' => $flatPosts,
            'flatPosts5x5' => $flatPosts5x5,
            'inventoryDetails' => $inventoryDetails,
            'productVariations' => $productVariations
        ]);
    }

    public function fetchProductDetails($id)
    {
        $productDetails = DB::table('products')
            ->join('product_details', 'products.product_id', '=', 'product_details.product_id')
            ->join('product_media', 'products.product_id', '=', 'product_media.product_id')
            ->leftJoin('shipping_details', 'products.product_id', '=', 'shipping_details.product_id') // Changed to leftJoin
            ->where('products.product_id', $id)
            ->select(
                'products.product_name',
                'products.item_no',
                'products.description',
                'products.price_per_unit',
                'product_details.*',
                'product_media.general_image',
                'product_media.large_image',
                'product_media.small_image',
                'shipping_details.weight',
                'shipping_details.free_shipping',
                'shipping_details.special_shipping',
                'shipping_details.amount_per_box'
            )
            ->first();

        return response()->json($productDetails);
    }
}
