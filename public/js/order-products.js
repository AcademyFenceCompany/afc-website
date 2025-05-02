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
                    const weightPerBox = productWeight * amountPerBox;
                    
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
                            <td>${product.product_name}</td>
                            <td>${qtyInThisBox}</td>
                            <td>${boxWeight.toFixed(2)} lbs</td>
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
                    <td>$${boxesTotal.toFixed(2)}</td>
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
                                    data-base-cost="${baseCharge.toFixed(2)}" checked>
                                UPS Ground
                            </div>
                            <span class="badge bg-primary rounded-pill">$${totalPrice.toFixed(2)}</span>
                        </label>
                    </div>
                `;
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
                                data-quote-number="${quoteNumber}" data-base-cost="${totalCharge.toFixed(2)}">
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
                                data-quote-number="N/A" data-base-cost="${netCharge.toFixed(2)}">
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
        
        // Add event listeners to shipping options
        addShippingOptionListeners();
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
                    
                    console.log('Selected shipping option:', {
                        carrier,
                        service,
                        charge
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
