<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GlobalSearchController extends Controller
{

    // This is a search method created by Colin to search for customers
    public function search(Request $request)
    {
        try {
            $str = $request->post('search');

            // Build customers query
            $customersQuery = DB::table('customers')
                ->select('name', 'email', 'phone', 'company')
                ->where(function ($q) use ($str) {
                    $q->where('name', 'like', "%{$str}%")
                      ->orWhere('company', 'like', "%{$str}%")
                      ->orWhere('email', 'like', "%{$str}%")
                      ->orWhere('phone', 'like', "%{$str}%");
                })
                ->orderBy('name')
                ->limit(10)
                ->get();

            // Build products query
            $productsQuery = DB::table('products')
                ->select('id', 'product_name', 'item_no',)
                ->where(function ($q) use ($str) {
                    $q->where('product_name', 'like', "%{$str}%")
                      ->orWhere('item_no', 'like', "%{$str}%");
                })->orderBy('product_name')->limit(5)
                ->get();

            // Combine queries using unionAll, then get results
            $ordersQuery = DB::connection('academyfence')->table('orders')
                ->select('id', 'shipping_firstname', 'shipping_lastname', 'shipping_company')
                ->where(function ($q) use ($str) {
                    $q->where('id', 'like', "%{$str}%")
                        ->orWhere('shipping_firstname', 'like', "%{$str}%")
                        ->orWhere('shipping_company', 'like', "%{$str}%")
                        ->orWhere('shipping_lastname', 'like', "%{$str}%");
                })
                ->limit(10)
                ->get();

            return view('components.search-global', compact('customersQuery', 'productsQuery', 'ordersQuery'));
        } catch (\Exception $e) {
            Log::error('Error in search2: ' . $e->getMessage());
            return response()->json(['error' => 'Error searching customers: ' . $e->getMessage()], 500);
        }
    }
}
