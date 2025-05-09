

<?php $__env->startSection('title', 'Stockade Fence'); ?>

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
    .speciality-header {
        background-color: #8B2703;
        color: white;
        text-align: center;
        padding: 8px;
        font-weight: bold;
        font-size: 1.1rem;
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
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="main-header">
                <h4 class="mb-0">Stockade Fence</h4>
            </div>
        </div>
    </div>
    
    <div class="row">
        <?php $__currentLoopData = $specialityOrder; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialityName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($productsByspeciality[$specialityName]) && count($productsByspeciality[$specialityName]) > 0): ?>
                <div class="col-md-4 mb-4">
                    <div class="speciality-header py-2"><?php echo e($specialityName); ?></div>
                    
                    <?php $__currentLoopData = $productsByspeciality[$specialityName]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $productId = $product->id;
                            $imagePath = isset($productData[$productId]) ? $productData[$productId]['image'] : $defaultImage;
                            $price = isset($productData[$productId]) && isset($productData[$productId]['price']) ? $productData[$productId]['price'] : 'N/A';
                            $height = isset($productData[$productId]) ? $productData[$productId]['height'] : '';
                            $width = isset($productData[$productId]) ? $productData[$productId]['width'] : '';
                            
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
                        
                        <div class="product-card h-100">
                            <div class="product-title"><?php echo e($product->product_name ?? 'Stockade Fence'); ?></div>
                            
                            <div class="text-center py-3" style="border: 1px solid #ddd; border-top: none; text-align: center !important;">
                                <img src="<?php echo e($imagePath); ?>" alt="<?php echo e($product->product_name ?? 'Stockade Fence'); ?>" style="max-height: 135px; max-width: 100%;">
                            </div>
                            
                            <div class="product-details small">  
                                <?php if(!empty($product->desc_short)): ?>
                                    <?php
                                        // Get the description text
                                        $desc = $product->desc_short;
                                        
                                        // Define the format we want to display
                                        $formattedDesc = '';
                                        
                                        // Add section top style if available
                                        $sectionTopStyle = '';
                                        if (preg_match('/Section\s+Top\s+Style\s*:\s*([^,\n]+)/i', $desc, $matches)) {
                                            $sectionTopStyle = trim($matches[1]);
                                            $formattedDesc .= "<strong>Section Top Style:</strong> {$sectionTopStyle}<br>";
                                        }
                                        
                                        // Add heights if available
                                        $heights = '';
                                        if (preg_match('/Heights?\s*:\s*([^,\n]+)/i', $desc, $matches)) {
                                            $heights = trim($matches[1]);
                                            $formattedDesc .= "<strong>Heights:</strong> {$heights}<br>";
                                        }
                                        
                                        // Add picket style if available
                                        $picketStyle = '';
                                        if (preg_match('/Picket\s+Style\s*:\s*([^,\n]+)/i', $desc, $matches)) {
                                            $picketStyle = trim($matches[1]);
                                            $formattedDesc .= "<strong>Picket Style:</strong> {$picketStyle}<br>";
                                        }
                                        
                                        // Add spacing if available
                                        $spacing = '';
                                        if (preg_match('/Spacing\s*:\s*([^,\n]+)/i', $desc, $matches)) {
                                            $spacing = trim($matches[1]);
                                            $formattedDesc .= "<strong>Spacing:</strong> {$spacing}<br>";
                                        }
                                        
                                        // Add pickets per section if available
                                        $picketsPerSection = '';
                                        if (preg_match('/Pickets\s+Per\s+Section\s*:\s*([^,\n]+)/i', $desc, $matches)) {
                                            $picketsPerSection = trim($matches[1]);
                                            $formattedDesc .= "<strong>Pickets Per Section:</strong> {$picketsPerSection}<br>";
                                        }
                                        
                                        // Add picket width if available
                                        $picketWidth = '';
                                        if (preg_match('/Picket\s+Width\s*:\s*([^,\n]+)/i', $desc, $matches)) {
                                            $picketWidth = trim($matches[1]);
                                            $formattedDesc .= "<strong>Picket Width:</strong> {$picketWidth}<br>";
                                        }
                                        
                                        // If we couldn't extract any structured data, just use nl2br
                                        if (empty($formattedDesc)) {
                                            $formattedDesc = nl2br($desc);
                                        }
                                    ?>
                                    <div class="mb-3 text-center"><?php echo $formattedDesc; ?></div>
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
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\afc-website\resources\views/categories/stockade.blade.php ENDPATH**/ ?>