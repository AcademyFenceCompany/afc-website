<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

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
}
