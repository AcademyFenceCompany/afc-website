// Order Management JavaScript
$(document).ready(function() {
    // Initialize variables
    let orderItems = [];
    let currentItemId = 1;
    let selectedProducts = [];
    let productModal = new bootstrap.Modal(document.getElementById('productModal'));
    let addressModal = new bootstrap.Modal(document.getElementById('addressBookModal'));
    let addressType = ''; // 'shipping' or 'billing'

    // Debug: Log when document is ready
    console.log('Document ready, initializing order management...');

    // Initialize category tree when modal is shown
    $('#productModal').on('shown.bs.modal', function() {
        console.log('Product modal shown, initializing category tree...');
        initializeCategoryTree();
    });

    function initializeCategoryTree() {
        // Initially collapse all nested categories
        $('.nested').hide();
        
        // Set up toggle buttons
        $('.category-tree .toggle-btn').off('click').on('click', function() {
            const $btn = $(this);
            const $icon = $btn.find('i');
            const $nested = $btn.closest('li').find('> .nested');
            
            $nested.slideToggle();
            $icon.toggleClass('bi-chevron-right bi-chevron-down');
        });

        // Load first category's products by default
        const $firstCategory = $('.category-link').first();
        if ($firstCategory.length) {
            $firstCategory.addClass('active');
            loadProductsByCategory($firstCategory.data('category-id'));
        }
    }

    // Show product modal
    $('#addItemsBtn').click(function() {
        productModal.show();
    });

    // Load products when category is clicked
    $(document).on('click', '.category-link', function(e) {
        e.preventDefault();
        const categoryId = $(this).data('category-id');
        loadProductsByCategory(categoryId);
        
        // Update active state
        $('.category-link').removeClass('active');
        $(this).addClass('active');
    });

    // Category search functionality
    $('#categorySearch').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        $('.category-item').each(function() {
            const text = $(this).find('.category-link').text().toLowerCase();
            $(this).toggle(text.includes(searchTerm));
        });
    });

    // Load products by category
    function loadProductsByCategory(categoryId) {
        console.log('Loading products for category:', categoryId);
        
        // Show loading state
        $('#productsTable tbody').html('<tr><td colspan="10" class="text-center">Loading products...</td></tr>');

        // Make AJAX request to get products
        $.ajax({
            url: `/categories/${categoryId}/products`,  
            method: 'GET',
            success: function(products) {
                console.log('Products loaded:', products);
                renderProductsTable(products.products); // Access the products array from the response
                
                // Update active category
                $('.category-link').removeClass('active');
                $(`[data-category-id="${categoryId}"]`).addClass('active');
            },
            error: function(xhr, status, error) {
                console.error('Error loading products:', {
                    status: status,
                    error: error,
                    response: xhr.responseText
                });
                $('#productsTable tbody').html('<tr><td colspan="10" class="text-center text-danger">Error loading products. Please try again.</td></tr>');
            }
        });
    }

    // Render products in modal table
    function renderProductsTable(products) {
        console.log('Rendering products table with:', products);
        const tbody = $('#productsTable tbody');
        tbody.empty();

        if (!Array.isArray(products) || products.length === 0) {
            tbody.html('<tr><td colspan="10" class="text-center">No products found in this category</td></tr>');
            return;
        }

        products.forEach(product => {
            // Ensure price is a valid number
            const price = parseFloat(product.price_per_unit) || 0;
            const row = `
                <tr data-product-id="${product.product_id}">
                    <td>${product.item_no || ''}</td>
                    <td>${product.description || ''}</td>
                    <td>${product.details?.color || ''}</td>
                    <td>${product.details?.size1 || ''}</td>
                    <td>${product.details?.size2 || ''}</td>
                    <td>${product.details?.style || ''}</td>
                    <td>$${price.toFixed(2)}</td>
                    <td>${product.inventory?.quantity || 0}</td>
                    <td>
                        <input type="number" class="form-control form-control-sm product-quantity" 
                               value="1" min="1" max="${product.inventory?.quantity || 999999}">
                    </td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input product-select" type="checkbox">
                        </div>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });

        // Add event handler for quantity input validation
        $('.product-quantity').on('input', function() {
            const max = parseInt($(this).attr('max'));
            let val = parseInt($(this).val());
            if (isNaN(val) || val < 1) {
                $(this).val(1);
            } else if (val > max) {
                $(this).val(max);
            }
        });
    }

    // Product search functionality
    $('#productSearch').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        if (searchTerm.length >= 2) {
            $.ajax({
                url: '/ams/orders/products',
                method: 'GET',
                data: { search: searchTerm },
                success: function(products) {
                    renderProductsTable(products);
                }
            });
        }
    });

    // Add selected products to order
    $('#addSelectedProducts').click(function() {
        const selectedRows = $('#productsTable tbody tr').filter(function() {
            return $(this).find('.product-select').is(':checked');
        });

        selectedRows.each(function() {
            const $row = $(this);
            const productId = $row.data('product-id');
            const quantity = parseInt($row.find('.product-quantity').val());
            
            // Get product details from the row
            const product = {
                id: productId,
                itemNo: $row.find('td:eq(0)').text(),
                description: $row.find('td:eq(1)').text(),
                color: $row.find('td:eq(2)').text(),
                size1: $row.find('td:eq(3)').text(),
                size2: $row.find('td:eq(4)').text(),
                style: $row.find('td:eq(5)').text(),
                price: parseFloat($row.find('td:eq(6)').text().replace('$', '')),
                quantity: quantity
            };

            addProductToOrder(product);
        });

        // Close modal and clear selections
        productModal.hide();
        $('.product-select').prop('checked', false);
    });

    // Add product to order table
    function addProductToOrder(product) {
        const total = product.price * product.quantity;
        const rowHtml = `
            <tr data-item-id="${currentItemId}">
                <td>${product.itemNo}</td>
                <td>${product.description}</td>
                <td>${product.color}</td>
                <td>${product.size1}</td>
                <td>${product.size2}</td>
                <td>${product.style}</td>
                <td>$${product.price.toFixed(2)}</td>
                <td>
                    <input type="number" class="form-control form-control-sm item-quantity" 
                           value="${product.quantity}" min="1">
                </td>
                <td>$${total.toFixed(2)}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger delete-item">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;

        // Remove "No items" row if it exists
        const tbody = $('#orderItemsTable tbody');
        if (tbody.find('tr td').length === 1) {
            tbody.empty();
        }

        // Add new row
        tbody.append(rowHtml);

        // Store item data
        orderItems.push({
            id: currentItemId,
            productId: product.id,
            quantity: product.quantity,
            price: product.price
        });

        currentItemId++;
        updateOrderTotals();
    }

    // Delete item from order
    $(document).on('click', '.delete-item', function() {
        const row = $(this).closest('tr');
        const itemId = row.data('item-id');
        
        // Remove from orderItems array
        orderItems = orderItems.filter(item => item.id !== itemId);
        
        // Remove row
        row.remove();
        
        // Show "No items" message if no items left
        if ($('#orderItemsTable tbody tr').length === 0) {
            $('#orderItemsTable tbody').html('<tr><td colspan="10" class="text-center">No items added yet</td></tr>');
        }
        
        updateOrderTotals();
    });

    // Update quantity
    $(document).on('change', '.item-quantity', function() {
        const row = $(this).closest('tr');
        const itemId = row.data('item-id');
        const quantity = parseInt($(this).val());
        const price = parseFloat(row.find('td:eq(6)').text().replace('$', ''));
        
        // Update total in row
        row.find('td:eq(8)').text('$' + (price * quantity).toFixed(2));
        
        // Update in orderItems array
        const item = orderItems.find(item => item.id === itemId);
        if (item) {
            item.quantity = quantity;
        }
        
        updateOrderTotals();
    });

    // Update order totals
    function updateOrderTotals() {
        let subtotal = 0;
        orderItems.forEach(item => {
            subtotal += item.price * item.quantity;
        });

        // Update subtotal display
        $('#subtotal').text(subtotal.toFixed(2));
        
        // Trigger recalculation of other totals if needed
        calculateTotals();
    }

    // Calculate all totals
    function calculateTotals() {
        const subtotal = parseFloat($('#subtotal').text());
        const shippingCost = parseFloat($('#shipping-cost').text()) || 0;
        const shippingPrice = parseFloat($('#shipping-price').text()) || 0;
        const salesTax = parseFloat($('#sales-tax').text()) || 0;
        const discount = parseFloat($('#discount').text()) || 0;
        
        const total = subtotal + shippingCost + shippingPrice + salesTax - discount;
        $('#total').text(total.toFixed(2));
    }

    // Handle View Address Book button clicks
    $('[data-bs-target="#addressBookModal"]').click(function() {
        addressType = $(this).closest('.card').find('.card-title').text().includes('Shipping') ? 'shipping' : 'billing';
        loadCustomerAddresses($('#customerSelect').val());
    });

    // Load customer addresses
    $('#customerSelect').change(function() {
        loadCustomerAddresses($(this).val());
    });

    function loadCustomerAddresses(customerId) {
        if (!customerId) {
            $('#addressList').empty();
            return;
        }

        $.get(`/ams/customers/${customerId}/addresses`, function(addresses) {
            renderAddressList(addresses);
        });
    }

    // Render address list
    function renderAddressList(addresses) {
        const container = $('#addressList');
        container.empty();

        addresses.forEach(address => {
            const addressHtml = `
                <div class="form-check mb-2">
                    <input class="form-check-input address-select" type="radio" name="address" value="${address.id}">
                    <label class="form-check-label">
                        ${address.address_line1}<br>
                        ${address.address_line2 ? address.address_line2 + '<br>' : ''}
                        ${address.city}, ${address.state} ${address.zip_code}
                    </label>
                </div>
            `;
            container.append(addressHtml);
        });
    }

    // Select address
    $('#selectAddress').click(function() {
        const selectedAddress = $('input[name="address"]:checked').val();
        if (selectedAddress) {
            if (addressType === 'shipping') {
                $('#shipping-address').val(selectedAddress);
            } else {
                $('#billing-address').val(selectedAddress);
            }
            addressModal.hide();
        }
    });

    // Add item to order
    function addItemToOrder(product, quantity = 1) {
        const item = {
            id: currentItemId++,
            product_id: product.product_id,
            quantity: quantity,
            item_no: product.item_no,
            description: product.description,
            color: product.details?.color || '',
            size: product.details?.size1 || '',
            size2: product.details?.size2 || '',
            style: product.details?.style || '',
            weight: product.shipping_details?.weight || 0,
            unit_price: product.price_per_unit,
            price: product.price_per_unit * quantity
        };

        orderItems.push(item);
        renderOrderItem(item);
        updateTotals();
    }

    // Render order item in table
    function renderOrderItem(item) {
        const row = `
            <tr data-item-id="${item.id}">
                <td>${item.id}</td>
                <td><input type="number" class="form-control form-control-sm quantity" value="${item.quantity}" min="1"></td>
                <td><input type="text" class="form-control form-control-sm inv" value=""></td>
                <td>${item.item_no}</td>
                <td>${item.description}</td>
                <td>${item.color}</td>
                <td>${item.size}</td>
                <td>${item.size2}</td>
                <td>${item.style}</td>
                <td>${item.weight}</td>
                <td>${item.unit_price.toFixed(2)}</td>
                <td>${item.price.toFixed(2)}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-danger delete-item">×</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary duplicate-item">Copy</button>
                </td>
            </tr>
        `;
        $('#order-items tbody').append(row);
    }

    // Update order totals
    function updateTotals() {
        let totalWeight = 0;
        let totalItems = 0;
        let subtotal = 0;

        orderItems.forEach(item => {
            totalWeight += (item.weight * item.quantity);
            totalItems += parseInt(item.quantity);
            subtotal += item.price;
        });

        $('#total-weight').text(totalWeight.toFixed(2));
        $('#total-items').text(totalItems);
        $('#subtotal').text(subtotal.toFixed(2));

        // Update shipping weight field
        $('input[placeholder="Weight"]').val(totalWeight.toFixed(2));
    }

    // Handle quantity changes
    $(document).on('change', '.quantity', function() {
        const row = $(this).closest('tr');
        const itemId = row.data('item-id');
        const quantity = parseInt($(this).val());
        
        const item = orderItems.find(i => i.id === itemId);
        if (item) {
            item.quantity = quantity;
            item.price = item.unit_price * quantity;
            row.find('td:nth-last-child(2)').text(item.price.toFixed(2));
            updateTotals();
        }
    });

    // Handle item deletion
    $(document).on('click', '.delete-item', function() {
        const row = $(this).closest('tr');
        const itemId = row.data('item-id');
        
        orderItems = orderItems.filter(i => i.id !== itemId);
        row.remove();
        updateTotals();
    });

    // Handle item duplication
    $(document).on('click', '.duplicate-item', function() {
        const row = $(this).closest('tr');
        const itemId = row.data('item-id');
        const originalItem = orderItems.find(i => i.id === itemId);
        
        if (originalItem) {
            const duplicateItem = {...originalItem, id: currentItemId++};
            orderItems.push(duplicateItem);
            renderOrderItem(duplicateItem);
            updateTotals();
        }
    });

    // Handle status updates
    $('.status-update').click(function() {
        const status = $(this).data('status');
        const orderId = $('#order-form').data('order-id');
        
        $.post(`/ams/orders/${orderId}/status`, {
            status: status,
            _token: $('meta[name="csrf-token"]').attr('content')
        }, function(response) {
            if (response.success) {
                // Update UI to show status change
                $(this).addClass('disabled').prop('disabled', true);
                // Add timestamp to the field
                $(`#${status}-date`).val(new Date().toISOString().split('T')[0]);
            }
        });
    });

    // Calculate shipping
    $('#calculate-shipping').click(function() {
        const data = {
            carrier: $('input[placeholder="Carrier"]').val(),
            weight: $('input[placeholder="Weight"]').val(),
            class: $('input[placeholder="Class"]').val(),
            zip: $('input[placeholder="Zip"]').val(),
            packages: $('input[placeholder="Packages"]').val(),
        };

        // Call your shipping calculation endpoint here
        $.post('/ams/orders/calculate-shipping', data, function(response) {
            if (response.success) {
                $('input[placeholder="Cost Price"]').val(response.cost);
                updateTotals();
            }
        });
    });

    // Save order
    $('#save-order').click(function() {
        const formData = {
            customer_id: $('#customer-id').val(),
            billing_address_id: $('#billing-address').val(),
            shipping_address_id: $('#shipping-address').val(),
            origin: $('input[name="origin"]:checked').val(),
            items: orderItems,
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        $.post('/ams/orders', formData, function(response) {
            if (response.success) {
                // Redirect to order view page or show success message
                window.location.href = `/ams/orders/${response.order.id}`;
            }
        });
    });
});
