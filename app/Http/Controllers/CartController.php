<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $validatedData = $request->validate([
            'item_no' => 'required|string',
            'product_name' => 'required|string',
            'price' => 'required|numeric',
            'color' => 'nullable|string',
            'size1' => 'nullable|string',
            'size2' => 'nullable|string',
            'size3' => 'nullable|string',
            'specialty' => 'nullable|string',
            'material' => 'nullable|string',
            'spacing' => 'nullable|string',
            'coating' => 'nullable|string',
            'weight' => 'nullable|numeric',
            'family_category' => 'nullable|string',
            'general_image' => 'nullable|string',
            'small_image' => 'nullable|string',
            'large_image' => 'nullable|string',
            'free_shipping' => 'nullable|boolean',
            'special_shipping' => 'nullable|boolean',
            'amount_per_box' => 'nullable|integer',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'subcategory_id' => 'nullable|integer',
            'shipping_length' => 'nullable|numeric',
            'shipping_width' => 'nullable|numeric',
            'shipping_height' => 'nullable|numeric',
            'shipping_class' => 'nullable|string',
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
            $cart[$validatedData['item_no']] = [
                'item_no' => $validatedData['item_no'],
                'product_name' => $validatedData['product_name'],
                'price' => $validatedData['price'],
                'color' => $validatedData['color'],
                'size1' => $validatedData['size1'],
                'size2' => $validatedData['size2'],
                'size3' => $validatedData['size3'],
                'specialty' => $validatedData['specialty'],
                'material' => $validatedData['material'],
                'spacing' => $validatedData['spacing'],
                'coating' => $validatedData['coating'],
                'weight' => $validatedData['weight'],
                'family_category' => $validatedData['family_category'],
                'general_image' => $validatedData['general_image'],
                'small_image' => $validatedData['small_image'],
                'large_image' => $validatedData['large_image'],
                'free_shipping' => $validatedData['free_shipping'],
                'special_shipping' => $validatedData['special_shipping'],
                'amount_per_box' => $validatedData['amount_per_box'],
                'quantity' => $validatedData['quantity'],
                'total' => $validatedData['price'] * $validatedData['quantity'],
                'description' => $validatedData['description'],
                'subcategory_id' => $validatedData['subcategory_id'],
                'shipping_length' => $validatedData['shipping_length'],
                'shipping_width' => $validatedData['shipping_width'],
                'shipping_height' => $validatedData['shipping_height'],
                'shipping_class' => $validatedData['shipping_class'],
            ];
        }

        // Save updated cart in session
        session()->put('cart', $cart);

        // Return the updated cart and cart count
        return response()->json([
            'success' => true,
            'cart' => session('cart'), // Include full cart
            'cartCount' => count(session('cart')), // Include count for the badge
        ]);
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
    public function update(Request $request)
{
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
