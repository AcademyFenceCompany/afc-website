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
        $cart = $shoppingCart->getCart();
        // Logic to retrieve the shopping cart items
        //$UPSService = new \App\Services\UPSService();
        //$validToken = $UPSService->isAccessTokenValid();
        //@dump($UPSService->accessToken, $validToken);
        // // Check if the UPS access token is valid
        // if (!$UPSService->accessToken) {
        //     $UPSService->authenticate2();
        //     $validToken = $UPSService->isAccessTokenValid();
        // }
        // @dd($UPSService->accessToken, $validToken);
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
    // Set the shipping method for the cart
    public function updateShippingMethod($rate)
    {
        $shoppingCart = new ShoppingCart();
        $cart = $shoppingCart->setShippingMethod($rate);
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

        $shoppingCart = new ShoppingCart();
        $cart = $shoppingCart->getCart();
        return view('cart.checkout2', compact('majCategories', 'subCategories', 'cart'));
    }
    // Process the payment
    // This method will be used to process the payment using the Checkout2 service
    public function processPayment(Request $request)
    {
        $majCategories = \DB::table('majorcategories')->where('enabled', 1)->get();
        $subCategories = \DB::table('categories')->where('majorcategories_id', 1)->get();
        $shoppingCart = new ShoppingCart();
        $cart = $shoppingCart->getCart();

        // // Validate the request data
        $request->validate([
            'cc_name' => 'required|string|max:255',
            'cc_number' => 'required',
            'cc_expiration' => 'required|date_format:m/y',
            'cc_cvv' => 'required|numeric|min:100|max:999',
            'amount' => 'required|numeric|min:0.01',
        ]);
        // //@dd($request->all());
        // // Send to authorize.net for processing
        $checkout = new Checkout2();
        $response = $checkout->processCreditCart($request);
        // Check if the payment was successful
        if ($response['success']) {
            // If payment was successful, save the transaction details
            return view('thankyou', compact('cart', 'majCategories', 'subCategories'))->with('success', 'Thank You for Your Order!');
        }else {
            // If payment failed, redirect back with an error message
            return view('cart.checkout2', compact('cart', 'majCategories', 'subCategories'))->with('error', 'Unable to process you order!');
        }
        // Log the checkout data for debugging
        //Log::info('Checkout data:', $request->all());
        return view('thankyou', compact('cart', 'majCategories', 'subCategories'))->with('success', 'Thank You for Your Order!');
        return redirect()->route('checkout2.success')->with('success', 'Thank You for Your Order!', [
            'transaction_id' => $response['transaction_id'],
            'cc_name' => $request->input('cc_name'),
            'cart' => $cart
        ]);
    }

}