<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Checkout2;
use App\Models\ShoppingCart; // Assuming you have a ShoppingCart model

class CheckoutController extends Controller
{
    public function index()
    {
        // Retrieve the cart from the session
        $cart = session()->get('cart', []);
        // If the cart is empty, redirect to the cart index with an error message
        if (!$cart || count($cart) === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Ensure updated quantities are correctly fetched
        foreach ($cart as $key => $item) {
            if (!isset($item['quantity']) || $item['quantity'] < 1) {
                $cart[$key]['quantity'] = 1;
            }
            $cart[$key]['total'] = $cart[$key]['price'] * $cart[$key]['quantity'];
        }
        // Update the session with the modified cart
        session()->put('cart', $cart);

        // Calculate subtotal
        $subtotal = array_sum(array_column($cart, 'total'));
        $tax = $subtotal * 0.06625; // NJ tax rate
        $total = $subtotal + $tax;

        // Calculate total weight and dimensions from cart items
        $totalWeight = 0;
        $maxLength = 0;
        $maxWidth = 0;
        $maxHeight = 0;

        foreach ($cart as $item) {
            $totalWeight += ($item['weight'] ?? 1) * $item['quantity'];
            $maxLength = max($maxLength, $item['length'] ?? 10);
            $maxWidth = max($maxWidth, $item['width'] ?? 10);
            $maxHeight = max($maxHeight, $item['height'] ?? 10);
        }

        return view('cart.checkout', compact(
            'cart', 
            'subtotal', 
            'tax', 
            'total',
            'totalWeight',
            'maxLength',
            'maxWidth',
            'maxHeight'
        ));
    }
    //Get The checkout form
    public function getCheckoutForm()
    {
        // Retrieve the cart from the session
        $cart = session()->get('cart', []);
        // If the cart is empty, redirect to the cart index with an error message
        if (!$cart || count($cart) === 0) {
            //return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Ensure updated quantities are correctly fetched
        foreach ($cart as $key => $item) {
            if (!isset($item['quantity']) || $item['quantity'] < 1) {
                $cart[$key]['quantity'] = 1;
            }
            $cart[$key]['total'] = $cart[$key]['price'] * $cart[$key]['quantity'];
        }
        // Update the session with the modified cart
        session()->put('cart', $cart);

        // Calculate subtotal
        $subtotal = array_sum(array_column($cart, 'total'));
        $tax = $subtotal * 0.06625; // NJ tax rate
        $total = $subtotal + $tax;

        return view('cart.checkout2', compact('cart', 'subtotal', 'tax', 'total'));
    }
    //Logic for handling the checkout process
    public function processCheckout(Request $request)
    {
        $shoppingCart = new ShoppingCart();
        $cart = $shoppingCart->getCart();
        // Validate the request data
        $request->validate([
            'cc_name' => 'required|string|max:255',
            'cc_number' => 'required',
            'cc_expiration' => 'required|date_format:m/y',
            'cc_cvv' => 'required|numeric|min:100|max:999',
            'amount' => 'required|numeric|min:0.01',
        ]);
        //@dd($request->all());
        // Send to authorize.net for processing
        $checkout = new Checkout2();
        $response = $checkout->processCreditCart($request);
        
        // Check if the payment was successful
        if (!$response['success']) {
            // If payment failed, redirect back with an error message
            return redirect()->back()->with('error', $response['message']);
        }
        // Log the checkout data for debugging
        //Log::info('Checkout data:', $request->all());
        
        return redirect()->route('checkout2.success')->with('success', 'Thank You for Your Order!');
    }
}
