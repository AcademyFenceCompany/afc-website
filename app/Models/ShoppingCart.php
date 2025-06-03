<?php

namespace App\Models;

class ShoppingCart{

    // This method can be used to retrieve the shopping cart items
    public function getCart()
    {
        // Dummy implementation for retrieving the shopping cart items
        // Dummy cart data for testing
        $cart = [
            'items' => [
                43765 => [
                    'id' => 43765,
                    'product_name' => 'Sample Product 1',
                    'quantity' => 2,
                    'price' => 19.99
                ],
                43870 => [
                    'id' => 43870,
                    'product_name' => 'Sample Product 2',
                    'quantity' => 1,
                    'price' => 9.99
                ]
            ],
            'subtotal' => 19.99 * 2 + 9.99 * 1, // 49.97
            'shipping_cost' => 5.00,
            'tax' => 4.00,
            'discount' => 3.00,
            'total' => (19.99 * 2 + 9.99 * 1) + 5.00 + 4.00 - 3.00, // 55.97
            'quantity' => 3, // Total quantity of items in the cart
        ];

        session()->put('cart2', $cart);
        // Logic to retrieve the shopping cart items
        return $cart;
    }
    // This method can be used to add an item to the cart
    public function addItem($id)
    {
        // Get product details from the database or request
        $product = \DB::table('products')->find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
        }
        // Logic to add an item to the cart
        //return response()->json(['success' => true, 'message' => 'Item added to cart.', 'data' => $id]);
        $quantity = 1;
        $name = $product->product_name ?? 'Unknown Product';
        $price = $product->price ?? 0.0;

        // Retrieve the current cart from the session, or initialize if not present
        $cart = session()->get('cart2', [
            'items' => [],
            'subtotal' => 0,
            'shipping_cost' => 0,
            'tax' => 0,
            'discount' => 0,
            'total' => 0,
            'quantity' => 0, // Initialize quantity
        ]);

        // If the item already exists in the cart, update its quantity
        if (isset($cart['items'][$id])) {
            $cart['items'][$id]['quantity'] += $quantity;
        } else {
            // Otherwise, add the new item with its details
            $cart['items'][$id] = [
                'id' => $id,
                'name' => $name,
                'quantity' => $quantity,
                'price' => $price,
            ];
        }

        // Recalculate subtotal and total
        $subtotal = 0;
        foreach ($cart['items'] as $item) {
            $subtotal += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
        }
        $cart['subtotal'] = $subtotal;
        $cart['total'] = $subtotal + ($cart['shipping_cost'] ?? 0) + ($cart['tax'] ?? 0) - ($cart['discount'] ?? 0);
        // Calculate total quantity of items in the cart
        $quantity = 0;
        if (!empty($cart['items'])) {
            foreach ($cart['items'] as $item) {
            $quantity += isset($item['quantity']) ? (int)$item['quantity'] : 0;
            }
        }
        $cart['quantity'] = $quantity;
        // Update the session with the updated cart
        session()->put('cart2', $cart);
        return $cart;

 
    }
    // This method can be used to update the quantity of an item in the cart
    public function updateItem($id, $qty)
    {


        // Retrieve the current cart from the session
        $cart = session()->get('cart2', []);

        // Check if the item exists in the cart
        if (isset($cart['items'][$id])) {
            // Update the item's quantity
            $cart['items'][$id]['quantity'] = $qty;

            // Recalculate subtotal and total
            $subtotal = 0;
            foreach ($cart['items'] as $item) {
                $subtotal += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
            }
            $cart['subtotal'] = $subtotal;
            $cart['total'] = $subtotal + ($cart['shipping_cost'] ?? 0) + ($cart['tax'] ?? 0) - ($cart['discount'] ?? 0);
            // Calculate total quantity of items in the cart
            $quantity = 0;
            if (!empty($cart['items'])) {
                foreach ($cart['items'] as $item) {
                $quantity += isset($item['quantity']) ? (int)$item['quantity'] : 0;
                }
            }
            $cart['quantity'] = $quantity;
            // Update the session with the updated cart
            session()->put('cart2', $cart);
        }
        return $cart;
        
    }
    // This method can be used to remove multiple items from the cart
    public function removeItem($id)
    {
        // Retrieve the current cart from the session
        $cart = session()->get('cart2', [
            'items' => [],
            'subtotal' => 0,
            'shipping_cost' => 0,
            'tax' => 0,
            'discount' => 0,
            'total' => 0,
            'quantity' => 0, // Initialize quantity
        ]);

        // Remove the item from the cart if it exists
        if (isset($cart['items'][$id])) {
            unset($cart['items'][$id]);
        }

        // Recalculate subtotal and total
        $subtotal = 0;
        foreach ($cart['items'] as $item) {
            $subtotal += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
        }
        $cart['subtotal'] = $subtotal;
        $cart['total'] = $subtotal + ($cart['shipping_cost'] ?? 0) + ($cart['tax'] ?? 0) - ($cart['discount'] ?? 0);
        // Calculate total quantity of items in the cart
        $quantity = 0;
        if (!empty($cart['items'])) {
            foreach ($cart['items'] as $item) {
            $quantity += isset($item['quantity']) ? (int)$item['quantity'] : 0;
            }
        }
        $cart['quantity'] = $quantity;
        // Update the session with the updated cart
        $cart =  session()->put('cart2', $cart);
        return $cart;

    }
    // This method calculates and returns the cart totals (subtotal, shipping, tax, discount, total)
    public function getCartTotal()
    {
        $cart = session()->get('cart2', []);

        // Default values if cart is empty
        $subtotal = 0;
        $shipping_cost = 0;
        $tax = 0;
        $discount = 0;
        $total = 0;

        if (!empty($cart) && isset($cart['items'])) {
            // Calculate subtotal
            foreach ($cart['items'] as $item) {
                $subtotal += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
            }
            // Use existing values if present, otherwise defaults
            $shipping_cost = $cart['shipping_cost'] ?? 0;
            $tax = $cart['tax'] ?? 0;
            $discount = $cart['discount'] ?? 0;
            $total = $subtotal + $shipping_cost + $tax - $discount;
        }
        // Calculate total quantity of items in the cart
        $quantity = 0;
        if (!empty($cart) && isset($cart['items'])) {
            foreach ($cart['items'] as $item) {
            $quantity += ($item['quantity'] ?? 0);
            }
        }
        // Return the calculated totals as a JSON response
        return response()->json([
            'subtotal' => round($subtotal, 2),
            'shipping_cost' => round($shipping_cost, 2),
            'tax' => round($tax, 2),
            'discount' => round($discount, 2),
            'total' => round($total, 2),
            'quantity' => $quantity,
        ]);
    }

}