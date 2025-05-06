<div class="card">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Add Items</h5>
    </div>
    <div class="card-body p-0">
        <!-- Categories List -->
        <div id="categoriesList" class="accordion">
            <!-- Categories will be loaded via AJAX here -->
            <div class="text-center p-3">
                <div class="spinner-border spinner-border-sm text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <span class="ms-2">Loading categories...</span>
            </div>
        </div>
    </div>
</div>

<!-- Products Container (shows when a category is selected) -->
<div id="productsContainer" class="mt-3 d-none">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0" id="selectedCategoryName">Products</h5>
            <button type="button" class="btn-close" id="closeProductsBtn" aria-label="Close"></button>
        </div>
        <div class="card-body p-0">
            <div id="productsList">
                <!-- Products will be loaded via AJAX here -->
            </div>
        </div>
    </div>
</div>

<!-- Category template for cloning -->
<template id="categoryTemplate">
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#category-{id}">
                <i class="bi bi-folder me-2"></i> <span class="category-name">{name}</span>
            </button>
        </h2>
        <div id="category-{id}" class="accordion-collapse collapse">
            <div class="accordion-body p-0">
                <ul class="list-group list-group-flush subcategories-container">
                    <!-- Subcategories will be inserted here -->
                </ul>
            </div>
        </div>
    </div>
</template>

<!-- Subcategory template for cloning -->
<template id="subcategoryTemplate">
    <li class="list-group-item subcategory-item" data-id="{id}">
        <i class="bi bi-tag me-2"></i> <span class="subcategory-name">{name}</span>
    </li>
</template>

<!-- Product template for cloning -->
<template id="productTemplate">
    <div class="list-group-item product-item">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <div class="fw-bold">{product_name}</div>
                <small>Item #: {item_no} | Size: {size}</small><br>
                <small>Price: ${price}</small>
            </div>
            <div class="ms-auto">
                <div class="input-group input-group-sm mb-1" style="width: 100px;">
                    <span class="input-group-text">Qty</span>
                    <input type="number" class="form-control product-quantity" value="1" min="1">
                </div>
                <button type="button" class="btn btn-sm btn-primary add-product-btn" 
                    data-id="{id}" 
                    data-item-no="{item_no}" 
                    data-product-name="{product_name}" 
                    data-price="{price}" 
                    data-size="{size}" 
                    data-size2="{size2}" 
                    data-size3="{size3}" 
                    data-color="{color}" 
                    data-weight="{weight}" 
                    data-material="{material}" 
                    data-spacing="{spacing}" 
                    data-coating="{coating}" 
                    data-speciality="{speciality}" 
                    data-img-small="{img_small}" 
                    data-img-large="{img_large}">
                    Add to Order
                </button>
            </div>
        </div>
    </div>
</template>
