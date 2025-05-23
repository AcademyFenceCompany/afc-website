<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"> <!-- CSRF Token -->
    <meta name="app-url" content="<?php echo e(url('/')); ?>"> <!-- Base URL for JavaScript -->
    <!-- Favicon -->
    <link rel="icon" href="<?php echo e(url('/resources/images/favicon.ico')); ?>" type="image/x-icon">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    
    <!-- App CSS -->
    <link href="<?php echo e(secure_asset('css/app.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(secure_asset('css/style.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo e(secure_asset('assets/css/vendor.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(secure_asset('assets/css/main.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(secure_asset('assets/css/bootstrap.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(secure_asset('assets/css/style.css')); ?>">
    
    <title><?php echo e($title ?? 'Academy Fence Company'); ?></title>
    
    <!-- Page specific styles -->
    <?php echo $__env->yieldContent('styles'); ?>
    
    <!-- Core JS -->
    <script src="<?php echo e(secure_asset('js/app.js')); ?>" defer></script>
</head>

<body style="font-family: 'Inter', sans-serif;">

    <!-- Preloader wrapper -->
    <div class="preloader-wrapper">
      <div class="preloader"></div>
    </div>

    <!-- Cart Offcanvas -->
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart" aria-labelledby="My Cart">
      <div class="offcanvas-header justify-content-center">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <div class="order-md-last">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-primary">Your cart</span>
            <span class="badge bg-primary rounded-pill cart-count">0</span>
          </h4>
          <ul class="list-group mb-3" id="cart-items">
            <!-- Cart items will be loaded here -->
          </ul>
          <button class="w-100 btn btn-primary btn-lg" type="button">Continue to checkout</button>
        </div>
      </div>
    </div>
    
    <!-- Search Offcanvas -->
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasSearch" aria-labelledby="Search">
      <div class="offcanvas-header justify-content-center">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <div class="order-md-last">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-primary">Search</span>
          </h4>
          <form role="search" action="<?php echo e(url('/search')); ?>" method="get" class="d-flex mt-3 gap-0">
            <input class="form-control rounded-start rounded-0 bg-light" type="text" name="query" placeholder="What are you looking for?" aria-label="What are you looking for?">
            <button class="btn btn-dark rounded-end rounded-0" type="submit">Search</button>
          </form>
        </div>
      </div>
    </div>

    <?php if(!in_array(Route::currentRouteName(), ['login', 'register'])): ?>
        <!-- Header Section -->
        <?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <!-- Main Content Section -->
    <main class="custom-container my-2">
        <?php echo e($slot ?? ''); ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php if(!in_array(Route::currentRouteName(), ['login', 'register'])): ?>
        <!-- Footer Section -->
        <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <!-- Core JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <!-- Vendor JavaScript -->
    <script src="<?php echo e(secure_asset('assets/js/jquery-1.11.0.min.js')); ?>"></script>
    <script src="<?php echo e(secure_asset('assets/js/plugins.js')); ?>"></script>
    <script src="<?php echo e(secure_asset('assets/js/script.js')); ?>"></script>
    <script src="<?php echo e(secure_asset('assets/js/main.js')); ?>"></script>
    
    <!-- Cart Scripts -->
    <script src="<?php echo e(secure_asset('js/mini-cart.js')); ?>"></script>
    <script src="<?php echo e(secure_asset('js/cart.js')); ?>"></script>
    <script src="<?php echo e(secure_asset('js/cart-helper.js')); ?>"></script>
    
    <!-- Common JS -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Hide scrolling info after 60 seconds
            setTimeout(function() {
                const scrollingInfo = document.getElementById("scrolling-info");
                if (scrollingInfo) scrollingInfo.style.display = "none";
            }, 60000);
            
            // Define global app URL for JS
            window.APP_URL = "<?php echo e(config('app.url')); ?>";
        });
    </script>
    
    <!-- Page-specific scripts -->
    <?php echo $__env->yieldContent('scripts'); ?>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\afc-website\resources\views/layouts/main.blade.php ENDPATH**/ ?>