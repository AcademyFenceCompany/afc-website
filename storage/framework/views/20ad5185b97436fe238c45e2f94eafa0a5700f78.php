


<?php $__env->startSection('title', $page->title); ?>

<?php $__env->startSection('content'); ?>
    <!-- Header Section -->
    <div class="bg-black text-white text-center py-3 rounded">
        <h1 class="mb-0"><?php echo e($page->title); ?></h1>
    </div>
    <div class="mt-2">
        <p class="text-center"><?php echo $page->subtitle; ?></p>
    </div>

    <!-- Main Section -->
    <div class="row mt-4 align-items-center">
        <!-- Left Column -->
        <div class="col-md-4">
            <div class="bg-warning text-dark p-4 rounded shadow-sm">
                <h4 class="fw-bold">The Original online Fence Superstore</h4>
                <p class="mb-0"><em>Family owned operated since 1968</em></p>
                <div><?php echo $page->bulletin_board; ?></div>

                <!-- Category Tidbits -->
                <div class="mt-3">
                    <?php if($page->category_tidbit_1): ?>
                        <div class="mb-3"><?php echo $page->category_tidbit_1; ?></div>
                    <?php endif; ?>
                    <?php if($page->category_tidbit_2): ?>
                        <div class="mb-3"><?php echo $page->category_tidbit_2; ?></div>
                    <?php endif; ?>
                    <?php if($page->category_tidbit_3): ?>
                        <div class="mb-3"><?php echo $page->category_tidbit_3; ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Center Image -->
        <div class="col-md-4 text-center">
            <?php if($page->product_image): ?>
                <img style="max-width: 357px;height: 270px;" src="<?php echo e(Storage::url($page->product_image)); ?>"
                    alt="<?php echo e($page->title); ?> Image" class="img-fluid rounded shadow-sm">
            <?php endif; ?>
        </div>

        <!-- Right Column -->
        <div class="col-md-4">
            <?php if($page->product_text): ?>
                <div class="product-text">
                    <?php echo $page->product_text; ?>

                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Products Section -->
    <?php if(empty($groupedProducts['groups']) && empty($meshSize_products) && empty($mainTableProducts)): ?>
        <div class="alert alert-info mt-5">
            No products found for this category.
        </div>
    <?php else: ?>
        <?php if($isRazorWire ?? false): ?>
            <!-- Razor Wire Products -->
            <div class="mt-4">
                <h2 class="text-center mb-4">18" Razor Wire Pricing</h2>

                <!-- Main Product Table -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-danger text-white">
                            <tr>
                                <th>Item No.</th>
                                <th>Description</th>
                                <th>Weight</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $mainTableProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($product->item_no); ?></td>
                                    <td><?php echo e($product->size1); ?></td>
                                    <td><?php echo e($product->weight); ?> lbs</td>
                                    <td>$<?php echo e(number_format($product->price_per_unit, 2)); ?></td>
                                    <td>
                                        <input type="number" class="form-control quantity-input" min="1"
                                            max="<?php echo e($quantityLimits[$product->product_id]); ?>" value="1"
                                            data-product-id="<?php echo e($product->product_id); ?>"
                                            onchange="validateQuantity(this, <?php echo e($quantityLimits[$product->product_id]); ?>)">
                                    </td>
                                    <td>
                                        <button class="btn btn-danger add-to-cart-btn"
                                            data-product-id="<?php echo e($product->product_id); ?>"
                                            data-price="<?php echo e($product->price_per_unit); ?>"
                                            data-item="<?php echo e($product->item_no); ?>"
                                            data-product-name="<?php echo e($product->product_name); ?>"
                                            data-size1="<?php echo e($product->size1); ?>" data-weight="<?php echo e($product->weight); ?>"
                                            data-family-category="<?php echo e($mainCategory->family_category_id); ?>">
                                            Add to Cart
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <!-- Footer Section -->
                <?php if($page->footer_subtitle || $page->footer_bulletin_board || $page->footer_product_image || $page->footer_product_text): ?>
                    <div class="mt-5">
                        <?php if($page->footer_subtitle): ?>
                            <div class="text-center mb-4">
                                <h3><?php echo $page->footer_subtitle; ?></h3>
                            </div>
                        <?php endif; ?>

                        <?php if($page->footer_bulletin_board): ?>
                            <div class="alert alert-danger text-center">
                                <?php echo $page->footer_bulletin_board; ?>

                            </div>
                        <?php endif; ?>

                        <div class="row align-items-center">
                            <?php if($page->footer_product_image): ?>
                                <div class="col-md-6 text-center">
                                    <img src="<?php echo e(Storage::url($page->footer_product_image)); ?>" alt="Footer Product Image"
                                        class="img-fluid rounded shadow-sm">
                                </div>
                            <?php endif; ?>

                            <?php if($page->footer_product_text): ?>
                                <div class="col-md-<?php echo e($page->footer_product_image ? '6' : '12'); ?>">
                                    <div class="footer-product-text">
                                        <?php echo $page->footer_product_text; ?>

                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- Other Products -->
                <?php if($otherProducts->count() > 0): ?>
                    <h3 class="text-center mt-5 mb-4">Other Available Products</h3>
                    <div class="row">
                        <?php $__currentLoopData = $otherProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-3 mb-4">
                                <div class="card h-100">
                                    <div class="card-header bg-danger text-white">
                                        <p class="mb-0"><?php echo e($product->product_name); ?></p>
                                    </div>
                                    <div class="card-body">
                                        <img style="max-width: 150px;height: 125px;"
                                            src="<?php echo e(Storage::url($product->large_image)); ?>"
                                            alt="<?php echo e($product->product_name); ?>" class="img-fluid rounded shadow-sm">
                                        <p class="card-text">
                                            <strong>Item No:</strong> <?php echo e($product->item_no); ?><br>
                                            <strong>Weight:</strong> <?php echo e($product->weight); ?> lbs<br>
                                            <strong>Price:</strong> $<?php echo e(number_format($product->price_per_unit, 2)); ?>

                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <input type="number" class="form-control quantity-input" style="width: 100px"
                                                min="1" value="1" data-product-id="<?php echo e($product->product_id); ?>">
                                            <button class="btn btn-danger add-to-cart-btn"
                                                data-item="<?php echo e($product->item_no); ?>"
                                                data-price="<?php echo e($product->price_per_unit); ?>"
                                                data-product-name="<?php echo e($product->product_name); ?>"
                                                data-size1="<?php echo e($product->size1); ?>" data-weight="<?php echo e($product->weight); ?>"
                                                data-family-category="<?php echo e($mainCategory->family_category_id); ?>">
                                                Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php elseif($isWeldedWire): ?>
            <!-- Welded Wire Products by Gauge -->
            <?php $__currentLoopData = $meshSize_products->groupBy('size3'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gauge => $products): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <!-- Gauge Section -->
                <div class="mt-5">
                    <div class="bg-danger text-white text-center py-2 rounded">
                        <h4><?php echo e($gauge); ?> Gauge</h4>
                    </div>
                    <div class="row mt-3">
                        <!-- Left Image -->
                        <div class="col-md-3 text-center">
                            <div class="card shadow-sm">
                                <div class="card-header bg-danger text-white fw-bold py-2">
                                    <?php echo e($products->first()->size2 ?? 'Mesh Size'); ?>,
                                    <?php echo e($gauge ?? 'Gauge'); ?>

                                </div>
                                <div class="card-body">
                                    <img src="<?php echo e($products->first()->large_image ? Storage::url($products->first()->large_image) : asset('images/default.png')); ?>"
                                        alt="<?php echo e($products->first()->product_name); ?>" class="img-fluid rounded">
                                </div>
                            </div>
                        </div>

                        <!-- Right Content -->
                        <div class="col-md-9">
                            <p class="text-danger"><strong>Note:</strong> call ahead for local pickup!</p>
                            <?php echo $__env->make('partials.product-table', [
                                'products' => $products,
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <!-- Regular Products -->
            <?php $__currentLoopData = $groupedProducts['groups']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="mt-5">
                    <div class="row">
                        <!-- Left Image Column -->
                        <div class="col-md-3">
                            <?php if($group['image']): ?>
                                <img style="max-width: 357px;height: 270px;" src="<?php echo e(Storage::url($group['image'])); ?>"
                                    alt="<?php echo e($group['title']); ?>" class="img-fluid rounded">
                            <?php endif; ?>
                        </div>

                        <!-- Right Content Column -->
                        <div class="col-md-9">
                            <!-- Group Header -->
                            <div class="bg-danger text-white text-center py-2 rounded">
                                <h4><?php echo e($group['title']); ?></h4>
                            </div>

                            <?php if(!empty($group['subgroups'])): ?>
                                <!-- Navigation Buttons -->
                                <div class="mt-3 text-center">
                                    <?php $__currentLoopData = $group['subgroups']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $subgroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <button class="btn btn-outline-primary mb-2 me-2 speciality-btn"
                                            data-target="speciality-<?php echo e($loop->parent->index); ?>-<?php echo e($index); ?>">
                                            <?php echo e($subgroup['title']); ?>

                                        </button>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                                <!-- speciality Groups -->
                                <?php $__currentLoopData = $group['subgroups']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $subgroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="speciality-group mt-4"
                                        id="speciality-<?php echo e($loop->parent->index); ?>-<?php echo e($index); ?>"
                                        style="<?php echo e($loop->first ? '' : 'display: none;'); ?>">
                                        <?php echo $__env->make('partials.product-table', [
                                            'products' => $subgroup['products'],
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <?php echo $__env->make('partials.product-table', ['products' => $group['products']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Footer Section -->
    <?php if($page->footer_subtitle || $page->footer_bulletin_board || $page->footer_product_image || $page->footer_product_text): ?>
        <div class="mt-5">
            <?php if($page->footer_subtitle): ?>
                <div class="text-center mb-4">
                    <h3><?php echo $page->footer_subtitle; ?></h3>
                </div>
            <?php endif; ?>

            <?php if($page->footer_bulletin_board): ?>
                <div class="alert alert-danger text-center">
                    <?php echo $page->footer_bulletin_board; ?>

                </div>
            <?php endif; ?>

            <div class="row align-items-center">
                <?php if($page->footer_product_image): ?>
                    <div class="col-md-6 text-center">
                        <img src="<?php echo e(Storage::url($page->footer_product_image)); ?>" alt="Footer Product Image"
                            class="img-fluid rounded shadow-sm">
                    </div>
                <?php endif; ?>

                <?php if($page->footer_product_text): ?>
                    <div class="col-md-<?php echo e($page->footer_product_image ? '6' : '12'); ?>">
                        <div class="footer-product-text">
                            <?php echo $page->footer_product_text; ?>

                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle speciality button clicks
            const specialityBtns = document.querySelectorAll('.speciality-btn');
            specialityBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const parentGroup = this.closest('.mt-5');
                    const allGroups = parentGroup.querySelectorAll('.speciality-group');
                    const allBtns = parentGroup.querySelectorAll('.speciality-btn');

                    // Hide all groups
                    allGroups.forEach(group => group.style.display = 'none');
                    // Show target group
                    document.getElementById(targetId).style.display = 'block';
                    // Update button states
                    allBtns.forEach(btn => btn.classList.remove('btn-primary', 'text-white'));
                    this.classList.add('btn-primary', 'text-white');
                });
            });

            // Handle quantity buttons
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('quantity-decrease') || e.target.classList.contains(
                        'quantity-increase')) {
                    const input = e.target.closest('.input-group').querySelector('.quantity-input');
                    let value = parseInt(input.value) || 1;

                    if (e.target.classList.contains('quantity-increase')) {
                        value = Math.min(value + 1, 99); // Max 99
                    } else {
                        value = Math.max(value - 1, 1); // Min 1
                    }

                    input.value = value;
                }
            });

            // Initialize cart functionality
            initializeCart();
        });

        function updateProductDetails(selectElement) {
            const row = selectElement.closest('tr');
            const variants = JSON.parse(selectElement.dataset.variants);
            const selectedColor = selectElement.value;
            const variant = variants[selectedColor];

            // Update item number
            row.querySelector('.item-no').textContent = variant.item_no;

            // Update mesh size
            const meshSize = row.querySelector('.mesh-size');
            if (meshSize) {
                meshSize.textContent = variant.size2;
            }

            // Update weight
            const weight = row.querySelector('.weight');
            if (weight) {
                weight.textContent = variant.weight ? variant.weight + ' lbs' : '-';
            }

            // Update add to cart button data attributes
            const addToCartBtn = row.querySelector('.add-to-cart-btn');
            if (addToCartBtn) {
                addToCartBtn.dataset.item = variant.item_no;
                addToCartBtn.dataset.size2 = variant.size2;
                addToCartBtn.dataset.weight = variant.weight;
            }
        }

        function initializeCart() {
            const cartIcon = document.getElementById('cart-icon');
            const miniCart = document.getElementById('mini-cart');

            if (cartIcon && miniCart) {
                // Toggle mini cart on icon click
                cartIcon.addEventListener('click', function(e) {
                    e.preventDefault();
                    miniCart.classList.toggle('show');
                });

                // Close mini cart when clicking outside
                document.addEventListener('click', function(e) {
                    if (miniCart && !miniCart.contains(e.target) && e.target !== cartIcon) {
                        miniCart.classList.remove('show');
                    }
                });
            }

            // Initialize color selects
            document.querySelectorAll('.color-select').forEach(select => {
                updateProductDetails(select);
            });

            // Add to cart functionality
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('add-to-cart-btn')) {
                    e.preventDefault();
                    const button = e.target;
                    const container = button.closest('tr') || button.closest('.card-body');
                    const quantity = parseInt(container.querySelector('.quantity-input').value) || 1;
                    const price = parseFloat(button.dataset.price);

                    // Create FormData
                    const formData = new FormData();
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                    formData.append('item_no', button.dataset.item || '');
                    formData.append('product_name', button.dataset.productName || '');
                    formData.append('price', price.toString());
                    formData.append('quantity', quantity.toString());
                    formData.append('size1', button.dataset.size1 || '');
                    formData.append('weight', button.dataset.weight || '0');
                    formData.append('family_category', button.dataset.familyCategory || '');

                    // Add color if color select exists
                    const colorSelect = container.querySelector('.color-select');
                    if (colorSelect) {
                        formData.append('color', colorSelect.value);
                    }

                    // Add other fields if they exist
                    if (button.dataset.size2) formData.append('size2', button.dataset.size2);
                    if (button.dataset.size3) formData.append('size3', button.dataset.size3);
                    if (button.dataset.speciality) formData.append('speciality', button.dataset.speciality);
                    if (button.dataset.material) formData.append('material', button.dataset.material);
                    if (button.dataset.spacing) formData.append('spacing', button.dataset.spacing);
                    if (button.dataset.coating) formData.append('coating', button.dataset.coating);
                    if (button.dataset.shippingLength) formData.append('shipping_length', button.dataset
                        .shippingLength);
                    if (button.dataset.shippingWidth) formData.append('shipping_width', button.dataset
                        .shippingWidth);
                    if (button.dataset.shippingHeight) formData.append('shipping_height', button.dataset
                        .shippingHeight);
                    if (button.dataset.shippingClass) formData.append('shipping_class', button.dataset
                        .shippingClass);

                    // Send request to add to cart
                    fetch('/cart/add', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show success message
                                const toast = new bootstrap.Toast(document.getElementById('cartToast'));
                                document.querySelector('#cartToast .toast-body').textContent =
                                    'Item added to cart successfully!';
                                toast.show();

                                // Update cart UI
                                updateCartUI(data);
                            } else {
                                alert(data.message || 'Failed to add item to cart');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while adding to cart');
                        });
                }
            });
        }

        function updateCartUI(response) {
            const cartCount = document.getElementById('cart-count');
            const cartItemsList = document.getElementById('cart-items');
            const cartTotal = document.getElementById('cart-total');
            const emptyCartMessage = document.getElementById('empty-cart-message');

            if (response.cart) {
                // Update cart count
                if (cartCount) {
                    cartCount.textContent = response.cartCount;
                    cartCount.style.display = response.cartCount > 0 ? 'inline' : 'none';
                }

                // Update cart items
                if (cartItemsList) {
                    cartItemsList.innerHTML = Object.values(response.cart).map(item => `
                        <li class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-0" style="font-size: 14px;">${item.product_name}</h6>
                                <small class="text-muted">Qty: ${item.quantity}</small>
                            </div>
                            <span class="fw-bold" style="font-size: 14px;">$${(item.total).toFixed(2)}</span>
                        </li>
                        <hr>
                    `).join('');
                }

                // Update cart total
                if (cartTotal && response.total) {
                    cartTotal.textContent = `$${response.total}`;
                }

                // Toggle empty cart message
                if (emptyCartMessage) {
                    emptyCartMessage.classList.toggle('d-none', Object.keys(response.cart).length > 0);
                }
            }
        }
    </script>

    <?php $__env->startPush('scripts'); ?>
        <script>
            function validateQuantity(input, maxLimit) {
                const value = parseInt(input.value);
                if (value > maxLimit) {
                    input.value = maxLimit;
                    alert('Maximum quantity for this product is ' + maxLimit);
                }
            }
        </script>
    <?php $__env->stopPush(); ?>

    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="cartToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">
                <strong class="me-auto">Cart Update</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="toast-body"></div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\afc-website\resources\views/category-page.blade.php ENDPATH**/ ?>