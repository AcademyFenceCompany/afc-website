<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShoppingCart; // Assuming you have a ShoppingCart model

class ShoppingCartController extends Controller
{

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
    // This method can be used to update the quantity of an item in the cart
    public function update(Request $request, $id)
    {
        // Logic to update the quantity of an item in the shopping cart
        // Example: $request->input('quantity');
        return response()->json(['success' => true, 'message' => 'Item updated in cart.']);
    }
    /**
     * Display the shopping cart.
     * Since there are two carts, this one will be used for the secure checkout process: Colin.
     * @return \Illuminate\Http\Response
     */
    //Logic for handling the pre-checkout process
    public function precheckout()
    {
        $majCategories = \DB::table('majorcategories')->where('enabled', 1)->get();
        $subCategories = \DB::table('categories')->where('majorcategories_id', 1)->get();
        $shoppingCart = new ShoppingCart();
        // Logic to retrieve the shopping cart items
        $cart = $shoppingCart->getCart();

        // Log the pre-checkout data for debugging
        //Log::info('Pre-checkout data:', $request->all());

        // Redirect to the checkout form
        return view('cart.shoppingcart', compact('cart', 'majCategories', 'subCategories'));
    }
    // This method can be used to retrieve the shopping cart items
    public function getCart(){
        $shoppingCart = new ShoppingCart();
        // Logic to retrieve the shopping cart items
        $cart = $shoppingCart->getCart();
        return response()->json($cart);
    }
    // This method can be used to clear the shopping cart
    public function clearCart()
    {
        // Logic to clear the shopping cart
        session()->forget('cart2');
        return response()->json(['success' => true, 'message' => 'Cart cleared successfully.']);
    }
    // This method can be used to add an item to the cart
    public function addItem($id)
    {
        $shoppingCart = new ShoppingCart();
        $cart = $shoppingCart->addItem($id);
        // Return the updated cart and cart count
        return response()->json([
            'success' => true,
            'cart2' => $cart,
            'cartCount' => $cart['quantity'],
        ]);
    }
    // This method can be used to update the quantity of an item in the cart
    public function updateItem($id, $qty)
    {
        $shoppingCart = new ShoppingCart();
        $cart = $shoppingCart->updateItem($id, $qty);
        // Return the updated cart and cart count
        return response()->json([
            'success' => true,
            'cart2' => $cart,
            'cartCount' => $cart['quantity'],
        ]);
    }
    // This method can be used to remove multiple items from the cart
    public function removeItem($id)
    {
        $shoppingCart = new ShoppingCart();
        $cart = $shoppingCart->removeItem($id);
        // Return the updated cart and cart count
        return response()->json([
            'success' => true,
            'cart2' => $cart,
            'cartCount' => $cart['quantity'],
        ]);
    }
        // Process the checkout
    public function processCheckout()
    {
        $majCategories = \DB::table('majorcategories')->where('enabled', 1)->get();
        $subCategories = \DB::table('categories')->where('majorcategories_id', 1)->get();
        // Logic to process the checkout
        // This could involve payment processing, order creation, etc.
        // For now, we will just return a success message
        $shoppingCart = new ShoppingCart();
        $cart = $shoppingCart->getCart();
        return view('cart.checkout2', compact('majCategories', 'subCategories', 'cart'));
    }


}