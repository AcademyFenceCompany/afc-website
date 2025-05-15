document.addEventListener('DOMContentLoaded', function() {
    console.log('Order Products JS Loaded');
    
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
    
    // Load saved order items from localStorage
    const savedOrderItems = localStorage.getItem('orderItems');
    if (savedOrderItems) {
        try {
            orderItems = JSON.parse(savedOrderItems);
            console.log('Loaded order items from localStorage:', orderItems);
            
            // Populate the order items table with saved items
            orderItems.forEach((item, index) => {
                addOrderItemRow(index);
            });
            
            updateOrderTotals();
        } catch (e) {
            console.error('Error parsing saved order items:', e);
            localStorage.removeItem('orderItems');
        }
    }
    
    // Event listeners
    if (searchProductBtn) {
        searchProductBtn.addEventListener('click', searchProducts);
    }
    
    if (productSearchInput) {
        productSearchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                searchProducts();
            }
            
            // Auto-search after 3 characters
            if (productSearchInput.value.length >= 3) {
                searchProducts();
            }
        });
    }
    
    if (addByItemBtn) {
        addByItemBtn.addEventListener('click', function() {
            const itemNumber = itemNumberDirectInput.value.trim();
            if (itemNumber) {
                fetchProductByItemNumber(itemNumber);
                itemNumberDirectInput.value = '';
            }
        });
    }
    
    if (itemNumberDirectInput) {
        itemNumberDirectInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                addByItemBtn.click();
            }
        });
    }
    
    document.addEventListener('click', function(e) {
        // Close search results if clicking outside
        if (searchResultsContainer && !searchResultsContainer.contains(e.target) && e.target !== productSearchInput) {
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
        if (!searchResultsContainer) return;
        
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
            .then(response => {
                if (!response.ok) {
                    if (response.status === 404) {
                        throw new Error('Product not found');
                    }
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data) {
                    addProductToOrder(data);
                } else {
                    alert('Product not found with Item #: ' + itemNumber);
                }
            })
            .catch(error => {
                console.error('Error fetching product:', error);
                alert('Product not found with Item #: ' + itemNumber);
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
        saveOrderItemsToLocalStorage();
    }
    
    function addOrderItemRow(index) {
        if (!orderItemsTableBody) return;
        
        const item = orderItems[index];
        const newRow = document.createElement('tr');
        newRow.dataset.index = index;
        newRow.innerHTML = `
            <td>
                <input type="text" class="form-control form-control-sm editable-field" data-field="item_no" value="${item.item_no}">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm editable-field" data-field="product_name" value="${item.product_name}">
                <div class="row mt-2">
                    <div class="col-6">
                        <input type="text" class="form-control form-control-sm editable-field" data-field="color" placeholder="Color" value="${item.color}">
                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control form-control-sm editable-field" data-field="size" placeholder="Size" value="${item.size}">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6">
                        <input type="text" class="form-control form-control-sm editable-field" data-field="size2" placeholder="Size 2" value="${item.size2}">
                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control form-control-sm editable-field" data-field="weight_lbs" placeholder="Weight (lbs)" value="${item.weight_lbs}">
                    </div>
                </div>
            </td>
            <td>
                <input type="number" class="form-control form-control-sm editable-field" data-field="price" value="${item.price.toFixed(2)}" step="0.01" min="0">
            </td>
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
        if (!orderItemsTableBody) return;
        
        const item = orderItems[index];
        const row = orderItemsTableBody.querySelector(`tr[data-index="${index}"]`);
        
        if (row) {
            const quantityInput = row.querySelector('.quantity-input');
            const itemTotal = row.querySelector('.item-total');
            const priceInput = row.querySelector('[data-field="price"]');
            
            quantityInput.value = item.quantity;
            priceInput.value = item.price.toFixed(2);
            itemTotal.textContent = '$' + item.total.toFixed(2);
            
            // Update all editable fields
            row.querySelectorAll('.editable-field').forEach(field => {
                const fieldName = field.dataset.field;
                if (fieldName && item[fieldName] !== undefined) {
                    field.value = fieldName === 'price' ? item[fieldName].toFixed(2) : item[fieldName];
                }
            });
        }
    }
    
    function setupRowEventListeners(row) {
        const index = parseInt(row.dataset.index);
        const quantityInput = row.querySelector('.quantity-input');
        const decreaseBtn = row.querySelector('.quantity-decrease');
        const increaseBtn = row.querySelector('.quantity-increase');
        const removeBtn = row.querySelector('.remove-item');
        
        // Quantity change events
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
        
        // Remove button event
        removeBtn.addEventListener('click', function() {
            removeOrderItem(index);
        });
        
        // Editable fields events
        row.querySelectorAll('.editable-field').forEach(field => {
            field.addEventListener('change', function() {
                const fieldName = this.dataset.field;
                let value = this.value;
                
                // Convert numeric fields to numbers
                if (fieldName === 'price' || fieldName === 'weight_lbs') {
                    value = parseFloat(value) || 0;
                }
                
                // Update the order item
                orderItems[index][fieldName] = value;
                
                // If price changed, recalculate total
                if (fieldName === 'price') {
                    orderItems[index].total = orderItems[index].quantity * value;
                    row.querySelector('.item-total').textContent = '$' + orderItems[index].total.toFixed(2);
                }
                
                updateOrderTotals();
                saveOrderItemsToLocalStorage();
            });
        });
    }
    
    function updateItemQuantity(index, newQuantity) {
        if (newQuantity < 1) newQuantity = 1;
        
        orderItems[index].quantity = newQuantity;
        orderItems[index].total = newQuantity * orderItems[index].price;
        
        updateOrderItemRow(index);
        updateOrderTotals();
        saveOrderItemsToLocalStorage();
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
        saveOrderItemsToLocalStorage();
    }
    
    function updateOrderTotals() {
        // Calculate subtotal
        const subtotal = orderItems.reduce((sum, item) => sum + item.total, 0);
        
        // Update display
        if (subtotalDisplay) {
            subtotalDisplay.textContent = '$' + subtotal.toFixed(2);
        }
        
        // Update hidden input for form submission
        const orderItemsInput = document.getElementById('orderItemsInput');
        if (orderItemsInput) {
            orderItemsInput.value = JSON.stringify(orderItems);
        }
        
        // Trigger tax calculation if needed
        if (typeof calculateOrderTotals === 'function') {
            calculateOrderTotals();
        }
    }
    
    function saveOrderItemsToLocalStorage() {
        try {
            localStorage.setItem('orderItems', JSON.stringify(orderItems));
            console.log('Saved order items to localStorage:', orderItems);
        } catch (e) {
            console.error('Error saving order items to localStorage:', e);
        }
    }
    
    // Add clear order function that can be called from outside
    window.clearOrderItems = function() {
        orderItems = [];
        if (orderItemsTableBody) {
            orderItemsTableBody.innerHTML = '';
        }
        updateOrderTotals();
        saveOrderItemsToLocalStorage();
    };
    
    // Add a function to handle shipping calculation
    window.calculateShipping = function() {
        console.log('Calculate shipping called');
        
        // Check if we have items to ship
        if (orderItems.length === 0) {
            alert('Please add items to the order before calculating shipping.');
            return;
        }
        
        // Get shipping address from form (from the Shipping Information section)
        const shippingAddress = document.getElementById('shipping-address');
        const shippingCity = document.getElementById('shipping-city');
        const shippingState = document.getElementById('shipping-state');
        const shippingZip = document.getElementById('shipping-zip');

        if (!shippingAddress || !shippingCity || !shippingState || !shippingZip) {
            console.error('Shipping address fields not found:', {
                shippingAddress,
                shippingCity,
                shippingState,
                shippingZip
            });
            alert('Please fill in the shipping address before calculating shipping.');
            return;
        }

        const address = shippingAddress.value;
        const city = shippingCity.value;
        const state = shippingState.value;
        const zip = shippingZip.value;

        console.log('Shipping address values:', { address, city, state, zip });

        if (!address || !city || !state || !zip) {
            alert('Please fill in all shipping address fields before calculating shipping.');
            return;
        }
        
        // Prepare packages data for shipping APIs
        const packages = [];
        let totalWeight = 0;
        
        orderItems.forEach(item => {
            const weight = parseFloat(item.weight_lbs) || 0;
            const quantity = parseInt(item.quantity) || 1;
            
            // Calculate total weight
            totalWeight += weight * quantity;
            
            // Get shipping dimensions from product data
            const productData = item.product_data || {};
            const shipLength = parseFloat(productData.ship_length) || 12;
            const shipWidth = parseFloat(productData.ship_width) || 12;
            const shipHeight = parseFloat(productData.ship_height) || 12;
            
            // Add package details for each quantity
            for (let i = 0; i < quantity; i++) {
                packages.push({
                    weight: weight.toFixed(2),
                    dimensions: {
                        length: shipLength.toFixed(2),
                        width: shipWidth.toFixed(2),
                        height: shipHeight.toFixed(2),
                    },
                    product_data: productData
                });
            }
        });
        
        console.log('Packages for shipping calculation:', packages);
        console.log('Total weight:', totalWeight);
        
        // Show shipping modal
        const shippingModal = document.getElementById('shippingModal');
        if (shippingModal) {
            const bsModal = new bootstrap.Modal(shippingModal);
            bsModal.show();
            
            // Show loading state
            const shippingRates = document.getElementById('shippingRates');
            if (shippingRates) {
                shippingRates.innerHTML = `
                    <div class="text-center p-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Calculating shipping rates...</p>
                    </div>
                `;
            }
            
            // Always fetch both UPS and freight rates
            fetchUPSRates(address, city, state, zip, packages);
            fetchFreightRates(address, city, state, zip, packages);
        } else {
            console.error('Shipping modal not found in the DOM');
            alert('Shipping modal not found. Please check the console for errors.');
        }
    };
    
    // Add a function to delete shipping
    window.deleteShipping = function() {
        // Reset shipping cost
        const shippingCostValue = document.getElementById('shipping-cost-value');
        if (shippingCostValue) {
            shippingCostValue.value = '0.00';
        }
        
        const shippingCostInput = document.getElementById('shipping-cost');
        if (shippingCostInput) {
            shippingCostInput.value = '0';
        }
        
        const shippingMethodInput = document.getElementById('shipping-method');
        if (shippingMethodInput) {
            shippingMethodInput.value = '';
        }
        
        // Update shipping display
        const shippingDisplay = document.getElementById('shipping-display');
        if (shippingDisplay) {
            shippingDisplay.textContent = '$0.00';
        }
        
        // Update order totals
        if (typeof calculateOrderTotals === 'function') {
            calculateOrderTotals();
        }
    };
    
    function fetchUPSRates(address, city, state, zip, packages) {
        console.log('Fetching UPS rates...');
        
        fetch('/api/ups-rates', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                recipient_address: address,
                recipient_city: city,
                recipient_state: state,
                recipient_postal: zip,
                packages: packages,
            }),
        })
        .then(response => response.json())
        .then(data => {
            console.log('UPS rates response:', data);
            displayUPSRates(data);
        })
        .catch(error => {
            console.error('Error fetching UPS rates:', error);
            const shippingRates = document.getElementById('shippingRates');
            if (shippingRates) {
                shippingRates.innerHTML = `
                    <div class="alert alert-danger">
                        Failed to fetch shipping rates. Please try again.
                    </div>
                `;
            }
        });
    }
    
    function fetchFreightRates(address, city, state, zip, packages) {
        console.log('Fetching freight rates...');
        
        // First try TForce
        fetch('/api/tforce-rates', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                recipient_address: address,
                recipient_city: city,
                recipient_state: state,
                recipient_postal: zip,
                packages: packages,
            }),
        })
        .then(response => response.json())
        .then(tforceData => {
            console.log('TForce rates response:', tforceData);
            
            // Then try R&L Carriers
            fetch('/api/rl-carriers-rates', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    recipient_address: address,
                    recipient_city: city,
                    recipient_state: state,
                    recipient_postal: zip,
                    packages: packages,
                }),
            })
            .then(response => response.json())
            .then(rlData => {
                console.log('R&L Carriers rates response:', rlData);
                // Display both sets of rates
                displayFreightRates(tforceData, rlData);
            })
            .catch(error => {
                // Still display TForce rates if R&L fails
                console.error('Error fetching R&L rates:', error);
                displayFreightRates(tforceData, null);
            });
        })
        .catch(error => {
            console.error('Error fetching TForce rates:', error);
            const shippingRates = document.getElementById('shippingRates');
            if (shippingRates) {
                shippingRates.innerHTML = `
                    <div class="alert alert-danger">
                        Failed to fetch freight shipping rates. Please try again.
                    </div>
                `;
            }
        });
    }
    
    function displayUPSRates(upsResponse) {
        console.log('UPS rates response:', upsResponse);
        
        const ratesContainer = document.getElementById('shippingRates');
        const upsShippingTable = document.getElementById('upsShippingTable');
        const upsShippingTotals = document.getElementById('upsShippingTotals');
        
        if (!ratesContainer || !upsShippingTable || !upsShippingTotals) {
            console.error('UPS shipping containers not found');
            return;
        }
        
        // Clear previous content
        upsShippingTable.innerHTML = '';
        upsShippingTotals.innerHTML = '';
        
        if (upsResponse.RateResponse && upsResponse.RateResponse.RatedShipment && upsResponse.RateResponse.RatedShipment.length > 0) {
            // Find UPS Ground rate (Service Code '03')
            const upsGroundRate = upsResponse.RateResponse.RatedShipment.find(shipment => shipment.Service.Code === '03');
            
            if (upsGroundRate) {
                const baseCharge = parseFloat(upsGroundRate.TotalCharges.MonetaryValue);
                const boxPrice = 5.00; // $5 per box
                
                // Group order items by product
                const productGroups = {};
                orderItems.forEach(item => {
                    const productId = item.id || item.product_id;
                    if (!productGroups[productId]) {
                        productGroups[productId] = {
                            ...item,
                            totalQuantity: 0,
                            totalWeight: 0
                        };
                    }
                    productGroups[productId].totalQuantity += parseInt(item.quantity) || 1;
                    productGroups[productId].totalWeight += (parseFloat(item.weight_lbs) || 0) * (parseInt(item.quantity) || 1);
                });
                
                // Calculate total weight and box count
                let totalWeight = 0;
                let totalBoxes = 0;
                let rowIndex = 1;
                
                // Add rows for each product
                Object.values(productGroups).forEach(product => {
                    const productWeight = parseFloat(product.weight_lbs) || 0;
                    const quantity = product.totalQuantity;
                    const amountPerBox = parseInt(product.product_data?.amount_per_box) || 1;
                    const boxCount = Math.ceil(quantity / amountPerBox);
                    
                    totalWeight += product.totalWeight;
                    totalBoxes += boxCount;
                    
                    // Calculate proportional shipping cost for this product
                    const productShippingCost = (baseCharge * (product.totalWeight / getTotalWeight())).toFixed(2);
                    
                    // Add row for each box
                    for (let i = 0; i < boxCount; i++) {
                        const qtyInThisBox = (i === boxCount - 1 && quantity % amountPerBox !== 0) 
                            ? quantity % amountPerBox 
                            : amountPerBox;
                        
                        const boxWeight = productWeight * qtyInThisBox;
                        
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${rowIndex}</td>
                            <td>${product.product_data?.class || 'WWF'}</td>
                            <td>${product.size || product.product_data?.size || '18x49x18'}</td>
                            <td>${amountPerBox}</td>
                            <td>${boxWeight.toFixed(2)} lbs</td>
                            <td>$${(productShippingCost / boxCount).toFixed(2)}</td>
                            <td>${product.product_name} (${product.product_data?.item_no})</td>
                        `;
                        
                        upsShippingTable.appendChild(row);
                        rowIndex++;
                    }
                });
                
                // Calculate markup and total price
                const markup = baseCharge * 0.33; // 33% markup
                const boxesTotal = totalBoxes * boxPrice;
                const totalPrice = baseCharge + markup + boxesTotal;
                
                // Add totals row
                const totalsRow = document.createElement('tr');
                totalsRow.innerHTML = `
                    <td>${totalWeight.toFixed(2)} lbs</td>
                    <td>$${baseCharge.toFixed(2)}</td>
                    <td>$${boxesTotal.toFixed(2)} (${totalBoxes} boxes)</td>
                    <td>$${markup.toFixed(2)}</td>
                    <td>$${totalPrice.toFixed(2)}</td>
                `;
                
                upsShippingTotals.appendChild(totalsRow);
                
                // Add UPS Ground option to rates container
                ratesContainer.innerHTML = `
                    <div class="list-group mb-3">
                        <label class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <input class="form-check-input me-2 shipping-option" type="radio" name="shipping_option" 
                                    value="UPS Ground" data-charge="${totalPrice.toFixed(2)}" 
                                    data-carrier="UPS" data-service="Ground" data-transit-days="3-5"
                                    data-base-cost="${baseCharge.toFixed(2)}" data-weight="${totalWeight.toFixed(2)}"
                                    data-class="" data-zip="${document.getElementById('shipping-zip')?.value || ''}"
                                    data-packages="${totalBoxes}" checked>
                                UPS Ground
                            </div>
                            <span class="badge bg-primary rounded-pill">$${totalPrice.toFixed(2)}</span>
                        </label>
                    </div>
                `;
                
                // Pre-populate the Shipping Estimate Organizer
                
                populateShippingEstimateOrganizer({
                    carrier: 'UPS',
                    weight: totalWeight.toFixed(2),
                    // class: Object.values(productGroups)[0].class,
                    cost: totalPrice.toFixed(2),
                    zip: document.getElementById('shipping-zip')?.value || '',
                    packages: totalBoxes
                });
                
                // Trigger the change event to ensure the shipping option is selected
                const shippingOption = document.querySelector('.shipping-option');
                if (shippingOption) {
                    const event = new Event('change');
                    shippingOption.dispatchEvent(event);
                }
            } else {
                ratesContainer.innerHTML = `
                    <div class="alert alert-warning">
                        No UPS Ground shipping rates available for this address and package configuration.
                    </div>
                `;
            }
        } else {
            ratesContainer.innerHTML = `
                <div class="alert alert-warning">
                    No UPS shipping rates available for this address and package configuration.
                </div>
            `;
        }
    }

    function displayFreightRates(tforceData, rlData) {
        console.log('TForce data:', tforceData);
        console.log('R&L data:', rlData);
        
        const ratesContainer = document.getElementById('shippingRates');
        const freightShippingTable = document.getElementById('freightShippingTable');
        
        if (!ratesContainer || !freightShippingTable) {
            console.error('Freight shipping containers not found');
            return;
        }
        
        // Clear previous content
        freightShippingTable.innerHTML = '';
        
        // Get existing rates HTML or create new
        let ratesHtml = ratesContainer.innerHTML || '<div class="list-group mb-3">';
        
        let hasRates = false;
        
        // Calculate pallet quantity based on product count
        const productCount = orderItems.length;
        const palletQty = Math.ceil(productCount / 4); // 4 products per pallet
        const palletSize = '49x48x54'; // Standard pallet size
        
        // Process TForce rates
        if (tforceData && tforceData.summary && tforceData.detail && tforceData.detail.length > 0) {
            hasRates = true;
            
            tforceData.detail.forEach((shipment) => {
                // Get total charge from shipmentCharges
                const totalCharge = parseFloat(shipment.shipmentCharges?.total?.value || 0);
                
                // Get service description
                const serviceName = shipment.service?.description || 'TForce Freight LTL';
                
                // Get quote number
                const quoteNumber = tforceData.summary?.quoteNumber || 'N/A';
                
                // Get billable weight
                const weight = shipment.shipmentWeights?.billable?.value || getTotalWeight().toFixed(2);
                
                // Get base charge (LND_GROSS)
                let baseCharge = 0;
                if (shipment.rate) {
                    const lndGrossRate = shipment.rate.find(r => r.code === 'LND_GROSS');
                    if (lndGrossRate) {
                        baseCharge = parseFloat(lndGrossRate.value);
                    }
                }
                
                // Calculate markup (33%)
                const markup = totalCharge * 0.33;
                const finalCharge = totalCharge + markup;
                
                // Add row to freight shipping table
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>
                        <input type="radio" name="freight_option" class="freight-option" 
                            data-carrier="TForce" data-weight="${weight}" data-class="50"
                            data-cost="${finalCharge.toFixed(2)}" data-zip="${document.getElementById('shipping-zip')?.value || ''}"
                            data-quote-number="${quoteNumber}" data-packages="${palletQty}">
                    </td>
                    <td>TForce</td>
                    <td>${weight} lbs</td>
                    <td>$${totalCharge.toFixed(2)}</td>
                    <td>$${markup.toFixed(2)}</td>
                    <td>$${finalCharge.toFixed(2)}</td>
                    <td>${document.getElementById('shipping-city')?.value || ''}, ${document.getElementById('shipping-state')?.value || ''}</td>
                    <td>${quoteNumber}</td>
                    <td>${palletQty}</td>
                    <td>${palletSize}</td>
                `;
                
                freightShippingTable.appendChild(row);
                
                // Add to rates list
                ratesHtml += `
                    <label class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <input class="form-check-input me-2 shipping-option" type="radio" name="shipping_option" 
                                value="${serviceName}" data-charge="${finalCharge.toFixed(2)}"
                                data-carrier="TForce" data-service="${serviceName}" data-transit-days="1-2"
                                data-quote-number="${quoteNumber}" data-base-cost="${totalCharge.toFixed(2)}"
                                data-weight="${weight}" data-class="50" 
                                data-zip="${document.getElementById('shipping-zip')?.value || ''}"
                                data-packages="${palletQty}">
                            ${serviceName}
                        </div>
                        <span class="badge bg-primary rounded-pill">$${finalCharge.toFixed(2)}</span>
                    </label>
                `;
            });
        }
        
        // Process R&L Carriers rates
        if (rlData && rlData.d && rlData.d.Result && rlData.d.Result.ServiceLevels && rlData.d.Result.ServiceLevels.length > 0) {
            hasRates = true;
            
            rlData.d.Result.ServiceLevels.forEach(service => {
                const serviceTitle = service.Title || 'Standard Service';
                
                // Remove $ and convert to number
                const netCharge = parseFloat(service.NetCharge.replace('$', '')) || 0;
                
                // Apply markups (33%)
                const markup = netCharge * 0.33;
                const finalCharge = netCharge + markup;
                
                // Get service days
                const serviceDays = service.ServiceDays || '1';
                
                // Add row to freight shipping table
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>
                        <input type="radio" name="freight_option" class="freight-option" 
                            data-carrier="R+L Carriers" data-weight="${getTotalWeight().toFixed(2)}" data-class="50"
                            data-cost="${finalCharge.toFixed(2)}" data-zip="${document.getElementById('shipping-zip')?.value || ''}"
                            data-quote-number="N/A" data-packages="${palletQty}">
                    </td>
                    <td>R+L Carriers</td>
                    <td>${getTotalWeight().toFixed(2)} lbs</td>
                    <td>$${netCharge.toFixed(2)}</td>
                    <td>$${markup.toFixed(2)}</td>
                    <td>$${finalCharge.toFixed(2)}</td>
                    <td>${document.getElementById('shipping-city')?.value || ''}, ${document.getElementById('shipping-state')?.value || ''}</td>
                    <td>N/A</td>
                    <td>${palletQty}</td>
                    <td>${palletSize}</td>
                `;
                
                freightShippingTable.appendChild(row);
                
                // Add to rates list
                ratesHtml += `
                    <label class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <input class="form-check-input me-2 shipping-option" type="radio" name="shipping_option" 
                                value="R&L ${serviceTitle}" data-charge="${finalCharge.toFixed(2)}"
                                data-carrier="R&L Carriers" data-service="${serviceTitle}" data-transit-days="${serviceDays}"
                                data-quote-number="N/A" data-base-cost="${netCharge.toFixed(2)}"
                                data-weight="${getTotalWeight().toFixed(2)}" data-class="50" 
                                data-zip="${document.getElementById('shipping-zip')?.value || ''}"
                                data-packages="${palletQty}">
                            R&L ${serviceTitle}
                        </div>
                        <span class="badge bg-primary rounded-pill">$${finalCharge.toFixed(2)}</span>
                    </label>
                `;
            });
        }
        
        // Close the list group
        ratesHtml += '</div>';
        
        // Update rates container if we have new rates
        if (hasRates && !ratesContainer.innerHTML.includes('shipping-option')) {
            ratesContainer.innerHTML = ratesHtml;
        } else if (!hasRates && !ratesContainer.innerHTML.includes('shipping-option')) {
            ratesContainer.innerHTML = `
                <div class="alert alert-warning">
                    No freight shipping rates available for this address and package configuration.
                </div>
            `;
        }
        
        // Add event listeners to shipping options and freight options
        addShippingOptionListeners();
        addFreightOptionListeners();
        
        // Initialize the freight option event listeners
        setTimeout(() => {
            // Add event listeners to freight options after they're added to the DOM
            document.querySelectorAll('.freight-option').forEach(option => {
                option.addEventListener('change', function() {
                    if (this.checked) {
                        console.log('Freight option selected:', this.dataset);
                        populateShippingEstimateOrganizer({
                            carrier: this.dataset.carrier,
                            weight: this.dataset.weight,
                            class: this.dataset.class,
                            cost: this.dataset.cost,
                            zip: this.dataset.zip,
                            packages: this.dataset.packages
                        });
                    }
                });
            });
        }, 500);
    }

    // Add event listeners to shipping options
    function addShippingOptionListeners() {
        // Add event listeners to shipping options
        document.querySelectorAll('.shipping-option').forEach(option => {
            option.addEventListener('change', function() {
                if (this.checked) {
                    // Store the selected shipping option data
                    const carrier = this.dataset.carrier;
                    const service = this.dataset.service;
                    const charge = parseFloat(this.dataset.charge);
                    const weight = this.dataset.weight;
                    const classValue = this.dataset.class;
                    const zip = this.dataset.zip;
                    const packages = this.dataset.packages;
                    
                    console.log('Selected shipping option:', {
                        carrier,
                        service,
                        charge,
                        weight,
                        classValue,
                        zip,
                        packages
                    });
                    
                    // Populate the Shipping Estimate Organizer
                    populateShippingEstimateOrganizer({
                        carrier: carrier,
                        weight: weight,
                        class: classValue,
                        cost: charge,
                        zip: zip,
                        packages: packages
                    });
                }
            });
        });
        
        // Add event listener to the "Populate to Order" button
        const populateToOrderBtn = document.getElementById('populateToOrder');
        if (populateToOrderBtn) {
            populateToOrderBtn.addEventListener('click', function() {
                const selectedOption = document.querySelector('.shipping-option:checked');
                if (selectedOption) {
                    const carrier = selectedOption.dataset.carrier;
                    const service = selectedOption.dataset.service;
                    const shippingCost = parseFloat(selectedOption.dataset.charge);
                    const shippingMethod = `${carrier} ${service}`;
                    
                    // Update shipping cost display in the order
                    const shippingCostInput = document.getElementById('shipping-cost');
                    if (shippingCostInput) {
                        shippingCostInput.value = shippingCost.toFixed(2);
                    }
                    
                    // Update the visible shipping cost input field
                    const shippingCostValueInput = document.getElementById('shipping-cost-value');
                    if (shippingCostValueInput) {
                        shippingCostValueInput.value = shippingCost.toFixed(2);
                    }
                    
                    const shippingMethodInput = document.getElementById('shipping-method');
                    if (shippingMethodInput) {
                        shippingMethodInput.value = shippingMethod;
                    }
                    
                    // Update shipping display
                    const shippingDisplay = document.getElementById('shipping-display');
                    if (shippingDisplay) {
                        shippingDisplay.textContent = '$' + shippingCost.toFixed(2);
                    }
                    
                    // Update order totals
                    if (typeof calculateOrderTotals === 'function') {
                        calculateOrderTotals();
                    }
                    
                    // Add shipping details to the order page
                    addShippingDetailsToOrder(selectedOption);
                    
                    // Close the modal
                    const shippingModal = document.getElementById('shippingModal');
                    if (shippingModal) {
                        const bsModal = bootstrap.Modal.getInstance(shippingModal);
                        if (bsModal) {
                            bsModal.hide();
                        }
                    }
                } else {
                    alert('Please select a shipping option first.');
                }
            });
        }
    }

    // Add shipping details to the order page
    function addShippingDetailsToOrder(selectedOption) {
        // Get data from the selected option
        const carrier = selectedOption.dataset.carrier;
        const service = selectedOption.dataset.service;
        const transitDays = selectedOption.dataset.transitDays;
        const quoteNumber = selectedOption.dataset.quoteNumber;
        const baseCost = selectedOption.dataset.baseCost;
        const totalCharge = selectedOption.dataset.charge;
        
        // Check if the shipping details section exists, if not create it
        let shippingDetailsSection = document.getElementById('order-shipping-details');
        if (!shippingDetailsSection) {
            // Create the shipping details section
            const orderTotalsSection = document.querySelector('.order-totals');
            if (orderTotalsSection) {
                shippingDetailsSection = document.createElement('div');
                shippingDetailsSection.id = 'order-shipping-details';
                shippingDetailsSection.className = 'card mt-3';
                
                // Determine fields based on carrier
                let fieldsHtml = '';
                
                if (carrier === 'UPS') {
                    // UPS Ground fields
                    fieldsHtml = `
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order-shipping-carrier" class="form-label">Carrier</label>
                                    <input type="text" class="form-control" id="order-shipping-carrier" name="order_shipping_carrier" value="${carrier}">
                                </div>
                                <div class="mb-3">
                                    <label for="order-shipping-service" class="form-label">Service</label>
                                    <input type="text" class="form-control" id="order-shipping-service" name="order_shipping_service" value="${service}">
                                </div>
                                <div class="mb-3">
                                    <label for="order-shipping-transit-days" class="form-label">Transit Days</label>
                                    <input type="text" class="form-control" id="order-shipping-transit-days" name="order_shipping_transit_days" value="${transitDays}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order-shipping-base-cost" class="form-label">Base Cost</label>
                                    <input type="text" class="form-control" id="order-shipping-base-cost" name="order_shipping_base_cost" value="${baseCost}">
                                </div>
                                <div class="mb-3">
                                    <label for="order-shipping-box-price" class="form-label">Box Price</label>
                                    <input type="text" class="form-control" id="order-shipping-box-price" name="order_shipping_box_price" value="5.00">
                                </div>
                                <div class="mb-3">
                                    <label for="order-shipping-total-charge" class="form-label">Total Price</label>
                                    <input type="text" class="form-control" id="order-shipping-total-charge" name="order_shipping_total_charge" value="${totalCharge}">
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    // Freight shipping fields
                    fieldsHtml = `
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order-shipping-carrier" class="form-label">Carrier</label>
                                    <input type="text" class="form-control" id="order-shipping-carrier" name="order_shipping_carrier" value="${carrier}">
                                </div>
                                <div class="mb-3">
                                    <label for="order-shipping-service" class="form-label">Service</label>
                                    <input type="text" class="form-control" id="order-shipping-service" name="order_shipping_service" value="${service}">
                                </div>
                                <div class="mb-3">
                                    <label for="order-shipping-quote-number" class="form-label">Quote #</label>
                                    <input type="text" class="form-control" id="order-shipping-quote-number" name="order_shipping_quote_number" value="${quoteNumber}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order-shipping-base-cost" class="form-label">Base Cost</label>
                                    <input type="text" class="form-control" id="order-shipping-base-cost" name="order_shipping_base_cost" value="${baseCost}">
                                </div>
                                <div class="mb-3">
                                    <label for="order-shipping-pallet-size" class="form-label">Pallet Size</label>
                                    <input type="text" class="form-control" id="order-shipping-pallet-size" name="order_shipping_pallet_size" value="49x48x54">
                                </div>
                                <div class="mb-3">
                                    <label for="order-shipping-total-charge" class="form-label">Total Price</label>
                                    <input type="text" class="form-control" id="order-shipping-total-charge" name="order_shipping_total_charge" value="${totalCharge}">
                                </div>
                            </div>
                        </div>
                    `;
                }
                
                shippingDetailsSection.innerHTML = `
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Shipping Details</h5>
                    </div>
                    <div class="card-body">
                        ${fieldsHtml}
                    </div>
                `;
                
                // Insert before the order totals section
                orderTotalsSection.parentNode.insertBefore(shippingDetailsSection, orderTotalsSection);
            }
        } else {
            // Update the existing shipping details section
            // First, determine if we need to change the fields based on carrier
            const currentCarrier = document.getElementById('order-shipping-carrier')?.value;
            
            if (currentCarrier !== carrier) {
                // Replace the entire shipping details section with new fields
                shippingDetailsSection.remove();
                addShippingDetailsToOrder(selectedOption); // Recursive call to create new section
            } else {
                // Just update the existing fields
                if (document.getElementById('order-shipping-carrier')) {
                    document.getElementById('order-shipping-carrier').value = carrier;
                }
                if (document.getElementById('order-shipping-service')) {
                    document.getElementById('order-shipping-service').value = service;
                }
                if (document.getElementById('order-shipping-transit-days')) {
                    document.getElementById('order-shipping-transit-days').value = transitDays;
                }
                if (document.getElementById('order-shipping-quote-number')) {
                    document.getElementById('order-shipping-quote-number').value = quoteNumber;
                }
                if (document.getElementById('order-shipping-base-cost')) {
                    document.getElementById('order-shipping-base-cost').value = baseCost;
                }
                if (document.getElementById('order-shipping-total-charge')) {
                    document.getElementById('order-shipping-total-charge').value = totalCharge;
                }
            }
        }
    }

    // Add event listeners to freight options
    function addFreightOptionListeners() {
        console.log('Adding freight option listeners');
        
        // Add event listeners to freight options
        document.querySelectorAll('.freight-option').forEach(option => {
            // Remove any existing event listeners first to avoid duplicates
            option.removeEventListener('change', handleFreightOptionChange);
            option.addEventListener('change', handleFreightOptionChange);
        });
    }

    // Handle freight option change
    function handleFreightOptionChange() {
        if (this.checked) {
            // Store the selected freight option data
            const carrier = this.dataset.carrier;
            const weight = this.dataset.weight;
            const classValue = this.dataset.class;
            const cost = this.dataset.cost;
            const zip = this.dataset.zip;
            const quoteNumber = this.dataset.quoteNumber;
            const packages = this.dataset.packages;
            
            console.log('Selected freight option:', {
                carrier,
                weight,
                classValue,
                cost,
                zip,
                quoteNumber,
                packages
            });
            
            // Populate the Shipping Estimate Organizer
            populateShippingEstimateOrganizer({
                carrier: carrier,
                weight: weight,
                class: classValue,
                cost: cost,
                zip: zip,
                packages: packages
            });
        }
    }

    // Initialize freight options on document ready
    document.addEventListener('DOMContentLoaded', function() {
        // Add a click event listener to the entire freight shipping table
        const freightShippingTable = document.getElementById('freightShippingTable');
        if (freightShippingTable) {
            freightShippingTable.addEventListener('click', function(event) {
                // Check if the clicked element is a freight option radio button
                if (event.target.classList.contains('freight-option')) {
                    // Trigger the change event
                    event.target.dispatchEvent(new Event('change'));
                    
                    // Also populate the shipping estimate organizer
                    populateShippingEstimateOrganizer({
                        carrier: event.target.dataset.carrier,
                        weight: event.target.dataset.weight,
                        class: event.target.dataset.class,
                        cost: event.target.dataset.cost,
                        zip: event.target.dataset.zip,
                        packages: event.target.dataset.packages
                    });
                }
            });
        }
    });

    // Populate the Shipping Estimate Organizer
    function populateShippingEstimateOrganizer(data) {
        document.getElementById('shipping-organizer-carrier').value = data.carrier || '';
        document.getElementById('shipping-organizer-weight').value = data.weight || '';
        document.getElementById('shipping-organizer-class').value = data.class || '';
        document.getElementById('shipping-organizer-cost').value = data.cost || '';
        document.getElementById('shipping-organizer-zip').value = data.zip || '';
        document.getElementById('shipping-organizer-packages').value = data.packages || '';
        console.log('Shipping Estimate Organizer populated with:', data);
    }
    
    // Helper function to get total weight
    function getTotalWeight() {
        let totalWeight = 0;
        orderItems.forEach(item => {
            const weight = parseFloat(item.weight_lbs) || 0;
            const quantity = parseInt(item.quantity) || 1;
            totalWeight += weight * quantity;
        });
        return totalWeight;
    }
});

// When the document is loaded, initialize event listeners for the shipping modal
document.addEventListener('DOMContentLoaded', function() {
    // Add event listener for the Calculate Shipping button
    const calculateShippingBtn = document.getElementById('calculateShipping');
    if (calculateShippingBtn) {
        calculateShippingBtn.addEventListener('click', function() {
            calculateShipping();
        });
    }
    
    // Add event listener for the shipping modal shown event
    const shippingModal = document.getElementById('shippingModal');
    if (shippingModal) {
        shippingModal.addEventListener('shown.bs.modal', function() {
            // Check if we need to calculate shipping rates
            if (document.getElementById('shippingRates').innerHTML === '') {
                calculateShipping();
            }
            
            // Add event listeners to shipping options and freight options
            addShippingOptionListeners();
            addFreightOptionListeners();
            
            // Make sure the first shipping option is selected
            const firstShippingOption = document.querySelector('.shipping-option');
            if (firstShippingOption && !document.querySelector('.shipping-option:checked')) {
                firstShippingOption.checked = true;
                firstShippingOption.dispatchEvent(new Event('change'));
            }
        });
    }
    
    // Add event listener for the Populate to Order button
    const populateToOrderBtn = document.getElementById('populateToOrder');
    if (populateToOrderBtn) {
        populateToOrderBtn.addEventListener('click', function() {
            const selectedOption = document.querySelector('.shipping-option:checked');
            if (selectedOption) {
                const carrier = selectedOption.dataset.carrier;
                const service = selectedOption.dataset.service;
                const shippingCost = parseFloat(selectedOption.dataset.charge);
                const shippingMethod = `${carrier} ${service}`;
                
                // Update shipping cost display in the order
                const shippingCostInput = document.getElementById('shipping-cost');
                if (shippingCostInput) {
                    shippingCostInput.value = shippingCost.toFixed(2);
                }
                
                // Update the visible shipping cost input field
                const shippingCostValueInput = document.getElementById('shipping-cost-value');
                if (shippingCostValueInput) {
                    shippingCostValueInput.value = shippingCost.toFixed(2);
                }
                
                const shippingMethodInput = document.getElementById('shipping-method');
                if (shippingMethodInput) {
                    shippingMethodInput.value = shippingMethod;
                }
                
                // Update shipping display
                const shippingDisplay = document.getElementById('shipping-display');
                if (shippingDisplay) {
                    shippingDisplay.textContent = '$' + shippingCost.toFixed(2);
                }
                
                // Update order totals
                if (typeof calculateOrderTotals === 'function') {
                    calculateOrderTotals();
                }
                
                // Add shipping details to the order page
                addShippingDetailsToOrder(selectedOption);
                
                // Close the modal
                const shippingModal = document.getElementById('shippingModal');
                if (shippingModal) {
                    const bsModal = bootstrap.Modal.getInstance(shippingModal);
                    if (bsModal) {
                        bsModal.hide();
                    }
                }
            } else {
                alert('Please select a shipping option first.');
            }
        });
    }
    
    // Add event listener to the "Add to Order" button in Shipping Estimate Organizer
    const addShippingEstimateBtn = document.getElementById('addShippingEstimate');
    if (addShippingEstimateBtn) {
        addShippingEstimateBtn.addEventListener('click', function() {
            // Get values from the Shipping Estimate Organizer
            const carrier = document.getElementById('shipping-organizer-carrier').value;
            const cost = document.getElementById('shipping-organizer-cost').value;
            
            if (!carrier || !cost) {
                alert('Please fill in at least the Carrier and Cost Price fields.');
                return;
            }
            
            // Update shipping cost display in the order
            const shippingCostInput = document.getElementById('shipping-cost');
            if (shippingCostInput) {
                shippingCostInput.value = parseFloat(cost).toFixed(2);
            }
            
            // Update the visible shipping cost input field
            const shippingCostValueInput = document.getElementById('shipping-cost-value');
            if (shippingCostValueInput) {
                shippingCostValueInput.value = parseFloat(cost).toFixed(2);
            }
            
            const shippingMethodInput = document.getElementById('shipping-method');
            if (shippingMethodInput) {
                shippingMethodInput.value = carrier;
            }
            
            // Update shipping display
            const shippingDisplay = document.getElementById('shipping-display');
            if (shippingDisplay) {
                shippingDisplay.textContent = '$' + parseFloat(cost).toFixed(2);
            }
            
            // Update order totals
            if (typeof calculateOrderTotals === 'function') {
                calculateOrderTotals();
            }
            
            // Add shipping details to the order page
            addShippingDetailsToOrderFromOrganizer();
            
            // Close the modal
            const shippingModal = document.getElementById('shippingModal');
            if (shippingModal) {
                const bsModal = bootstrap.Modal.getInstance(shippingModal);
                if (bsModal) {
                    bsModal.hide();
                }
            }
        });
    }
    
    // Add a click event listener to the entire freight shipping table
    const freightShippingTable = document.getElementById('freightShippingTable');
    if (freightShippingTable) {
        freightShippingTable.addEventListener('click', function(event) {
            // Check if the clicked element is a freight option radio button
            if (event.target.classList.contains('freight-option')) {
                // Trigger the change event
                event.target.dispatchEvent(new Event('change'));
                
                // Also populate the shipping estimate organizer
                populateShippingEstimateOrganizer({
                    carrier: event.target.dataset.carrier,
                    weight: event.target.dataset.weight,
                    class: event.target.dataset.class,
                    cost: event.target.dataset.cost,
                    zip: event.target.dataset.zip,
                    packages: event.target.dataset.packages
                });
            }
        });
    }
});

// Add shipping details to the order page from the Shipping Estimate Organizer
function addShippingDetailsToOrderFromOrganizer() {
    // Get values from the Shipping Estimate Organizer
    const carrier = document.getElementById('shipping-organizer-carrier').value;
    const weight = document.getElementById('shipping-organizer-weight').value;
    const classValue = document.getElementById('shipping-organizer-class').value;
    const cost = document.getElementById('shipping-organizer-cost').value;
    const zip = document.getElementById('shipping-organizer-zip').value;
    const resDate = document.getElementById('shipping-organizer-res-date').value;
    const packages = document.getElementById('shipping-organizer-packages').value;
    const quotedBy = document.getElementById('shipping-organizer-quoted-by').value;
    
    // Check if the shipping details section exists, if not create it
    let shippingDetailsSection = document.getElementById('order-shipping-details');
    if (!shippingDetailsSection) {
        // Create the shipping details section
        const orderTotalsSection = document.querySelector('.order-totals');
        if (orderTotalsSection) {
            shippingDetailsSection = document.createElement('div');
            shippingDetailsSection.id = 'order-shipping-details';
            shippingDetailsSection.className = 'card mt-3';
            
            shippingDetailsSection.innerHTML = `
                <div class="card-header bg-light">
                    <h5 class="mb-0">Shipping Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="order-shipping-carrier" class="form-label">Carrier</label>
                                <input type="text" class="form-control" id="order-shipping-carrier" name="order_shipping_carrier" value="${carrier}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="order-shipping-weight" class="form-label">Weight</label>
                                <input type="text" class="form-control" id="order-shipping-weight" name="order_shipping_weight" value="${weight}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="order-shipping-class" class="form-label">Class</label>
                                <input type="text" class="form-control" id="order-shipping-class" name="order_shipping_class" value="${classValue}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="order-shipping-cost" class="form-label">Cost</label>
                                <input type="text" class="form-control" id="order-shipping-cost" name="order_shipping_cost" value="${cost}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="order-shipping-zip" class="form-label">Zip</label>
                                <input type="text" class="form-control" id="order-shipping-zip" name="order_shipping_zip" value="${zip}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="order-shipping-res-date" class="form-label">Res Date</label>
                                <input type="date" class="form-control" id="order-shipping-res-date" name="order_shipping_res_date" value="${resDate}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="order-shipping-packages" class="form-label">Packages</label>
                                <input type="text" class="form-control" id="order-shipping-packages" name="order_shipping_packages" value="${packages}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="order-shipping-quoted-by" class="form-label">Quoted by</label>
                                <input type="text" class="form-control" id="order-shipping-quoted-by" name="order_shipping_quoted_by" value="${quotedBy}">
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Insert before the order totals section
            orderTotalsSection.parentNode.insertBefore(shippingDetailsSection, orderTotalsSection);
        }
    } else {
        // Update the existing shipping details section
        if (document.getElementById('order-shipping-carrier')) {
            document.getElementById('order-shipping-carrier').value = carrier;
        }
        if (document.getElementById('order-shipping-weight')) {
            document.getElementById('order-shipping-weight').value = weight;
        }
        if (document.getElementById('order-shipping-class')) {
            document.getElementById('order-shipping-class').value = classValue;
        }
        if (document.getElementById('order-shipping-cost')) {
            document.getElementById('order-shipping-cost').value = cost;
        }
        if (document.getElementById('order-shipping-zip')) {
            document.getElementById('order-shipping-zip').value = zip;
        }
        if (document.getElementById('order-shipping-res-date')) {
            document.getElementById('order-shipping-res-date').value = resDate;
        }
        if (document.getElementById('order-shipping-packages')) {
            document.getElementById('order-shipping-packages').value = packages;
        }
        if (document.getElementById('order-shipping-quoted-by')) {
            document.getElementById('order-shipping-quoted-by').value = quotedBy;
        }
    }
}

// Order Status Handling
document.addEventListener('DOMContentLoaded', function() {
    // Initialize the order status dropdown
    const orderStatusDropdown = document.getElementById('order-status');
    if (orderStatusDropdown) {
        // Set an initial value if none is selected
        if (!orderStatusDropdown.value) {
            orderStatusDropdown.value = 'QUOTE'; // Default to QUOTE
        }
        
        // Apply the initial color
        applyOrderStatusColor(orderStatusDropdown);
        
        // Add change event listener
        orderStatusDropdown.addEventListener('change', function() {
            applyOrderStatusColor(this);
        });
    }
    
    // Add the order status to form submission
    const saveOrderBtn = document.getElementById('save-order');
    if (saveOrderBtn) {
        saveOrderBtn.addEventListener('click', function() {
            // Get the current order status
            const orderStatus = document.getElementById('order-status').value;
            
            // Add the order status to the existing order data or create a hidden input
            let orderStatusInput = document.getElementById('order-status-hidden');
            if (!orderStatusInput) {
                orderStatusInput = document.createElement('input');
                orderStatusInput.type = 'hidden';
                orderStatusInput.id = 'order-status-hidden';
                orderStatusInput.name = 'order_status';
                document.body.appendChild(orderStatusInput);
            }
            
            orderStatusInput.value = orderStatus;
            
            // Now proceed with saving the order
            saveOrder();
        });
    }
});

// Function to apply color based on selected order status
function applyOrderStatusColor(selectElement) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const color = selectedOption.getAttribute('data-color');
    
    // Apply color to the select element background
    if (color) {
        selectElement.style.backgroundColor = color;
        
        // Adjust text color for readability based on background brightness
        const rgb = hexToRgb(color);
        const brightness = (rgb.r * 299 + rgb.g * 587 + rgb.b * 114) / 1000;
        selectElement.style.color = brightness > 128 ? '#000000' : '#FFFFFF';
    }
}

