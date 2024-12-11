<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve the cart from the session
        $cart = session()->get('cart', []);
        $subtotal = array_sum(array_column($cart, 'total'));

        // Check for the state and calculate tax
        $state = $request->input('state', 'Other'); // Default state is 'Other'
        $tax = 0;

        if ($state === 'New Jersey') {
            $tax = $subtotal * 0.06625; // 6.625% tax for New Jersey
        }

        $total = $subtotal + $tax;

        return view('cart.checkout', compact('cart', 'subtotal', 'tax', 'total', 'state'));
    }
}
