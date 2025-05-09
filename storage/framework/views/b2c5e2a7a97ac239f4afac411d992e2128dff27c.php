

<?php $__env->startSection('title', 'AFC Category Management'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .category-tree {
        margin-left: 0;
        padding-left: 0;
        font-size: 0.875rem;
    }
    
    .category-tree ul {
        list-style-type: none;
        padding-left: 20px;
        margin-top: 0;
        margin-bottom: 0;
    }
    
    .category-tree li {
        margin: 4px 0;
        position: relative;
    }
    
    .category-tree .major-category {
        font-weight: 500;
        font-size: 0.9rem;
        margin-bottom: 4px;
        padding: 6px 10px;
        background-color: #f8f9fa;
        border-left: 3px solid #007bff;
        display: flex;
        align-items: center;
    }
    
    .category-tree .sub-category {
        padding: 4px 8px;
        margin: 2px 0;
        border-left: 2px solid #28a745;
        background-color: #fff;
        display: flex;
        align-items: center;
        font-size: 0.85rem;
    }
    
    .toggle-icon {
        cursor: pointer;
        margin-right: 6px;
        font-size: 0.8rem;
    }
    
    .category-actions {
        margin-left: 10px;
        white-space: nowrap;
    }
    
    .category-actions .btn {
        padding: 0.2rem 0.4rem;
        font-size: 0.75rem;
        border: none;
    }
    
    .category-actions .btn i {
        font-size: 0.7rem;
    }
    
    .badge {
        font-size: 0.7rem;
        padding: 0.2em 0.5em;
        margin-left: 5px;
    }
    
    .major-category .category-actions {
        margin-left: auto;
    }
    
    .category-name {
        flex: 1;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <div>
            <a href="<?php echo e(route('ams.mysql-categories.create')); ?>" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Add New Category
            </a>
            <a href="<?php echo e(route('ams.mysql-majorcategories.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Major Category
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <?php if($majorCategories->isEmpty()): ?>
                <div class="alert alert-info">No categories found in the system.</div>
            <?php else: ?>
                <div class="category-tree">
                    <ul>
                        <?php $__currentLoopData = $majorCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $majorCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <div class="major-category">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-caret-right-fill toggle-icon" onclick="toggleSubcategories(this)"></i>
                                        <span class="category-name"><?php echo e($majorCategory->cat_name); ?></span>
                                        <?php if(!$majorCategory->enabled): ?>
                                            <span class="badge bg-secondary ms-2"></span>
                                        <?php endif; ?>
                                        <div class="category-actions">
                                            <a href="<?php echo e(route('ams.mysql-majorcategories.edit', $majorCategory->id)); ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i> 
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <ul style="display: none;">
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($category->majorcategories_id == $majorCategory->id): ?>
                                            <li>
                                                <div class="sub-category d-flex align-items-center" style="justify-content: flex-start;">
                                                    <a href="<?php echo e(route('ams.mysql-categories.edit', $category->id)); ?>" class="text-decoration-none text-dark flex-grow-0 me-2">
                                                        <?php echo e($category->cat_name); ?>

                                                        <?php if(!$category->web_enabled): ?>
                                                            <span class="badge bg-secondary ms-1"></span>
                                                        <?php endif; ?>
                                                    </a>
                                                    <div class="category-actions" style="margin-left: 0;">
                                                        <a href="<?php echo e(route('ams.mysql-categories.edit', $category->id)); ?>" class="btn btn-sm btn-outline-primary">
                                                            <i class="bi bi-pencil"></i> 
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    function toggleSubcategories(icon) {
        const categoryItem = icon.closest('li');
        const subcategoryList = categoryItem.querySelector('ul');
        
        if (subcategoryList.style.display === 'none' || subcategoryList.style.display === '') {
            subcategoryList.style.display = 'block';
            icon.classList.remove('bi-caret-right-fill');
            icon.classList.add('bi-caret-down-fill');
        } else {
            subcategoryList.style.display = 'none';
            icon.classList.remove('bi-caret-down-fill');
            icon.classList.add('bi-caret-right-fill');
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.ams', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\afc-website\resources\views/ams/category-management/mysql-categories/index.blade.php ENDPATH**/ ?>