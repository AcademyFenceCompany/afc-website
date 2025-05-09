


<?php $__env->startSection('title', 'Activity'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Filters Section -->
    <div class="filters">
        <form method="GET" action="" class="filters-form">
            <input type="text" name="search" class="search-input" placeholder="Search by Order ID, Name or Email"
                value="<?php echo e(request('search')); ?>" />
            <input type="date" name="activity_date" id="activity-date" class="filter-input"
                value="<?php echo e(request('activity_date')); ?>" />
            <select name="status" id="status" class="filter-select">
                <option value="all" <?php echo e(request('status') == 'all' ? 'selected' : ''); ?>>All Orders</option>
                <option value="new" <?php echo e(request('status') == 'new' ? 'selected' : ''); ?>>New Orders</option>
                <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Completed</option>
                <option value="sold" <?php echo e(request('status') == 'sold' ? 'selected' : ''); ?>>Sold Only</option>
                <option value="quote" <?php echo e(request('status') == 'quote' ? 'selected' : ''); ?>>Quote Only</option>
                <option value="both" <?php echo e(request('status') == 'both' ? 'selected' : ''); ?>>Quoted and Sold</option>
            </select>
            <button class="filter-btn" type="submit">Apply Filters</button>
        </form>
    </div>
    <div class="activity-navigation">
        <a href="<?php echo e(route('ams.activity', ['activity_date' => \Carbon\Carbon::parse($activityDate)->subDay()->toDateString()])); ?>"
            class="nav-button">
            << Previous Day </a>
                <span class="current-date">
                    Today's Activity For: <?php echo e(\Carbon\Carbon::parse($activityDate)->format('l m/d/Y')); ?>

                </span>
                <a href="<?php echo e(route('ams.activity', ['activity_date' => \Carbon\Carbon::parse($activityDate)->addDay()->toDateString()])); ?>"
                    class="nav-button">
                    Next Day >>
                </a>
    </div>
    <!-- Orders List -->
    <div class="orders-list">
        <?php dump($orders); ?>
        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <!-- Order Header -->
            <div class="order-header">
                <a href="<?php echo e(route('ams.orders.edit', $order->id)); ?>" class="order-id">
                    #<?php echo e($order->id); ?>

                </a>
                <span class="customer-name">
                    <?php if($order->customer): ?>
                        <?php if($order->customer->name && $order->customer->company): ?>
                            <p><?php echo e($order->customer->company); ?></p>
                        <?php elseif($order->customer->name): ?>
                            <p><?php echo e($order->customer->name); ?></p>
                        <?php elseif($order->customer->company): ?>
                            <p><?php echo e($order->customer->company); ?></p>
                        <?php else: ?>
                            <p>N/A</p>
                        <?php endif; ?>
                    <?php else: ?>
                        <p>N/A</p>
                    <?php endif; ?>
                </span>
                <span class="order-location">
                    <?php if($order->shippingAddress): ?>
                        <?php echo e($order->shippingAddress->city ?? 'N/A'); ?>, <?php echo e($order->shippingAddress->state ?? 'N/A'); ?>

                    <?php elseif($order->billingAddress): ?>
                        <?php echo e($order->billingAddress->city ?? 'N/A'); ?>, <?php echo e($order->billingAddress->state ?? 'N/A'); ?>

                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </span>

                <!-- Determine the Order Date -->
                <span class="order-date">
                    <?php if($order->status->sold_date): ?>
                        Sold-<?php echo e(\Carbon\Carbon::parse($order->status->sold_date)->format('m-d-Y')); ?>

                    <?php elseif($order->status->quote_date): ?>
                        Quoted-<?php echo e(\Carbon\Carbon::parse($order->status->quote_date)->format('m-d-Y')); ?>

                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </span>

                <span class="order-total">$<?php echo e(number_format($order->total, 2)); ?></span>

                <!-- Status Buttons -->
                <div class="order-status-buttons">
                    <?php if($order->status->sold_date): ?>
                        <button class="status-button sold" title="Sold">S</button>
                    <?php endif; ?>
                    <?php if($order->status->quote_date): ?>
                        <button class="status-button quoted" title="Quoted">Q</button>
                    <?php endif; ?>
                    <?php if($order->status->customer_confirmed_date): ?>
                        <button class="status-button customer-confirmed" title="Customer Confirmed">CC</button>
                    <?php endif; ?>
                    
                </div>
                <!-- Toggle Button -->
                <button class="toggle-items-btn" type="button" data-id="<?php echo e($order->id); ?>">
                    Order Summary </button>
            </div>

            <!-- Order Items -->
            <div class="order-items collapse" id="order-items-<?php echo e($order->id); ?>">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item #</th>
                            <th>Description</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $order->order; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($loop->iteration); ?></td>
                                <td><?php echo e($item->product ? $item->product->item_no : 'N/A'); ?></td>
                                <td><?php echo e($item->product ? $item->product->product_name : 'Unknown Product'); ?></td>
                                <td><?php echo e($item->product->details->size1 ?? 'N/A'); ?></td>
                                <td><?php echo e($item->product_quantity); ?></td>
                                <td>$<?php echo e(number_format($item->product_price_at_time_of_purchase, 2)); ?></td>
                                <td>$<?php echo e(number_format($item->product_price_at_time_of_purchase * $item->product_quantity, 2)); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <!-- Notes Section -->
                <div class="order-notes">
                    <p><strong>Notes:</strong> <?php echo e($order->notes ?? 'No additional notes.'); ?></p>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="no-orders">No orders found</div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php echo e($orders->links()); ?>

    </div>

    <!-- Status Legend -->
    <div class="status-legend">
        <div class="legend-item">
            <span class="status-box new"></span> New/Processing
        </div>
        <div class="legend-item">
            <span class="status-box quote"></span> Quote
        </div>
        <div class="legend-item">
            <span class="status-box customer-confirm"></span> Customer Confirm
        </div>
        <div class="legend-item">
            <span class="status-box sold"></span> Sold
        </div>
        <div class="legend-item">
            <span class="status-box completed"></span> Completed
        </div>
        <!-- Small Status Buttons -->
        <div class="small-status">
            <span class="small-box q">Q</span> Quote was sent
            <span class="small-box cc">CC</span> Customer confirm
            <span class="small-box s">S</span> Sold
            <span class="small-box sc">SC</span> Shipping confirm
        </div>
    </div>

<?php $__env->stopSection(); ?>

<style>
    /* Filters Section */
    .filters {
        margin-bottom: 20px;
    }

    .filters-form {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
    }

    .search-input,
    .filter-input,
    .filter-select,
    .filter-btn {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .filter-btn {
        background-color: #007bff;
        color: white;
        cursor: pointer;
    }

    .filter-btn:hover {
        background-color: #0056b3;
    }

    /* Orders List */
    .orders-list {
        margin-top: 20px;
    }

    .order-header {
        display: flex;
        align-items: center;
        /* Align items vertically */
        justify-content: space-between;
        /* Distribute space between items */
        padding: 10px;
        background-color: #f4f4f4;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 5px;
        gap: 10px;
        /* Add spacing between elements */
    }

    .order-header>* {
        flex: 1;
        /* Equal space for all items */
        text-align: center;
        /* Center align the text */
    }

    .order-id {
        font-weight: bold;
        color: #007bff;
        text-align: left;
        /* Align order ID to the left */
    }

    .customer-name {
        font-weight: bold;
        text-align: left;
        /* Align customer name to the left */
    }

    .order-location {
        text-align: left;
        /* Align location to the left */
    }

    .order-date {
        text-align: center;
        /* Center align the date */
    }

    .order-total {
        text-align: right;
        /* Align total to the right */
    }

    .order-status-buttons {
        display: flex;
        justify-content: center;
        /* Center align status buttons */
        gap: 5px;
    }

    .status-button {
        border: none;
        padding: 5px 10px;
        border-radius: 3px;
        font-weight: bold;
        cursor: pointer;
    }

    .status-button.sold {
        background-color: #28a745;
        color: #fff;
    }

    .status-button.quoted {
        background-color: #ffc107;
        color: #fff;
    }

    .status-button.customer-confirmed {
        background-color: #17a2b8;
        color: #fff;
    }

    .status-button.shipped {
        background-color: #6610f2;
        color: #fff;
    }

    .toggle-items-btn {
        background-color: #007bff;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
    }

    .toggle-items-btn:hover {
        background-color: #0056b3;
    }

    .order-status-buttons {
        display: flex;
        gap: 5px;
    }

    .status-button {
        border: none;
        padding: 5px 10px;
        border-radius: 3px;
        font-weight: bold;
        cursor: pointer;
    }

    .status-button.sold {
        background-color: #28a745;
        color: #fff;
    }

    .status-button.quoted {
        background-color: #ffc107;
        color: #fff;
    }

    .status-button.customer-confirmed {
        background-color: #17a2b8;
        color: #fff;
    }

    .status-button.shipped {
        background-color: #6610f2;
        color: #fff;
    }

    .order-items {
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
    }

    .table-sm th,
    .table-sm td {
        padding: 5px;
        font-size: 0.875rem;
    }

    .order-notes {
        margin-top: 10px;
        font-style: italic;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .pagination a,
    .pagination span {
        margin: 0 5px;
        padding: 5px 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        text-decoration: none;
        color: #000;
    }

    .pagination .active {
        background-color: #007bff;
        color: #fff;
    }

    .pagination .disabled {
        opacity: 0.5;
        pointer-events: none;
    }

    .order-items {
        display: none;
        /* Hide initially */
        padding: 10px;
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-top: 10px;
    }

    .order-items.show {
        display: block;
        /* Show when toggled */
    }

    .toggle-items-btn {
        background-color: #007bff;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        margin-top: 5px;
    }

    .toggle-items-btn:hover {
        background-color: #0056b3;
    }

    /* Navigation Section */
    .activity-navigation {
        display: flex;
        /* Arrange navigation buttons and date in a row */
        justify-content: space-between;
        /* Space out the Previous, Date, and Next buttons */
        align-items: center;
        /* Center align items vertically */
        margin-bottom: 20px;
        /* Add spacing below the navigation */
        background-color: #f4f4f4;
        /* Light background for better visibility */
        padding: 10px;
        /* Add padding for a better appearance */
        border-radius: 5px;
        /* Slightly round the corners */
    }

    .nav-button {
        text-decoration: none;
        /* Remove underline from links */
        font-weight: bold;
        /* Make text bold for emphasis */
        padding: 5px 10px;
        /* Add padding to make buttons look clickable */
        background-color: #007bff;
        /* Set blue background for buttons */
        color: white;
        /* White text color */
        border-radius: 5px;
        /* Rounded corners for buttons */
    }

    .nav-button:hover {
        background-color: #0056b3;
        /* Darker blue on hover */
    }

    .current-date {
        font-size: 16px;
        /* Slightly larger font for emphasis */
        font-weight: bold;
        /* Bold text to highlight the date */
    }

    /* Status Legend Fixed at Bottom */
    .status-legend {
        position: fixed;
        /* Fix to the bottom of the viewport */
        bottom: 0;
        /* Align to the bottom of the screen */
        left: 0;
        /* Stretch from the left */
        right: 0;
        /* Stretch to the right */
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        background-color: #f4f4f4;
        padding: 15px 20px;
        /* Add padding for spacing */
        border-top: 1px solid #ddd;
        /* Optional: Add a border for separation */
        justify-content: center;
        align-items: center;
        font-size: 14px;
        color: #333;
        z-index: 1000;
        /* Ensure it appears above other elements */
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .status-box {
        display: inline-block;
        width: 20px;
        height: 20px;
        border-radius: 3px;
    }

    .status-box.new {
        background-color: #c49b9b;
        /* New/Processing */
    }

    .status-box.quote {
        background-color: #d1b484;
        /* Quote */
    }

    .status-box.customer-confirm {
        background-color: #b3c9e2;
        /* Customer Confirm */
    }

    .status-box.sold {
        background-color: #7dc17d;
        /* Sold */
    }

    .status-box.completed {
        background-color: #a0a2c3;
        /* Completed */
    }

    .small-status {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
    }

    .small-box {
        display: inline-block;
        width: 25px;
        height: 25px;
        border-radius: 3px;
        text-align: center;
        line-height: 25px;
        font-weight: bold;
        border: 1px solid #ccc;
        background-color: #f4f4f4;
        color: #333;
    }

    .small-box.q {
        border-color: #d1b484;
    }

    .small-box.cc {
        border-color: #b3c9e2;
    }

    .small-box.s {
        border-color: #7dc17d;
    }

    .small-box.sc {
        border-color: #a0a2c3;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Add event listener to all toggle buttons
        document.querySelectorAll('.toggle-items-btn').forEach((button) => {
            button.addEventListener('click', () => {
                const orderId = button.getAttribute('data-id');
                const target = document.querySelector(`#order-items-${orderId}`);

                // Hide all other collapses
                document.querySelectorAll('.order-items').forEach((item) => {
                    if (item !== target) {
                        item.classList.remove('show');
                    }
                });

                // Toggle the current collapse
                target.classList.toggle('show');
            });
        });
    });
</script>

<?php echo $__env->make('layouts.ams', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\afc-website\resources\views/ams/activity.blade.php ENDPATH**/ ?>