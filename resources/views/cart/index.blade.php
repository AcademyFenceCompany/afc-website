@extends('layouts.main')

@section('title', 'Checkout')

@section('content')
<main class="container py-5">
    <h1 class="text-center mb-3">Checkout</h1>
    <p class="text-center text-danger">Because of current conditions, prices are subject to change without prior notice.</p>
    
    <div class="row">
        <!-- Product and Delivery Section -->
        <div class="col-md-8">
            <div class="card shadow-sm p-4 mb-4">
                <h5 class="mb-4">Product Information</h5>
                <div class="d-flex align-items-center mb-3">
                    <img src="/resources/images/dum-product.png" alt="Product Image" class="img-fluid me-3" style="width: 80px; height: 80px;">
                    <div>
                        <h6 class="mb-0">Black PVC Coated Welded Wire</h6>
                        <small class="text-muted">3" x 3" - 12.5 ga.</small><br>
                        <small class="text-muted">36 inches x 300 feet</small>
                        <p class="text-danger mt-2 delete-btn" style="cursor: pointer;">Delete</p>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <button class="btn btn-outline-secondary btn-sm quantity-decrease">-</button>
                    <input type="number" value="1" class="form-control mx-2 text-center quantity-input" style="width: 60px;" min="1">
                    <button class="btn btn-outline-secondary btn-sm quantity-increase">+</button>
                </div>
            </div>

            <div class="card shadow-sm p-4">
                <h5 class="mb-4">Delivery Options</h5>
                <div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="delivery" id="localPickup" checked>
                        <label class="form-check-label" for="localPickup">
                            Tomorrow from 11AM - 4PM - <span class="fw-bold">Free</span> (Local Pickup)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="delivery" id="rushPickup">
                        <label class="form-check-label" for="rushPickup">
                            Today from 2PM - 4PM - <span class="fw-bold">$30.00</span> (Rush Local Pickup)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="delivery" id="upsGround">
                        <label class="form-check-label" for="upsGround">
                            Receiving in 5-7 days - <span class="fw-bold">$34.99</span> (UPS GROUND)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="delivery" id="tforceFreight">
                        <label class="form-check-label" for="tforceFreight">
                            Receiving in 1-2 weeks - <span class="fw-bold">$84.99</span> (TForce Freight LTL)
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Section -->
        <div class="col-md-4">
            <div class="card shadow-sm p-4 mb-4">
                <h5>Shipping Address</h5>
                <p>Jonathan Doe<br>+1 456 789 123<br>144 Baker Avenue<br>Northernhills, UK SW43 4MM</p>
                <a href="#" class="text-primary">Change</a>
            </div>

            <div class="card shadow-sm p-4 mb-4">
                <h5>Payment Method</h5>
                <p>Debit card<br>**** **** **** 2742</p>
                <a href="#" class="text-primary">Change</a>
            </div>

            <div class="card shadow-sm p-4">
                <h5>Items Summary</h5>
                <p>Items(2): <span class="float-end">$90.00</span></p>
                <p>Shipping & Handling: <span class="float-end">$34.99</span></p>
                <p>Tax: <span class="float-end">$4.99</span></p>
                <h5>Total: <span class="float-end text-danger">$99.97</span></h5>
            </div>
        </div>
    </div>

    <div class="text-end mt-4">
        <button class="btn btn-danger">Place Your Order</button>
    </div>
</main>
@endsection

@section('scripts')
<script>
    // Quantity Button Functionality
    document.addEventListener('DOMContentLoaded', function () {
        // Update Cart Total
        const updateCartTotal = () => {
            let total = 0;
            document.querySelectorAll('.quantity-input').forEach(input => {
                total += parseFloat(input.value) * 90; // Example price per item
            });
            document.querySelector('.text-danger.float-end').textContent = `$${total.toFixed(2)}`;
        };

        document.querySelectorAll('.quantity-increase').forEach(button => {
            button.addEventListener('click', function () {
                const quantityInput = this.previousElementSibling;
                quantityInput.value = parseInt(quantityInput.value) + 1;
                updateCartTotal();
            });
        });

        document.querySelectorAll('.quantity-decrease').forEach(button => {
            button.addEventListener('click', function () {
                const quantityInput = this.nextElementSibling;
                if (quantityInput.value > 1) {
                    quantityInput.value = parseInt(quantityInput.value) - 1;
                    updateCartTotal();
                }
            });
        });
    });
</script>
@endsection
