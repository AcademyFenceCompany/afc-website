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
                    <div class="input-group input-group-sm" style="width: auto;">
                        <span class="input-group-text">Customer Confirmed</span>
                        <input type="text" class="form-control form-control-sm" id="sold-number">
                    </div>
                    <div class="input-group input-group-sm" style="width: auto;">
                        <span class="input-group-text">Shipped Confirmed</span>
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
                <button type="button" class="btn btn-sm btn-primary" onclick="openCategoryPage()">
                    <i class="fas fa-plus"></i> Add Products
                </button>
            </div>
        </div>

        <!-- Main Form -->
        <form id="order-form">
            <div class="row g-2">
                <!-- Left Column -->
                <div class="col-md-6">
                    <!-- Shipping Info -->
                    <div class="card card-sm mb-2">
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

                    <!-- Billing Info -->
                    <div class="card card-sm mb-2">
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="card-title mb-0">Billing Information</h6>
                                {{-- <button type="button" class="btn btn-sm btn-outline-primary py-0" data-bs-toggle="modal"
                                    data-bs-target="#addressBookModal">View Address Book</button> --}}
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

                    <!-- Origin and Shipping -->
                    <div class="card card-sm mb-2">
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

                <!-- Right Column -->
                <div class="col-md-6">
                    <!-- Payment Info -->
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
                    <div class="card card-sm mb-2">
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

            <!-- Order Items Table -->
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Order Items</h5>
                        <small class="text-muted">Order ID: {{ $order->order_id }}</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary" onclick="openCategoryPage()">
                        <i class="fas fa-plus"></i> Add Products
                    </button>
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

            <!-- Shipping Calculator -->
            <div class="card card-sm mt-2">
                <div class="card-body p-2">
                    <div class="row g-2">
                        <div class="col-md-12">
                            <div class="d-flex align-items-center gap-3">
                                <button type="button" class="btn btn-sm btn-primary">Calculate Shipping</button>
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

                                <div class="d-flex gap-2 flex-grow-1">
                                    <input type="text" class="form-control form-control-sm" placeholder="Carrier">
                                    <input type="text" class="form-control form-control-sm" placeholder="Weight">
                                    <input type="text" class="form-control form-control-sm" placeholder="Class">
                                    <input type="text" class="form-control form-control-sm" placeholder="Cost Price">
                                    <input type="text" class="form-control form-control-sm" placeholder="Zip">
                                    <input type="date" class="form-control form-control-sm" id="res-date"
                                        value="{{ date('Y-m-d') }}">
                                    <input type="text" class="form-control form-control-sm" placeholder="Packages">
                                    <input type="text" class="form-control form-control-sm" placeholder="Quoted by">
                                    <input type="text" class="form-control form-control-sm" placeholder="Quote #">
                                    <button type="button" class="btn btn-sm btn-success">Select Show</button>
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
                        <li>1.) Order Started: by sunny on {{ date('m/d/Y H:i:s') }}</li>
                        <li>2.) Order origin is AFC Stock by sunny on {{ date('m/d/Y H:i:s') }}</li>
                        <li>3.) Order origin is AFC Make by sunny on {{ date('m/d/Y H:i:s') }}</li>
                        <li>4.) Order origin is AFC Acquire by sunny on {{ date('m/d/Y H:i:s') }}</li>
                        <li>5.) Order origin is Drop Ship by sunny on {{ date('m/d/Y H:i:s') }}</li>
                    </ol>
                </div>
            </div>
        </form>
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

    <!-- Add Address Modal -->
    <div class="modal fade" id="addAddressModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addAddressForm">
                        <div class="mb-2">
                            <label class="form-label small">Address 1</label>
                            <input type="text" class="form-control form-control-sm" id="new-address-1" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Address 2</label>
                            <input type="text" class="form-control form-control-sm" id="new-address-2">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">City</label>
                            <input type="text" class="form-control form-control-sm" id="new-city" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">State</label>
                            <input type="text" class="form-control form-control-sm" id="new-state" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Zip</label>
                            <input type="text" class="form-control form-control-sm" id="new-zip" required>
                        </div>
                        <div class="mb-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="new-shipping" checked>
                                <label class="form-check-label small">Shipping Address</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="new-billing" checked>
                                <label class="form-check-label small">Billing Address</label>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-sm btn-primary">Add Address</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Address Modal -->
    <div class="modal fade" id="editAddressModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editAddressForm">
                        <input type="hidden" id="edit-address-id">
                        <div class="mb-2">
                            <label class="form-label small">Address 1</label>
                            <input type="text" class="form-control form-control-sm" id="edit-address-1" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Address 2</label>
                            <input type="text" class="form-control form-control-sm" id="edit-address-2">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">City</label>
                            <input type="text" class="form-control form-control-sm" id="edit-city" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">State</label>
                            <input type="text" class="form-control form-control-sm" id="edit-state" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Zip</label>
                            <input type="text" class="form-control form-control-sm" id="edit-zip" required>
                        </div>
                        <div class="mb-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="edit-shipping">
                                <label class="form-check-label small">Shipping Address</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="edit-billing">
                                <label class="form-check-label small">Billing Address</label>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-sm btn-primary">Update Address</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .card-sm {
            border: 1px solid rgba(0, 0, 0, 0.125);
        }

        .category-tree {
            list-style: none;
            padding-left: 0;
        }

        .category-tree ul {
            list-style: none;
            padding-left: 1.5rem;
        }

        .category-item {
            margin-bottom: 0.25rem;
        }

        .toggle-btn {
            padding: 0;
            color: #6c757d;
        }

        .category-link {
            text-decoration: none;
            color: #212529;
            cursor: pointer;
        }

        .category-link:hover {
            color: #0d6efd;
        }

        .category-link.active {
            color: #0d6efd;
            font-weight: 500;
        }

        .nested {
            display: none;
        }

        .card-sm {
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
    </style>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Initialize modals
            const addressBookModal = new bootstrap.Modal(document.getElementById('addressBookModal'));

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

            // Function to open category page
            window.openCategoryPage = function() {
                const orderId = $('input[name="order_id"]').val();
                const url = "{{ route('ams.orders.categories') }}";
                const categoryWindow = window.open(`${url}?order_id=${orderId}`, 'categoryWindow');
                
                // Make updateOrderItemsTable available to child window
                window.updateOrderItemsTable = updateOrderItemsTable;
            };

            // Function to clear address fields
            function clearAddressFields() {
                clearShippingFields();
                clearBillingFields();
            }

            // Function to clear shipping fields
            function clearShippingFields() {
                $('#shipping-address-1').val('');
                $('#shipping-address-2').val('');
                $('#shipping-city').val('');
                $('#shipping-state').val('');
                $('#shipping-zip').val('');
            }

            // Function to clear billing fields
            function clearBillingFields() {
                $('#billing-address-1').val('');
                $('#billing-address-2').val('');
                $('#billing-city').val('');
                $('#billing-state').val('');
                $('#billing-zip').val('');
            }

            // Function to copy shipping to billing
            function copyShippingToBilling() {
                $('#billing-address-1').val($('#shipping-address-1').val());
                $('#billing-address-2').val($('#shipping-address-2').val());
                $('#billing-city').val($('#shipping-city').val());
                $('#billing-state').val($('#shipping-state').val());
                $('#billing-zip').val($('#shipping-zip').val());
            }

            // Function to clear address selects
            function clearAddressSelects() {
                $('#shipping-address, #billing-address').html('<option value="">Select address</option>');
                clearAddressFields();
            }

            // Load customer addresses when customer is selected
            $('#customer-select').on('change', function() {
                const customerId = $(this).val();
                if (!customerId) {
                    clearAddressSelects();
                    return;
                }

                // Show loading state
                $('#shipping-address, #billing-address').html('<option value="">Loading addresses...</option>');

                // Fetch customer addresses
                $.ajax({
                    url: `/ams/customers/${customerId}/addresses`,
                    method: 'GET',
                    success: function(response) {
                        if (response.success && response.addresses) {
                            updateAddressSelects(response.addresses);
                            updateAddressBookTable(response.addresses);
                        } else {
                            clearAddressSelects();
                            console.error('No addresses in response:', response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading addresses:', error);
                        console.error('Response:', xhr.responseText);
                        clearAddressSelects();
                    }
                });
            });

            // Update address selects with fetched addresses
            function updateAddressSelects(addresses) {
                const shippingSelect = $('#shipping-address');
                const billingSelect = $('#billing-address');
                
                // Clear existing options
                shippingSelect.find('option:not(:first)').remove();
                billingSelect.find('option:not(:first)').remove();

                // Add shipping addresses
                addresses.forEach(addr => {
                    if (addr.shipping_flag) {
                        const option = $('<option>', {
                            value: addr.address_id,
                            text: `${addr.address_1 || ''} ${addr.city || ''}, ${addr.state || ''} ${addr.zipcode || ''}`
                        });
                        option.data({
                            'address1': addr.address_1,
                            'address2': addr.address_2,
                            'city': addr.city,
                            'state': addr.state,
                            'zip': addr.zipcode
                        });
                        shippingSelect.append(option);
                    }
                });

                // Add billing addresses
                addresses.forEach(addr => {
                    if (addr.billing_flag) {
                        const option = $('<option>', {
                            value: addr.address_id,
                            text: `${addr.address_1 || ''} ${addr.city || ''}, ${addr.state || ''} ${addr.zipcode || ''}`
                        });
                        option.data({
                            'address1': addr.address_1,
                            'address2': addr.address_2,
                            'city': addr.city,
                            'state': addr.state,
                            'zip': addr.zipcode
                        });
                        billingSelect.append(option);
                    }
                });
            }

            // Update address book table
            function updateAddressBookTable(addresses) {
                const tbody = $('#addressBookTable');
                tbody.empty();

                addresses.forEach(addr => {
                    const types = [];
                    if (addr.shipping_flag) types.push('Shipping');
                    if (addr.billing_flag) types.push('Billing');
                    
                    const row = $('<tr>');
                    row.html(`
                        <td>${addr.address_1 || ''}</td>
                        <td>${addr.address_2 || ''}</td>
                        <td>${addr.city || ''}</td>
                        <td>${addr.state || ''}</td>
                        <td>${addr.zipcode || ''}</td>
                        <td>${types.join(', ')}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-primary select-address" 
                                    data-type="${types.join(',')}"
                                    data-address1="${addr.address_1 || ''}"
                                    data-address2="${addr.address_2 || ''}"
                                    data-city="${addr.city || ''}"
                                    data-state="${addr.state || ''}"
                                    data-zip="${addr.zipcode || ''}">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button type="button" class="btn btn-warning edit-address" 
                                    data-address-id="${addr.address_id}"
                                    data-address1="${addr.address_1 || ''}"
                                    data-address2="${addr.address_2 || ''}"
                                    data-city="${addr.city || ''}"
                                    data-state="${addr.state || ''}"
                                    data-zip="${addr.zipcode || ''}"
                                    data-shipping="${addr.shipping_flag}"
                                    data-billing="${addr.billing_flag}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger delete-address" data-address-id="${addr.address_id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    `);
                    tbody.append(row);
                });
            }

            // Handle new address form submission
            $('#addAddressForm').on('submit', function(e) {
                e.preventDefault();
                const customerId = $('#customer-select').val();
                if (!customerId) {
                    alert('Please select a customer first');
                    return;
                }

                const formData = {
                    address_1: $('#new-address-1').val(),
                    address_2: $('#new-address-2').val(),
                    city: $('#new-city').val(),
                    state: $('#new-state').val(),
                    zipcode: $('#new-zip').val(),
                    shipping_flag: $('#new-shipping').is(':checked') ? 1 : 0,
                    billing_flag: $('#new-billing').is(':checked') ? 1 : 0
                };

                $.ajax({
                    url: `/ams/customers/${customerId}/addresses`,
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            // Refresh addresses
                            $('#customer-select').trigger('change');
                            // Clear form
                            $('#addAddressForm')[0].reset();
                            // Hide modal
                            $('#addAddressModal').modal('hide');
                        } else {
                            alert(response.message || 'Error adding address');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error adding address:', xhr.responseText);
                        alert('Error adding address');
                    }
                });
            });

            // Handle edit address
            $(document).on('click', '.edit-address', function() {
                const btn = $(this);
                const addressId = btn.data('address-id');

                // Fill edit form
                $('#edit-address-id').val(addressId);
                $('#edit-address-1').val(btn.data('address1'));
                $('#edit-address-2').val(btn.data('address2'));
                $('#edit-city').val(btn.data('city'));
                $('#edit-state').val(btn.data('state'));
                $('#edit-zip').val(btn.data('zip'));
                $('#edit-shipping').prop('checked', btn.data('shipping') === 1);
                $('#edit-billing').prop('checked', btn.data('billing') === 1);

                // Show edit modal
                $('#editAddressModal').modal('show');
            });

            // Handle edit address form submission
            $('#editAddressForm').on('submit', function(e) {
                e.preventDefault();
                const customerId = $('#customer-select').val();
                const addressId = $('#edit-address-id').val();

                const formData = {
                    address_1: $('#edit-address-1').val(),
                    address_2: $('#edit-address-2').val(),
                    city: $('#edit-city').val(),
                    state: $('#edit-state').val(),
                    zipcode: $('#edit-zip').val(),
                    shipping_flag: $('#edit-shipping').is(':checked') ? 1 : 0,
                    billing_flag: $('#edit-billing').is(':checked') ? 1 : 0
                };

                $.ajax({
                    url: `/ams/customers/${customerId}/addresses/${addressId}`,
                    method: 'PUT',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            // Refresh addresses
                            $('#customer-select').trigger('change');
                            // Hide modal
                            $('#editAddressModal').modal('hide');
                        } else {
                            alert(response.message || 'Error updating address');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error updating address:', xhr.responseText);
                        alert('Error updating address');
                    }
                });
            });

            // Handle delete address
            $(document).on('click', '.delete-address', function() {
                if (!confirm('Are you sure you want to delete this address?')) {
                    return;
                }

                const customerId = $('#customer-select').val();
                const addressId = $(this).data('address-id');

                $.ajax({
                    url: `/ams/customers/${customerId}/addresses/${addressId}`,
                    method: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            // Refresh addresses
                            $('#customer-select').trigger('change');
                        } else {
                            alert(response.message || 'Error deleting address');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error deleting address:', xhr.responseText);
                        alert('Error deleting address');
                    }
                });
            });

            // Handle address book selection
            $(document).on('click', '.select-address', function() {
                const btn = $(this);
                const type = btn.data('type').split(',');
                const addressData = {
                    address1: btn.data('address1'),
                    address2: btn.data('address2'),
                    city: btn.data('city'),
                    state: btn.data('state'),
                    zip: btn.data('zip')
                };

                if (type.includes('Shipping')) {
                    fillAddressFields('shipping', addressData);
                }
                if (type.includes('Billing')) {
                    fillAddressFields('billing', addressData);
                }

                $('#addressBookModal').modal('hide');
            });

            // Handle shipping address selection
            $('#shipping-address').on('change', function() {
                const selected = $(this).find(':selected');
                if (selected.val()) {
                    fillAddressFields('shipping', {
                        address1: selected.data('address1'),
                        address2: selected.data('address2'),
                        city: selected.data('city'),
                        state: selected.data('state'),
                        zip: selected.data('zip')
                    });

                    // If "Same as Shipping" is checked, update billing too
                    if ($('#same-as-shipping').is(':checked')) {
                        copyShippingToBilling();
                    }
                } else {
                    clearShippingFields();
                }
            });

            // Handle billing address selection
            $('#billing-address').on('change', function() {
                const selected = $(this).find(':selected');
                if (selected.val()) {
                    fillAddressFields('billing', {
                        address1: selected.data('address1'),
                        address2: selected.data('address2'),
                        city: selected.data('city'),
                        state: selected.data('state'),
                        zip: selected.data('zip')
                    });
                } else {
                    clearBillingFields();
                }
            });

            // Function to fill address fields
            function fillAddressFields(prefix, data) {
                $(`#${prefix}-address-1`).val(data.address1);
                $(`#${prefix}-address-2`).val(data.address2);
                $(`#${prefix}-city`).val(data.city);
                $(`#${prefix}-state`).val(data.state);
                $(`#${prefix}-zip`).val(data.zip);
            }

            // Handle "Same as Shipping" checkbox
            $('#same-as-shipping').on('change', function() {
                if ($(this).is(':checked')) {
                    copyShippingToBilling();
                    $('#billing-address').prop('disabled', true);
                    $('#billing-address-1, #billing-address-2, #billing-city, #billing-state, #billing-zip')
                        .prop('readonly', true);
                } else {
                    $('#billing-address').prop('disabled', false);
                    $('#billing-address-1, #billing-address-2, #billing-city, #billing-state, #billing-zip')
                        .prop('readonly', false);
                }
            });
        });

        // Order Items Table Management code...
    </script>
@endsection
