

<?php $__env->startSection('title', $productDetails->product_name); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-5">
        <!-- Product Details Section -->
        <div class="row g-5 mb-5 align-items-start">
            <!-- Product Image Section -->
            <div class="col-md-4">
                <div class="card shadow-sm text-center">
                    <img id="product-image" src="<?php echo e(asset('storage/products/' . $productDetails->img_large ?? $productDetails->img_large)); ?>" alt="<?php echo e($productDetails->product_name); ?>" class="img-fluid p-3">
                </div>
            </div>
            
            <!-- Product Information Section -->
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <h1 id="product-name" style="font-size: 1.7rem">
                            <?php echo e($productDetails->product_name); ?>

                            </br>
                            <?php echo e($productDetails->size); ?>

                            </br>
                            <?php if($productDetails->majorcategories_id === 1): ?>
                                <!-- Check if it's Wood Fence -->
                                <?php if($productDetails->style): ?>
                                    <?php echo e($productDetails->style); ?>

                                <?php endif; ?>
                                <?php if($productDetails->speciality): ?>
                                    </br><?php echo e($productDetails->speciality); ?>

                                <?php endif; ?>
                                <?php if($productDetails->spacing): ?>
                                    
                                <?php endif; ?>
                            <?php else: ?>
                                <!-- For non-Wood Fence categories -->
                                <?php echo e($productDetails->size2); ?> <?php echo e($productDetails->size3); ?>

                            <?php endif; ?>
                        </h1>
                        <p class="text-success fw-bold">In Stock</p>
                        <p><strong>Item Number:</strong> <span id="item-number"><?php echo e($productDetails->item_no); ?></span></p>
                        <?php if(!is_null($productDetails->weight_lbs)): ?>
                            <p><strong>weight</strong> <span id="weight"><?php echo e($productDetails->weight_lbs); ?> lbs</span></p>
                        <?php endif; ?>
                        <div class="product-options-container" style="position: relative; width: 250px;">
                            <!-- Constrain width -->
                            <label for="product-option" class="form-label fw-bold">Size - Color:</label>
                            <select id="product-option" class="form-select bg-white mb-2"
                                style="max-height: 38px; max-width:fit-content;">
                                <?php $__currentLoopData = $productVariations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($option->id); ?>">
                                        <?php if($option->size): ?>
                                            <?php echo e($option->size); ?> ---- <?php echo e($option->color); ?> --- <?php echo e($option->size2); ?>

                                        <?php else: ?>
                                            <?php echo e($option->size); ?> ---- <?php echo e($option->color); ?>

                                        <?php endif; ?>
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-6">
                                
                                
                                
                                <div class="d-flex align-items-center mb-3">
                                    <label for="quantity" class="me-3 fw-bold">Quantity:</label>
                                    <button class="btn btn-outline-secondary btn-sm me-2 quantity-decrease">-</button>
                                    <input type="number" class="quantity-input text-center" value="1" min="1"
                                        data-price="<?php echo e($productDetails->price); ?>" />
                                    <button class="btn btn-outline-secondary btn-sm quantity-increase">+</button>
                                </div>
                                
                                <h5>Price:</h5>
                                <p id="product-price">$<?php echo e(number_format($productDetails->price, 2)); ?></p>

                                <button class="btn btn-sm btn-danger text-white ms-2 add-to-cart-btn"
                                    data-item="<?php echo e($productDetails->item_no); ?>"
                                    data-name="<?php echo e($productDetails->product_name); ?>"
                                    data-price="<?php echo e($productDetails->price); ?>"
                                    data-color="<?php echo e($productDetails->color); ?>" data-size="<?php echo e($productDetails->size); ?>"
                                    data-size2="<?php echo e($productDetails->size2); ?>" data-size3="<?php echo e($productDetails->size3); ?>"
                                    data-speciality="<?php echo e($productDetails->speciality); ?>"
                                    data-material="<?php echo e($productDetails->material); ?>"
                                    data-spacing="<?php echo e($productDetails->spacing); ?>"
                                    data-coating="<?php echo e($productDetails->coating); ?>"
                                    data-weight="<?php echo e($productDetails->weight_lbs); ?>"
                                    data-family_category="<?php echo e($productDetails->majorcategories_id); ?>"
                                    data-img_large="<?php echo e($productDetails->img_large); ?>"
                                    data-img_small="<?php echo e($productDetails->img_small); ?>"
                                    data-img_large="<?php echo e($productDetails->img_large); ?>"
                                    data-free_shipping="<?php echo e($productDetails->free_shipping); ?>"
                                    data-special_shipping="<?php echo e($productDetails->special_shipping); ?>"
                                    data-amount_per_box="<?php echo e($productDetails->amount_per_box); ?>"
                                    data-desc_short="<?php echo e($productDetails->desc_short); ?>"
                                    data-id="<?php echo e($productDetails->id); ?>"
                                    data-ship_length="<?php echo e($productDetails->ship_length); ?>"
                                    data-ship_width="<?php echo e($productDetails->ship_width); ?>"
                                    data-ship_height="<?php echo e($productDetails->ship_height); ?>">
                                    
                                    Add to Cart
                                </button>

                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-white shadow rounded">
                            <h5 class="text-center">About this item</h5>
                            <p><?php echo e($productDetails->desc_short); ?></p>
                        </div>
                        <div class="p-3 bg-white shadow rounded mt-4">
                            <h5 class="text-center">To Place Order - Get Quick Quote/Price</h5>
                            <p>If you know what parts you need - Add items to the cart for total price with shipping.</p>
                            <a href="#" class="btn btn-outline-dark mt-2">Print Quote Sheet</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

      
        <!-- Dynamically Generated Associated Products Sections -->
        <?php if(isset($associatedSections) && count($associatedSections) > 0): ?>
          <!-- Associated Products Section -->
          <div class="mt-5">
            <h4 class="text-black px-3 rounded">Necessary Associated Products</h4>
        </div>

            <?php $__currentLoopData = $associatedSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="mt-5">
                    <h4 class="bg-danger text-white py-2 px-3 rounded" style="
                    font-size: 15px;
                    text-align: center;
                "><?php echo e($section['title']); ?></h4>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered text-center">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>Item Number</th>
                                    <th>Name</th>
                                    <th>Size</th>
                                    <th>Color</th>
                                    <th>Quantity</th>
                                    <th>Price / Add to Cart</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $section['products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($product->item_no); ?></td>
                                        <td><?php echo e($product->product_name); ?></td>
                                        <td><?php echo e($product->size); ?></td>
                                        <td><?php echo e($product->color); ?></td>
                                        <td>
                                            <button class="btn btn-outline-secondary btn-sm decrease-qty">-</button>
                                            <input type="number" class="quantity-input text-center" value="1" min="1"
                                                data-price="<?php echo e($product->price); ?>" data-product-id="<?php echo e($product->id ?? ''); ?>">
                                            <button class="btn btn-outline-secondary btn-sm increase-qty">+</button>
                                        </td>
                                        <td>
                                            <span>$<?php echo e(number_format($product->price, 2)); ?></span>
                                            <button class="btn btn-danger btn-sm add-to-cart-btn"
                                                data-item="<?php echo e($product->item_no); ?>" data-name="<?php echo e($product->product_name); ?>"
                                                data-price="<?php echo e($product->price); ?>" data-product-id="<?php echo e($product->id ?? ''); ?>" style="padding: 1px 5px;font-size: 12px;">
                                                Add to Cart
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <!-- Related Products Section -->
        <?php if(isset($relatedProducts) && count($relatedProducts) > 0): ?>
            <div class="mt-5">
                <h4 class="text-black px-3 rounded">Related Products</h4>
                <div class="row mt-3">
                    <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="<?php echo e(asset('storage/products/' . ($product->img_large ?? 'placeholder.jpg'))); ?>" 
                                        class="card-img-top p-2" 
                                        alt="<?php echo e($product->product_name); ?>"
                                        style="height: 150px; object-fit: contain;">
                                <div class="card-body text-center">
                                    <h6 class="card-title"><?php echo e($product->product_name); ?></h6>
                                    <p class="card-text">$<?php echo e(number_format($product->price, 2)); ?></p>
                                    <button class="btn btn-danger btn-sm add-to-cart-btn"
                                        data-item="<?php echo e($product->item_no); ?>" 
                                        data-name="<?php echo e($product->product_name); ?>"
                                        data-price="<?php echo e($product->price); ?>" style="padding: 1px 5px;font-size: 12px;">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/mini-cart.js')); ?>"></script>
    <script src="<?php echo e(asset('js/cart.js')); ?>"></script>
    <script src="<?php echo e(asset('js/single-product.js')); ?>"></script>
    <script src="<?php echo e(asset('js/associated-products.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<!-- Toast Container -->
<div class="toast-container position-fixed bottom-0 start-0 p-3">
    <div id="cartToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="1500">
        <div class="toast-header bg-success">
            <strong class="me-auto">Cart Notification</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Item added to the cart successfully!
        </div>
    </div>
</div>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\afc-website\resources\views/products/single-product.blade.php ENDPATH**/ ?>