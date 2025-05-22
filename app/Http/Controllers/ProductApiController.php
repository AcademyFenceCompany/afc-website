<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductApiController extends Controller
{
    /**
     * Search for products by term (item number or product name)
     */
    public function search(Request $request)
    {
        $term = $request->query('term');
        
        if (empty($term) || strlen($term) < 2) {
            return response()->json([]);
        }
        
        $products = DB::connection('academyfence')
            ->table('products')
            ->where('enabled', 1)
            ->where(function($query) use ($term) {
                $query->where('item_no', 'LIKE', "%{$term}%")
                    ->orWhere('product_name', 'LIKE', "%{$term}%");
            })
            ->select(
                'id', 'product_name', 'seo_name', 'desc_short', 'color', 'item_no', 
                'parent', 'cat_id_fk', 'price', 'weight_lbs', 'shipable', 'size', 'size_ln', 'size_wt', 'size_ht', 
                'inv_stocked', 'inv_eastorange', 'inv_orange', 'inv_processing', 'inv_ordered', 
                'inv_ordered_expect', 'img_small', 'img_large', 'supplier', 'ext_domain', 'featured',
                'creation', 'modified', 'inv_mod', 'mod_by', 'product_assoc', 'product_accessories', 
                'alt_length', 'alt_width', 'alt_height', 'ship_length', 'ship_width', 'ship_height', 
                'nominal_length', 'nominal_width', 'nominal_height', 'product_relatives', 'meta_title', 
                'meta_keywords', 'add_keywords', 'meta_description', 'display_size_2', 'free_shipping', 
                'special_shipping', 'amount_per_box', 'class', 'producttree', 'gauge', 'size2',
                'size3', 'spacing', 'coating', 'material', 'style', 'speciality', 'shippable', 'notes', 
                'categories_id', 'shipping_method'
            )
            ->limit(10)
            ->get();
            
        return response()->json($products);
    }
    
    /**
     * Get product by item number
     */
    public function getByItemNumber($itemNumber)
    {
        $product = DB::connection('academyfence')
            ->table('products')
            ->where('enabled', 1)
            ->where('item_no', $itemNumber)
            ->select(
                'id', 'product_name', 'seo_name', 'desc_short', 'color', 'item_no', 
                'parent', 'cat_id_fk', 'price', 'weight_lbs', 'shipable', 'size', 'size_ln', 'size_wt', 'size_ht', 
                'inv_stocked', 'inv_eastorange', 'inv_orange', 'inv_processing', 'inv_ordered', 
                'inv_ordered_expect', 'img_small', 'img_large', 'supplier', 'ext_domain', 'featured',
                'creation', 'modified', 'inv_mod', 'mod_by', 'product_assoc', 'product_accessories', 
                'alt_length', 'alt_width', 'alt_height', 'ship_length', 'ship_width', 'ship_height', 
                'nominal_length', 'nominal_width', 'nominal_height', 'product_relatives', 'meta_title', 
                'meta_keywords', 'add_keywords', 'meta_description', 'display_size_2', 'free_shipping', 
                'special_shipping', 'amount_per_box', 'class', 'producttree', 'gauge', 'size2',
                'size3', 'spacing', 'coating', 'material', 'style', 'speciality', 'shippable', 'notes', 
                'categories_id', 'shipping_method'
            )
            ->first();
            
        if (!$product) {
            return response()->json(null, 404);
        }
        
        return response()->json($product);
    }
}
