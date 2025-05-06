@extends('layouts.ams')

@section('title', 'Create New Order')

@section('content')
    <div class="container-fluid py-2">
        <!-- Header Info -->
        <div class="row g-2 mb-2">
            <div class="col-md-12">
                <div class="d-flex align-items-center gap-2">
                    <div class="input-group input-group-sm" style="width: auto;">
                        <span class="input-group-text">Customer</span>
                        <select class="form-select form-select-sm" id="customer-select" style="min-width: 200px;">
                            <option value="">Select Customer...</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->customer_id }}" data-email="{{ $customer->email }}"
                                    data-company="{{ $customer->company_name }}" data-phone="{{ $customer->phone }}"
                                    data-alt-phone="{{ $customer->alternative_phone }}" data-fax="{{ $customer->fax }}"
                                    {{ request('customer_id') == $customer->customer_id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group input-group-sm" style="width: auto;">
                        <span class="input-group-text">Call Date</span>
                        <input type="date" class="form-control form-control-sm" id="call-date"
                            value="{{ date('Y-m-d') }}" readonly>
                    </div>
                    <div class="input-group input-group-sm" style="width: auto;">
                        <span class="input-group-text">Quote</span>
                        <input type="text" class="form-control form-control-sm" id="quote-number"
                            value="{{ auth()->user()->username ?? '' }}">
                    </div>
                    <div class="input-group input-group-sm" style="width: auto;">
                        <span class="input-group-text">Sold</span>
                        <input type="text" class="form-control form-control-sm" id="sold-number">
                    </div>
                    <div class="input-group input-group-sm ms-2" style="width: auto;">
                        <span class="input-group-text">Sales Person</span>
                        <select class="form-select form-select-sm" id="sales-person" style="width: 100px;">
                            <option value="">N/A</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-end mb-2">
                <button type="button" class="btn btn-sm btn-success me-1" id="save-order">Save and Finish</button>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row">
            <!-- Left Column: Order Form (75% width) -->
            <div class="col-md-9">
                <!-- Main Form -->
                <form id="order-form">
                    <div class="row g-2">
                        <!-- Address Information Row -->
                        <div class="col-md-12">
                            <div class="row g-2">
                                <!-- Shipping Info -->
                                <div class="col-md-6">
                                    <div class="card card-sm">
                                        <div class="card-body p-2">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="card-title mb-0">Shipping Information</h6>
                                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                    data-bs-target="#addressBookModal">
                                                    <i class="fas fa-address-book"></i> Address Book
                                                </button>
                                            </div>
                                            <div class="form-check form-check-inline mb-2">
                                                <input class="form-check-input" type="checkbox" id="non-residential">
                                                <label class="form-check-label small" for="non-residential">Non-residential</label>
                                            </div>
                                            <select class="form-select form-select-sm" id="shipping-address">
                                                <option value="">Select Address</option>
                                            </select>
                                            <div class="input-group input-group-sm mt-2">
                                                <span class="input-group-text">Address 1</span>
                                                <input type="text" class="form-control form-control-sm" id="shipping-address-1">
                                            </div>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">Address 2</span>
                                                <input type="text" class="form-control form-control-sm" id="shipping-address-2">
                                            </div>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">City</span>
                                                <input type="text" class="form-control form-control-sm" id="shipping-city">
                                            </div>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">State</span>
                                                <input type="text" class="form-control form-control-sm" id="shipping-state">
                                            </div>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">Zip</span>
                                                <input type="text" class="form-control form-control-sm" id="shipping-zip">
                                            </div>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">Country</span>
                                                <input type="text" class="form-control form-control-sm" id="shipping-country">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Billing Info -->
                                <div class="col-md-6">
                                    <div class="card card-sm">
                                        <div class="card-body p-2">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="card-title mb-0">Billing Information</h6>
                                            </div>
                                            <select class="form-select form-select-sm" id="billing-address">
                                                <option value="">Select Address</option>
                                            </select>
                                            <div class="input-group input-group-sm mt-2">
                                                <span class="input-group-text">Address 1</span>
                                                <input type="text" class="form-control form-control-sm" id="billing-address-1">
                                            </div>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">Address 2</span>
                                                <input type="text" class="form-control form-control-sm" id="billing-address-2">
                                            </div>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">City</span>
                                                <input type="text" class="form-control form-control-sm" id="billing-city">
                                            </div>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">State</span>
                                                <input type="text" class="form-control form-control-sm" id="billing-state">
                                            </div>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">Zip</span>
                                                <input type="text" class="form-control form-control-sm" id="billing-zip">
                                            </div>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">Country</span>
                                                <input type="text" class="form-control form-control-sm" id="billing-country">
                                            </div>
                                            <div class="form-check form-check-inline mt-2">
                                                <input class="form-check-input" type="checkbox" id="same-as-shipping">
                                                <label class="form-check-label small" for="same-as-shipping">Same as Shipping</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Origin and Payment Row -->
                        <div class="col-md-12">
                            <div class="row g-2">
                                <!-- Origin and Shipping -->
                                <div class="col-md-6">
                                    <div class="card card-sm">
                                        <div class="card-body p-2">
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <h6 class="card-title small mb-2">Origin</h6>
                                                    <div class="btn-group-vertical w-100" role="group">
                                                        <input type="radio" class="btn-check" name="origin" id="origin-afc-stock"
                                                            value="afc_stock" checked>
                                                        <label class="btn btn-sm btn-outline-secondary py-0" for="origin-afc-stock">AFC
                                                            Stock</label>
                                                        <input type="radio" class="btn-check" name="origin" id="origin-afc-make"
                                                            value="afc_make">
                                                        <label class="btn btn-sm btn-outline-secondary py-0" for="origin-afc-make">AFC
                                                            Make</label>
                                                        <input type="radio" class="btn-check" name="origin" id="origin-afc-acquire"
                                                            value="afc_acquire">
                                                        <label class="btn btn-sm btn-outline-secondary py-0" for="origin-afc-acquire">AFC
                                                            Acquire</label>
                                                        <input type="radio" class="btn-check" name="origin" id="origin-drop-ship"
                                                            value="drop_ship">
                                                        <label class="btn btn-sm btn-outline-secondary py-0" for="origin-drop-ship">Drop
                                                            Ship</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="card-title small mb-2">Shipping Method</h6>
                                                    <div class="btn-group-vertical w-100" role="group">
                                                        <input type="radio" class="btn-check" name="shipping_method"
                                                            id="shipping-small-package" value="small_package">
                                                        <label class="btn btn-sm btn-outline-secondary py-0"
                                                            for="shipping-small-package">Small Package</label>
                                                        <input type="radio" class="btn-check" name="shipping_method"
                                                            id="shipping-freight" value="freight">
                                                        <label class="btn btn-sm btn-outline-secondary py-0"
                                                            for="shipping-freight">Freight</label>
                                                        <input type="radio" class="btn-check" name="shipping_method"
                                                            id="shipping-delivery-afc" value="delivery_afc">
                                                        <label class="btn btn-sm btn-outline-secondary py-0"
                                                            for="shipping-delivery-afc">Delivery AFC</label>
                                                        <input type="radio" class="btn-check" name="shipping_method"
                                                            id="shipping-pickup-afc" value="pickup_afc">
                                                        <label class="btn btn-sm btn-outline-secondary py-0"
                                                            for="shipping-pickup-afc">Pickup AFC</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment and Correspondence -->
                                <div class="col-md-6">
                                    <div class="card card-sm mb-2">
                                        <div class="card-body p-2">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="card-title mb-0">Payment Information</h6>
                                                <div class="form-check form-check-inline m-0">
                                                    <input class="form-check-input" type="checkbox" id="add-po">
                                                    <label class="form-check-label small" for="add-po">Add PO</label>
                                                </div>
                                            </div>
                                            <select class="form-select form-select-sm" id="payment-method">
                                                <option value="">Select Payment</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <!-- Correspondence -->
                                    <div class="card card-sm">
                                        <div class="card-body p-2">
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <h6 class="card-title small mb-2">Customer</h6>
                                                    <select class="form-select form-select-sm mb-2" id="customer-print">
                                                        <option value="">Print...</option>
                                                        <option value="invoice">Invoice</option>
                                                        <option value="quote">Quote</option>
                                                    </select>
                                                    <select class="form-select form-select-sm" id="customer-email">
                                                        <option value="">Email...</option>
                                                        <option value="invoice">Invoice</option>
                                                        <option value="quote">Quote</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="card-title small mb-2">Supplier</h6>
                                                    <select class="form-select form-select-sm mb-2" id="supplier-print">
                                                        <option value="">Print Fax Order</option>
                                                        <option value="ship_request">Print Ship Request</option>
                                                    </select>
                                                    <select class="form-select form-select-sm" id="supplier-email">
                                                        <option value="">Email Supplier</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items Table -->
                    <div class="card mb-3 mt-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">Order Items</h5>
                                <small class="text-muted">Order ID: {{ $order->order_id }}</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm" id="orderItemsTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th style="width: 15%">Item #</th>
                                            <th style="width: 30%">Description</th>
                                            <th style="width: 10%">Size</th>
                                            <th style="width: 10%">Weight</th>
                                            <th style="width: 10%">Price</th>
                                            <th style="width: 10%">Quantity</th>
                                            <th style="width: 10%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Order items will be dynamically added here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden fields for order submission -->
                    <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                    <input type="hidden" name="order_items" id="orderItemsJson">

                    <!-- Order Totals -->
                    <div class="card card-sm mt-2">
                        <div class="card-body p-2">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label small">Shipping Cost ($)</label>
                                        <input type="number" class="form-control form-control-sm" id="shipping-cost"
                                            value="0" min="0" step="0.01">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small">Tax Rate (%)</label>
                                        <input type="number" class="form-control form-control-sm" id="tax-rate" value="0"
                                            min="0" max="100" step="0.01">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small">Discount ($)</label>
                                        <input type="number" class="form-control form-control-sm" id="discount" value="0"
                                            min="0" step="0.01">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                        <tr>
                                            <td>Subtotal:</td>
                                            <td class="text-end">$<span id="subtotal">0.00</span></td>
                                        </tr>
                                        <tr>
                                            <td>Shipping:</td>
                                            <td class="text-end">$<span id="shipping-cost-display">0.00</span></td>
                                        </tr>
                                        <tr>
                                            <td>Tax:</td>
                                            <td class="text-end">$<span id="tax-amount">0.00</span></td>
                                        </tr>
                                        <tr>
                                            <td>Discount:</td>
                                            <td class="text-end">-$<span id="discount-display">0.00</span></td>
                                        </tr>
                                        <tr class="fw-bold">
                                            <td>Total:</td>
                                            <td class="text-end">$<span id="total">0.00</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Calculator (replaced with button to open modal) -->
                    <div class="card card-sm mt-2">
                        <div class="card-body p-2">
                            <div class="row g-2">
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center gap-3">
                                        <button type="button" class="btn btn-sm btn-primary" id="calculateShippingBtn">
                                            <i class="fas fa-shipping-fast me-1"></i> Shipping Details
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger">Delete Shipping</button>

                                        <div class="d-flex align-items-center gap-2">
                                            <div class="form-check form-check-inline m-0">
                                                <input class="form-check-input" type="checkbox" id="tax-exempt">
                                                <label class="form-check-label small" for="tax-exempt">Tax Exempt</label>
                                            </div>

                                            <div class="input-group input-group-sm" style="width: auto;">
                                                <span class="input-group-text">Deposit</span>
                                                <div class="input-group-text">
                                                    <input class="form-check-input mt-0" type="radio" name="deposit"
                                                        value="1st">
                                                    <label class="form-check-label ms-1">1st</label>
                                                </div>
                                                <div class="input-group-text">
                                                    <input class="form-check-input mt-0" type="radio" name="deposit"
                                                        value="2nd">
                                                    <label class="form-check-label ms-1">2nd</label>
                                                </div>
                                            </div>
                                            <small class="text-muted">50% deposit required</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Display on Homepage -->
                    <div class="card card-sm mt-2">
                        <div class="card-body p-2">
                            <div class="row g-2 align-items-center">
                                <div class="col-auto">
                                    <label class="mb-0">DISPLAY ON HOMEPAGE:</label>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control form-control-sm" value="USE AT YOUR OWN RISK">
                                </div>
                                <div class="col-auto">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="enable-display">
                                        <label class="form-check-label" for="enable-display">Enable:</label>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-sm btn-success">Add/Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Custom Order Actions -->
                    <div class="card card-sm mt-2">
                        <div class="card-body p-2">
                            <div class="row g-2 align-items-center">
                                <div class="col-auto">
                                    <label class="mb-0">Custom Order Actions Note:</label>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control form-control-sm">
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-sm btn-success">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Activity -->
                    <div class="card card-sm mt-2">
                        <div class="card-body p-2">
                            <h6 class="card-title small mb-2">Order Activity:</h6>
                            <ol class="list-unstyled mb-0 small">
                                <li>1.) Order Started: by {{ auth()->user()->username ?? 'user' }} on {{ date('m/d/Y H:i:s') }}</li>
                            </ol>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Right Column: Categories Sidebar (25% width) -->
            <div class="col-md-3">
                @include('ams.order.categories-sidebar')
            </div>
        </div>
    </div>

    <!-- Include modals -->
    @include('ams.order.shipping-modal')
    
    <!-- Address Book Modal -->
    <div class="modal fade" id="addressBookModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Address Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                            <i class="fas fa-plus"></i> Add New Address
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Address 1</th>
                                    <th>Address 2</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Zip</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="addressBookTable">
                                <!-- Addresses will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css">
    <style>
        .card-sm {
            border: 1px solid rgba(0, 0, 0, 0.125);
            margin-bottom: 0.5rem;
        }

        .card-sm .card-body {
            padding: 0.5rem;
        }

        .form-control-sm,
        .form-select-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .table> :not(caption)>*>* {
            padding: 0.25rem;
        }

        .btn-group-vertical>.btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            text-align: left;
        }
        
        @media (max-width: 767px) {
            .col-md-9, .col-md-3 {
                width: 100%;
            }
            
            .col-md-3 {
                margin-top: 1rem;
            }
        }

        /* Shipping modal styling */
        .shipping-table th, .shipping-table td {
            font-size: 0.85rem;
            padding: 0.25rem;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('js/order-categories.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize modals
            const addressBookModal = new bootstrap.Modal(document.getElementById('addressBookModal'));
            const shippingModal = new bootstrap.Modal(document.getElementById('shippingModal'));
            
            // Update the Calculate Shipping button to open the modal
            $('#calculateShippingBtn').on('click', function() {
                shippingModal.show();
            });
            
            // Function to update order items table
            function updateOrderItemsTable() {
                try {
                    // Get items from localStorage
                    const orderItems = JSON.parse(localStorage.getItem('orderItems') || '[]');
                    const tbody = $('#orderItemsTable tbody');
                    tbody.empty();

                    // Add each item to the table
                    orderItems.forEach((item, index) => {
                        const row = $('<tr>');
                        row.html(`
                            <td>${index + 1}</td>
                            <td>${item.itemNo}</td>
                            <td>${item.productName}</td>
                            <td>${item.size}</td>
                            <td>${item.weight}</td>
                            <td>$${parseFloat(item.price).toFixed(2)}</td>
                            <td>
                                <input type="number" class="form-control form-control-sm item-quantity" 
                                    value="${item.quantity}" min="1" style="width: 60px"
                                    data-item-id="${item.id}">
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger delete-item" 
                                    data-item-id="${item.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        `);
                        tbody.append(row);
                    });

                    // Update order totals
                    updateOrderTotals();

                    // Store items in hidden field for form submission
                    $('#orderItemsJson').val(JSON.stringify(orderItems));
                } catch (error) {
                    console.error('Error updating order items table:', error);
                }
            }

            // Function to update order totals
            function updateOrderTotals() {
                try {
                    const orderItems = JSON.parse(localStorage.getItem('orderItems') || '[]');
                    
                    // Calculate subtotal
                    const subtotal = orderItems.reduce((total, item) => {
                        return total + (parseFloat(item.price) * parseInt(item.quantity));
                    }, 0);

                    // Get other values
                    const shippingCost = parseFloat($('#shipping-cost').val()) || 0;
                    const taxRate = parseFloat($('#tax-rate').val()) || 0;
                    const discount = parseFloat($('#discount').val()) || 0;

                    // Calculate tax
                    const taxAmount = (subtotal * taxRate) / 100;

                    // Calculate total
                    const total = subtotal + shippingCost + taxAmount - discount;

                    // Update display
                    $('#subtotal').text(subtotal.toFixed(2));
                    $('#shipping-cost-display').text(shippingCost.toFixed(2));
                    $('#tax-amount').text(taxAmount.toFixed(2));
                    $('#discount-display').text(discount.toFixed(2));
                    $('#total').text(total.toFixed(2));
                } catch (error) {
                    console.error('Error updating order totals:', error);
                }
            }

            // Handle quantity changes
            $(document).on('change', '.item-quantity', function() {
                const itemId = $(this).data('item-id');
                const newQuantity = parseInt($(this).val()) || 1;
                
                try {
                    let orderItems = JSON.parse(localStorage.getItem('orderItems') || '[]');
                    const itemIndex = orderItems.findIndex(item => item.id === itemId);
                    
                    if (itemIndex !== -1) {
                        orderItems[itemIndex].quantity = newQuantity;
                        localStorage.setItem('orderItems', JSON.stringify(orderItems));
                        updateOrderTotals();
                    }
                } catch (error) {
                    console.error('Error updating item quantity:', error);
                }
            });

            // Handle item deletion
            $(document).on('click', '.delete-item', function() {
                const itemId = $(this).data('item-id');
                
                try {
                    let orderItems = JSON.parse(localStorage.getItem('orderItems') || '[]');
                    orderItems = orderItems.filter(item => item.id !== itemId);
                    localStorage.setItem('orderItems', JSON.stringify(orderItems));
                    updateOrderItemsTable();
                } catch (error) {
                    console.error('Error deleting item:', error);
                }
            });

            // Load initial order items
            updateOrderItemsTable();

            // Handle shipping cost, tax rate, and discount changes
            $('#shipping-cost, #tax-rate, #discount').on('change', updateOrderTotals);
            
            // Function to open category page (now shows sidebar on mobile)
            window.openCategoryPage = function() {
                // On mobile, show the sidebar which might be hidden
                if (window.innerWidth < 768) {
                    $('.col-md-3').removeClass('d-none d-md-block').addClass('d-block');
                }
                
                // Focus on the first category
                $('#categoriesList .accordion-button:first').focus();
            };
            
            // Make updateOrderItemsTable available globally
            window.updateOrderItemsTable = updateOrderItemsTable;
            
            // Handle same as shipping checkbox
            $('#same-as-shipping').on('change', function() {
                if ($(this).is(':checked')) {
                    // Copy shipping address to billing address
                    $('#billing-address-1').val($('#shipping-address-1').val());
                    $('#billing-address-2').val($('#shipping-address-2').val());
                    $('#billing-city').val($('#shipping-city').val());
                    $('#billing-state').val($('#shipping-state').val());
                    $('#billing-zip').val($('#shipping-zip').val());
                    $('#billing-country').val($('#shipping-country').val());
                }
            });
            
            // Handle save order button
            $('#save-order').on('click', function() {
                // Validate form
                if (!validateOrderForm()) {
                    return;
                }
                
                // Submit form
                $('#order-form').submit();
            });
            
            // Function to validate order form
            function validateOrderForm() {
                let isValid = true;
                
                // Check if customer is selected
                if (!$('#customer-select').val()) {
                    alert('Please select a customer');
                    $('#customer-select').focus();
                    isValid = false;
                }
                
                // Check if there are items in the order
                const orderItems = JSON.parse(localStorage.getItem('orderItems') || '[]');
                if (orderItems.length === 0) {
                    alert('Please add at least one item to the order');
                    isValid = false;
                }
                
                return isValid;
            }
        });
    </script>
@endsection
