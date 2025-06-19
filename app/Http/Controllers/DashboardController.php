<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ShoppingCart;

class DashboardController extends Controller
{
    //  Display the AMS dashboard
    public function index()
    {
        // Get list of unique counties
        $counties = \DB::table('county')
            ->select('county', \DB::raw('MIN(id) as id'))
            ->groupBy('county')
            ->get();

        $majCategories = \DB::table('majorcategories')->where('enabled', 1)->get();
        $cities = \DB::table('county')->get();
        $shoppingCart = new ShoppingCart();
        $cart = $shoppingCart->getCart();

        return view('ams.index',compact('counties', 'majCategories', 'cart', 'cities'));
    }
}
