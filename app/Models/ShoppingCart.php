<?php

namespace App\Models;

class ShoppingCart{
    public $cart;
    public function __construct()
    {
        // Initialize the cart
        $this->cart = $this->getCart();
    }
    public $subtotal = 0;
    public $shipping_cost = 0;
    public $tax = 0;
    public $discount = 0;
    public $total = 0;
    public $quantity = 0;
    public $weight = 0.0; // Total weight in lbs
    private $statetax = 0.06625; // NJ tax rate

    // This method is used to retrieve the shopping cart from the session or initialize it if not present
    public function getCart()
    {
        // Dummy implementation for retrieving the shopping cart items
        // Dummy cart data for testing
        $cart = [
            'items' => [
                43870 => [
                    'id' => 43870,
                    'product_name' => 'Sample Product 1',
                    'quantity' => 2,
                    'price' => 19.99,
                    'weight' => 1.5, // Example weight in lbs
                    'length' => 10, // Example length in inches
                    'width' => 5, // Example width in inches
                    'height' => 3 // Example height in inches
                ],
                43765 => [
                    'id' => 43765,
                    'product_name' => 'Sample Product 2',
                    'quantity' => 1,
                    'price' => 9.99,
                    'weight' => 1.0, // Example weight in lbs
                    'length' => 8, // Example length in inches
                    'width' => 4, // Example width in inches
                    'height' => 2 // Example height in inches
                ]
            ],
            'subtotal' => 19.99 * 2 + 9.99 * 1, // 49.97
            'shipping_cost' => 5.00,
            'tax' => 4.00,
            'discount' => 3.00,
            'total' => (19.99 * 2 + 9.99 * 1) + 5.00 + 4.00 - 3.00, // 55.97
            'quantity' => 3, // Total quantity of items in the cart
        ];

        //session()->put('cart2', $cart);
        //return session()->get('cart2', $cart); // Return the dummy cart for testing
        // Logic to retrieve the shopping cart items
        return session()->get('cart2', [
            'items' => [],
            'subtotal' => $this->subtotal,
            'shipping_cost' => $this->shipping_cost,
            'tax' => $this->tax,
            'discount' => $this->discount,
            'total' => $this->total,
            'quantity' => $this->quantity,
            'weight' => $this->weight, // Total weight in lbs
        ]);
    }
    // This method can be used to add an item to the cart
    public function addItem($id)
    {
        // Get product details from the database or request
        $product = \DB::table('products')->find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
        }

        // Retrieve the current cart from the session, or initialize if not present
        $this->cart = $this->getCart();

        // If the item already exists in the cart, update its quantity
        if (isset($this->cart['items'][$id])) {
            $this->cart['items'][$id]['quantity'] += 1;
        } else {
            // Otherwise, add the new item with its details
            $this->cart['items'][$id] = [
                'id' => $id,
                'item_no' => $product->item_no ?? 'Unknown Item Number',
                'name' => $product->product_name ?? 'Unknown Product',
                'quantity' => 1,
                'price' => $product->price ?? 0.0,
                'length' => $product->ship_length ?? 0, // Example length in inches
                'width' => $product->ship_width ?? 0, // Example width in inches
                'height' => $product->ship_height ?? 0, // Example height in inches
                'weight' => $product->weight_lbs ?? 0.0, // Example weight in lbs
            ];
        }

        // Recalculate subtotal and total
        $this->cart = $this->getCartTotal();

