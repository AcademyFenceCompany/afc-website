


<?php $__env->startSection('title', 'Customer Details'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt-4">
        <h1 class="mb-4">Customer Details</h1>

        <!-- Customer Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Customer Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> <?php echo e($customer->name ?: 'N/A'); ?></p>
                <p><strong>Company:</strong> <?php echo e($customer->company ?: 'N/A'); ?></p>
                <p><strong>Email:</strong> <?php echo e($customer->email ?: 'N/A'); ?></p>
                <p><strong>Phone:</strong> <?php echo e($customer->phone ?: 'N/A'); ?></p>
            </div>
        </div>

        <!-- Addresses -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Addresses</h5>
            </div>
            <div class="card-body">
                <?php $__empty_1 = true; $__currentLoopData = $customer->addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="mb-3">
                        <p><strong>Address:</strong> <?php echo e($address->address_1); ?>, <?php echo e($address->city); ?>, <?php echo e($address->state); ?>

                            <?php echo e($address->zipcode); ?></p>
                        <p>
                            <?php if($address->billing_flag): ?>
                                <span class="badge bg-primary">Billing</span>
                            <?php endif; ?>
                            <?php if($address->shipping_flag): ?>
                                <span class="badge bg-success">Shipping</span>
                            <?php endif; ?>
                        </p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p>No addresses found.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Orders -->
        <div class="card">
            <div class="card-header">
                <h5>Orders</h5>
            </div>
            <div class="card-body">
                <?php if($customer->orders->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $customer->orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($order->customer_order_id); ?></td>
                                        <td><?php echo e($order->created_at ? $order->created_at->format('M d, Y H:i') : 'N/A'); ?></td>
                                        <td>$<?php echo e(number_format($order->total, 2)); ?></td>
                                        <td><?php echo e(ucfirst($order->status)); ?></td>
                                        <td>
                                            <a href="/orders/<?php echo e($order->id); ?>" class="btn btn-sm btn-primary">View</a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p>No orders found for this customer.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.ams', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\afc-website\resources\views/ams/customers/view.blade.php ENDPATH**/ ?>