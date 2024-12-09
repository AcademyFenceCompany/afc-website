<?php

namespace App\Http\Controllers;

use App\Models\FamilyCategory;
use App\Models\Product;

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
        $products = Product::where('family_category_id', $weldedWireCategory->product_id)
        ->with(['productDetail', 'productMedia'])
        ->get();
    
        return view('categories.weldedwire', compact('weldedWireCategory', 'products'));
    }
}