        // Update the session with the updated cart
        session()->put('cart2', $this->cart);
        return $this->cart;

    }
    // This method can be used to update the quantity of an item in the cart
    public function updateItem($id, $qty)
    {
        // Retrieve the current cart from the session
        $this->cart = $this->getCart();

        // Check if the item exists in the cart
        if (isset($this->cart['items'][$id])) {
            if ($qty > 0) {
                // Update the item's quantity
                $this->cart['items'][$id]['quantity'] = (int) $qty;
            } else {
                // Remove the item if quantity is zero or less
                unset($this->cart['items'][$id]);
            }    
        } else {
            // Get product details from the database or request
            $product = \DB::table('products')->find($id);
            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
            }

            // If the item does not exist, add it with the specified quantity
            $this->cart['items'][$id] = [
                'id' => $id,
                'item_no' => $product->item_no ?? 'Unknown Item Number',
                'name' => $product->product_name ?? 'Unknown Product',
                'quantity' => $qty,
                'price' => $product->price ?? 0.0,
                'length' => $product->ship_length ?? 0, // Example length in inches
                'width' => $product->ship_width ?? 0, // Example width in inches
                'height' => $product->ship_height ?? 0, // Example height in inches
                'weight' => $product->weight_lbs ?? 0.0, // Example weight in lbs
            ];
        }
        // Recalculate subtotal and total
        $this->cart = $this->getCartTotal();
        // Update the session with the updated cart
        session()->put('cart2', $this->cart);
        return $this->cart;

    }
    // This method can be used to remove multiple items from the cart
    public function removeItem($id)
    {
        // Retrieve the current cart from the session
        $this->cart = $this->getCart();

        // Remove the item from the cart if it exists
        if (isset($this->cart['items'][$id])) {
            unset($this->cart['items'][$id]);
        }

        // Recalculate subtotal and total
        $this->cart = $this->getCartTotal();
        // Update the session with the updated cart
        session()->put('cart2', $this->cart);
        return $this->cart;

    }
    // This method can be used to set the shipping method and calculate the shipping cost
    public function setShippingMethod($rate)
    {
        // Retrieve the current cart from the session
        $this->cart = $this->getCart();

        // Set the shipping cost based on the provided rate
        $this->cart['shipping_cost'] = (float)$rate;

        // Recalculate subtotal and total
        $this->cart = $this->getCartTotal();

        // Update the session with the updated cart
        session()->put('cart2', $this->cart);
        return $this->cart;
    }
    // This method calculates and returns the cart totals (subtotal, shipping, tax, discount, total)
    public function getCartTotal()
    {
        $this->subtotal = $this->shipping_cost = $this->tax = $this->discount = $this->total = $this->quantity = 0;

        if (!empty($this->cart['items'])) {
            foreach ($this->cart['items'] as $item) {
                $qty = isset($item['quantity']) ? (int)$item['quantity'] : 1;
                $price = isset($item['price']) ? (float)$item['price'] : 0.0;
                $this->subtotal += $price * $qty;
                $this->quantity += $qty;
            }
        }
        $this->weight = 0.0;
        if (!empty($this->cart['items'])) {
            foreach ($this->cart['items'] as $item) {
                $qty = isset($item['quantity']) ? (int)$item['quantity'] : 1;
                $weight = isset($item['weight']) ? (float)$item['weight'] : 0.0;
                $this->weight += $weight * $qty;
            }
        }
        $this->cart['weight'] = round($this->weight, 2);
        // Calculate shipping cost, discount, and tax
        $this->shipping_cost = isset($this->cart['shipping_cost']) ? (float)$this->cart['shipping_cost'] : 0.0;
        $this->discount = isset($this->cart['discount']) ? (float)$this->cart['discount'] : 0.0;
        $this->tax = $this->subtotal * $this->statetax;
        $this->total = $this->subtotal + $this->shipping_cost + $this->tax - $this->discount;

        // Update cart array with new totals
        $this->cart['subtotal'] = round($this->subtotal, 2);
        $this->cart['shipping_cost'] = round($this->shipping_cost, 2);
        $this->cart['tax'] = round($this->tax, 2);
        $this->cart['discount'] = round($this->discount, 2);
        $this->cart['total'] = round($this->total, 2);
        $this->cart['quantity'] = $this->quantity;
        // Return the updated cart
        session()->put('cart2', $this->cart);
        return $this->cart;
    }

}