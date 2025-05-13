<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    /**
     * Display the shopping cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Logic to display items in the shopping cart
        return view('shopping_cart.index');
    }

    /**
     * Add an item to the shopping cart.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response()->json(['success' => true, 'message' => 'Item added to cart.']);
        // Logic to add an item to the shopping cart
        // Example: $request->input('product_id');
        return redirect()->route('shopping_cart.index')->with('success', 'Item added to cart.');
    }

}