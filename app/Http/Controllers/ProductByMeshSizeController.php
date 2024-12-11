<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductByMeshSizeController extends Controller
{
    public function showMeshSizeProducts(Request $request)
    {
        $meshSize = urldecode($request->input('meshSize')); // Decode URL parameter
        $coating = $request->input('coating');
    
        // Debugging
        // dd($meshSize, $coating);
    
        // Fetch products filtered by mesh size and coating
        $meshSize_products = DB::table('products')
            ->join('product_details', 'products.product_id', '=', 'product_details.product_id')
            ->join('product_media', 'products.product_id', '=', 'product_media.product_id')
            ->join('shipping_details', 'products.product_id', '=', 'shipping_details.product_id')
            ->where('product_details.size2', $meshSize) // Filter by mesh size
            ->where('product_details.coating', $coating) // Filter by coating
            ->select('*')
            ->get();
    
            return view('categories.wwf-product', [
                'meshSize_products' => $meshSize_products
            ]);
    }
    
}
