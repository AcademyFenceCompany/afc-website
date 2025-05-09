

<?php $__env->startSection('title', 'Aluminum Fence - In Stock for Quick Shipping or Pick Up'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    /* Header styles */
    .bg-brown {
        background-color: #8B4513 !important;
    }
    .page-title {
        font-size: 24px !important;
        color: #fff !important;
        font-weight: bold !important;
        padding: 10px 0 !important;
    }
    
    /* Product section styles */
    .product-section {
        margin-bottom: 40px;
    }
    
    .product-header {
        background-color: #8B4513;
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        margin-bottom: 15px;
    }
    
    .product-image {
        width: 100%;
        max-width: 190px;
        height: auto;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 15px;
    }
    
    .product-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .product-table th {
        background-color: #f8f9fa;
        padding: 8px;
        text-align: left;
        border: 1px solid #ddd;
    }
    
    .product-table td {
        border: 1px solid #ddd;
        font-size: 13px;
    }
    
    .price {
        font-weight: bold;
        color: #8B4513;
    }
    
    .btn-add-cart {
        background-color: #8B4513;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 3px;
        cursor: pointer;
        font-size: 12px;
    }
    
    .btn-add-cart:hover {
        background-color: #6B3100;
    }
    
    .quantity-input {
        width: 50px;
        text-align: center;
    }
    .product-header h4 {
        font-size: 15px;
    /* Responsive grid */
    @media (max-width: 768px) {
        .product-section {
            flex-direction: column;
        }
        
        .product-image {
            margin: 0 auto 15px;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    
    
    <!-- Intro Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body" style="padding: 10px;">
                    <h2 class="text-center">Most Popular Aluminum Fence Items <span style="color: red; font-weight: bold;">in stock</span> for Quick Shipping or Pick Up</h2>
                    <p class="text-center">
                        We carry a wide variety of aluminum fence styles and heights for immediate pickup or quick shipping.
                        Below are our most popular items that are typically in stock and ready to go.
                    </p>
                    <div class="text-center">
                        <a href="<?php echo e(route('aluminumfence.index')); ?>" class="btn btn-danger">View All OnGuard Aluminum Fence Options</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Products Grid -->
    <div class="row">
        <?php $__currentLoopData = $pickupProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 product-section">
                <div class="product-header">
                    <h4 class="mb-0"><?php echo e($product['title']); ?></h4>
                </div>
                
                <div class="d-flex flex-column flex-md-row">
                    <div class="text-center mb-3 mb-md-0 me-md-4">
                        <img src="<?php echo e($product['image']); ?>" alt="<?php echo e($product['title']); ?>" class="product-image" onerror="this.src='<?php echo e(url('storage/products/default.png')); ?>'">
                    </div>
                    
                    <div class="flex-grow-1">
                        <table class="product-table">
                            <thead>
                              
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $product['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($item['name']); ?></td>
                                        <td><?php echo e($item['size']); ?></td>
                                        <td class="price">$<?php echo e(number_format($item['price'], 2)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<?php $__env->startSection('scripts'); ?>
<script>
    $(document).ready(function() {
        // Handle add to cart button clicks
        $('.btn-add-cart').click(function() {
            var button = $(this);
            var itemNo = button.data('item');
            var name = button.data('name');
            var price = button.data('price');
            var quantity = button.closest('tr').find('.quantity-input').val();
            
            // Add to cart AJAX call
            $.ajax({
                url: '<?php echo e(route("cart.add")); ?>',
                method: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    item_no: itemNo,
                    product_name: name,
                    price: price,
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        alert('Item added to cart!');
                        
                        // Update cart count in the header if it exists
                        if ($('.cart-count').length > 0) {
                            $('.cart-count').text(response.cartCount);
                        }
                    } else {
                        alert('Error adding item to cart');
                    }
                },
                error: function(xhr) {
                    alert('Error adding item to cart');
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\afc-website\resources\views/categories/aluminumfence-pickup.blade.php ENDPATH**/ ?>