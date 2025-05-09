

<?php $__env->startSection('title', 'Product Categories'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-2">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Select Category</h5>
                    <div class="row row-cols-1 row-cols-md-4 g-4">
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col">
                                <a href="<?php echo e(route('ams.orders.category.show', $category->family_category_id)); ?>" 
                                   class="card h-100 text-decoration-none">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary"><?php echo e($category->family_category_name); ?></h5>
                                        <?php if($category->children_count > 0): ?>
                                            <p class="card-text text-muted">
                                                <?php echo e($category->children_count); ?> subcategories
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
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
.card:hover {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    transform: translateY(-2px);
    transition: all 0.2s ease-in-out;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.ams', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\afc-website\resources\views/ams/order/categories/index.blade.php ENDPATH**/ ?>