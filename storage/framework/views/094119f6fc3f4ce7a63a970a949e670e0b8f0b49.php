

<?php $__env->startSection('content'); ?>
<div class="container">
    <h3 class="text-center mt-4 mb-4">Wood Fence Specifications - Solid Board</h3>

    <?php $__currentLoopData = $styleOrder; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $styleName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="section-title py-2" style="background-color: #000; color: #fff; text-align: center; text-transform: uppercase; font-weight: bold; font-size: 1.2rem;"><?php echo e($styleName); ?></div>
            </div>
        </div>

        <div class="row mb-5">
            <?php
                // Define the speciality order for this style
                $specialityOrder = [
                    'Straight On Top' => ['Slant Ear', 'Gothic Point', 'French Gothic'],
                    'Concave' => ['Flat Picket', 'Gothic Point', 'French Gothic'],
                    'Convex' => ['Flat Picket', 'Gothic Point', 'French Gothic']
                ][$styleName] ?? [];
            ?>
            
            <?php $__currentLoopData = $specialityOrder; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialityName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    // Get product ID from the map
                    $productLink = $productIdMap[$styleName][$specialityName] ?? null;
                    $productId = null;
                    
                    if ($productLink) {
                        $parts = explode('/', $productLink);
                        if (count($parts) == 2 && $parts[0] === 'product') {
                            $productId = $parts[1];
                        }
                    }
                    
                    // Get image from product map or use default
                    $image = $productId && isset($productMap[$productId]) ? $productMap[$productId]['image'] : $defaultImage;
                ?>
                
                <div class="col-md-4">
                    <div class="mb-4">
                        <div class="speciality-header py-2" style="background-color: #8B2703; color: #fff; text-align: center; font-weight: bold; text-transform: uppercase;"><?php echo e($specialityName); ?></div>
                        
                        <div class="text-center py-3" style="border: 1px solid #ddd; border-top: none;">
                            <img src="<?php echo e($image); ?>" alt="<?php echo e($specialityName); ?>" style="max-height: 135px; max-width: 100%;">
                        </div>
                        
                        <div style="padding: 1rem; border: 1px solid #ddd; border-top: none; text-align: center;">
                            <div class="product-details small">
                                <p class="mb-1"><strong>Section Top Style:</strong> <?php echo e($styleName); ?></p>
                                <p class="mb-1"><strong>Heights:</strong> 3ft, 42in, 4ft, 5ft, 6ft, 7ft, 8ft</p>
                                <p class="mb-1"><strong>Picket Style:</strong> <?php echo e($specialityName); ?></p>
                                <p class="mb-1"><strong>Spacing:</strong> No Spacing</p>
                                <p class="mb-1"><strong>Pickets Per Section:</strong> 27</p>
                            </div>
                            <div class="mt-3">
                                <?php if(isset($productIdMap[$styleName][$specialityName])): ?>
                                    <?php
                                        $link = $productIdMap[$styleName][$specialityName];
                                        $linkParts = explode('/', $link);
                                        $linkType = $linkParts[0];
                                        $linkId = $linkParts[1];
                                    ?>
                                    
                                    <?php if($linkType === 'product'): ?>
                                        <a href="<?php echo e(route('product.show', ['id' => $linkId])); ?>" class="btn btn-sm btn-brown">View Details</a>
                                    <?php elseif($linkType === 'category'): ?>
                                        <a href="<?php echo e(route('category.show', ['slug' => $linkId])); ?>" class="btn btn-sm btn-brown">View Details</a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <a href="#" class="btn btn-sm btn-brown">View Details</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<style>
    .btn-brown {
        background-color: #8B2703;
        color: white;
        border: none;
    }
    .btn-brown:hover {
        background-color: #6e1f02;
        color: white;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\afc-website\resources\views/categories/solidboard.blade.php ENDPATH**/ ?>