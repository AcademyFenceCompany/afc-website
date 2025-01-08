<?php

namespace App\Http\Controllers;

use App\Models\FamilyCategory;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function showWeldedWire()
    {
        // Fetch the Welded Wire category
        $weldedWireCategory = FamilyCategory::where('family_category_name', 'Welded Wire')->first();

        if (!$weldedWireCategory) {
            abort(404, 'Welded Wire category not found.');
        }

        // Fetch products related to the Welded Wire category
        // $products = Product::where('family_category_id', $weldedWireCategory->product_id)
        //     ->with(['productDetail', 'productMedia'])
        //     ->get();

        $general_products_ww = DB::table('products')
            ->join('product_details', 'products.product_id', '=', 'product_details.product_id')
            ->join('product_media', 'products.product_id', '=', 'product_media.product_id');

        $products_ww = DB::table('products')
            ->select($columns = ['*'])
            ->get();

        $general_ww_mesh_size_imgs = $general_products_ww
            ->join('general_media', 'product_details.size2', '=', 'general_media.size_portrayed')
            ->select($columns = ['general_media.image', 'general_media.size_portrayed', 'product_details.size2'])
            ->groupBy('general_media.size_portrayed', 'general_media.image')
            ->get();

        return view('categories.weldedwire', compact('weldedWireCategory', 'products_ww', 'general_ww_mesh_size_imgs'));
    }
    public function create()
    {
        return view('ams.add-product');
    }
}
