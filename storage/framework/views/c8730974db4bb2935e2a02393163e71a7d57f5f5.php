<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2 rounded">
            <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>">Home</a></li>
            <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="breadcrumb-item <?php echo e($loop->last ? 'active' : ''); ?>">
                    <?php if(!$loop->last): ?>
                        <a href="<?php echo e($breadcrumb['url']); ?>"><?php echo e($breadcrumb['name']); ?></a>
                    <?php else: ?>
                        <?php echo e($breadcrumb['name']); ?>

                    <?php endif; ?>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ol>
    </nav>
</div>
<?php /**PATH C:\xampp\htdocs\afc-website\resources\views/components/breadcrumbs.blade.php ENDPATH**/ ?>