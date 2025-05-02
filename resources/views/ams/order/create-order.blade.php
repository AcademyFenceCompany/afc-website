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
                                <option value="{{ $customer->id }}" data-email="{{ $customer->email }}"
                                    data-company="{{ $customer->company }}" data-phone="{{ $customer->phone }}"
                                    data-alt-phone="{{ $customer->phone_alt }}" data-fax="{{ $customer->fax }}"
                                    {{ (isset($selectedCustomer) && $selectedCustomer->id == $customer->id) ? 'selected' : '' }}>
                                    {{ $customer->name ?: $customer->company }}
                                </option>
                            @endforeach
                        </select>
                        <a href="{{ route('customers.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-search"></i> Find Customer
                        </a>
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

        <!-- Customer Information Section -->
        @if(isset($selectedCustomer))
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Customer Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <p><strong>Name:</strong> {{ $selectedCustomer->name }}</p>
                                <p><strong>Company:</strong> {{ $selectedCustomer->company }}</p>
                                <p><strong>Contact:</strong> {{ $selectedCustomer->contact }}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Phone:</strong> {{ $selectedCustomer->phone }}</p>
                                <p><strong>Alt Phone:</strong> {{ $selectedCustomer->phone_alt }}</p>
                                <p><strong>Email:</strong> {{ $selectedCustomer->email }}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Fax:</strong> {{ $selectedCustomer->fax }}</p>
                                <p><strong>Customer ID:</strong> {{ $selectedCustomer->id }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Main Content Row -->
        <div class="row mt-4">
            <!-- Left Sidebar - Categories -->
            <div class="col-md-3">
                <!-- Add Items Section -->
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Add Items</h5>
                    </div>
                    <div class="card-body p-0">
                        <div id="categoriesList">
                            <div class="text-center py-4">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content - Order Details -->
            <div class="col-md-9">
                <!-- Address Information Row -->
                <div class="row g-2 mb-3">
                    <!-- Shipping Info -->
                    <div class="col-md-6">
                        <div class="card card-sm">
                            <div class="card-header bg-light p-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="card-title mb-0">Shipping Information</h6>
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#addressBookModal">
                                        <i class="bi bi-book"></i> Address Book
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">Name</span>
                                    <input type="text" class="form-control form-control-sm" id="shipping-name" 
                                        value="{{ isset($selectedCustomer) ? $selectedCustomer->name : '' }}">
                                </div>
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">Company</span>
                                    <input type="text" class="form-control form-control-sm" id="shipping-company"
                                        value="{{ isset($selectedCustomer) ? $selectedCustomer->company : '' }}">
                                </div>
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">Address</span>
                                    <input type="text" class="form-control form-control-sm" id="shipping-address"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_address : '' }}">
                                </div>
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">Address 2</span>
                                    <input type="text" class="form-control form-control-sm" id="shipping-address2"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_address2 : '' }}">
                                </div>
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">City</span>
                                    <input type="text" class="form-control form-control-sm" id="shipping-city"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_city : '' }}">
                                </div>
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">State</span>
                                    <input type="text" class="form-control form-control-sm" id="shipping-state"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_state : '' }}">
                                </div>
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">ZIP</span>
                                    <input type="text" class="form-control form-control-sm" id="shipping-zip"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_postcode : '' }}">
                                </div>
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">Country</span>
                                    <input type="text" class="form-control form-control-sm" id="shipping-country"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_country : 'USA' }}">
                                </div>
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">Phone</span>
                                    <input type="text" class="form-control form-control-sm" id="shipping-phone"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_phone : (isset($selectedCustomer) ? $selectedCustomer->phone : '') }}">
                                </div>
                                <input type="hidden" id="shipping-address-id" value="{{ isset($order->shipping_address) ? $order->shipping_address->id : '' }}">
                            </div>
                        </div>
                    </div>

                    <!-- Billing Information -->
                    <div class="col-md-6">
                        <div class="card card-sm">
                            <div class="card-header bg-light p-2">
                                <h6 class="card-title mb-0">Billing Information</h6>
                            </div>
                            <div class="card-body p-2">
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">Name</span>
                                    <input type="text" class="form-control form-control-sm" id="billing-name"
                                        value="{{ isset($order->billing_info) ? $order->billing_info->name : (isset($selectedCustomer) ? $selectedCustomer->name : '') }}">
                                </div>
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">Company</span>
                                    <input type="text" class="form-control form-control-sm" id="billing-company"
                                        value="{{ isset($order->billing_info) ? $order->billing_info->company : (isset($selectedCustomer) ? $selectedCustomer->company : '') }}">
                                </div>
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">Address</span>
                                    <input type="text" class="form-control form-control-sm" id="billing-address"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_address : '' }}">
                                </div>
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">Address 2</span>
                                    <input type="text" class="form-control form-control-sm" id="billing-address2"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_address2 : '' }}">
                                </div>
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">City</span>
                                    <input type="text" class="form-control form-control-sm" id="billing-city"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_city : '' }}">
                                </div>
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">State</span>
                                    <input type="text" class="form-control form-control-sm" id="billing-state"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_state : '' }}">
                                </div>
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">ZIP</span>
                                    <input type="text" class="form-control form-control-sm" id="billing-zip"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_postcode : '' }}">
                                </div>
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">Country</span>
                                    <input type="text" class="form-control form-control-sm" id="billing-country"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_country : 'USA' }}">
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" id="same-as-shipping">
                                    <label class="form-check-label small" for="same-as-shipping">Same as Shipping</label>
                                </div>
                                <input type="hidden" id="billing-info-id" value="{{ isset($order->billing_info) ? $order->billing_info->id : '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Origin and Payment Row -->
                <div class="row g-2 mb-3">
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

                <!-- Order Items Section -->
                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Order Items</h5>
                    </div>
                    
                    <!-- Product Search Box -->
                    <div class="card-body border-bottom pb-3">
                        <div class="row g-2">
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="productSearch" placeholder="Search by Item # or Product Name">
                                    <button class="btn btn-outline-secondary" type="button" id="searchProductBtn">
                                        <i class="bi bi-search"></i> Search
                                    </button>
                                </div>
                                <div id="searchResults" class="position-absolute bg-white border rounded shadow-sm d-none" style="z-index: 1000; width: 95%; max-height: 300px; overflow-y: auto;"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="itemNumberDirect" placeholder="Item #">
                                    <button class="btn btn-primary" type="button" id="addByItemBtn">
                                        <i class="bi bi-plus-lg"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="orderItemsTable">
                                <thead>
                                    <tr>
                                        <th>Item #</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="orderItemsTableBody">
                                    <!-- Order items will be loaded here -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                                        <td id="subtotal-display">$0.00</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Order Totals Section -->
                <div class="card card-sm mt-2">
                    <div class="card-body p-2">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">Tax Rate (%)</span>
                                    <input type="number" class="form-control" id="taxRate" name="tax_rate" value="0" min="0" max="100" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">Shipping Cost</span>
                                    <input type="number" class="form-control" id="shippingCost" name="shipping_cost" value="0" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex justify-content-between">
                                    <div>Tax: <span id="taxAmount">$0.00</span></div>
                                    <div>Total: <span id="total">$0.00</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Shipping Calculator -->
                <div class="card card-sm mt-2">
                    <div class="card-body p-2">
                        <div class="row g-2">
                            <div class="col-md-12">
                                <div class="d-flex align-items-center gap-3">
                                    <button type="button" class="btn btn-sm btn-primary" id="calculateShippingBtn" data-bs-toggle="modal" data-bs-target="#shippingModal">
                                        <i class="fas fa-shipping-fast me-1"></i> Calculate Shipping
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
                
                <!-- Hidden fields for order submission -->
                <input type="hidden" name="order_id" value="">
                <input type="hidden" name="order_items" id="orderItemsJson">
                <input type="hidden" name="subtotal" id="subtotalInput">
                <input type="hidden" name="tax_amount" id="taxInput">
                <input type="hidden" name="shipping_cost" id="shippingInput">
                <input type="hidden" name="total" id="totalInput">
            </div>
        </div>
    </div>

    <!-- Shipping Options Modal -->
    <div class="modal fade" id="shippingModal" tabindex="-1" aria-labelledby="shippingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="shippingModalLabel">Shipping</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="shippingTabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#upsShipping">UPS Shipping</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#freightShipping">Freight Shipping</a>
                        </li>
                    </ul>
                    
                    <div class="tab-content mt-3">
                        <!-- UPS Shipping Tab -->
                        <div class="tab-pane fade show active" id="upsShipping">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Class</th>
                                            <th>Size</th>
                                            <th>Qty per Box</th>
                                            <th>Weight</th>
                                            <th>Cost</th>
                                            <th>Item</th>
                                            <th>Qty in Box</th>
                                            <th>Weight of Box</th>
                                        </tr>
                                    </thead>
                                    <tbody id="upsShippingTable">
                                        <!-- UPS shipping items will be populated here -->
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="table-responsive mt-3">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Weight</th>
                                            <th>Total Cost</th>
                                            <th>Box Price</th>
                                            <th>Markup</th>
                                            <th>Full Price</th>
                                        </tr>
                                    </thead>
                                    <tbody id="upsShippingTotals">
                                        <!-- UPS shipping totals will be populated here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Freight Shipping Tab -->
                        <div class="tab-pane fade" id="freightShipping">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Carriers</th>
                                            <th>Weight</th>
                                            <th>Cost</th>
                                            <th>Markup</th>
                                            <th>Price</th>
                                            <th>Destination</th>
                                            <th>Quote Number</th>
                                            <th>Pallet Qty</th>
                                            <th>Pallet Size</th>
                                        </tr>
                                    </thead>
                                    <tbody id="freightShippingTable">
                                        <!-- Freight shipping items will be populated here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" class="btn btn-success btn-sm" id="populateToOrder">Populate to Order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    <script src="{{ asset('js/order-products.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize order items table
            updateOrderItemsTable();
            
            // Handle item removal
            $(document).on('click', '.remove-item-btn', function() {
                const itemId = $(this).data('id');
                removeOrderItem(itemId);
            });
            
            // Handle item quantity change
            $(document).on('change', '.item-quantity', function() {
                const itemId = $(this).data('id');
                const newQuantity = parseInt($(this).val());
                updateItemQuantity(itemId, newQuantity);
            });
            
            // Handle customer selection
            $('#customer-select').change(function() {
                const customerId = $(this).val();
                if (customerId) {
                    window.location.href = `/ams/orders/create?customer_id=${customerId}`;
                }
            });

            // Handle "Same as Shipping" checkbox
            $('#same-as-shipping').change(function() {
                if ($(this).is(':checked')) {
                    // Copy shipping address to billing address
                    $('#billing-name').val($('#shipping-name').val());
                    $('#billing-company').val($('#shipping-company').val());
                    $('#billing-address').val($('#shipping-address').val());
                    $('#billing-address2').val($('#shipping-address2').val());
                    $('#billing-city').val($('#shipping-city').val());
                    $('#billing-state').val($('#shipping-state').val());
                    $('#billing-zip').val($('#shipping-zip').val());
                    $('#billing-country').val($('#shipping-country').val());
                }
            });

            // Address Book Modal - Use Address
            $(document).on('click', '.use-address-btn', function() {
                const addressId = $(this).data('address-id');
                const addressType = $(this).data('address-type');
                
                // Get address data from the modal
                const name = $(this).data('name');
                const company = $(this).data('company');
                const address = $(this).data('address');
                const address2 = $(this).data('address2');
                const city = $(this).data('city');
                const state = $(this).data('state');
                const zip = $(this).data('zip');
                const country = $(this).data('country');
                const phone = $(this).data('phone');
                
                // Populate the appropriate address form
                if (addressType === 'shipping') {
                    $('#shipping-address-id').val(addressId);
                    $('#shipping-name').val(name);
                    $('#shipping-company').val(company);
                    $('#shipping-address').val(address);
                    $('#shipping-address2').val(address2);
                    $('#shipping-city').val(city);
                    $('#shipping-state').val(state);
                    $('#shipping-zip').val(zip);
                    $('#shipping-country').val(country);
                    $('#shipping-phone').val(phone);
                } else if (addressType === 'billing') {
                    $('#billing-info-id').val(addressId);
                    $('#billing-name').val(name);
                    $('#billing-company').val(company);
                    $('#billing-address').val(address);
                    $('#billing-address2').val(address2);
                    $('#billing-city').val(city);
                    $('#billing-state').val(state);
                    $('#billing-zip').val(zip);
                    $('#billing-country').val(country);
                }
                
                // Close the modal
                $('#addressBookModal').modal('hide');
            });

            // Save order
            $('#save-order').click(function() {
                // Collect order data
                const orderData = {
                    customer_id: $('#customer-select').val(),
                    call_date: $('#call-date').val(),
                    quote_number: $('#quote-number').val(),
                    sold_number: $('#sold-number').val(),
                    sales_person: $('#sales-person').val(),
                    shipping_address_id: $('#shipping-address-id').val(),
                    billing_address_id: $('#billing-info-id').val(),
                    items: getOrderItems(),
                    subtotal: calculateSubtotal(),
                    tax: calculateTax(),
                    shipping: calculateShipping(),
                    total: calculateTotal(),
                    notes: $('#order-notes').val()
                };

                // Submit order via AJAX
                $.ajax({
                    url: '{{ route("ams.orders.store") }}',
                    type: 'POST',
                    data: orderData,
                    success: function(response) {
                        if (response.success) {
                            alert('Order created successfully!');
                            // Redirect to the order view page
                            window.location.href = `/ams/orders/${response.order_id}`;
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            });

            // Helper functions for calculations
            function getOrderItems() {
                // Implementation depends on how order items are stored in the UI
                // For example, if stored in localStorage:
                return JSON.parse(localStorage.getItem('orderItems') || '[]');
            }

            function calculateSubtotal() {
                const items = getOrderItems();
                return items.reduce((total, item) => total + (item.price * item.quantity), 0);
            }

            function calculateTax() {
                // Implement tax calculation logic
                return calculateSubtotal() * 0.07; // Example: 7% tax
            }

            function calculateShipping() {
                // Implement shipping calculation logic
                return 0; // Default to 0
            }

            function calculateTotal() {
                return calculateSubtotal() + calculateTax() + calculateShipping();
            }
        });
        
        // Function to update the order items table
        function updateOrderItemsTable() {
            const orderItems = getOrderItems();
            const tableBody = $('#orderItemsTableBody');
            tableBody.empty();
            
            if (orderItems.length === 0) {
                // tableBody.append('<tr><td colspan="6" class="text-center">No items added to order</td></tr>');
                $('#subtotal-display').text('$0.00');
                return;
            }
            
            let subtotal = 0;
            
            orderItems.forEach(function(item) {
                const itemTotal = parseFloat(item.price) * parseInt(item.quantity);
                subtotal += itemTotal;
                
                const row = `
                    <tr>
                        <td>${item.itemNo}</td>
                        <td>${item.productName}</td>
                        <td>$${parseFloat(item.price).toFixed(2)}</td>
                        <td>
                            <input type="number" class="form-control form-control-sm item-quantity" 
                                value="${item.quantity}" min="1" data-id="${item.id}">
                        </td>
                        <td>$${itemTotal.toFixed(2)}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger remove-item-btn" data-id="${item.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                
                tableBody.append(row);
            });
            
            $('#subtotal-display').text('$' + subtotal.toFixed(2));
            updateOrderTotals();
        }
        
        // Function to get order items from localStorage
        function getOrderItems() {
            const storedItems = localStorage.getItem('orderItems');
            return storedItems ? JSON.parse(storedItems) : [];
        }
        
        // Function to remove an item from the order
        function removeOrderItem(itemId) {
            let orderItems = getOrderItems();
            orderItems = orderItems.filter(item => item.id !== itemId);
            localStorage.setItem('orderItems', JSON.stringify(orderItems));
            updateOrderItemsTable();
            showToast('Item removed from order', 'warning');
        }
        
        // Function to update an item's quantity
        function updateItemQuantity(itemId, newQuantity) {
            if (newQuantity < 1) return;
            
            let orderItems = getOrderItems();
            const itemIndex = orderItems.findIndex(item => item.id === itemId);
            
            if (itemIndex !== -1) {
                orderItems[itemIndex].quantity = newQuantity;
                localStorage.setItem('orderItems', JSON.stringify(orderItems));
                updateOrderItemsTable();
            }
        }
        
        // Function to update order totals
        function updateOrderTotals() {
            const subtotal = parseFloat($('#subtotal-display').text().replace('$', '')) || 0;
            const taxRate = parseFloat($('#taxRate').val()) || 0;
            const taxAmount = subtotal * (taxRate / 100);
            const shippingCost = parseFloat($('#shippingCost').val()) || 0;
            const total = subtotal + taxAmount + shippingCost;
            
            $('#taxAmount').text('$' + taxAmount.toFixed(2));
            $('#total').text('$' + total.toFixed(2));
            
            // Update hidden inputs for form submission
            $('#subtotalInput').val(subtotal.toFixed(2));
            $('#taxInput').val(taxAmount.toFixed(2));
            $('#shippingInput').val(shippingCost.toFixed(2));
            $('#totalInput').val(total.toFixed(2));
            
            // Update order items JSON for submission
            $('#orderItemsJson').val(JSON.stringify(getOrderItems()));
        }
    </script>
    <script>
        function calculateOrderTotals() {
            const subtotal = parseFloat(document.getElementById('subtotal-display').textContent.replace('$', '')) || 0;
            const taxRate = parseFloat(document.getElementById('taxRate').value) || 0;
            const taxAmount = subtotal * (taxRate / 100);
            
            // Update tax amount display if it exists
            const taxDisplay = document.getElementById('tax-display');
            if (taxDisplay) {
                taxDisplay.textContent = '$' + taxAmount.toFixed(2);
            }
            
            // Calculate and update total
            const total = subtotal + taxAmount;
            const totalDisplay = document.getElementById('total-display');
            if (totalDisplay) {
                totalDisplay.textContent = '$' + total.toFixed(2);
            }
            
            // Update hidden fields for form submission
            document.getElementById('subtotal').value = subtotal.toFixed(2);
            document.getElementById('tax_amount').value = taxAmount.toFixed(2);
            document.getElementById('total').value = total.toFixed(2);
        }
        
        // Initialize tax rate change listener
        document.getElementById('taxRate').addEventListener('change', calculateOrderTotals);
    </script>
@endsection
