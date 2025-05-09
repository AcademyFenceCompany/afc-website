

<?php $__env->startSection('title', 'Edit AFC Category'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="mb-3">
        <h2>Edit AFC Category</h2>
        <p class="text-muted">Update category information in the mysql_second database</p>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('ams.mysql-categories.update', $category->id)); ?>" method="POST" enctype="multipart/form-data">
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
unset($__errorArgs, $__bag); ?>" id="cat_name" name="cat_name" value="<?php echo e(old('cat_name', $category->cat_name)); ?>" required>
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
                    <label for="seo_name" class="form-label">SEO Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control <?php $__errorArgs = ['seo_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="seo_name" name="seo_name" value="<?php echo e(old('seo_name', $category->seo_name)); ?>" required>
                    <small class="text-muted">URL-friendly version of the category name (no spaces, lowercase)</small>
                    <?php $__errorArgs = ['seo_name'];
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
                    <label for="majorcategories_id" class="form-label">Major Category <span class="text-danger">*</span></label>
                    <select class="form-select <?php $__errorArgs = ['majorcategories_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="majorcategories_id" name="majorcategories_id" required>
                        <option value="">Select Major Category</option>
                        <?php $__currentLoopData = $majorCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $majorCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($majorCategory->id); ?>" <?php echo e(old('majorcategories_id', $category->majorcategories_id) == $majorCategory->id ? 'selected' : ''); ?>>
                                <?php echo e($majorCategory->cat_name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['majorcategories_id'];
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
                    <label for="cat_desc_short" class="form-label">Short Description</label>
                    <textarea class="form-control <?php $__errorArgs = ['cat_desc_short'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="cat_desc_short" name="cat_desc_short" rows="2"><?php echo e(old('cat_desc_short', $category->cat_desc_short)); ?></textarea>
                    <?php $__errorArgs = ['cat_desc_short'];
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
                    <label for="cat_desc_long" class="form-label">Long Description</label>
                    <textarea class="form-control <?php $__errorArgs = ['cat_desc_long'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="cat_desc_long" name="cat_desc_long" rows="5"><?php echo e(old('cat_desc_long', $category->cat_desc_long)); ?></textarea>
                    <?php $__errorArgs = ['cat_desc_long'];
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
                    <label for="image" class="form-label">Category Image</label>
                    <input type="file" class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="image" name="image">
                    <?php if(!empty($category->img)): ?>
                        <div class="mt-2">
                            <img src="<?php echo e(url('storage/categories/' . $category->img)); ?>" alt="<?php echo e($category->cat_name); ?>" class="img-thumbnail" style="max-height: 150px;">
                            <p class="small text-muted">Current image: <?php echo e($category->img); ?></p>
                        </div>
                    <?php endif; ?>
                    <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <small class="text-muted">Upload a new image to replace the current one (if any)</small>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="web_enabled" name="web_enabled" value="1" <?php echo e(old('web_enabled', $category->web_enabled) ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="web_enabled">Show on Website</label>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="<?php echo e(route('ams.mysql-categories.index')); ?>" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.ams', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\afc-website\resources\views/ams/category-management/mysql-categories/edit.blade.php ENDPATH**/ ?>