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
            'product_details.*',
            'product_media.general_image',
            'product_media.large_image',
            'product_media.small_image',
            'shipping_details.weight', // Shipping details fields can now be null
            'shipping_details.free_shipping',
            'shipping_details.special_shipping',
            'shipping_details.amount_per_box'
        )
        ->first();
    
        // Fetch options filtered by size2 and size3
        $productOptions = DB::table('products')
        ->join('product_details', 'products.product_id', '=', 'product_details.product_id')
        ->when($productDetails->family_category_id === 17, function ($query) use ($productDetails) {
            // For Wood Fence categories (family_category_id = 17), filter by style, speciality, and spacing
            return $query->where('product_details.style', $productDetails->style)
                         ->where('product_details.speciality', $productDetails->speciality)
                         ->where('product_details.spacing', $productDetails->spacing);
        }, function ($query) use ($productDetails) {
            // For other categories, filter by size2 and size3
            return $query->where('product_details.size2', $productDetails->size2)
                         ->where('product_details.size3', $productDetails->size3);
        })
        ->select(
            'products.product_id',
            'product_details.size1',
            'product_details.color'
        )
        ->get()
        ->map(function ($option) use ($id) {
            return [
                'value' => $option->product_id,
                'text' => $option->size1 . ' - ' . ucfirst($option->color),
                'selected' => $option->product_id == $id
            ];
        });
    
        // Rest of your code remains the same
        $associatedProducts = DB::table('product_associations')
            ->join('products', 'product_associations.associated_product', '=', 'products.product_id')
            ->where('product_associations.product_id', $id)
            ->select('products.product_id', 'products.product_name', 'products.price_per_unit')
            ->get();
    
        $inventoryDetails = DB::table('inventory_details')
            ->where('product_id', $id)
            ->select('in_stock_hq', 'in_stock_warehouse', 'inventory_ordered', 'inventory_expected_date')
            ->first();
    
        return view('products.single-product', [
            'productDetails' => $productDetails,
            'productOptions' => $productOptions,
            'associatedProducts' => $associatedProducts,
            'inventoryDetails' => $inventoryDetails,
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
