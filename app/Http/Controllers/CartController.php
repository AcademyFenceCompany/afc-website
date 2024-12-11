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
            'size' => 'nullable|string',
            'mesh' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
        ]);
        // Get cart from session or create a new one
        $cart = session()->get('cart', []);

        // Add new item to cart
        $cart[$validatedData['item_no']] = [
            'item_no' => $validatedData['item_no'],
            'product_name' => $validatedData['product_name'],
            'price' => $validatedData['price'],
            'color' => $validatedData['color'],
            'size' => $validatedData['size'],
            'mesh' => $validatedData['mesh'],
            'quantity' => $validatedData['quantity'],
            'total' => $validatedData['price'] * $validatedData['quantity'],
        ];

        // Save updated cart in session
        session()->put('cart', $cart);

        return response()->json(['success' => true, 'cart' => $cart,'cartCount' => count($cart)]);
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
    
        // Search and remove the item with the specified item number
        $cart = array_filter($cart, function ($item) use ($itemNo) {
            return $item['item_no'] !== $itemNo;
        });
    
        // Update the session with the filtered cart
        session()->put('cart', $cart);
    
        return response()->json(['success' => true, 'cart' => $cart]);
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


}
