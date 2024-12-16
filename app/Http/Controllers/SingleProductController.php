<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SingleProductController extends Controller
{
    public function show($id)
    {
        // Fetch the product details from multiple tables based on the given product ID
        $productDetails = DB::table('products')
            ->join('product_details', 'products.product_id', '=', 'product_details.product_id')
            ->join('product_media', 'products.product_id', '=', 'product_media.product_id')
            ->join('shipping_details', 'products.product_id', '=', 'shipping_details.product_id')
            ->where('products.product_id', $id)
            ->select(
                'products.product_name',
                'products.item_no',
                'products.description',
                'products.price_per_unit',
                'product_details.*',
                'product_media.large_image',
                'product_media.small_image',
                'shipping_details.weight',
                'shipping_details.free_shipping',
                'shipping_details.special_shipping',
                'shipping_details.amount_per_box'
            )
            ->first();

        // Fetch all height (size1) variations for this product
        $heightVariations = DB::table('products')
        ->join('product_details', 'products.product_id', '=', 'product_details.product_id')
        ->where('products.product_name', $productDetails->product_name)
        ->where('product_details.size2', $productDetails->size2)
        ->where('product_details.size3', $productDetails->size3)
        ->select('products.product_id', 'product_details.size1')
        ->get();

        // Fetch all color variations for the same product
        $colorVariations = DB::table('products')
    ->join('product_details', 'products.product_id', '=', 'product_details.product_id')
    ->where('products.product_name', $productDetails->product_name)
    ->where('product_details.size2', $productDetails->size2)
    ->where('product_details.size3', $productDetails->size3)
    ->select('product_details.color', 'products.product_id')
    ->distinct('product_details.color') // Ensures unique color
    ->get();

    
    

        // Fetch associated products (if needed)
        $associatedProducts = DB::table('product_associations')
            ->join('products', 'product_associations.associated_product', '=', 'products.product_id')
            ->where('product_associations.product_id', $id)
            ->select('products.product_id', 'products.product_name', 'products.price_per_unit')
            ->get();

        // Fetch inventory details (if needed)
        $inventoryDetails = DB::table('inventory_details')
            ->where('product_id', $id)
            ->select('in_stock_hq', 'in_stock_warehouse', 'inventory_ordered', 'inventory_expected_date')
            ->first();

        // Return the product details view
        return view('products.single-product', [
            'productDetails' => $productDetails,
            'associatedProducts' => $associatedProducts,
            'inventoryDetails' => $inventoryDetails,
            'heightVariations' => $heightVariations,
            'colorVariations' => $colorVariations
        ]);
    }
    public function fetchProductDetails($id)
{
    $productDetails = DB::table('products')
        ->join('product_details', 'products.product_id', '=', 'product_details.product_id')
        ->join('product_media', 'products.product_id', '=', 'product_media.product_id')
        ->join('shipping_details', 'products.product_id', '=', 'shipping_details.product_id')
        ->where('products.product_id', $id)
        ->select(
            'products.product_name',
            'products.item_no',
            'products.description',
            'products.price_per_unit',
            'product_details.*',
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
