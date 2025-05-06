

<?php $__env->startSection('title', '404 Not Found'); ?>

<?php $__env->startSection('content'); ?>
<div class="container my-5 text-center">
    <div class="error-code" style="font-size: 8rem; font-weight: bold;">404</div>
    <div class="error-message" style="font-size: 1.5rem; margin-bottom: 1rem;">
        Oops, the page you're looking for isn't here
    </div>
    <a href="<?php echo e(url('/')); ?>" class="btn btn-danger">Go to Home page</a>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\afc-website\resources\views/errors/404.blade.php ENDPATH**/ ?>