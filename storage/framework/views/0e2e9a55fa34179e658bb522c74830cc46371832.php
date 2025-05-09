

<?php $__env->startSection('title', 'Wood Fence'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    /* Ensure these styles take precedence */
    .bg-brown {
        background-color: #8B4513 !important;
    }
    .page-title {
        font-size: 24px !important;
        color: #fff !important;
        font-weight: bold !important;
        padding: 10px 0 !important;
    }
    .page-description {
        font-size: 14px !important;
        font-weight: 500 !important;
        line-height: 1.5 !important;
        margin-bottom: 1rem !important;
    }
    /* Custom button styles */
    .btn.btn-brown {
        background-color: #8B4513 !important;
        color: white !important;
        border-color: #8B4513 !important;
    }
    .btn.btn-brown:hover {
        background-color: #6B3100 !important;
        color: white !important;
    }
    /* Custom 4-column layout */
    .col-lg-3 {
        width: 25% !important;
    }
    @media (max-width: 992px) {
        .col-lg-3 {
            width: 33.333% !important;
        }
    }
    @media (max-width: 768px) {
        .col-lg-3 {
            width: 50% !important;
        }
    }
    @media (max-width: 576px) {
        .col-lg-3 {
            width: 100% !important;
        }
    }
    .about-image {
        width: 180px !important;
        height: 180px !important;
        object-fit: cover !important;
    }
    .bg-light-yellow {
        background-color: #FFFFD4 !important;
    }
    .small-font {
        font-size: 14px !important;
    }
    .product-image {
        width: 250px !important;
        height: 250px !important;
        object-fit: cover !important;
    }
    .btn-small-text {
        font-size: 0.7rem !important;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <main class="container">
        <!-- Header Section -->
        <div class="rounded bg-brown">
            <h1 class="page-title text-center py-2 mb-0">WOOD FENCE</h1>
        </div>
        <div class="text-center py-2 mb-4 border-bottom">
            <p class="mb-0">Academy Wood Fence - Cedar Wood Fencing Leaders Since 1968</p>
        </div>

        <!-- Info Section -->
        <div class="row g-4 mb-4">
            <!-- Left Section - About -->
            <div class="col-md-6 wf-about">
                <div class="d-flex">
                    <img src="/resources/images/lattice_top_big.jpg" alt="Wood Post Cap" class="me-4 rounded about-image">
                    <div>
                        <h4 class="mb-3">Academy Wood Fence - Cedar Fencing</h4>
                        <p class="page-description mb-2">
                            Academy Fence offers many different types of wood fencing including, spaced picket wood fencing,
                            solid board wood fencing, board on board and post and rail wood fencing for purchase or install.
                            Academy Fence designs, manufactures, wholesales and professionally installs top quality custom
                            decorative and privacy wood fencing and picket.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Middle Section - Brochures -->
            <div class="col-md-2 text-center">
                <h4 class="text-brown mb-3">Brochures</h4>
                <div class="d-flex flex-column gap-2">
                    <button class="btn btn-light border w-100 text-center">
                        Wood Post Cap Brochure
                    </button>
                    <button class="btn btn-light border w-100 text-center">
                        Wood Post Cap Order Sheet
                    </button>
                    <button class="btn btn-brown w-100" style="background-color: #8B4513 !important; color: white !important;">
                        Get a Quote
                    </button>
                </div>
            </div>

            <!-- Right Section - Manufacturer Info -->
            <div class="col-md-4">
                <div class="p-3 rounded bg-light-yellow">
                    <h5 class="text-center mb-1">The Original online Fence Superstore</h5>
                    <p class="text-center small mb-3 fst-italic">Family owned operated since 1968</p>
                    <ul class="list-unstyled mb-0 small-font">
                        <li>• Leading custom cedar fence manufacturers since 1968.</li>
                        <li>• Many/most orders in stock, or ready rapidly.</li>
                        <li>• Wide variety of styles, gates, posts and caps</li>
                        <li>• Pick up available in NJ</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Product List Section -->
        <div class="container-fluid px-0">
            <!-- Academy Custom Cedar Fencing Section -->
            <div class="row">
                <div class="col-12">
                    <div class="bg-brown text-white text-center py-2 rounded mb-3">
                        <h4 class="mb-0">Academy Custom Cedar Fencing Sections</h4>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <?php
                    $customCedarProducts = $wood_categories->filter(function($item) {
                        return (!isset($item['category_group']) || $item['category_group'] === 'custom_cedar') 
                            && !in_array($item['family_category_id'], [25, 337, 24, 82, 147, 791]);
                    });
                ?>

                <?php $__currentLoopData = $customCedarProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-3">
                        <div class="card h-100 border-0 shadow-sm">
                           
                            <div class="text-center p-2">
                                <?php if($category['image']): ?>
                                    <img src="<?php echo e($category['image']); ?>" class="rounded product-image">
                                <?php endif; ?>
                                <div class="text-center pt-2">
                                    <h6 class="card-title text-brown fw-bold"><?php echo e($category['family_category_name']); ?></h6>
                                </div>
                                <?php if($category['family_category_id'] == 7): ?>
                                    <a href="<?php echo e(route('solid-board')); ?>" class="btn btn-sm btn-brown btn-small-text mt-2" style="background-color: #8B4513 !important; color: white !important;">VIEW</a>
                                <?php elseif($category['family_category_id'] == 8): ?>
                                    <?php if(isset($category['spacing']) && !empty($category['spacing'])): ?>
                                        <div class="d-flex flex-wrap justify-content-center gap-1 mt-2">
                                            <?php $__currentLoopData = $category['spacing']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spacing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($spacing): ?>
                                                    <a href="<?php echo e(route('board-on-board', ['spacing' => $spacing])); ?>" class="btn btn-sm btn-brown btn-small-text" style="background-color: #8B4513 !important; color: white !important;">
                                                        <?php echo e($spacing); ?>

                                                    </a>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('board-on-board')); ?>" class="btn btn-sm btn-brown btn-small-text mt-2" style="background-color: #8B4513 !important; color: white !important;">VIEW</a>
                                    <?php endif; ?>
                                <?php elseif($category['family_category_id'] == 4): ?>
                                    <a href="<?php echo e(route('tongue-groove')); ?>" class="btn btn-sm btn-brown btn-small-text mt-2" style="background-color: #8B4513 !important; color: white !important;">VIEW</a>
                                <?php elseif($category['family_category_id'] == 161): ?>
                                    <a href="<?php echo e(route('postrail.index')); ?>" class="btn btn-sm btn-brown btn-small-text mt-2" style="background-color: #8B4513 !important; color: white !important;">VIEW</a>
                                <?php elseif($category['family_category_id'] == 5): ?>
                                    <a href="<?php echo e(route('stockade.index')); ?>" class="btn btn-sm btn-brown btn-small-text mt-2" style="background-color: #8B4513 !important; color: white !important;">VIEW</a>
                                <?php elseif(isset($category['spacing']) && !empty($category['spacing'])): ?>
                                    <div class="d-flex flex-wrap justify-content-center gap-1 mt-2">
                                        <?php $__currentLoopData = $category['spacing']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spacing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($spacing): ?>
                                                <a href="<?php echo e(route('woodfence.specs', [
                                                    'id' => $category['family_category_id'],
                                                    'spacing' => $spacing,
                                                ])); ?>?styleTitle=<?php echo e(urlencode($category['family_category_name'])); ?>" class="btn btn-sm btn-brown btn-small-text" style="background-color: #8B4513 !important; color: white !important;">
                                                    <?php echo e($spacing); ?>

                                                </a>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php else: ?>
                                    <a href="<?php echo e(route('woodfence.specs', [
                                        'id' => $category['family_category_id'],
                                    ])); ?>?styleTitle=<?php echo e(urlencode($category['family_category_name'])); ?>" class="btn btn-sm btn-brown btn-small-text mt-2" style="background-color: #8B4513 !important; color: white !important;">VIEW</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="row g-4 mb-4">
                <?php
                    $otherFencingProducts = $wood_categories->filter(function($item) {
                        return isset($item['category_group']) && $item['category_group'] === 'other_fencing';
                    });
                ?>

                <?php $__currentLoopData = $otherFencingProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="text-center pt-2">
                                <h6 class="card-title text-brown small fw-bold"><?php echo e($category['family_category_name']); ?></h6>
                            </div>
                            <div class="text-center p-2">
                                <?php if($category['image']): ?>
                                    <img src="<?php echo e($category['image']); ?>" class="rounded product-image">
                                <?php endif; ?>
                                
                                <?php if(isset($category['spacing']) && !empty($category['spacing'])): ?>
                                    <div class="d-flex flex-wrap justify-content-center gap-1 mt-2">
                                        <?php $__currentLoopData = $category['spacing']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spacing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($spacing): ?>
                                                <a href="<?php echo e(route('woodfence.specs', [
                                                    'id' => $category['family_category_id'],
                                                    'spacing' => $spacing,
                                                ])); ?>?styleTitle=<?php echo e(urlencode($category['family_category_name'])); ?>" class="btn btn-sm btn-brown btn-small-text" style="background-color: #8B4513 !important; color: white !important;">
                                                    <?php echo e($spacing); ?>

                                                </a>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php else: ?>
                                    <?php if($category['family_category_id'] == 82): ?>
                                        <a href="<?php echo e(route('woodpostcaps.index')); ?>" class="btn btn-sm btn-brown btn-small-text mt-2" style="background-color: #8B4513 !important; color: white !important;">VIEW</a>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('woodfence.specs', [
                                            'id' => $category['family_category_id'],
                                        ])); ?>?styleTitle=<?php echo e(urlencode($category['family_category_name'])); ?>" class="btn btn-sm btn-brown btn-small-text mt-2" style="background-color: #8B4513 !important; color: white !important;">VIEW</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Additional Wood Fence Parts -->
            <div class="row">
                <div class="col-12">
                    <div class="bg-brown text-white text-center py-2 rounded mb-3">
                        <h4 class="mb-0">Additional Wood Fence Parts and Accessories</h4>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <?php
                    $accessoryProducts = $wood_categories->filter(function($item) {
                        return in_array($item['family_category_id'], [25, 337, 24, 82, 147, 791]);
                    });
                ?>

                <?php $__currentLoopData = $accessoryProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="text-center pt-2">
                                <h6 class="card-title text-brown small fw-bold"><?php echo e($category['family_category_name']); ?></h6>
                            </div>
                            <div class="text-center p-2">
                                <?php if($category['image']): ?>
                                    <img src="<?php echo e($category['image']); ?>" class="rounded product-image">
                                <?php endif; ?>
                                
                                
                                    <?php if($category['family_category_id'] == 82): ?>
                                        <a href="<?php echo e(route('woodpostcaps.index')); ?>" class="btn btn-sm btn-brown btn-small-text mt-2" style="background-color: #8B4513 !important; color: white !important;">VIEW</a>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('woodfence.specs', [
                                            'id' => $category['family_category_id'],
                                        ])); ?>?styleTitle=<?php echo e(urlencode($category['family_category_name'])); ?>" class="btn btn-sm btn-brown btn-small-text mt-2" style="background-color: #8B4513 !important; color: white !important;">VIEW</a>
                                    <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\afc-website\resources\views/categories/woodfence.blade.php ENDPATH**/ ?>