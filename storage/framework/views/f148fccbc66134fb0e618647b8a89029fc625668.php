

<?php $__env->startSection('title', 'OnGuard Aluminum Fence - ' . $type . ' ' . $model); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .product-header {
        background-color: #8B4513;
        color: white;
        padding: 10px;
    }
    
    .filter-section {
        background-color: #f8f9fa;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
    }
    
    .filter-title {
        font-weight: bold;
        font-size: 1.2rem;
        margin-bottom: 15px;
        color: #8B4513;
    }
    
    .filter-label {
        font-weight: bold;
        margin-bottom: 8px;
        color: #555;
    }
    
    .filter-group {
        margin-bottom: 15px;
    }
    
    .product-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .product-table th, .product-table td {
        padding: 0;
        border: 1px solid #ddd;
    }
    
    .product-table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }
    
    .product-row:nth-child(even) {
        background-color: #f9f9f9;
    }
    
    .product-image-container {
        position: relative;
        width: 290px;
        height: 200px;
        overflow: hidden;
    }
    
    .primary-image, .hover-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        border: 1px solid #ddd;
        border-radius: 5px;
        position: absolute;
        top: 0;
        left: 0;
        transition: opacity 0.3s ease;
    }
    
    .hover-image {
        opacity: 0;
    }
    
    .product-image-container:hover .primary-image {
        opacity: 0;
    }
    
    .product-image-container:hover .hover-image {
        opacity: 1;
    }
    
    .btn-add-cart {
        background-color: #8B4513;
        color: white;
        border: none;
        padding: 2px 10px;
        border-radius: 3px;
        cursor: pointer;
    }
    
    .btn-add-cart:hover {
        background-color: #218838;
    }
    
    .quantity-input {
        width: 60px;
        padding: 5px;
        border: 1px solid #ddd;
        border-radius: 3px;
    }
    
    .color-swatch {
        display: inline-block;
        width: 15px;
        height: 15px;
        margin-right: 5px;
        border: 1px solid #ccc;
        vertical-align: middle;
    }
    
    .black-swatch {
        background-color: #000;
    }
    
    .bronze-swatch {
        background-color: #8c7853;
    }
    
    .white-swatch {
        background-color: #fff;
    }
    
    .green-swatch {
        background-color: #006400;
    }
    
    .color-option {
        margin-bottom: 5px;
    }
    
    .color-option label {
        display: flex;
        align-items: center;
    }
    
    .model-description {
        margin-bottom: 20px;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 5px;
        border-left: 4px solid #8B4513;
    }
    
    .main-header {
        margin-bottom: 30px;
    }
    
    /* Navigation buttons */
    .nav-buttons {
        margin-bottom: 20px;
    }
    
    .nav-buttons .btn {
        margin-right: 10px;
    }
    
    /* Size selector */
    .size-selector {
        margin-top: 20px;
        padding: 15px;
        background-color: #8B4513;
        border-radius: 5px;
        color: white;
    }
    
    .size-selector h5 {
        margin-bottom: 15px;
        text-align: center;
    }
    
    .size-option {
        margin-bottom: 10px;
    }
    
    .size-option label {
        display: block;
        cursor: pointer;
    }
    
    .size-options-desktop {
        display: none;
    }
    
    .size-dropdown-mobile {
        display: none;
    }
    .mobile-title {
        display: none;
    }
    /* Media query for mobile devices */
    @media (max-width: 767.98px) {
        .product-header {
            font-size: 14px;
        }
        .mobile-title {
            display: block;
            font-weight: bold;
            font-size: 14px;
        }
        .size-options-desktop {
            display: none;
        }
        
        .size-dropdown-mobile {
            display: block;
            width: 100%;
            margin-top: 10px;
            background-color: white;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 8px;
        }
        .size-selector {
            background-color: #fff;
            color: #000;
            padding: 0;
        }
        .size-selector h5 {
            font-weight: bold;
            text-align: left;
            font-size: 16px;
        }
        
        .nav-buttons .btn {
            margin-right: 0;
            font-size: 11px;
        }
        
        /* Mobile product card styles */
        .product-table {
            display: none;
        }
        
        .mobile-product-cards {
            display: block;
        }
        
        .product-card {
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 15px;
            background-color: #fff;
        }
        
        .product-card-body {
            padding: 12px;
        }
        
        .product-card-row {
            display: flex;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .product-card-label {
            font-weight: bold;
            width: 70px;
            flex-shrink: 0;
        }
        
        .product-card-value {
            flex-grow: 1;
        }
        
        .product-card-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 12px;
        }
        
        .section-title{
            font-size: 13px;
        }
        .section-title-mobile {
            background-color: #6c757d;
            color: white;
            padding: 7px;
            margin-bottom: 10px;
            border-radius: 5px;
            font-size: 12px;
            cursor: pointer;
            position: relative;
        }
        
        .section-title-mobile::after {
            content: '\f107';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            right: 15px;
        }
        
        .section-title-mobile.collapsed::after {
            content: '\f105';
        }
        
        .section-products-mobile {
            margin-bottom: 20px;
        }
    }
    
    /* Desktop-only styles */
    @media (min-width: 768px) {
        .mobile-product-cards {
            display: none;
        }
    }
    
    .necessary-products-box {
        margin-top: 5px;
        border-radius: 5px;
        background-color: #fff;
    }
    
    .necessary-products-title {
        background-color: #fff;
        color: #000;
        padding: 5px;
        text-align: center;
        border-radius: 5px 5px 0 0;
    }
    
    .section-container {
        margin-bottom: 20px;
        position: relative;
    }
    
    .section-image {
        display: none;
        width: 140px;
        height: 72px;
        object-fit: contain;
        margin-right: 15px;
    }
    
    .section-table-container {
        display: flex;
        align-items: flex-start;
    }
    
    .section-table-container .product-table {
        flex: 1;
    }
    
    .hidden-products {
        display: none;
    }

    .see-all-btn {
    text-transform: uppercase;
    padding: 0;
    color: #000;
    font-weight: bold;
    margin-top: 2px;
    cursor: pointer;
    font-size: 11px;
    width: 15%;
    background-color: #f8f9fa;
}
    
    .see-all-btn:hover {
        background-color: #e9ecef;
    }
    
    .font-size-14 {
        font-size: 14px;
    }
    
    .font-size-12 {
        font-size: 12px;
    }
    
    .model-list {
        margin-top: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
    
    .model-list-header {
        background-color: #8B4513;
        color: white;
        padding: 10px;
        text-align: center;
        border-radius: 5px 5px 0 0;
    }
    
    .model-list-item {
        padding: 8px 15px;
        border-bottom: 1px solid #ddd;
    }
    
    .model-list-item:last-child {
        border-bottom: none;
    }
    
    .model-list-item a {
        color: #333;
        text-decoration: none;
    }
    
    .model-list-item a:hover {
        color: #8B4513;
    }
    
    .model-list-item.active {
        background-color: #f5f5f5;
        font-weight: bold;
    }
    
    .model-list-item.active a {
        color: #8B4513;
    }
    
    /* Accordion styles */
    .accordion-item {
        border: none;
        margin-bottom: 10px;
    }
    
    .accordion-button {
        padding: 0;
        background: none;
        box-shadow: none;
    }
    
    .accordion-button:not(.collapsed) {
        background-color: transparent;
        box-shadow: none;
    }
    
    .accordion-button::after {
        display: none;
    }
    
    .accordion-button span {
        width: 100%;
        display: block;
    }
    
    .accordion-body {
        padding: 0;
    }
    
    .see-all-btn {
        margin: 10px auto;
        display: block;
    }
    
    .model-type-header {
        cursor: pointer;
        position: relative;
        padding-right: 30px;
        transition: background-color 0.3s;
    }
    
    .model-type-header:hover {
        background-color: #6c757d;
    }
    
    .model-type-header::after {
        content: '\f107'; /* Font Awesome down arrow */
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        transition: transform 0.3s;
    }
    
    .model-type-header.collapsed::after {
        transform: translateY(-50%) rotate(-90deg);
    }
    
    .model-type-items {
        display: none;
        border-left: 1px solid #ddd;
        border-right: 1px solid #ddd;
    }
    
    .model-type-items.show {
        display: block;
    }
    
    /* Make mobile accordion buttons more touch-friendly */
    .d-block.d-md-none .accordion-button {
        padding: 2px 0px;
    }
    
    .d-block.d-md-none .accordion-button span {
        padding: 10px !important;
    }
    
    /* Fix for accordion opening/closing */
    .accordion-button:not(.collapsed)::after {
        display: none;
    }
    
    .accordion-button::after {
        display: none;
    }
    
    .accordion-icon {
        display: inline-block;
        margin-left: 5px;
        font-size: 14px;
    }
    
    .accordion-icon-up {
        display: none;
        margin-left: 5px;
        font-size: 14px;
    }
    
    .accordion-button.collapsed .accordion-icon {
        display: inline-block;
    }
    
    .accordion-button.collapsed .accordion-icon-up {
        display: none;
    }
    
    .accordion-button:not(.collapsed) .accordion-icon {
        display: none;
    }
    
    .accordion-button:not(.collapsed) .accordion-icon-up {
        display: inline-block;
    }
    
    /* Custom accordion styling */
    .accordion-button:focus {
        box-shadow: none;
    }
    
    .accordion-button {
        padding: 0;
        background: transparent;
        box-shadow: none;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <!-- Navigation Buttons -->
    <div class="row nav-buttons">
        <div class="col-12">
            <a href="<?php echo e(route('aluminumfence.index')); ?>" class="btn btn-secondary">Back to All OnGuard Styles</a>
            <a href="<?php echo e(route('aluminumfence.pickup')); ?>" class="btn btn-danger">See what's available for pickup</a>
        </div>
    </div>
    
    <!-- Product Details Section -->
    <div class="row mb-4">
        <!-- Product Image and Size Selector -->
        <div class="col-md-3">
            <p class="mobile-title">ONGUARD <?php echo e(strtoupper($type)); ?> ALUMINUM FENCE - <?php echo e(strtoupper($model)); ?></p>
            <div class="product-image-container">
                <img src="<?php echo e($modelImage); ?>" alt="<?php echo e($type); ?> <?php echo e($model); ?>" class="primary-image" onerror="this.src='<?php echo e(url('storage/products/default.png')); ?>'">
                <img src="<?php echo e($selectedProduct->img_small ? url('storage/products/' . $selectedProduct->img_small) : url('storage/products/default.png')); ?>" alt="<?php echo e($type); ?> <?php echo e($model); ?> Hover" class="hover-image" onerror="this.src='<?php echo e(url('storage/products/default.png')); ?>'">
            </div>
            
            <!-- Size Filter -->
            <div class="size-selector">
                <h5 class="mb-0">SELECT HEIGHT</h5>
                
                <!-- Desktop size radio buttons -->
                <div class="d-none d-md-block mt-3 size-options-desktop">
                    <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="size-option">
                            <label>
                                <input type="radio" name="size" class="size-filter" value="<?php echo e($size); ?>" <?php echo e($loop->first ? 'checked' : ''); ?>>
                                <span class="ms-2"><?php echo e($size); ?></span>
                            </label>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <!-- Mobile size dropdown -->
                <div class="d-block d-md-none size-dropdown-mobile">
                    <select id="size-select-mobile" class="form-select size-filter-mobile">
                        <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($size); ?>" <?php echo e($loop->first ? 'selected' : ''); ?>><?php echo e($size); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            
            <!-- Color Dropdown -->
            <?php if(count($colors) > 1): ?>
            <div class="mt-3">
                <label for="color-select" class="form-label fw-bold">COLOR</label>
                <select id="color-select" class="form-select">
                    <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($color); ?>"><?php echo e($color); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <?php endif; ?>
            
            <!-- Model List -->
            <div class="model-list mt-4">
                <div class="model-list-content">
                    <?php $__currentLoopData = $fenceTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fenceType => $typeData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="model-type-section mb-2">
                            <div class="model-type-header bg-secondary text-white p-2 <?php echo e($type == $fenceType ? '' : 'collapsed'); ?>" data-fence-type="<?php echo e($fenceType); ?>">
                                <i class="fas fa-bars me-2"></i> <?php echo e($fenceType); ?>

                            </div>
                            <div class="model-type-items <?php echo e($type == $fenceType ? 'show' : ''); ?>">
                                <?php $__currentLoopData = $typeData['models']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $modelName => $modelData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="model-list-item <?php echo e(($type == $fenceType && $model == $modelName) ? 'active' : ''); ?>">
                                        <a href="<?php echo e(route('aluminumfence.product', ['type' => $fenceType, 'model' => $modelName])); ?>">
                                            <i class="fas fa-angle-right me-2"></i> <?php echo e($modelName); ?>

                                        </a>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        
        <!-- Product Info -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header product-header">
                    <p class="text-center text-white mb-0">ONGUARD <?php echo e(strtoupper($type)); ?> ALUMINUM FENCE - <?php echo e(strtoupper($model)); ?></p>
                </div>
                <div class="card-body p-0">
                    <!-- Desktop table view -->
                    <table class="product-table" id="products-table">
                        <tbody>
                            <?php if($selectedProduct): ?>
                                <tr style="font-weight: bold">
                                    <td><?php echo e($selectedProduct->item_no); ?></td>
                                    <td><?php echo e($selectedProduct->product_name); ?></td>
                                    <td><?php echo e($selectedProduct->size); ?></td>
                                    <td><?php echo e($selectedProduct->color); ?></td>
                                    <td class="price">$<?php echo e(number_format($selectedProduct->price, 2)); ?></td>
                                    <td>
                                        <input type="number" class="quantity-input" value="1" min="1">
                                    </td>
                                    <td>
                                        <button class="btn-add-cart add-to-cart-btn" 
                                            data-id="<?php echo e($selectedProduct->id); ?>"
                                            data-item_no="<?php echo e($selectedProduct->item_no); ?>" 
                                            data-product_name="<?php echo e($selectedProduct->product_name); ?>"
                                            data-price="<?php echo e($selectedProduct->price); ?>"
                                            data-color="<?php echo e($selectedProduct->color ?? ''); ?>"
                                            data-size="<?php echo e($selectedProduct->size ?? ''); ?>"
                                            data-size_in="<?php echo e($selectedProduct->size_in ?? ''); ?>"
                                            data-size_wt="<?php echo e($selectedProduct->size_wt ?? ''); ?>"
                                            data-size_ht="<?php echo e($selectedProduct->size_ht ?? ''); ?>"
                                            data-weight_lbs="<?php echo e($selectedProduct->weight_lbs ?? ''); ?>"
                                            data-img_small="<?php echo e($selectedProduct->img_small ?? ''); ?>"
                                            data-img_large="<?php echo e($selectedProduct->img_large ?? ''); ?>"
                                            data-display_size_2="<?php echo e($selectedProduct->display_size_2 ?? ''); ?>"
                                            data-size2="<?php echo e($selectedProduct->size2 ?? ''); ?>"
                                            data-size3="<?php echo e($selectedProduct->size3 ?? ''); ?>"
                                            data-material="<?php echo e($selectedProduct->material ?? ''); ?>"
                                            data-spacing="<?php echo e($selectedProduct->spacing ?? ''); ?>"
                                            data-coating="<?php echo e($selectedProduct->coating ?? ''); ?>"
                                            data-style="<?php echo e($selectedProduct->style ?? ''); ?>"
                                            data-speciality="<?php echo e($selectedProduct->speciality ?? ''); ?>"
                                            data-free_shipping="<?php echo e($selectedProduct->free_shipping ?? '0'); ?>"
                                            data-special_shipping="<?php echo e($selectedProduct->special_shipping ?? '0'); ?>"
                                            data-amount_per_box="<?php echo e($selectedProduct->amount_per_box ?? '1'); ?>"
                                            data-class="<?php echo e($selectedProduct->class ?? ''); ?>"
                                            data-categories_id="<?php echo e($selectedProduct->categories_id ?? ''); ?>"
                                            data-shipping_method="<?php echo e($selectedProduct->shipping_method ?? ''); ?>">
                                            Add
                                        </button>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    
                    <!-- Mobile card view -->
                    <div class="mobile-product-cards">
                        <?php if($selectedProduct): ?>
                            <div class="product-card">
                                <div class="product-card-body">
                                    <div class="product-card-row">
                                        <div class="product-card-label">Item #:</div>
                                        <div class="product-card-value"><?php echo e($selectedProduct->item_no); ?></div>
                                    </div>
                                    <div class="product-card-row">
                                        <div class="product-card-label">Name:</div>
                                        <div class="product-card-value"><?php echo e($selectedProduct->product_name); ?></div>
                                    </div>
                                    <div class="product-card-row">
                                        <div class="product-card-label">Size:</div>
                                        <div class="product-card-value"><?php echo e($selectedProduct->size); ?></div>
                                    </div>
                                    <div class="product-card-row">
                                        <div class="product-card-label">Color:</div>
                                        <div class="product-card-value"><?php echo e($selectedProduct->color); ?></div>
                                    </div>
                                    <div class="product-card-row">
                                        <div class="product-card-label">Price:</div>
                                        <div class="product-card-value">$ <?php echo e(number_format($selectedProduct->price, 2)); ?></div>
                                    </div>
                                    <div class="product-card-actions">
                                        <div>
                                            <label for="mobile-qty" class="me-2">Qty:</label>
                                            <input type="number" id="mobile-qty" class="quantity-input" value="1" min="1" style="width: 60px;">
                                        </div>
                                        <button class="btn-add-cart add-to-cart-btn" 
                                            data-id="<?php echo e($selectedProduct->id); ?>"
                                            data-item_no="<?php echo e($selectedProduct->item_no); ?>" 
                                            data-product_name="<?php echo e($selectedProduct->product_name); ?>"
                                            data-price="<?php echo e($selectedProduct->price); ?>"
                                            data-color="<?php echo e($selectedProduct->color ?? ''); ?>"
                                            data-size="<?php echo e($selectedProduct->size ?? ''); ?>"
                                            data-size2="<?php echo e($selectedProduct->size2 ?? ''); ?>"
                                            data-size3="<?php echo e($selectedProduct->size3 ?? ''); ?>"
                                            data-img_small="<?php echo e($selectedProduct->img_small ?? ''); ?>"
                                            data-img_large="<?php echo e($selectedProduct->img_large ?? ''); ?>">
                                            Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Necessary Products Box -->
            <?php if(!empty($associatedSections)): ?>
            <div class="necessary-products-box">
                <!-- Desktop View -->
                <div class="d-none d-md-block">
                    <h5 class="mt-3 text-center" style="font-size: 15px;">NECESSARY ASSOCIATED PRODUCTS</h5>
                    <div class="accordion" id="associatedProductsAccordion">
                        <?php $__currentLoopData = $associatedSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="accordion-item section-container mb-2">
                            <h6 class="accordion-header">
                                <button class="accordion-button <?php echo e($index > 0 ? 'collapsed' : ''); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#section-collapse-<?php echo e($index); ?>" aria-expanded="<?php echo e($index === 0 ? 'true' : 'false'); ?>" aria-controls="section-collapse-<?php echo e($index); ?>">
                                    <span class="bg-secondary text-white p-2 w-100 text-center" style="font-size: 13px;"><?php echo e($section['title']); ?>

                                        <i class="accordion-icon bi bi-chevron-down"></i>
                                        <i class="accordion-icon-up bi bi-chevron-up"></i>
                                    </span>
                                </button>
                            </h6>
                            <div id="section-collapse-<?php echo e($index); ?>" class="accordion-collapse collapse <?php echo e($index === 0 ? 'show' : ''); ?>">
                                <div class="accordion-body p-0">
                                    <div class="section-table-container">
                                        <?php if(isset($section['products'][0])): ?>
                                        
                                        
                                        <?php endif; ?>
                                        <table class="product-table">
                                            <tbody>
                                                <?php $__currentLoopData = $section['products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($product->item_no); ?></td>
                                                        <td><?php echo e($product->product_name); ?></td>
                                                        <td><?php echo e($product->size); ?></td>
                                                        <td><?php echo e($product->color); ?></td>
                                                        <td class="price">$ <?php echo e(number_format($product->price, 2)); ?></td>
                                                        <td>
                                                            <input type="number" class="quantity-input" value="1" min="1">
                                                        </td>
                                                        <td>
                                                            <button class="btn-add-cart add-to-cart-btn" 
                                                                data-id="<?php echo e($product->id); ?>"
                                                                data-item_no="<?php echo e($product->item_no); ?>" 
                                                                data-product_name="<?php echo e($product->product_name); ?>"
                                                                data-price="<?php echo e($product->price); ?>"
                                                                data-color="<?php echo e($product->color ?? ''); ?>"
                                                                data-size="<?php echo e($product->size ?? ''); ?>"
                                                                data-size2="<?php echo e($product->size2 ?? ''); ?>"
                                                                data-size3="<?php echo e($product->size3 ?? ''); ?>"
                                                                data-img_small="<?php echo e($product->img_small ?? ''); ?>"
                                                                data-img_large="<?php echo e($product->img_large ?? ''); ?>">
                                                                Add to Cart
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                
                <!-- Mobile View -->
                <div class="d-block d-md-none">
                    <h5 class="mt-3 text-center" style="font-size: 15px;">NECESSARY ASSOCIATED PRODUCTS</h5>
                    <div class="accordion" id="mobileAssociatedProductsAccordion">
                        <?php $__currentLoopData = $associatedSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="accordion-item section-container mb-2">
                            <h6 class="accordion-header">
                                <button class="accordion-button <?php echo e($index > 0 ? 'collapsed' : ''); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#mobile-section-<?php echo e($index); ?>" aria-expanded="<?php echo e($index === 0 ? 'true' : 'false'); ?>" aria-controls="mobile-section-<?php echo e($index); ?>">
                                    <span class="bg-secondary text-white p-2 w-100 text-center" style="font-size: 13px;"><?php echo e($section['title']); ?>

                                        <i class="accordion-icon bi bi-chevron-down"></i>
                                        <i class="accordion-icon-up bi bi-chevron-up"></i>
                                    </span>
                                </button>
                            </h6>
                            <div id="mobile-section-<?php echo e($index); ?>" class="accordion-collapse collapse <?php echo e($index === 0 ? 'show' : ''); ?>">
                                <div class="accordion-body p-0">
                                    <?php $__currentLoopData = $section['products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="product-card">
                                        <div class="product-card-body">
                                            <div class="product-card-row">
                                                <div class="product-card-label">Item #:</div>
                                                <div class="product-card-value"><?php echo e($product->item_no); ?></div>
                                            </div>
                                            <div class="product-card-row">
                                                <div class="product-card-label">Name:</div>
                                                <div class="product-card-value"><?php echo e($product->product_name); ?></div>
                                            </div>
                                            <div class="product-card-row">
                                                <div class="product-card-label">Size:</div>
                                                <div class="product-card-value"><?php echo e($product->size); ?></div>
                                            </div>
                                            <div class="product-card-row">
                                                <div class="product-card-label">Color:</div>
                                                <div class="product-card-value"><?php echo e($product->color); ?></div>
                                            </div>
                                            <div class="product-card-row">
                                                <div class="product-card-label">Price:</div>
                                                <div class="product-card-value">$ <?php echo e(number_format($product->price, 2)); ?></div>
                                            </div>
                                            <div class="product-card-actions">
                                                <div>
                                                    <label for="mobile-assoc-qty-<?php echo e($product->item_no); ?>" class="me-2">Qty:</label>
                                                    <input type="number" id="mobile-assoc-qty-<?php echo e($product->item_no); ?>" class="quantity-input" value="1" min="1" style="width: 60px;">
                                                </div>
                                                <button class="btn-add-cart add-to-cart-btn" 
                                                    data-id="<?php echo e($product->id); ?>"
                                                    data-item_no="<?php echo e($product->item_no); ?>" 
                                                    data-product_name="<?php echo e($product->product_name); ?>"
                                                    data-price="<?php echo e($product->price); ?>"
                                                    data-color="<?php echo e($product->color ?? ''); ?>"
                                                    data-size="<?php echo e($product->size ?? ''); ?>"
                                                    data-size2="<?php echo e($product->size2 ?? ''); ?>"
                                                    data-size3="<?php echo e($product->size3 ?? ''); ?>"
                                                    data-img_small="<?php echo e($product->img_small ?? ''); ?>"
                                                    data-img_large="<?php echo e($product->img_large ?? ''); ?>">
                                                    Add to Cart
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof jQuery === 'undefined') {
            console.error('jQuery is not loaded!');
            return;
        }
        
        (function($) {
            console.log('Document ready');
            
            const sizeInputs = $('input[name="size"]');
            const colorSelect = $('#color-select');
            const sizeSelectMobile = $('#size-select-mobile');
            
            console.log('Size inputs found:', sizeInputs.length);
            console.log('Color select found:', colorSelect.length);
            console.log('Size select mobile found:', sizeSelectMobile.length);
            
            // Get initial values from either desktop or mobile selector
            const defaultSize = sizeInputs.filter(':checked').val() || sizeSelectMobile.val();
            const defaultColor = colorSelect.val();
            
            // Make sure both selectors are in sync initially
            if (defaultSize) {
                sizeInputs.filter('[value="' + defaultSize + '"]').prop('checked', true);
                sizeSelectMobile.val(defaultSize);
            }
            
            console.log('Default size:', defaultSize);
            console.log('Default color:', defaultColor);
            
            // We don't need to filter on initial load since the server already provided the correct product
            // Only set up the event handlers for when filters change
            
            sizeInputs.on('change', function() {
                console.log('Size changed (desktop)');
                const selectedSize = $(this).val();
                const selectedColor = colorSelect.val() || '';
                console.log('Selected size:', selectedSize);
                console.log('Selected color:', selectedColor);
                
                // Sync with mobile dropdown
                sizeSelectMobile.val(selectedSize);
                
                // Show loading indicator before filtering
                $('#products-table tbody').html('<tr><td colspan="7" class="text-center">Loading...</td></tr>');
                $('.mobile-product-cards').html('<div class="p-3 text-center">Loading...</div>');
                
                filterProducts(selectedSize, selectedColor);
            });
            
            sizeSelectMobile.on('change', function() {
                console.log('Size changed (mobile)');
                const selectedSize = $(this).val();
                const selectedColor = colorSelect.val() || '';
                console.log('Selected size:', selectedSize);
                console.log('Selected color:', selectedColor);
                
                // Sync with desktop radio buttons
                sizeInputs.filter('[value="' + selectedSize + '"]').prop('checked', true);
                
                // Show loading indicator before filtering
                $('#products-table tbody').html('<tr><td colspan="7" class="text-center">Loading...</td></tr>');
                $('.mobile-product-cards').html('<div class="p-3 text-center">Loading...</div>');
                
                filterProducts(selectedSize, selectedColor);
            });
            
            colorSelect.on('change', function() {
                console.log('Color changed');
                const selectedColor = $(this).val();
                const selectedSize = sizeInputs.filter(':checked').val() || sizeSelectMobile.val();
                console.log('Selected size:', selectedSize);
                console.log('Selected color:', selectedColor);
                
                // Show loading indicator before filtering
                $('#products-table tbody').html('<tr><td colspan="7" class="text-center">Loading...</td></tr>');
                $('.mobile-product-cards').html('<div class="p-3 text-center">Loading...</div>');
                
                filterProducts(selectedSize, selectedColor);
            });
            
            function filterProducts(size, color) {
                console.log('Filtering products - Size:', size, 'Color:', color);
                
                // Cache key for storing filtered results
                const cacheKey = `${size}-${color}-<?php echo e($type); ?>-<?php echo e($model); ?>`;
                
                // Initialize cache in memory if it doesn't exist
                if (!window.productCache) {
                    window.productCache = {};
                }
                
                // Check if we have cached results in memory
                if (window.productCache[cacheKey]) {
                    console.log('Using cached results for:', cacheKey);
                    updateProductDisplay(window.productCache[cacheKey]);
                    updateAssociatedProducts(window.productCache[cacheKey]);
                    return;
                }
                
                $.ajax({
                    url: '<?php echo e(route("aluminumfence.filter")); ?>',
                    method: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        size: size,
                        color: color,
                        type: '<?php echo e($type); ?>',
                        model: '<?php echo e($model); ?>'
                    },
                    beforeSend: function() {
                        console.log('AJAX request sending with data:', {
                            size: size,
                            color: color,
                            type: '<?php echo e($type); ?>',
                            model: '<?php echo e($model); ?>'
                        });
                    },
                    success: function(response) {
                        console.log('Filter response:', response);
                        
                        // Cache the results in memory instead of sessionStorage
                        try {
                            window.productCache[cacheKey] = response;
                        } catch (e) {
                            console.error('Error caching results:', e);
                            // If we can't cache for some reason, still update the display
                        }
                        
                        updateProductDisplay(response);
                        updateAssociatedProducts(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error filtering products:', error);
                        console.error('Status:', status);
                        console.error('Response:', xhr.responseText);
                        
                        $('#products-table tbody').html('<tr><td colspan="7" class="text-center">Error loading product. Please try again.</td></tr>');
                        $('.mobile-product-cards').html('<div class="p-3 text-center">Error loading product. Please try again.</div>');
                    }
                });
            }
            
            function updateProductDisplay(response) {
                if (response.product) {
                    const product = response.product;
                    console.log('Product found:', product);
                    
                    // Update desktop table view
                    const newRow = `
                        <tr class="product-row" data-color="${product.color}" data-size="${product.size}">
                            <td>${product.item_no}</td>
                            <td>${product.product_name}- ${product.display_size_2}</td>
                            <td>${product.size}</td>
                            <td>${product.color}</td>
                            <td class="price">$${parseFloat(product.price).toFixed(2)}</td>
                            <td>
                                <input type="number" class="quantity-input" value="1" min="1">
                            </td>
                            <td>
                                <button class="btn-add-cart add-to-cart-btn" 
                                    data-id="${product.id}"
                                    data-item_no="${product.item_no}" 
                                    data-product_name="${product.product_name}"
                                    data-price="${product.price}"
                                    data-color="${product.color ?? ''}"
                                    data-size="${product.size ?? ''}"
                                    data-size_in="${product.size_in ?? ''}"
                                    data-size_wt="${product.size_wt ?? ''}"
                                    data-size_ht="${product.size_ht ?? ''}"
                                    data-weight_lbs="${product.weight_lbs ?? ''}"
                                    data-img_small="${product.img_small ?? ''}"
                                    data-img_large="${product.img_large ?? ''}"
                                    data-display_size_2="${product.display_size_2 ?? ''}"
                                    data-size2="${product.size2 ?? ''}"
                                    data-size3="${product.size3 ?? ''}"
                                    data-material="${product.material ?? ''}"
                                    data-spacing="${product.spacing ?? ''}"
                                    data-coating="${product.coating ?? ''}"
                                    data-style="${product.style ?? ''}"
                                    data-speciality="${product.speciality ?? ''}"
                                    data-free_shipping="${product.free_shipping ?? '0' }"
                                    data-special_shipping="${product.special_shipping ?? '0' }"
                                    data-amount_per_box="${product.amount_per_box ?? '1' }"
                                    data-class="${product.class ?? '' }"
                                    data-categories_id="${product.categories_id ?? '' }"
                                    data-shipping_method="${product.shipping_method ?? '' }">
                                    Add
                                </button>
                            </td>
                        </tr>
                    `;
                    
                    $('#products-table tbody').html(newRow);
                    
                    // Update mobile card view
                    const mobileCard = `
                        <div class="product-card">
                            <div class="product-card-body">
                                <div class="product-card-row">
                                    <div class="product-card-label">Item #:</div>
                                    <div class="product-card-value">${product.item_no}</div>
                                </div>
                                <div class="product-card-row">
                                    <div class="product-card-label">Name:</div>
                                    <div class="product-card-value">${product.product_name}- ${product.display_size_2}</div>
                                </div>
                                <div class="product-card-row">
                                    <div class="product-card-label">Size:</div>
                                    <div class="product-card-value">${product.size}</div>
                                </div>
                                <div class="product-card-row">
                                    <div class="product-card-label">Color:</div>
                                    <div class="product-card-value">${product.color}</div>
                                </div>
                                <div class="product-card-row">
                                    <div class="product-card-label">Price:</div>
                                    <div class="product-card-value">$${parseFloat(product.price).toFixed(2)}</div>
                                </div>
                                <div class="product-card-actions">
                                    <div>
                                        <label for="mobile-qty" class="me-2">Qty:</label>
                                        <input type="number" id="mobile-qty" class="quantity-input" value="1" min="1" style="width: 60px;">
                                    </div>
                                    <button class="btn-add-cart add-to-cart-btn" 
                                        data-id="${product.id}"
                                        data-item_no="${product.item_no}" 
                                        data-product_name="${product.product_name}"
                                        data-price="${product.price}"
                                        data-color="${product.color ?? ''}"
                                        data-size="${product.size ?? ''}"
                                        data-size2="${product.size2 ?? ''}"
                                        data-size3="${product.size3 ?? ''}"
                                        data-img_small="${product.img_small ?? ''}"
                                        data-img_large="${product.img_large ?? ''}">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    $('.mobile-product-cards').html(mobileCard);
                } else {
                    console.log('No product found in response');
                    $('#products-table tbody').html('<tr><td colspan="7" class="text-center">No matching product found.</td></tr>');
                    $('.mobile-product-cards').html('<div class="p-3 text-center">No matching product found.</div>');
                }
                
                updateAssociatedProducts(response);
            }
            
            function updateAssociatedProducts(response) {
                if (response.associatedSections && response.associatedSections.length > 0) {
                    // Desktop view
                    let associatedHtml = '<h5 class="mt-3 text-center" style="font-size: 15px;">NECESSARY ASSOCIATED PRODUCTS</h5>';
                    
                    response.associatedSections.forEach(function(section, index) {
                        // Get the first product image for the section
                        const firstProductImage = section.products.length > 0 ? 
                            (section.products[0].img_small ? 
                                `<?php echo e(url('storage/products/')); ?>/${section.products[0].img_small}` : 
                                `<?php echo e(url('storage/products/default.png')); ?>`) : 
                            `<?php echo e(url('storage/products/default.png')); ?>`;
                        
                        associatedHtml += `
                            <div class="accordion-item section-container mb-2">
                                <h6 class="accordion-header">
                                    <button class="accordion-button ${index > 0 ? 'collapsed' : ''}" type="button" data-bs-toggle="collapse" data-bs-target="#section-collapse-${index}" aria-expanded="${index === 0 ? 'true' : 'false'}" aria-controls="section-collapse-${index}">
                                        <span class="bg-secondary text-white p-2 w-100 text-center" style="font-size: 13px;">${section.title}
                                            <i class="accordion-icon bi bi-chevron-down"></i>
                                            <i class="accordion-icon-up bi bi-chevron-up"></i>
                                        </span>
                                    </button>
                                </h6>
                                <div id="section-collapse-${index}" class="accordion-collapse collapse ${index === 0 ? 'show' : ''}">
                                    <div class="accordion-body p-0">
                                        <div class="section-table-container">
                                            <table class="product-table">
                                                <tbody>
                                                    ${section.products.map(function(product) {
                                                        return `
                                                            <tr>
                                                                <td>${product.item_no}</td>
                                                                <td>${product.product_name}</td>
                                                                <td>${product.size}</td>
                                                                <td>${product.color}</td>
                                                                <td class="price">$${parseFloat(product.price).toFixed(2)}</td>
                                                                <td>
                                                                    <input type="number" class="quantity-input" value="1" min="1">
                                                                </td>
                                                                <td>
                                                                    <button class="btn-add-cart add-to-cart-btn" 
                                                                        data-id="${product.id}"
                                                                        data-item_no="${product.item_no}" 
                                                                        data-product_name="${product.product_name}"
                                                                        data-price="${product.price}"
                                                                        data-color="${product.color || ''}"
                                                                        data-size="${product.size || ''}"
                                                                        data-size2="${product.size2 || ''}"
                                                                        data-size3="${product.size3 || ''}"
                                                                        data-img_small="${product.img_small || ''}"
                                                                        data-img_large="${product.img_large || ''}">
                                                                        Add to Cart
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        `;
                                                    }).join('')}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    // Mobile view
                    let mobileSectionsHtml = '<h5 class="mb-3 text-center font-size-14">NECESSARY ASSOCIATED PRODUCTS</h5>';
                    
                    response.associatedSections.forEach(function(section, index) {
                        let mobileProductsHtml = '';
                        
                        section.products.forEach(function(product) {
                            mobileProductsHtml += `
                                <div class="product-card">
                                    <div class="product-card-body">
                                        <div class="product-card-row">
                                            <div class="product-card-label">Item #:</div>
                                            <div class="product-card-value">${product.item_no}</div>
                                        </div>
                                        <div class="product-card-row">
                                            <div class="product-card-label">Name:</div>
                                            <div class="product-card-value">${product.product_name}</div>
                                        </div>
                                        <div class="product-card-row">
                                            <div class="product-card-label">Size:</div>
                                            <div class="product-card-value">${product.size}</div>
                                        </div>
                                        <div class="product-card-row">
                                            <div class="product-card-label">Color:</div>
                                            <div class="product-card-value">${product.color}</div>
                                        </div>
                                        <div class="product-card-row">
                                            <div class="product-card-label">Price:</div>
                                            <div class="product-card-value">$${parseFloat(product.price).toFixed(2)}</div>
                                        </div>
                                        <div class="product-card-actions">
                                            <div>
                                                <label for="mobile-assoc-qty-${product.item_no}" class="me-2">Qty:</label>
                                                <input type="number" id="mobile-assoc-qty-${product.item_no}" class="quantity-input" value="1" min="1" style="width: 60px;">
                                            </div>
                                            <button class="btn-add-cart add-to-cart-btn" 
                                                data-id="${product.id}"
                                                data-item_no="${product.item_no}" 
                                                data-product_name="${product.product_name}"
                                                data-price="${product.price}"
                                                data-color="${product.color || ''}"
                                                data-size="${product.size || ''}"
                                                data-size2="${product.size2 || ''}"
                                                data-size3="${product.size3 || ''}"
                                                data-img_small="${product.img_small || ''}"
                                                data-img_large="${product.img_large || ''}">
                                                Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        
                        mobileSectionsHtml += `
                            <div class="accordion-item section-container mb-2">
                                <h6 class="accordion-header">
                                    <button class="accordion-button ${index > 0 ? 'collapsed' : ''}" type="button" data-bs-toggle="collapse" data-bs-target="#mobile-section-ajax-${index}" aria-expanded="${index === 0 ? 'true' : 'false'}" aria-controls="mobile-section-ajax-${index}">
                                        <span class="bg-secondary text-white p-2 w-100 text-center" style="font-size: 13px;">${section.title}
                                            <i class="accordion-icon bi bi-chevron-down"></i>
                                            <i class="accordion-icon-up bi bi-chevron-up"></i>
                                        </span>
                                    </button>
                                </h6>
                                <div id="mobile-section-ajax-${index}" class="accordion-collapse collapse ${index === 0 ? 'show' : ''}">
                                    <div class="accordion-body p-0">
                                        ${mobileProductsHtml}
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    if ($('.necessary-products-box').length === 0) {
                        const necessaryProductsBox = `
                            <div class="necessary-products-box mt-4">
                                <div class="d-none d-md-block">
                                    <div class="accordion" id="associatedProductsAccordion">
                                        ${associatedHtml}
                                    </div>
                                </div>
                                <div class="d-block d-md-none">
                                    <div class="accordion" id="mobileAssociatedProductsAccordion">
                                        ${mobileSectionsHtml}
                                    </div>
                                </div>
                            </div>
                        `;
                        $('.products-container').append(necessaryProductsBox);
                    } else {
                        $('.necessary-products-box .d-none.d-md-block').html(`<div class="accordion" id="associatedProductsAccordion">${associatedHtml}</div>`);
                        $('.necessary-products-box .d-block.d-md-none').html(`<div class="accordion" id="mobileAssociatedProductsAccordion">${mobileSectionsHtml}</div>`);
                    }

                    // Initialize accordions after dynamic content is loaded
                    setTimeout(function() {
                        // Initialize any new Bootstrap components after dynamic loading
                        document.querySelectorAll('.accordion-button').forEach(function(button) {
                            button.addEventListener('click', function() {
                                const target = document.querySelector(button.getAttribute('data-bs-target'));
                                if (target) {
                                    if (target.classList.contains('show')) {
                                        target.classList.remove('show');
                                        button.classList.add('collapsed');
                                        button.setAttribute('aria-expanded', 'false');
                                    } else {
                                        target.classList.add('show');
                                        button.classList.remove('collapsed');
                                        button.setAttribute('aria-expanded', 'true');
                                    }
                                }
                            });
                        });
                    }, 100);
                } else {
                    $('.necessary-products-box').remove();
                }
            }
            
            $(document).on('click', '.model-type-header', function() {
                const $this = $(this);
                const $items = $this.next('.model-type-items');
                
                if ($this.hasClass('collapsed')) {
                    $this.removeClass('collapsed');
                    $items.addClass('show');
                } else {
                    $this.addClass('collapsed');
                    $items.removeClass('show');
                }
            });
            
            // Toggle mobile section collapsible
            $(document).on('click', '.section-title-mobile', function() {
                const $this = $(this);
                const $content = $this.next('.section-content-mobile');
                
                if ($this.hasClass('collapsed')) {
                    $this.removeClass('collapsed');
                    $content.removeClass('d-none');
                } else {
                    $this.addClass('collapsed');
                    $content.addClass('d-none');
                }
            });
        })(jQuery);
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\afc-website\resources\views/categories/aluminumfence-product.blade.php ENDPATH**/ ?>