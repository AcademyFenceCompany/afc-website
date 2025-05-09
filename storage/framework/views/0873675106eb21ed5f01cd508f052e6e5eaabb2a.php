

<?php $__env->startSection('title', 'Order Details'); ?>

<?php $__env->startSection('content'); ?>
    <div class="order-details">
        <!-- Order Summary and Shipping Info -->
        <div class="grid-container">
            <div class="section order-summary">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="card-title mb-0">Order Details</h5>
                    <div>
                        <a href="<?php echo e(route('ams.orders.create', ['customer_id' => $order->customer_id])); ?>"
                            class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Create Order for this Customer
                        </a>
                    </div>
                </div>
                <h2 class="section-title"><i class="fas fa-receipt"></i> Order Summary</h2>
                <p><strong>Customer:</strong>
                    <?php echo e($order->customer->name ?? 'N/A'); ?>

                    <?php if($order->customer->company): ?>
                        (<?php echo e($order->customer->company); ?>)
                    <?php endif; ?>
                </p>
                <p><strong>Email:</strong> <?php echo e($order->customer->email ?? 'N/A'); ?></p>
                <p><strong>Order Status:</strong>
                    <?php if($order->status->sold_date): ?>
                        <span class="status sold">Sold on
                            <?php echo e(\Carbon\Carbon::parse($order->status->sold_date)->format('F j, Y, g:i a')); ?></span>
                    <?php elseif($order->status->quote_date): ?>
                        <span class="status quote">Quoted on
                            <?php echo e(\Carbon\Carbon::parse($order->status->quote_date)->format('F j, Y, g:i a')); ?></span>
                    <?php else: ?>
                        <span class="status pending">Pending</span>
                    <?php endif; ?>
                </p>
            </div>

            <div class="section shipping-details">
                <h2 class="section-title"><i class="fas fa-shipping-fast"></i> Shipping Information</h2>
                <?php if($order->shippingDetails): ?>
                    <p><strong>Carrier:</strong> <?php echo e($order->shippingDetails->carrier ?? 'N/A'); ?></p>
                    <p><strong>Shipped By:</strong> <?php echo e($order->shippingDetails->shipby ?? 'N/A'); ?></p>
                    <p><strong>Status:</strong> <?php echo e($order->shippingDetails->status ?? 'N/A'); ?></p>
                    <p><strong>Tracking No:</strong> <?php echo e($order->shippingDetails->tracking_no ?? 'N/A'); ?></p>
                    <p><strong>Actual Shipping Cost:</strong>
                        $<?php echo e(number_format($order->shippingDetails->actual_shipping_cost, 2)); ?></p>
                    <p><strong>Shipping Cost Markup:</strong>
                        $<?php echo e(number_format($order->shippingDetails->shipping_cost_markup, 2)); ?></p>
                <?php else: ?>
                    <p>No shipping details available for this order.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Shipping & Billing Info -->
        <div class="grid-container">
            <div class="section address-info">
                <h2 class="section-title"><i class="fas fa-map-marker-alt"></i> Shipping Address</h2>
                <p>
                    <?php if($order->shippingAddress): ?>
                        <?php echo e($order->shippingAddress->address_1); ?>,
                        <?php echo e($order->shippingAddress->city); ?>,
                        <?php echo e($order->shippingAddress->state); ?>

                        <?php echo e($order->shippingAddress->zipcode); ?>

                    <?php else: ?>
                        Shipping address not available
                    <?php endif; ?>
                </p>
            </div>

            <div class="section address-info">
                <h2 class="section-title"><i class="fas fa-bill"></i> Billing Address</h2>
                <p>
                    <?php if($order->billingAddress): ?>
                        <?php echo e($order->billingAddress->address_1 ?? 'N/A'); ?>,
                        <?php echo e($order->billingAddress->city ?? 'N/A'); ?>,
                        <?php echo e($order->billingAddress->state ?? 'N/A'); ?>

                        <?php echo e($order->billingAddress->zipcode ?? 'N/A'); ?>

                    <?php else: ?>
                        Billing address not available
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <!-- Order Items -->
        <div class="section order-items">
            <h2 class="section-title"><i class="fas fa-box"></i> Order Items</h2>
            <table>
                <thead>
                    <tr>
                        <th>Item #</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $order->order; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($item->product ? $item->product->item_no : 'N/A'); ?></td>
                            <td><?php echo e($item->product ? $item->product->product_name : 'Unknown Product'); ?></td>
                            <td><?php echo e($item->product_quantity); ?></td>
                            <td>$<?php echo e(number_format($item->product_price_at_time_of_purchase, 2)); ?></td>
                            <td>$<?php echo e(number_format($item->product_quantity * $item->product_price_at_time_of_purchase, 2)); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <!-- Payment Info -->
        <div class="section payment-info">
            <h2 class="section-title"><i class="fas fa-credit-card"></i> Payment Information</h2>
            <p><strong>Payment Method:</strong> <?php echo e($order->payment_method); ?></p>
            <p><strong>Total:</strong> $<?php echo e(number_format($order->total, 2)); ?></p>
        </div>

        <!-- Other Orders by Customer -->
        <div class="section other-orders">
            <h2 class="section-title"><i class="fas fa-history"></i> Other Orders</h2>
            <?php if($customerOrders->isNotEmpty()): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $customerOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customerOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <a href="<?php echo e(route('orders.show', $customerOrder->original_order_id)); ?>">
                                        #<?php echo e($customerOrder->original_order_id); ?>

                                    </a>
                                </td>
                                <td>
                                    <?php echo e($customerOrder->status->sold_date ? \Carbon\Carbon::parse($customerOrder->status->sold_date)->format('F j, Y') : 'N/A'); ?>

                                </td>
                                <td>
                                    <?php if($customerOrder->status): ?>
                                        <?php if($customerOrder->status->sold_date): ?>
                                            Sold
                                        <?php elseif($customerOrder->status->quote_date): ?>
                                            Quoted
                                        <?php else: ?>
                                            Pending
                                        <?php endif; ?>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td>$<?php echo e(number_format($customerOrder->total, 2)); ?></td>
                                <td>
                                    <a href="<?php echo e(route('orders.show', $customerOrder->original_order_id)); ?>"
                                        class="view-details-btn">View</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No other orders found for this customer.</p>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<style>
    .order-details {
        padding: 20px;
        background: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
    }

    .grid-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .section {
        padding: 15px;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 18px;
        color: #333;
        margin-bottom: 15px;
        border-bottom: 2px solid #007bff;
        padding-bottom: 5px;
    }

    .status {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
        color: white;
        font-size: 12px;
    }

    .status.sold {
        background-color: #28a745;
    }

    .status.quote {
        background-color: #ffc107;
        color: black;
    }

    .status.pending {
        background-color: #6c757d;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    table th,
    table td {
        text-align: left;
        padding: 10px;
        border: 1px solid #ddd;
    }

    table th {
        background: #f4f4f4;
        font-weight: bold;
    }

    .view-details-btn {
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
    }

    .view-details-btn:hover {
        text-decoration: underline;
    }
</style>

<?php echo $__env->make('layouts.ams', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\afc-website\resources\views/ams/order/order-details.blade.php ENDPATH**/ ?>