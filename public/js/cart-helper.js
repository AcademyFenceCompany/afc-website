/**
 * AFC Website - Cart Helper
 * Standardizes cart buttons across all product types
 */

// Initialize cart functionality
document.addEventListener("DOMContentLoaded", function() {
    console.log("Cart Helper initialized");
    
    // Standard "Add to Cart" button data attributes helper
    function standardizeCartButtons() {
        document.querySelectorAll('.btn-add-cart').forEach(button => {
            // Make sure it has the add-to-cart-btn class
            if (!button.classList.contains('add-to-cart-btn')) {
                button.classList.add('add-to-cart-btn');
                console.log("Added add-to-cart-btn class to button");
            }
            
            // Make sure it has at least the minimum required data attributes
            if (!button.dataset.item_no && button.dataset.item) {
                button.dataset.item_no = button.dataset.item;
                console.log("Converted data-item to data-item_no");
            }
            
            if (!button.dataset.product_name && button.dataset.name) {
                button.dataset.product_name = button.dataset.name;
                console.log("Converted data-name to data-product_name");
            }
        });
    }
    
    // Run immediately
    standardizeCartButtons();
    
    // Also run when DOM changes
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length) {
                standardizeCartButtons();
            }
        });
    });
    
    observer.observe(document.body, { 
        childList: true, 
        subtree: true 
    });
});
