@extends('layouts.main')

@section('title', 'Checkout')

@section('content')
<main class="container my-5">
    <!-- Page Header -->
    <div class="text-center mb-4">
        <h2>Checkout</h2>
        <p class="text-danger">Because of current conditions, prices are subject to change without prior notice.</p>
    </div>

    <!-- Checkout Section -->
    <div class="row g-4">
        <!-- Product and Delivery Section -->
        <div class="col-lg-8">
            <div class="card p-4 shadow-sm rounded">
                <div class="row g-3">
                    <!-- Product Details -->
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <img src="/resources/images/product-placeholder.png" alt="Product Image" class="img-fluid rounded me-3" style="width: 80px; height: 80px; object-fit: cover;">
                            <div>
                                <h6 class="mb-1">Black PVC Coated Welded Wire</h6>
                                <p class="mb-1 text-muted" style="font-size: 0.9rem;">3" × 3" - 12.5 ga. <br> 36 inches × 300 feet</p>
                                <button class="btn btn-link text-danger p-0" style="font-size: 0.85rem;">Delete</button>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="input-group" style="max-width: 120px;">
                                <button class="btn btn-outline-secondary btn-sm">-</button>
                                <input type="text" class="form-control text-center" value="1" style="font-size: 0.9rem;">
                                <button class="btn btn-outline-secondary btn-sm">+</button>
                            </div>
                        </div>
                    </div>
                    <!-- Delivery Options -->
                    <div class="col-md-6">
                        <h6 class="mb-3">Delivery options</h6>
                        <form>
                            <div class="form-check mb-2">
                                <input type="radio" class="form-check-input" id="option1" name="delivery" checked>
                                <label for="option1" class="form-check-label">Tomorrow from 11AM - 4PM - <strong>Free</strong></label>
                                <small class="text-muted d-block">Local Pick up - 19 N Day, Orange, NJ, 07050</small>
                            </div>
                            <div class="form-check mb-2">
                                <input type="radio" class="form-check-input" id="option2" name="delivery">
                                <label for="option2" class="form-check-label">Today from 2PM - 4PM - <strong>$30.00</strong></label>
                                <small class="text-danger d-block">Rush Local Pick up - Call before placing order</small>
                            </div>
                            <div class="form-check mb-2">
                                <input type="radio" class="form-check-input" id="option3" name="delivery">
                                <label for="option3" class="form-check-label">Receiving in 5-7 days - <strong>$34.99</strong></label>
                                <small class="text-muted d-block">UPS GROUND</small>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="option4" name="delivery">
                                <label for="option4" class="form-check-label">Receiving in 1-2 weeks - <strong>$84.99</strong></label>
                                <small class="text-muted d-block">TForce Freight LTL</small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Section -->
        <div class="col-lg-4">
            <div class="card p-4 shadow-sm rounded">
                <h6 class="mb-3">Shipping Address</h6>
                <p class="mb-2">Jonathan Doe<br>+1 456 789 123<br>144 Baker Avenue<br>Northehills, UK<br>SW43 4MM</p>
                <a href="#" class="btn btn-link text-primary p-0 mb-4" style="font-size: 0.9rem;">Change</a>

                <h6 class="mb-3">Payment Method</h6>
                <p class="mb-2">Debit card<br>**** **** **** 2742</p>
                <a href="#" class="btn btn-link text-primary p-0 mb-4" style="font-size: 0.9rem;">Change</a>

                <h6 class="mb-3">Items Summary</h6>
                <div class="d-flex justify-content-between mb-2">
                    <span>Items(2)</span>
                    <span>$90.00</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Shipping & handling</span>
                    <span>$34.99</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Tax</span>
                    <span>$4.99</span>
                </div>
                <div class="d-flex justify-content-between mb-3 fw-bold">
                    <span>Total</span>
                    <span>$99.97</span>
                </div>
                <button class="btn btn-danger w-100">Place your order</button>
            </div>
        </div>
    </div>
</main>
@endsection
