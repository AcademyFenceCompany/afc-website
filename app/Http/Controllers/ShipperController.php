<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShipperController extends Controller
{
    public function showView($page)
    {
        $validPages = [
            'index_shippers',
            'add_shippers',
            'add_shippers_contacts',
            'delivery_log',
            'freight_log',
            'sm_package',
            'shipping_markup'
        ];

        if (!in_array($page, $validPages)) {
            abort(404); // Return a 404 error if the page is invalid
        }

        return view("ams.shipping.$page");
    }
}
