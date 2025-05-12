<div class="dropdown" style="margin-left: 10px;">
    <a href="#" class="nav-link position-relative text-light" id="cartDropdown" data-bs-toggle="dropdown">
        <i class="bi bi-cart fs-4"></i>
        <span id="cart-count" class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill">
            <?php echo e(session('cart') ? count(session('cart')) : 0); ?>

        </span>
    </a>

    <div class="dropdown-menu dropdown-menu-end p-3 shadow-lg" style="min-width: 270px;">
        <ul id="mini-cart-items" class="list-unstyled mb-2">
            <?php $__currentLoopData = session('cart', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h6 class="mb-0" style="font-size: 14px;"><?php echo e($item['product_name']); ?></h6>
                        <small class="text-muted">Qty: <?php echo e($item['quantity']); ?></small>
                    </div>
                    <span class="fw-bold" style="font-size: 14px;">$<?php echo e(number_format($item['total'], 2)); ?></span>
                </li>
                <hr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>

        <p id="empty-cart-message" class="<?php echo e(count(session('cart', [])) > 0 ? 'd-none' : ''); ?> text-center">Your cart is
            empty
        </p>
        <div class="d-grid gap-2">
            <a href="<?php echo e(route('cart.view')); ?>" class="btn btn-danger w-100">View Cart</a>
            <a href="<?php echo e(route('checkout.index')); ?>" class="btn btn-danger w-100">Checkout</a>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\afc-website\resources\views/layouts/partials/mini-cart.blade.php ENDPATH**/ ?>