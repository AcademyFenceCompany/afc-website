@extends('layouts.main')

@section('title', 'Checkout')

@section('content')
    <main class="container my-5">
        <!-- Returning Customer -->
        <div class="text-center mb-4">
            <div class="border border-danger p-2">
                Returning customer? <a href="{{ route('login') }}" class="text-danger">Click here to login</a>
            </div>
        </div>

        <!-- Page Header -->
        <h2 class="text-center mb-4">Checkout</h2>

        <div class="row g-4">
            <!-- Billing Details -->
            <div class="col-lg-8">
                <form action="" method="POST">
                    @csrf

                    <h5 class="mb-3">Billing details</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">First name *</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last name *</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label for="country" class="form-label">Country/Region *</label>
                            <select id="country" name="country" class="form-select" required>
                                <option value="United States">United States (US)</option>
                                <!-- Add more countries if needed -->
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="street_address" class="form-label">Street address *</label>
                            <input type="text" id="street_address" name="street_address" class="form-control"
                                placeholder="House number and street name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="city" class="form-label">Town/City *</label>
                            <input type="text" id="city" name="city" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="state" class="form-label">State *</label>
                            <select id="state" name="state" class="form-select" required>
                                <option value="New Jersey">New Jersey</option>
                                <!-- Add more states if needed -->
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="zip" class="form-label">ZIP Code *</label>
                            <input type="text" id="zip" name="zip" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone *</label>
                            <input type="text" id="phone" name="phone" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label for="email" class="form-label">Email address *</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-check my-3">
                        <input type="checkbox" class="form-check-input" id="ship_different" name="ship_different">
                        <label for="ship_different" class="form-check-label">Ship to a different address?</label>
                    </div>

                    <div class="mb-3">
                        <label for="order_notes" class="form-label">Order notes (optional)</label>
                        <textarea id="order_notes" name="order_notes" class="form-control" rows="3"
                            placeholder="Notes about your order, e.g., special notes for delivery."></textarea>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <h5 class="mb-3">Your order</h5>
                <div class="border p-3 rounded mb-4">
                    @foreach ($cart as $item)
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ $item['product_name'] }} × {{ $item['quantity'] }}</span>
                            <span>${{ number_format($item['total'], 2) }}</span>
                        </div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax</span>
                        <span>${{ number_format($tax, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                </div>

                <h5 class="mb-3">Payment Method</h5>
                <div class="form-check mb-3">
                    <input type="radio" class="form-check-input" id="credit_card" name="payment_method"
                        value="credit_card" required>
                    <label for="credit_card" class="form-check-label">Credit Card</label>
                </div>
                <div class="form-check mb-3">
                    <input type="radio" class="form-check-input" id="paypal" name="payment_method" value="paypal">
                    <label for="paypal" class="form-check-label">PayPal</label>
                </div>

                <div class="mb-3">
                    <label for="card_number" class="form-label">Card Number *</label>
                    <input type="text" id="card_number" name="card_number" class="form-control" required>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="expiration" class="form-label">Expiration (MM/YY) *</label>
                        <input type="text" id="expiration" name="expiration" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="cvc" class="form-label">(CVC) *</label>
                        <input type="text" id="cvc" name="cvc" class="form-control" required>
                    </div>
                </div>

                <div class="form-check my-3">
                    <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                    <label for="terms" class="form-check-label">I have read and agree to the website terms and
                        conditions *</label>
                </div>

                <button type="submit" class="btn btn-danger w-100">Place Order</button>
            </div>
        </div>
    </main>
@endsection
