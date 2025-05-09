

<?php $__env->startSection('title', 'Edit AFC Major Category'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="mb-3">
        <h2>Edit AFC Major Category</h2>
        <p class="text-muted">Update major category information in the mysql_second database</p>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('ams.mysql-majorcategories.update', $majorCategory->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div class="mb-3">
                    <label for="cat_name" class="form-label">Category Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control <?php $__errorArgs = ['cat_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="cat_name" name="cat_name" value="<?php echo e(old('cat_name', $majorCategory->cat_name)); ?>" required>
                    <?php $__errorArgs = ['cat_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="mb-3">
                    <label for="cat_desc" class="form-label">Description</label>
                    <textarea class="form-control <?php $__errorArgs = ['cat_desc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="cat_desc" name="cat_desc" rows="4"><?php echo e(old('cat_desc', $majorCategory->cat_desc)); ?></textarea>
                    <?php $__errorArgs = ['cat_desc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="enabled" name="enabled" value="1" <?php echo e(old('enabled', $majorCategory->enabled) ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="enabled">Show on Website</label>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="<?php echo e(route('ams.mysql-majorcategories.index')); ?>" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Major Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.ams', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\afc-website\resources\views/ams/category-management/mysql-categories/major-edit.blade.php ENDPATH**/ ?>