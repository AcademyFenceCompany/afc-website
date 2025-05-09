

<?php $__env->startSection('title', $category->family_category_name); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-2">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="<?php echo e(route('ams.orders.categories')); ?>">Categories</a>
                    </li>
                    <?php if($category->parent): ?>
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(route('ams.orders.category.show', $category->parent->family_category_id)); ?>">
                                <?php echo e($category->parent->family_category_name); ?>

                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="breadcrumb-item active"><?php echo e($category->family_category_name); ?></li>
                </ol>
            </nav>
            <?php if(request()->has('order_id')): ?>
                <a href="<?php echo e(route('ams.orders.create')); ?>?order_id=<?php echo e(request()->get('order_id')); ?>" class="btn btn-primary">
                    <i class="fas fa-shopping-cart"></i> Back to Order
                </a>
            <?php endif; ?>
        </div>

        <!-- Toast Container for Notifications -->
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" id="addToOrderToast">
                <div class="d-flex">
                    <div class="toast-body">
                        Product added to order successfully!
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>

        <?php if($category->children->count() > 0): ?>
            <!-- Show subcategories -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4"><?php echo e($category->family_category_name); ?> Categories</h5>
                        <div class="row row-cols-1 row-cols-md-4 g-4">
                            <?php $__currentLoopData = $category->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col">
                                    <a href="<?php echo e(route('ams.orders.category.show', $child->family_category_id)); ?>"
                                        class="card h-100 text-decoration-none">
                                        <div class="card-body">
                                            <h5 class="card-title text-primary"><?php echo e($child->family_category_name); ?></h5>
                                            <?php if($child->children_count > 0): ?>
                                                <p class="card-text text-muted">
                                                    <?php echo e($child->children_count); ?> subcategories
                                                </p>
                                            <?php endif; ?>
                                            <?php if($child->products_count > 0): ?>
                                                <p class="card-text text-muted">
                                                    <?php echo e($child->products_count); ?> products
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Products Section -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3"><?php echo e($category->family_category_name); ?> Products</h5>

                    <?php if($columns->isNotEmpty()): ?>
                        <div class="row g-4">
                            <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $columnGroups): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-4">
                                    <?php $__currentLoopData = $columnGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title => $products): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="product-group mb-4">
                                            <div class="header bg-dark text-white py-2 px-3"><?php echo e($title); ?></div>
                                            <div class="table-responsive">
                                                <table class="table table-sm mb-0">
                                                    <thead>
                                                        <tr class="bg-secondary text-white">
                                                            <th class="px-2" style="width: 20%">Size</th>
                                                            <th class="px-2" style="width: 12%">Price</th>
                                                            <th class="px-2" style="width: 20%">Item #</th>
                                                            <th class="px-2" style="width: 10%">WT</th>
                                                            <th class="px-2" style="width: 8%">EO</th>
                                                            <th class="px-2" style="width: 8%">HQ</th>
                                                            <th class="px-2" style="width: 12%">Qty</th>
                                                            <th class="px-2" style="width: 10%"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td class="px-2"><?php echo e($product->size1); ?></td>
                                                                <td class="px-2">$<?php echo e(number_format($product->price_per_unit, 2)); ?></td>
                                                                <td class="px-2"><?php echo e($product->item_no); ?></td>
                                                                <td class="px-2"><?php echo e($product->weight); ?></td>
                                                                <td class="px-2"><?php echo e($product->in_stock_warehouse); ?></td>
                                                                <td class="px-2"><?php echo e($product->in_stock_hq); ?></td>
                                                                <td class="px-2">
                                                                    <input type="number"
                                                                        class="form-control form-control-sm product-quantity"
                                                                        value="1" min="1">
                                                                </td>
                                                                <td class="px-2">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-primary add-single-product w-100"
                                                                        data-product-id="<?php echo e($product->product_id); ?>"
                                                                        data-product-name="<?php echo e($product->product_name); ?>"
                                                                        data-product-price="<?php echo e($product->price_per_unit); ?>"
                                                                        data-item-no="<?php echo e($product->item_no); ?>"
                                                                        data-size="<?php echo e($product->size1); ?>"
                                                                        data-weight="<?php echo e($product->weight); ?>">
                                                                        Add
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <h6 class="text-muted">No products found in this category</h6>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Return to Order Modal -->
    <div class="modal fade" id="returnToOrderModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Return to Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Do you want to return to the order? Your selected products will be added to the order.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continue Shopping</button>
                    <button type="button" class="btn btn-primary" id="confirmReturn">Return to Order</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        .product-group {
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            overflow: hidden;
        }

        .product-group .header {
            font-size: 0.9rem;
            font-weight: 500;
        }

        .table {
            margin-bottom: 0;
            white-space: nowrap;
        }

        .table td,
        .table th {
            padding: 0.25rem 0.5rem;
            vertical-align: middle;
            font-size: 11px;
            line-height: 1.2;
        }

        .table thead th {
            border-bottom: 0;
            background-color: #6c757d;
            font-weight: 500;
            white-space: nowrap;
        }

        .product-quantity {
            width: 45px !important;
            padding: 0.15rem 0.25rem;
            text-align: center;
            font-size: 11px;
            height: 22px;
        }

        .btn-primary {
            padding: 0.15rem 0.25rem;
            font-size: 11px;
            height: 22px;
            line-height: 1;
        }

        .row.g-4 {
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 1.5rem;
        }

        .row.g-4>* {
            margin-bottom: 1.5rem;
        }

        .table-responsive {
            margin-bottom: -1px;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function() {
            const toast = new bootstrap.Toast(document.getElementById('addToOrderToast'));
            
            // Function to update parent window's order table
            function updateParentOrderTable() {
                try {
                    if (window.opener && typeof window.opener.updateOrderItemsTable === 'function') {
                        window.opener.updateOrderItemsTable();
                        return true;
                    }
                    return false;
                } catch (e) {
                    console.error('Error updating parent window:', e);
                    return false;
                }
            }
            
            // Add single product
            $('.add-single-product').click(function() {
                const button = $(this);
                const row = button.closest('tr');
                const productId = button.data('product-id');
                const productName = button.data('product-name');
                const price = button.data('product-price');
                const quantity = parseInt(row.find('.product-quantity').val()) || 1;
                const itemNo = button.data('item-no');
                const size = button.data('size');
                const weight = button.data('weight');

                console.log('Adding product:', {
                    productId,
                    productName,
                    price,
                    quantity,
                    itemNo,
                    size,
                    weight
                });

                // Show loading state
                button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

                try {
                    // Get existing order items from localStorage
                    let orderItems = [];
                    try {
                        orderItems = JSON.parse(localStorage.getItem('orderItems') || '[]');
                        console.log('Current order items:', orderItems);
                    } catch (e) {
                        console.error('Error parsing orderItems from localStorage:', e);
                    }

                    // Add new product
                    const newItem = {
                        id: Date.now(),
                        productId: productId,
                        productName: productName,
                        itemNo: itemNo,
                        size: size,
                        weight: weight,
                        quantity: quantity,
                        price: price
                    };
                    
                    orderItems.push(newItem);
                    console.log('Added new item:', newItem);
                    console.log('Updated order items:', orderItems);

                    // Save back to localStorage
                    localStorage.setItem('orderItems', JSON.stringify(orderItems));
                    console.log('Saved to localStorage');

                    // Show success state
                    button.html('<i class="fas fa-check"></i>')
                        .removeClass('btn-primary')
                        .addClass('btn-success');

                    // Show toast
                    toast.show();

                    // Try to update parent window
                    const updated = updateParentOrderTable();
                    if (!updated) {
                        console.log('Parent window update failed - opening new window');
                        // If parent window update fails, redirect back to order page
                        const orderId = new URLSearchParams(window.location.search).get('order_id');
                        if (orderId) {
                            window.location.href = "<?php echo e(route('ams.orders.create')); ?>?order_id=" + orderId;
                        }
                    }
                } catch (error) {
                    console.error('Error adding product:', error);
                    button.html('<i class="fas fa-exclamation-triangle"></i>')
                        .removeClass('btn-primary')
                        .addClass('btn-danger');
                }

                // Reset button after delay
                setTimeout(() => {
                    button.prop('disabled', false)
                        .html('Add')
                        .removeClass('btn-success btn-danger')
                        .addClass('btn-primary');
                }, 1000);
            });

            // Add all products in a group
            $('.add-group').click(function() {
                const group = $(this).closest('.product-group');
                const products = [];

                group.find('tbody tr').each(function() {
                    const row = $(this);
                    const button = row.find('.add-single-product');
                    const quantity = parseInt(row.find('.product-quantity').val()) || 1;

                    products.push({
                        id: Date.now() + Math.random(),
                        productId: button.data('product-id'),
                        productName: button.data('product-name'),
                        itemNo: button.data('item-no'),
                        size: button.data('size'),
                        weight: button.data('weight'),
                        quantity: quantity,
                        price: button.data('product-price')
                    });
                });

                console.log('Adding group of products:', products);

                try {
                    // Get existing order items
                    let orderItems = JSON.parse(localStorage.getItem('orderItems') || '[]');
                    console.log('Current order items:', orderItems);
                    
                    // Add all products
                    orderItems = orderItems.concat(products);
                    console.log('Updated order items:', orderItems);
                    
                    // Save to localStorage
                    localStorage.setItem('orderItems', JSON.stringify(orderItems));
                    console.log('Saved to localStorage');

                    // Update buttons to show success
                    group.find('.add-single-product').each(function() {
                        const button = $(this);
                        button.prop('disabled', true)
                            .html('<i class="fas fa-check"></i>')
                            .removeClass('btn-primary')
                            .addClass('btn-success');
                    });

                    // Show toast
                    toast.show();

                    // Try to update parent window
                    const updated = updateParentOrderTable();
                    if (!updated) {
                        console.log('Parent window update failed - opening new window');
                        // If parent window update fails, redirect back to order page
                        const orderId = new URLSearchParams(window.location.search).get('order_id');
                        if (orderId) {
                            window.location.href = "<?php echo e(route('ams.orders.create')); ?>?order_id=" + orderId;
                        }
                    }
                } catch (error) {
                    console.error('Error adding products:', error);
                    group.find('.add-single-product').each(function() {
                        const button = $(this);
                        button.html('<i class="fas fa-exclamation-triangle"></i>')
                            .removeClass('btn-primary')
                            .addClass('btn-danger');
                    });
                }

                // Reset buttons after delay
                setTimeout(() => {
                    group.find('.add-single-product').each(function() {
                        const button = $(this);
                        button.prop('disabled', false)
                            .html('Add')
                            .removeClass('btn-success btn-danger')
                            .addClass('btn-primary');
                    });
                }, 1000);
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.ams', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\afc-website\resources\views/ams/order/categories/show.blade.php ENDPATH**/ ?>