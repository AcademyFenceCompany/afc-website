

<?php $__env->startSection('title', 'Chain Link Fence'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .main-header {
        background-color: #1a4d2e;
        color: white;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
    }
    
    .about-image-chainlink {
        border: 2px solid #1a4d2e;
    }
    
    .page-description {
        line-height: 1.6;
    }
    
    .group-grid {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .group-card {
        width: calc(33.333% - 20px);
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .group-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .group-image {
        height: 150px;
        width: 100%;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    
    .group-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .group-info {
        padding: 15px;
    }
    
    .group-title {
        font-weight: bold;
        margin-bottom: 5px;
        color: #000;
        font-size: 15px;
    }
    
    .group-description {
        color: #555;
        font-size: 0.9rem;
        margin-bottom: 15px;
    }
    
    .group-code {
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 10px;
    }
    
    .section-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #000;
        border-bottom: 2px solid #1a4d2e;
        padding-bottom: 10px;
    }
    
    .pricing-option-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 20px;
        height: 86%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .pricing-option-header {
        background-color: #972525;
        color: white;
        padding: 10px 15px 10px 45px;
        font-weight: bold;
        font-size: 1.1rem;
        position: relative;
    }
    
    .pricing-option-body {
        padding: 15px;
        background-color: white;
        height: calc(100% - 45px);
        display: flex;
        flex-direction: column;
    }
    
    .pricing-option-title {
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
        font-size: 1.1rem;
    }
    
    .pricing-option-list {
        list-style: none;
        padding-left: 0;
        margin-bottom: 15px;
    }
    
    .pricing-option-list li {
        padding: 5px 0;
        border-bottom: 1px dashed #eee;
    }
    
    .pricing-option-list li:last-child {
        border-bottom: none;
    }
    
    .pricing-option-list li i {
        color: #972525;
        margin-right: 5px;
    }
    
    .pricing-option-group {
        border: 0px solid #972525;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        background-color: rgba(151, 37, 37, 0.05);
        height: 100%;
    }
    
    .pricing-option-group-title {
    font-size: 1.2rem;
    font-weight: bold;
    color: #972525;
    margin-bottom: 15px;
    padding-bottom: 5px;
    border: 1px solid #972525;
    border-bottom: 0px;
    text-align: center;
}
    
    .pricing-option-list.vertical li {
        display: block;
        width: 100%;
        margin-bottom: 8px;
    }

    .option-number {
        position: absolute;
        top: 8px;
        left: 10px;
        background-color: white;
        color: #972525;
        width: 25px;
        height: 25px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 14px;
    }

    .pricing-option-image {
        margin-bottom: 15px;
        text-align: center;
    }

    .pricing-option-image img {
        max-width: 65%;
        height: 160px;
        border-radius: 5px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .pricing-option-actions {
        margin-top: auto;
    }
    
    /* .pricing-option-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    } */
    
    .help-button {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 6px 12px;
        font-size: 14px;
        color: #333;
        margin-left: 5px;
        transition: all 0.3s ease;
    }
    
    .help-button:hover {
        background-color: #e9ecef;
    }
    
    @media (max-width: 992px) {
        .group-card {
            width: calc(50% - 20px);
        }
    }
    
    @media (max-width: 576px) {
        .group-card {
            width: 100%;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="rounded bg-brown mb-2">
        <h1 class="page-title text-center mb-0">Chain Link Fence</h1>
    </div>


    <!-- Pricing Options Section -->
    <div class="row">
        <div class="col-12">
            <h2 class="section-title text-center mb-4">3 Pricing Options - Chain Link Fence</h2>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <!-- Complete Systems Group -->
            <div class="pricing-option-group h-100">
                <div class="pricing-option-group-title">All Inclusive By Footage - Include All Necessary Accessories</div>
                <div class="row">
                    <!-- Complete Custom Option -->
                    <div class="col-md-6">
                        <div class="pricing-option-card h-100">
                            <div class="pricing-option-header">
                                *Complete - By Your Custom Footage
                                <div class="option-number">1</div>
                            </div>
                            <div class="pricing-option-body">
                                <div class="pricing-option-image">
                                    <img src="<?php echo e(url('storage/categories/chainlinkdraw.jpg')); ?>" alt="Complete Custom Chain Link Fence" onerror="this.src='<?php echo e(url('storage/products/default.png')); ?>'">
                                </div>
                                <div class="pricing-option-title">Just Submit:</div>
                                <ul class="pricing-option-list">
                                    <li><i class="bi bi-check-circle"></i>Your Total Footage</li>
                                    <li><i class="bi bi-check-circle"></i>Your Number of Terminals</li>
                                    <li><i class="bi bi-check-circle"></i>Your Number of Gates</li>
                                </ul>
                                <div class="pricing-option-actions">
                                    <a href="<?php echo e(route('chainlink.height', ['height' => '4ft'])); ?>" class="btn btn-danger">See Pricing Now</a>
                                    <button class="btn btn-danger">HELP</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Complete Packages Option -->
                    <div class="col-md-6">
                        <div class="pricing-option-card h-100">
                            <div class="pricing-option-header">
                                *Complete - Preset Package
                                <div class="option-number">2</div>
                            </div>
                            <div class="pricing-option-body">
                                <div class="pricing-option-image">
                                    <img src="<?php echo e(url('storage/categories/ch.webp')); ?>" alt="Complete Package Chain Link Fence" onerror="this.src='<?php echo e(url('storage/products/default.png')); ?>'">
                                </div>
                                <div class="pricing-option-title">Pre-Configured Packages:</div>
                                <ul class="pricing-option-list">
                                    <li><i class="bi bi-box"></i> 50' Package</li>
                                    <li><i class="bi bi-box"></i> 100' Package</li>
                                    <li><i class="bi bi-box"></i> 400' Package</li>
                                </ul>
                                <div class="pricing-option-actions">
                                    <a href="#" class="btn btn-danger">See Pricing Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Individual Parts Option -->
        <div class="col-md-4">
            <div class="pricing-option-group h-100">
                <div class="pricing-option-group-title">Individual Parts</div>
                <div class="pricing-option-card">
                    <div class="pricing-option-header">Shop By Category: <div class="option-number">3</div></div>
                    <div class="pricing-option-body">
                        <div class="d-flex flex-wrap justify-content-between">
                            <div class="category-item d-flex align-items-center mb-3" style="width: 48%;">
                                <div class="pricing-option-image me-2" style="width: 40px;">
                                    <img src="<?php echo e(url('storage/categories/chainlink-wire.jpg')); ?>" alt="Chain Link Wire" onerror="this.src='<?php echo e(url('storage/products/default.png')); ?>'" style="max-height: 40px; max-width: 100%;">
                                </div>
                                <span>Wire</span>
                            </div>
                            <div class="category-item d-flex align-items-center mb-3" style="width: 48%;">
                                <div class="pricing-option-image me-2" style="width: 40px;">
                                    <img src="<?php echo e(url('storage/categories/chainlink-fittings.jpg')); ?>" alt="Chain Link Fittings" onerror="this.src='<?php echo e(url('storage/products/default.png')); ?>'" style="max-height: 40px; max-width: 100%;">
                                </div>
                                <span>Fittings</span>
                            </div>
                            <div class="category-item d-flex align-items-center mb-3" style="width: 48%;">
                                <div class="pricing-option-image me-2" style="width: 40px;">
                                    <img src="<?php echo e(url('storage/categories/chainlink-posts.jpg')); ?>" alt="Chain Link Posts" onerror="this.src='<?php echo e(url('storage/products/default.png')); ?>'" style="max-height: 40px; max-width: 100%;">
                                </div>
                                <span>Pipe/Posts</span>
                            </div>
                            <div class="category-item d-flex align-items-center mb-3" style="width: 48%;">
                                <div class="pricing-option-image me-2" style="width: 40px;">
                                    <img src="<?php echo e(url('storage/categories/chainlink-hardware.jpg')); ?>" alt="Chain Link Hardware" onerror="this.src='<?php echo e(url('storage/products/default.png')); ?>'" style="max-height: 40px; max-width: 100%;">
                                </div>
                                <span>Hardware</span>
                            </div>
                            <div class="category-item d-flex align-items-center mb-3" style="width: 48%;">
                                <div class="pricing-option-image me-2" style="width: 40px;">
                                    <img src="<?php echo e(url('storage/categories/chainlink-gates.jpg')); ?>" alt="Chain Link Gates" onerror="this.src='<?php echo e(url('storage/products/default.png')); ?>'" style="max-height: 40px; max-width: 100%;">
                                </div>
                                <span>Gates</span>
                            </div>
                        </div>
                        <div class="pricing-option-actions mt-auto">
                            <a href="<?php echo e(route('chainlink.height', ['height' => '4ft'])); ?>" class="btn btn-danger">View Individual Parts</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <!-- Parent Groups Section -->
    <div class="row mb-4 mt-4">
        <div class="col-12">
            <h2 class="section-title">Complete Chain Link Fence Systems</h2>
            <div class="group-grid">
                <?php $__currentLoopData = $parentGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="group-card">
                        <a href="<?php echo e(route('chainlink.height', ['height' => explode('ft', $group['title'])[0] . 'ft'])); ?>" class="text-decoration-none">
                            <div class="group-image">
                                <img src="<?php echo e($group['image']); ?>" alt="<?php echo e($group['title']); ?>">
                            </div>
                            <div class="group-info">
                                <div class="group-title"><?php echo e($group['title']); ?></div>
                                
                                <div class="group-description"><?php echo e($group['description']); ?></div>
                                
                            </div>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <div class="row mb-4 mt-4">
        <div class="col-12">
            <h2 class="section-title">Related Products</h2>
            <div class="group-grid">
                    <div class="group-card">
                        <a href="" class="text-decoration-none">
                            <div class="group-image">
                                <img src="<?php echo e(url('storage/categories/dog_run_complete.jpg')); ?>" alt="Dog Run Kennels">
                            </div>
                            <div class="group-info">
                                <div class="group-title">Dog Run Kennels</div>
                            </div>
                        </a>
                    </div>
                    <div class="group-card">
                        <a href="" class="text-decoration-none">
                            <div class="group-image">
                                <img src="<?php echo e(url('storage/categories/regualrpvtslats_sm2.jpg')); ?>" alt="Fence Slats">
                            </div>
                            <div class="group-info">
                                <div class="group-title">Fence Slats</div>
                            </div>
                        </a>
                    </div>
                    <div class="group-card">
                        <a href="" class="text-decoration-none">
                            <div class="group-image">
                                <img src="<?php echo e(url('storage/categories/chainlinkdraw.jpg')); ?>" alt="Chain Link Fence">
                            </div>
                            <div class="group-info">
                                <div class="group-title">Portable Panels</div>
                            </div>
                        </a>
                    </div>
                    <div class="group-card">
                        <a href="" class="text-decoration-none">
                            <div class="group-image">
                                <img src="<?php echo e(url('storage/categories/universal_pliers_sm.jpg')); ?>" alt="Fence Tools">
                            </div>
                            <div class="group-info">
                                <div class="group-title">Fence Tools</div>
                            </div>
                        </a>
                    </div>
                    <div class="group-card">
                        <a href="" class="text-decoration-none">
                            <div class="group-image">
                                <img src="<?php echo e(url('storage/categories/chainlinkdraw.jpg')); ?>" alt="Chain Link Fence">
                            </div>
                            <div class="group-info">
                                <div class="group-title">Industrial Chain Link Fence</div>
                            </div>
                        </a>    
                    </div>
            </div>
        </div>
    </div>
    <div class="row g-4 mb-6">
        <!-- Left Section - About -->
        <div class="col-md-8 wf-about mb-2">
            <div class="d-flex">
                <img src="<?php echo e($headerImage); ?>" alt="Chain Link Fence" style="width: 180px; height: 180px; object-fit: cover;" class="me-4 rounded about-image-chainlink">
                <div>
                    <h4 class="mb-3">In Stock - Quick Shipping - Home Installation - Pick Up</h4>
                    <p class="page-description mb-2">
                        We offer from our fully stocked warehouse inventory, 
                        many heights, mesh sizes, colors and gauges of mesh fabric. We also have a complete 
                        line of posts, rail, pipe, fittings, hardware, hinges, latches, accessories and gates; 
                        all in stock and ready to pick up or ship.
                    </p>
                    <a href="#" class="btn btn-danger">See what's available for pickup</a>
                </div>
            </div>
        </div>

        <!-- Right Section - Manufacturer Info -->
        <div class="col-md-4">
            <div class="p-3 rounded bg-light-yellow">
                <ul class="small-font mb-0">
                    <li><strong><i class="bi bi-currency-dollar text-brown me-2"></i>Multiple Heights Available</strong></li>
                    <li><strong><i class="bi bi-shield-check text-brown me-2"></i>Variety of Mesh Sizes</strong></li>
                    <li><strong><i class="bi bi-tools text-brown me-2"></i>Complete Line of Accessories</strong></li>
                    <li><strong><i class="bi bi-check-circle text-brown me-2"></i>Ready to Pick Up or Ship</strong></li>
                </ul>

            </div>
        </div>
    </div>
    <!-- Categories Section -->
    
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\afc-website\resources\views/categories/chainlink/main.blade.php ENDPATH**/ ?>