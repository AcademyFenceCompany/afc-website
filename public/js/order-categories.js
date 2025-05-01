$(document).ready(function() {
    // Load categories when the page loads
    loadCategories();
});

// Function to load categories via AJAX
function loadCategories() {
    $.ajax({
        url: '/ams/api/order-categories',
        method: 'GET',
        success: function(response) {
            renderCategories(response);
        },
        error: function(xhr) {
            console.error('Error loading categories:', xhr);
            $('#categoriesList').html('<div class="alert alert-danger m-3">Failed to load categories</div>');
        }
    });
}

// Function to render categories
function renderCategories(categories) {
    const categoriesList = $('#categoriesList');
    categoriesList.empty();
    
    if (categories.length === 0) {
        categoriesList.html('<div class="alert alert-info m-3">No categories available</div>');
        return;
    }
    
    categories.forEach(function(category, index) {
        // Create category card
        const categoryCard = $('<div class="card mb-2"></div>');
        
        // Create card header
        const cardHeader = $('<div class="card-header"></div>').attr('id', 'category-' + category.id);
        
        // Create heading
        const heading = $('<h5 class="mb-0"></h5>');
        
        // Create accordion button
        const button = $('<button class="accordion-button collapsed" type="button"></button>')
            .attr('data-bs-toggle', 'collapse')
            .attr('data-bs-target', '#collapse-' + category.id)
            .attr('aria-expanded', 'false')
            .attr('aria-controls', 'collapse-' + category.id)
            .text(category.name);
        
        // Create collapse div
        const collapseDiv = $('<div class="collapse"></div>')
            .attr('id', 'collapse-' + category.id)
            .attr('aria-labelledby', 'category-' + category.id);
        
        // Create subcategories list
        const subcategoriesList = $('<ul class="list-group list-group-flush"></ul>');
        
        // Add subcategories if available
        if (category.subcategories && category.subcategories.length > 0) {
            category.subcategories.forEach(function(subcategory) {
                const subcategoryItem = $('<li class="list-group-item subcategory-item"></li>')
                    .attr('data-id', subcategory.id);
                
                const subcategoryName = $('<span class="subcategory-name"></span>')
                    .text(subcategory.name);
                
                subcategoryItem.append(subcategoryName);
                subcategoriesList.append(subcategoryItem);
            });
        } else {
            subcategoriesList.append('<li class="list-group-item text-muted">No subcategories available</li>');
        }
        
        // Assemble the category card
        heading.append(button);
        cardHeader.append(heading);
        collapseDiv.append(subcategoriesList);
        categoryCard.append(cardHeader);
        categoryCard.append(collapseDiv);
        
        // Add to categories list
        categoriesList.append(categoryCard);
    });
    
    // Initialize Bootstrap accordions
    const accordionElements = document.querySelectorAll('.accordion-button');
    accordionElements.forEach(function(element) {
        element.addEventListener('click', function() {
            const target = document.querySelector(this.getAttribute('data-bs-target'));
            if (target.classList.contains('show')) {
                target.classList.remove('show');
                this.classList.add('collapsed');
                this.setAttribute('aria-expanded', 'false');
            } else {
                target.classList.add('show');
                this.classList.remove('collapsed');
                this.setAttribute('aria-expanded', 'true');
            }
        });
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
