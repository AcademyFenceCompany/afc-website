document.addEventListener('DOMContentLoaded', function() {
    // Ensure jQuery is available before proceeding
    if (typeof jQuery === 'undefined') {
        console.error('jQuery is not loaded. Categories will not function properly.');
        // Show error in the categories list
        const categoriesList = document.getElementById('categoriesList');
        if (categoriesList) {
            categoriesList.innerHTML = '<div class="alert alert-danger m-3">Error: jQuery is not loaded. Please check the console for details.</div>';
        }
        return;
    }
    
    // Load categories when the page loads
    loadCategories();
    
    // Event delegation for subcategory clicks
    $(document).on('click', '.subcategory-item', function() {
        const categoryId = $(this).data('id');
        const categoryName = $(this).find('.subcategory-name').text();
        loadProducts(categoryId, categoryName);
    });
    
    // Close products button
    $(document).on('click', '#closeProductsBtn', function() {
        $('#productsContainer').addClass('d-none');
    });
    
    // Add product to order button
    $(document).on('click', '.add-product-btn', function() {
        const productData = {
            id: $(this).data('id'),
            itemNo: $(this).data('item-no'),
            productName: $(this).data('product-name'),
            price: parseFloat($(this).data('price')),
            size: $(this).data('size') || '',
            size2: $(this).data('size2') || '',
            size3: $(this).data('size3') || '',
            color: $(this).data('color') || '',
            weight_lbs: parseFloat($(this).data('weight')) || 0,
            quantity: parseInt($(this).closest('.product-item').find('.product-quantity').val()) || 1,
            product_data: {
                id: $(this).data('id'),
                item_no: $(this).data('item-no'),
                product_name: $(this).data('product-name'),
                price: parseFloat($(this).data('price')),
                size: $(this).data('size') || '',
                size2: $(this).data('size2') || '',
                size3: $(this).data('size3') || '',
                color: $(this).data('color') || '',
                weight_lbs: parseFloat($(this).data('weight')) || 0,
                material: $(this).data('material') || '',
                spacing: $(this).data('spacing') || '',
                coating: $(this).data('coating') || '',
                speciality: $(this).data('speciality') || '',
                img_small: $(this).data('img-small') || '',
                img_large: $(this).data('img-large') || ''
            }
        };
        
        // Calculate total
        productData.total = productData.price * productData.quantity;
        
        // Add to order (this function should be defined in order-products.js)
        if (typeof addProductToOrder === 'function') {
            addProductToOrder(productData.product_data);
            showToast('Product added to order', 'success');
        } else {
            console.error('addProductToOrder function not found');
            alert('Could not add product to order. Please check the console for errors.');
        }
    });
});

// Function to load categories via AJAX
function loadCategories() {
    $.ajax({
        url: '/api/order-categories',
        method: 'GET',
        success: function(response) {
            renderCategories(response);
        },
        error: function(xhr) {
            console.error('Error loading categories:', xhr);
            $('#categoriesList').html('<div class="alert alert-danger m-3">Failed to load categories. Please check the console for errors.</div>');
            
            // If API fails, show some default categories to allow the user to continue
            const defaultCategories = [
                {
                    id: 1,
                    name: "Aluminum Fence",
                    subcategories: [
                        { id: 101, name: "Residential" },
                        { id: 102, name: "Commercial" }
                    ]
                },
                {
                    id: 2,
                    name: "Chain Link Fence",
                    subcategories: [
                        { id: 201, name: "Galvanized" },
                        { id: 202, name: "Vinyl Coated" }
                    ]
                },
                {
                    id: 3,
                    name: "Vinyl Fence",
                    subcategories: [
                        { id: 301, name: "Privacy" },
                        { id: 302, name: "Picket" }
                    ]
                }
            ];
            
            renderCategories(defaultCategories);
        }
    });
}

