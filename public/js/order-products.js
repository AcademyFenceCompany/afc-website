document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const productSearchInput = document.getElementById('productSearch');
    const searchProductBtn = document.getElementById('searchProductBtn');
    const searchResultsContainer = document.getElementById('searchResults');
    const itemNumberDirectInput = document.getElementById('itemNumberDirect');
    const addByItemBtn = document.getElementById('addByItemBtn');
    const orderItemsTableBody = document.getElementById('orderItemsTableBody');
    const subtotalDisplay = document.getElementById('subtotal-display');
    
    // Variables to track order state
    let orderItems = [];
    let subtotal = 0;
    
    // Event listeners
    searchProductBtn.addEventListener('click', searchProducts);
    productSearchInput.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            searchProducts();
        }
        
        // Auto-search after 3 characters
        if (productSearchInput.value.length >= 3) {
            searchProducts();
        }
    });
    
    addByItemBtn.addEventListener('click', function() {
        const itemNumber = itemNumberDirectInput.value.trim();
        if (itemNumber) {
            fetchProductByItemNumber(itemNumber);
            itemNumberDirectInput.value = '';
        }
    });
    
    itemNumberDirectInput.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            addByItemBtn.click();
        }
    });
    
    document.addEventListener('click', function(e) {
        // Close search results if clicking outside
        if (!searchResultsContainer.contains(e.target) && e.target !== productSearchInput) {
            searchResultsContainer.classList.add('d-none');
        }
    });
    
    // Functions
    function searchProducts() {
        const searchTerm = productSearchInput.value.trim();
        if (searchTerm.length < 2) return;
        
        fetch(`/api/products/search?term=${encodeURIComponent(searchTerm)}`)
            .then(response => response.json())
            .then(data => {
                displaySearchResults(data);
            })
            .catch(error => {
                console.error('Error searching products:', error);
            });
    }
    
    function displaySearchResults(products) {
        if (products.length === 0) {
            searchResultsContainer.innerHTML = '<div class="p-2 text-center">No products found</div>';
            searchResultsContainer.classList.remove('d-none');
            return;
        }
        
        let html = '';
        products.forEach(product => {
            html += `
                <div class="product-result p-2 border-bottom" data-product='${JSON.stringify(product)}'>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>${product.item_no}</strong> - ${product.product_name}
                            <div class="small text-muted">
                                ${product.color ? 'Color: ' + product.color : ''} 
                                ${product.size ? 'Size: ' + product.size : ''}
                                ${product.inv_stocked ? 'In Stock: ' + product.inv_stocked : ''}
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold">$${parseFloat(product.price).toFixed(2)}</div>
                        </div>
                    </div>
                </div>
            `;
        });
        
        searchResultsContainer.innerHTML = html;
        searchResultsContainer.classList.remove('d-none');
        
        // Add click event to each product result
        document.querySelectorAll('.product-result').forEach(result => {
            result.addEventListener('click', function() {
                const product = JSON.parse(this.dataset.product);
                addProductToOrder(product);
                searchResultsContainer.classList.add('d-none');
                productSearchInput.value = '';
            });
        });
    }
    
    function fetchProductByItemNumber(itemNumber) {
        fetch(`/api/products/item/${encodeURIComponent(itemNumber)}`)
            .then(response => response.json())
            .then(data => {
                if (data) {
                    addProductToOrder(data);
                } else {
                    alert('Product not found with Item #: ' + itemNumber);
                }
            })
            .catch(error => {
                console.error('Error fetching product:', error);
            });
    }
    
    function addProductToOrder(product) {
        // Check if product already exists in order
        const existingItemIndex = orderItems.findIndex(item => item.id === product.id);
        
        if (existingItemIndex !== -1) {
            // Increment quantity if product already exists
            orderItems[existingItemIndex].quantity++;
            orderItems[existingItemIndex].total = orderItems[existingItemIndex].quantity * orderItems[existingItemIndex].price;
            updateOrderItemRow(existingItemIndex);
        } else {
            // Add new product to order
            const orderItem = {
                id: product.id,
                item_no: product.item_no,
                product_name: product.product_name,
                color: product.color || '',
                size: product.size || '',
                size2: product.size2 || '',
                weight_lbs: product.weight_lbs || 0,
                price: parseFloat(product.price),
                quantity: 1,
                inv_stocked: product.inv_stocked || 0,
                total: parseFloat(product.price),
                // Store all product data for potential use
                product_data: product
            };
            
            orderItems.push(orderItem);
            addOrderItemRow(orderItems.length - 1);
        }
        
        updateOrderTotals();
    }
    
    function addOrderItemRow(index) {
        const item = orderItems[index];
        const newRow = document.createElement('tr');
        newRow.dataset.index = index;
        newRow.innerHTML = `
            <td>${item.item_no}</td>
            <td>
                ${item.product_name}
                <div class="small text-muted">
                    ${item.color ? 'Color: ' + item.color : ''} 
                    ${item.size ? 'Size: ' + item.size : ''}
                    ${item.size2 ? 'Size 2: ' + item.size2 : ''}
                    ${item.weight_lbs ? 'Weight: ' + item.weight_lbs + ' lbs' : ''}
                </div>
            </td>
            <td>$${item.price.toFixed(2)}</td>
            <td>
                <div class="input-group input-group-sm quantity-control">
                    <button class="btn btn-outline-secondary quantity-decrease" type="button">-</button>
                    <input type="number" class="form-control text-center quantity-input" value="${item.quantity}" min="1" style="width: 60px;">
                    <button class="btn btn-outline-secondary quantity-increase" type="button">+</button>
                </div>
                <div class="small text-muted mt-1">In Stock: ${item.inv_stocked}</div>
            </td>
            <td class="item-total">$${item.total.toFixed(2)}</td>
            <td>
                <button class="btn btn-sm btn-danger remove-item" type="button">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;
        
        orderItemsTableBody.appendChild(newRow);
        
        // Add event listeners for the new row
        setupRowEventListeners(newRow);
    }
    
    function updateOrderItemRow(index) {
        const item = orderItems[index];
        const row = orderItemsTableBody.querySelector(`tr[data-index="${index}"]`);
        
        if (row) {
            const quantityInput = row.querySelector('.quantity-input');
            const itemTotal = row.querySelector('.item-total');
            
            quantityInput.value = item.quantity;
            itemTotal.textContent = '$' + item.total.toFixed(2);
        }
    }
    
    function setupRowEventListeners(row) {
        const index = parseInt(row.dataset.index);
        const quantityInput = row.querySelector('.quantity-input');
        const decreaseBtn = row.querySelector('.quantity-decrease');
        const increaseBtn = row.querySelector('.quantity-increase');
        const removeBtn = row.querySelector('.remove-item');
        
        quantityInput.addEventListener('change', function() {
            updateItemQuantity(index, parseInt(this.value) || 1);
        });
        
        decreaseBtn.addEventListener('click', function() {
            if (orderItems[index].quantity > 1) {
                updateItemQuantity(index, orderItems[index].quantity - 1);
            }
        });
        
        increaseBtn.addEventListener('click', function() {
            updateItemQuantity(index, orderItems[index].quantity + 1);
        });
        
        removeBtn.addEventListener('click', function() {
            removeOrderItem(index);
        });
    }
    
    function updateItemQuantity(index, newQuantity) {
        if (newQuantity < 1) newQuantity = 1;
        
        orderItems[index].quantity = newQuantity;
        orderItems[index].total = newQuantity * orderItems[index].price;
        
        updateOrderItemRow(index);
        updateOrderTotals();
    }
    
    function removeOrderItem(index) {
        // Remove from array
        orderItems.splice(index, 1);
        
        // Remove row from table
        const row = orderItemsTableBody.querySelector(`tr[data-index="${index}"]`);
        if (row) {
            row.remove();
        }
        
        // Update indices for remaining rows
        const rows = orderItemsTableBody.querySelectorAll('tr');
        rows.forEach((row, i) => {
            row.dataset.index = i;
        });
        
        updateOrderTotals();
    }
    
    function updateOrderTotals() {
        // Calculate subtotal
        subtotal = orderItems.reduce((sum, item) => sum + item.total, 0);
        
        // Update display
        subtotalDisplay.textContent = '$' + subtotal.toFixed(2);
        
        // Update hidden input for form submission
        const orderItemsInput = document.getElementById('orderItemsInput');
        if (orderItemsInput) {
            orderItemsInput.value = JSON.stringify(orderItems);
        } else {
            // Create hidden input if it doesn't exist
            const input = document.createElement('input');
            input.type = 'hidden';
            input.id = 'orderItemsInput';
            input.name = 'order_items';
            input.value = JSON.stringify(orderItems);
            document.getElementById('orderForm').appendChild(input);
        }
        
        // Trigger tax calculation if needed
        if (typeof calculateOrderTotals === 'function') {
            calculateOrderTotals();
        }
    }
});
