

<?php $__env->startSection('title', 'Post and Rail Fence Products'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .page-title {
        text-align: center;
        margin-bottom: 30px;
    }
    .main-header {
        background-color: #000;
        color: white;
        text-align: center;
        padding: 10px;
        margin-bottom: 20px;
        font-weight: bold;
    }
    .product-image {
        max-height: 200px;
        max-width: 100%;
        object-fit: contain;
    }
    .product-details {
        padding: 15px;
        min-height: 150px;
    }
    .btn-brown {
        background-color: #8B4513 !important;
        color: white !important;
        border-color: #8B4513 !important;
    }
    .btn-brown:hover {
        background-color: #6B3100 !important;
    }
    .product-card {
        transition: transform 0.3s;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .product-title {
        background-color: #8B2703;
        color: white;
        text-align: center;
        padding: 10px;
        margin-bottom: 0;
        font-weight: bold;
    }
    .back-link {
        margin-bottom: 20px;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="main-header">
                <h4 class="mb-0">
                    <?php if($currentStyle == 'Round Rail'): ?>
                        Cedar Round Post & Rail
                    <?php elseif($currentStyle == 'Split Rail'): ?>
                        Split Rail Post and Rail
                    <?php else: ?>
                        Post and Rail Products
                    <?php endif; ?>
                </h4>
            </div>
        </div>
    </div>


    <div class="row">
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $productId = $product->id;
                $imagePath = isset($productData[$productId]) ? $productData[$productId]['image'] : $defaultImage;
                $price = isset($productData[$productId]) && isset($productData[$productId]['price']) ? $productData[$productId]['price'] : 'N/A';
                $railCount = isset($productData[$productId]) ? $productData[$productId]['rails'] : '';
                $endType = isset($productData[$productId]) ? $productData[$productId]['end_type'] : '';
                
                // Determine if we have a link to a product page
                $linkType = null;
                $linkId = null;
                
                if (isset($product->products_id) && $product->products_id > 0) {
                    $linkType = 'product';
                    $linkId = $product->products_id;
                } elseif (isset($product->id) && $product->id > 0) {
                    $linkType = 'product';
                    $linkId = $product->id;
                }
            ?>
            
            <div class="col-md-4 mb-4">
                <div class="product-card h-100">
                    <div class="product-title"><?php echo e($product->product_name ?? 'Post and Rail Fence'); ?></div>
                    
                    
                    <div class="text-center py-3" style="border: 1px solid #ddd; border-top: none; text-align: center !important;">
                        <img src="<?php echo e($imagePath); ?>" alt="<?php echo e($product->product_name ?? 'Post and Rail Fence'); ?>" style="max-height: 135px; max-width: 100%;">
                    </div>
                    <div class="product-details small">  
                        <?php if(!empty($product->desc_short)): ?>
                            <?php
                                // Get the description text
                                $desc = $product->desc_short;
                                
                                // Check if the description has the specific format we're looking for
                                if (strpos($desc, 'Approx. Height:') !== false) {
                                    // Split by the known labels
                                    $parts = preg_split('/(Approx\. Height:|Post:|Rail:|One Section:|Post Spacing:)/', $desc, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
                                    
                                    // Initialize formatted description
                                    $formattedDesc = '';
                                    
                                    // Combine labels with their values
                                    for ($i = 0; $i < count($parts); $i += 2) {
                                        if (isset($parts[$i+1])) {
                                            $label = trim($parts[$i]);
                                            $value = trim($parts[$i+1]);
                                            $formattedDesc .= "<strong>{$label}</strong> {$value}<br>";
                                        }
                                    }
                                } else {
                                    // If it doesn't match our expected format, just use nl2br
                                    $formattedDesc = nl2br($desc);
                                }
                            ?>
                            <div class="mb-3"><?php echo $formattedDesc; ?></div>
                        <?php endif; ?>
                        <div class="text-center mt-3">
                            <?php if($linkType && $linkId): ?>
                                <a href="<?php echo e(route($linkType . '.show', ['id' => $linkId])); ?>" class="btn btn-sm btn-brown">View Details</a>
                            <?php else: ?>
                                <a href="#" class="btn btn-sm btn-brown">View Product</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\afc-website\resources\views/categories/postrail-products.blade.php ENDPATH**/ ?>