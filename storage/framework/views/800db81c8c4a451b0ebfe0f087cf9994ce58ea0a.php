<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"> <!-- CSRF Token -->
    <!-- Favicon -->
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <title><?php echo e($title ?? 'Academy Fence Company'); ?></title>
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet">
    <?php echo $__env->yieldContent('styles'); ?>
    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>
</head>

<body style="font-family: 'Inter', sans-serif;">
    <?php if(!in_array(Route::currentRouteName(), ['login', 'register'])): ?>
        <!-- Header Section -->
        <?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    

    <!-- Main Content Section -->
    <main class="custom-container my-2">
        <?php echo e($slot ?? ''); ?>

        <?php echo $__env->yieldContent('content'); ?>

    </main>
    <?php echo $__env->yieldContent('scripts'); ?>
    <?php if(!in_array(Route::currentRouteName(), ['login', 'register'])): ?>
        <!-- Footer Section -->
        <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                const scrollingInfo = document.getElementById("scrolling-info");
                if (scrollingInfo) scrollingInfo.style.display = "none";
            }, 60000); // 60 seconds
        });
    </script>
    <!-- Cart Scripts -->
    <script src="<?php echo e(asset('js/mini-cart.js')); ?>"></script>
    <script src="<?php echo e(asset('js/cart.js')); ?>"></script>
    <script src="<?php echo e(asset('js/cart-helper.js')); ?>"></script>

</body>

</html>
<?php /**PATH C:\xampp\htdocs\afc-website\resources\views/layouts/main.blade.php ENDPATH**/ ?>