// Helper function to convert hex color to RGB
function hexToRgb(hex) {
    // Remove # if present
    hex = hex.replace('#', '');
    
    // Parse the hex values
    const r = parseInt(hex.substring(0, 2), 16);
    const g = parseInt(hex.substring(2, 4), 16);
    const b = parseInt(hex.substring(4, 6), 16);
    
    return { r, g, b };
}

// Save order function (placeholder)
function saveOrder() {
    // Get all order data
    const orderData = {
        customer_id: document.getElementById('customer-select')?.value,
        call_date: document.getElementById('call-date')?.value,
        quote_number: document.getElementById('quote-number')?.value,
        sold_number: document.getElementById('sold-number')?.value,
        sales_person: document.getElementById('sales-person')?.value,
        
        shipping_name: document.getElementById('shipping-name')?.value,
        shipping_company: document.getElementById('shipping-company')?.value,
        shipping_address: document.getElementById('shipping-address')?.value,
        shipping_address2: document.getElementById('shipping-address2')?.value,
        shipping_city: document.getElementById('shipping-city')?.value,
        shipping_state: document.getElementById('shipping-state')?.value,
        shipping_zip: document.getElementById('shipping-zip')?.value,
        shipping_country: document.getElementById('shipping-country')?.value,
        shipping_phone: document.getElementById('shipping-phone')?.value,
        
        billing_name: document.getElementById('billing-name')?.value,
        billing_company: document.getElementById('billing-company')?.value,
        billing_address: document.getElementById('billing-address')?.value,
        billing_address2: document.getElementById('billing-address2')?.value,
        billing_city: document.getElementById('billing-city')?.value,
        billing_state: document.getElementById('billing-state')?.value,
        billing_zip: document.getElementById('billing-zip')?.value,
        billing_country: document.getElementById('billing-country')?.value,
        
        origin: document.querySelector('input[name="origin"]:checked')?.value,
        shipping_method_type: document.querySelector('input[name="shipping_method"]:checked')?.value,
        payment_method: document.getElementById('payment-method')?.value,
        
        tax_rate: document.getElementById('taxRate')?.value,
        shipping_cost: document.getElementById('shipping-cost')?.value,
        shipping_method: document.getElementById('shipping-method')?.value,
        tax_exempt: document.getElementById('tax-exempt')?.checked ? 1 : 0,
        deposit: document.querySelector('input[name="deposit"]:checked')?.value,
        
        subtotal: document.getElementById('subtotal')?.value,
        tax_amount: document.getElementById('tax_amount')?.value,
        total: document.getElementById('total')?.value,
        
        order_items: getOrderItems(),
        order_status: document.getElementById('order-status')?.value
    };
    
    // Send order data to server
    fetch('/ams/orders', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(orderData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Order saved successfully:', data);
        
        // Show success message
        alert('Order saved successfully!');
        
        // Redirect to order list or order view page
        if (data.order_id) {
            window.location.href = `/ams/orders/${data.order_id}`;
        } else {
            window.location.href = '/ams/orders';
        }
    })
    .catch(error => {
        console.error('Error saving order:', error);
        alert('Error saving order. Please try again.');
    });
}
