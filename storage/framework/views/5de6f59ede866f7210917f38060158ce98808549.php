

<?php $__env->startSection('title', 'Checkout'); ?>

<?php $__env->startSection('content'); ?>
    <main class="container my-5">
        <h2 class="text-center mb-4">Checkout</h2>

        <div class="row">
            <div class="col-lg-8">
                <form id="checkout-form">
                    <?php echo csrf_field(); ?>
                    <!-- Customer Information -->
                    <h5 class="mb-3">Customer Information</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="customer-first-name" class="form-label">First Name</label>
                            <input type="text" id="customer-first-name" name="customer_first_name" class="form-control"
                                placeholder="Enter your first name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="customer-last-name" class="form-label">Last Name</label>
                            <input type="text" id="customer-last-name" name="customer_last_name" class="form-control"
                                placeholder="Enter your last name" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="customer-email" class="form-label">Email Address</label>
                            <input type="email" id="customer-email" name="customer_email" class="form-control"
                                placeholder="Enter your email address" required>
                        </div>
                    </div>
                    <!-- Shipping or Pickup -->
                    <h5 class="mb-3">Shipping or Pickup</h5>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="delivery_option" id="delivery-shipping"
                            value="shipping" checked>
                        <label class="form-check-label" for="delivery-shipping">
                            Ship to Address
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="delivery_option" id="delivery-pickup"
                            value="pickup">
                        <label class="form-check-label" for="delivery-pickup">
                            Pickup from Store
                        </label>
                    </div>

                    <!-- Shipping Information -->
                    <div id="shipping-section">
                        <h6 class="mb-3">Shipping Information</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="recipient-address" class="form-label">Shipping Address</label>
                                <input type="text" id="recipient-address" name="recipient_address" class="form-control"
                                    placeholder="Enter recipient address" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="recipient-city" class="form-label">Shipping City</label>
                                <input type="text" id="recipient-city" name="recipient_city" class="form-control"
                                    placeholder="Enter recipient city" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="recipient-state" class="form-label">Shipping State</label>
                                <input type="text" id="recipient-state" name="recipient_state" class="form-control"
                                    placeholder="Enter recipient state" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="recipient-postal" class="form-label">Shipping ZIP Code</label>
                                <input type="text" id="destination-zip" name="recipient_postal" class="form-control"
                                    placeholder="Enter recipient ZIP code" required>
                            </div>
                        </div>
                    </div>

                    <!-- Pickup Information -->
                    <div id="pickup-section" class="d-none">
                        <h6 class="mb-3">Pickup Location</h6>
                        <div class="d-flex">
                            <div class="border p-3 flex-grow-1">
                                <strong>Academy Fence Company, Inc</strong>
                                <p>119 N Day St, Orange, NJ 07050</p>
                                <p><strong>Phone:</strong> 973-674-0600</p>
                                <p><strong>Email:</strong> info@academyfence.com</p>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <!-- Google Map Embed -->
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3021.38648183507!2d-74.2278731!3d40.775516800000005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c3ab30c593349f%3A0x8f5a4fd1e023b46c!2sAcademy%20Fence%20Company%20Inc!5e0!3m2!1sen!2sus!4v1738428950886!5m2!1sen!2sus"
                                    width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>
                    </div>

                    <!-- Billing Information -->
                    <h5 class="mb-3">Billing Information</h5>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="billing-toggle">
                        <label class="form-check-label" for="billing-toggle">
                            Billing information is different from shipping information
                        </label>
                    </div>

                    <div id="billing-info-section" class="d-none">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="billing-address" class="form-label">Billing Address</label>
                                <input type="text" id="billing-address" name="billing_address" class="form-control"
                                    placeholder="Enter billing address">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="billing-city" class="form-label">Billing City</label>
                                <input type="text" id="billing-city" name="billing_city" class="form-control"
                                    placeholder="Enter billing city">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="billing-state" class="form-label">Billing State</label>
                                <input type="text" id="billing-state" name="billing_state" class="form-control"
                                    placeholder="Enter billing state">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="billing-postal" class="form-label">Billing ZIP Code</label>
                                <input type="text" id="billing-postal" name="billing_postal" class="form-control"
                                    placeholder="Enter billing ZIP code">
                            </div>
                        </div>
                    </div>

                    <div class="d-none">
                        <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="product-item" data-quantity="<?php echo e($item['quantity']); ?>" data-weight="<?php echo e($item['weight_lbs']); ?>"
                                data-shipping-length="<?php echo e($item['ship_length']); ?>"
                                data-shipping-width="<?php echo e($item['ship_width']); ?>"
                                data-shipping-height="<?php echo e($item['ship_height']); ?>"
                                data-category-id="<?php echo e($item['categories_id'] ?? 0); ?>">
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <button type="button" id="calculate-shipping" class="btn btn-primary">Calculate Shipping</button>
                </form>

                <div id="shipping-options" class="mt-4">
                    <h5 class="mb-3">Available Shipping Rates</h5>
                    <div id="shipping-rates" class="border p-3"></div>
                    
                    <?php if(!empty($cart)): ?>
                        <?php
                            $hasCategory82 = false;
                            foreach($cart as $item) {
                                if(isset($item['categories_id']) && $item['categories_id'] == 82) {
                                    $hasCategory82 = true;
                                    break;
                                }
                            }
                        ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-4">
                <h5>Your Order</h5>
                <div class="border p-3">
                    <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="d-flex justify-content-between">
                            <span><?php echo e($item['product_name']); ?> × <?php echo e($item['quantity']); ?></span><br>
                            <span>$<?php echo e(number_format($item['total'], 2)); ?></span><br>
                        </div>
                        <small class="text-muted">Item # - <?php echo e($item['item_no']); ?></small><br>
                        <small class="text-muted">Item # - <?php echo e($item['weight_lbs']); ?> LBS</small><br>
                        <small class="text-muted">Size: <?php echo e($item['size'] ?? 'N/A'); ?></small><br>
                        <small class="text-muted">Size 2: <?php echo e($item['size2'] ?? 'N/A'); ?></small><br>
                        <small class="text-muted">Size 3: <?php echo e($item['size3'] ?? 'N/A'); ?></small><br>
                        <small class="text-muted">Color: <?php echo e($item['color'] ?? 'N/A'); ?></small>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span>Subtotal</span>
                        <span>$<?php echo e(number_format($subtotal, 2)); ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Tax</span>
                        <span>$<?php echo e(number_format($tax, 2)); ?></span>
                    </div>
                    <div id="shipping-cost" class="d-flex justify-content-between d-none">
                        <span>Shipping</span>
                        <span id="shipping-cost-value">$0.00</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong id="total-amount"
                            data-total="<?php echo e($total); ?>">$<?php echo e(number_format($total, 2)); ?></strong>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="mt-4">
                    <h5 class="mb-3">Payment Information</h5>
                    <div class="border p-3">
                        <form id="payment-form" action="api/charge" method="POST" class="needs-validation" novalidate>
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="amount" id="amount" value="<?php echo e(number_format($total, 2)); ?>">
                            <div class="mb-3">
                                <label for="card-number" class="form-label">Card Number</label>
                                <input type="text" class="form-control" id="card-number" name="card_number" required
                                    placeholder="1234 5678 9012 3456">
                                <div class="invalid-feedback">
                                    Please enter a valid card number
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="card-expiry" class="form-label">Expiration Date</label>
                                    <input type="text" class="form-control" id="card-expiry" name="expiration_date"
                                        required placeholder="MM/YY">
                                    <div class="invalid-feedback">
                                        Please enter a valid expiration date
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="card-cvc" class="form-label">Security Code</label>
                                    <input type="text" class="form-control" id="card-cvc" name="cvv" required
                                        placeholder="CVC">
                                    <div class="invalid-feedback">
                                        Please enter a valid security code
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100" id="submit-payment">
                                Pay Now <?php echo e(number_format($total, 2)); ?>

                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        .shipping-breakdown {
            font-size: 0.875rem;
        }

        .shipping-option-label {
            display: block;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            cursor: pointer;
        }

        .shipping-option-label:hover {
            background-color: #f8f9fa;
        }

        .shipping-option-label input[type="radio"] {
            margin-right: 8px;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        window.appConfig = {
            csrfToken: "<?php echo e(csrf_token()); ?>",
            calculateShippingUrl: "/shipping-rates",
        };

        // Toggle Billing Information Section
        document.getElementById('billing-toggle').addEventListener('change', function() {
            const billingSection = document.getElementById('billing-info-section');
            if (this.checked) {
                billingSection.classList.remove('d-none');
            } else {
                billingSection.classList.add('d-none');
            }
        });

        // Toggle between Shipping and Pickup sections
        const shippingSection = document.getElementById('shipping-section');
        const pickupSection = document.getElementById('pickup-section');
        const calculateShippingButton = document.getElementById('calculate-shipping');
        const shippingRatesSection = document.getElementById('shipping-options');

        document.getElementById('delivery-shipping').addEventListener('change', function() {
            if (this.checked) {
                shippingSection.classList.remove('d-none');
                pickupSection.classList.add('d-none');
                calculateShippingButton.classList.remove('d-none'); // Show the button
                shippingRatesSection.classList.remove('d-none'); // Show the shipping rates section
            }
        });

        document.getElementById('delivery-pickup').addEventListener('change', function() {
            if (this.checked) {
                pickupSection.classList.remove('d-none');
                shippingSection.classList.add('d-none');
                calculateShippingButton.classList.add('d-none'); // Hide the button
                shippingRatesSection.classList.add('d-none'); // Hide the shipping rates section
                document.getElementById('shipping-cost-value').innerText = '$0.00'; // Set shipping cost to $0.00
            }
        });
    </script>
    <script src="<?php echo e(asset('js/checkout.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\afc-website\resources\views/cart/checkout.blade.php ENDPATH**/ ?>