// Function to render categories using templates
function renderCategories(categories) {
    const categoriesList = $('#categoriesList');
    categoriesList.empty();
    
    if (!categories || categories.length === 0) {
        categoriesList.html('<div class="alert alert-info m-3">No categories available</div>');
        return;
    }
    
    // Get the templates
    const categoryTemplate = document.getElementById('categoryTemplate');
    const subcategoryTemplate = document.getElementById('subcategoryTemplate');
    
    if (!categoryTemplate || !subcategoryTemplate) {
        console.error('Category templates not found');
        categoriesList.html('<div class="alert alert-danger m-3">Templates not found</div>');
        return;
    }
    
    // Create and append category elements
    categories.forEach(function(category) {
        // Clone the category template
        const categoryContent = categoryTemplate.content.cloneNode(true);
        
        // Replace placeholders in the category template
        const categoryHtml = categoryContent.firstElementChild.outerHTML
            .replace(/{id}/g, category.id)
            .replace(/{name}/g, category.name);
        
        const categoryElement = $(categoryHtml);
        const subcategoriesContainer = categoryElement.find('.subcategories-container');
        
        // Add subcategories
        if (category.subcategories && category.subcategories.length > 0) {
            category.subcategories.forEach(function(subcategory) {
                // Clone the subcategory template
                const subcategoryContent = subcategoryTemplate.content.cloneNode(true);
                
                // Replace placeholders in the subcategory template
                const subcategoryHtml = subcategoryContent.firstElementChild.outerHTML
                    .replace(/{id}/g, subcategory.id)
                    .replace(/{name}/g, subcategory.name);
                
                subcategoriesContainer.append(subcategoryHtml);
            });
        } else {
            subcategoriesContainer.append('<li class="list-group-item text-muted">No subcategories available</li>');
        }
        
        categoriesList.append(categoryElement);
    });
}

// Function to load products for a category
function loadProducts(categoryId, categoryName) {
    $('#selectedCategoryName').text(categoryName);
    $('#productsContainer').removeClass('d-none');
    
    const productsList = $('#productsList');
    productsList.html(`
        <div class="text-center p-3">
            <div class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <span class="ms-2">Loading products...</span>
        </div>
    `);
    
    $.ajax({
        url: `/api/order-products/${categoryId}`,
        method: 'GET',
        success: function(response) {
            renderProducts(response);
        },
        error: function(xhr) {
            console.error('Error loading products:', xhr);
            productsList.html('<div class="alert alert-danger m-3">Failed to load products</div>');
        }
    });
}

// Function to render products using template
function renderProducts(products) {
    const productsList = $('#productsList');
    productsList.empty();
    
    if (!products || products.length === 0) {
        productsList.html('<div class="alert alert-info m-3">No products available in this category</div>');
        return;
    }
    
    // Get the product template
    const productTemplate = document.getElementById('productTemplate');
    
    if (!productTemplate) {
        console.error('Product template not found');
        productsList.html('<div class="alert alert-danger m-3">Product template not found</div>');
        return;
    }
    
    // Create and append product elements
    products.forEach(function(product) {
        // Clone the product template
        const productContent = productTemplate.content.cloneNode(true);
        
        // Replace placeholders in the product template
        let productHtml = productContent.firstElementChild.outerHTML;
        
        // Replace all placeholders with actual values
        for (const [key, value] of Object.entries(product)) {
            const regex = new RegExp(`{${key}}`, 'g');
            productHtml = productHtml.replace(regex, value || '');
        }
        
        // Add any missing placeholders
        productHtml = productHtml.replace(/{[^}]+}/g, '');
        
        productsList.append(productHtml);
    });
}

// Function to show toast notification
function showToast(message, type = 'info') {
    const toast = `
        <div class="toast align-items-center text-white bg-${type} border-0 position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;
    
    const toastElement = $(toast);
    $('body').append(toastElement);
    
    const bsToast = new bootstrap.Toast(toastElement[0], {
        delay: 3000
    });
    
    bsToast.show();
    
    // Remove toast from DOM after it's hidden
    toastElement.on('hidden.bs.toast', function() {
        $(this).remove();
    });
}
