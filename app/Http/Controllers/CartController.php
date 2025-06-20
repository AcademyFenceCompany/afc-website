<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id' => 'nullable|string',
                'item_no' => 'required|string',
                'product_name' => 'required|string',
                'price' => 'required|numeric',
                'quantity' => 'required|integer|min:1',
                'color' => 'nullable|string',
                'size' => 'nullable|string',
                'size_in' => 'nullable|string',
                'size_wt' => 'nullable|string',
                'size_ht' => 'nullable|string',
                'size2' => 'nullable|string',
                'size3' => 'nullable|string',
                'speciality' => 'nullable|string',
                'material' => 'nullable|string',
                'spacing' => 'nullable|string',
                'coating' => 'nullable|string',
                'weight_lbs' => 'nullable|numeric',
                'cat_id_fk' => 'nullable|string',
                'img_small' => 'nullable|string',
                'img_large' => 'nullable|string',
                'free_shipping' => 'nullable|string',
                'special_shipping' => 'nullable|string',
                'amount_per_box' => 'nullable|string',
                'desc_short' => 'nullable|string',
                'desc_long' => 'nullable|string',
                'ship_length' => 'nullable|numeric',
                'ship_width' => 'nullable|numeric',
                'ship_height' => 'nullable|numeric',
                'categories_id' => 'nullable|string',
                'shipping_method' => 'nullable|string',
            ]);

            // Get cart from session or create a new one
            $cart = session()->get('cart', []);

            // Check if the item already exists in the cart
            if (isset($cart[$validatedData['item_no']])) {
                // Increase the quantity and update the total
                $cart[$validatedData['item_no']]['quantity'] += $validatedData['quantity'];
                $cart[$validatedData['item_no']]['total'] =
                    $cart[$validatedData['item_no']]['quantity'] * $validatedData['price'];
            } else {
                // Add new item to the cart
                $cart[$validatedData['item_no']] = array_merge(
                    $validatedData,
                    ['total' => $validatedData['price'] * $validatedData['quantity']]
                );
            }

            // Save updated cart in session
            session()->put('cart', $cart);

            // Return the updated cart and cart count
            return response()->json([
                'success' => true,
                'cart' => session('cart'),
                'cartCount' => count(session('cart')),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function viewCart()
    {
        // Retrieve cart from session
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function removeItem(Request $request)
    {
        $itemNo = $request->item_no;

        // Retrieve the current cart from the session
        $cart = session()->get('cart', []);

        // Remove the item from the cart
        unset($cart[$itemNo]);

        // Update the session with the updated cart
        session()->put('cart', $cart);

        // Return the updated cart and cart count
        return response()->json([
            'success' => true,
            'cart' => $cart, // Include full cart
            'cartCount' => count($cart), // Include count for the badge
        ]);
    }

    public function removeSelectedItems(Request $request)
    {
        $itemNos = $request->item_nos; // Array of item numbers to remove

        // Retrieve the current cart from the session
        $cart = session()->get('cart', []);

        // Remove the selected items from the cart
        foreach ($itemNos as $itemNo) {
            unset($cart[$itemNo]);
        }

        // Update the session
        session()->put('cart', $cart);

        return response()->json(['success' => true, 'cart' => $cart]);
    }

    public function clear()
    {
        session()->forget('cart');
        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully',
        ]);
    }
    public function update(Request $request){
    $cart = session()->get('cart', []);

    if (isset($cart[$request->item_no])) {
        $cart[$request->item_no]['quantity'] = $request->quantity;
        $cart[$request->item_no]['total'] = $cart[$request->item_no]['price'] * $request->quantity;
    }

    session()->put('cart', $cart);

    return response()->json([
        'success' => true,
        'subtotal' => array_sum(array_column($cart, 'total'))
    ]);
}

}
