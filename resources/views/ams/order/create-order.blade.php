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
<<<<<<< HEAD
                                <option value="{{ $customer->customer_id }}" data-email="{{ $customer->email }}"
                                    data-company="{{ $customer->company_name }}" data-phone="{{ $customer->phone }}"
                                    data-alt-phone="{{ $customer->alternative_phone }}" data-fax="{{ $customer->fax }}"
                                    {{ request('customer_id') == $customer->customer_id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
=======
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
>>>>>>> origin/ready-push-main
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
<<<<<<< HEAD
                    <div class="input-group input-group-sm" style="width: auto;">
                        <span class="input-group-text">Customer Confirmed</span>
                        <input type="text" class="form-control form-control-sm" id="sold-number">
                    </div>
                    <div class="input-group input-group-sm" style="width: auto;">
                        <span class="input-group-text">Shipped Confirmed</span>
                        <input type="text" class="form-control form-control-sm" id="sold-number">
                    </div>
=======
>>>>>>> origin/ready-push-main
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
<<<<<<< HEAD
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
=======
                <button type="button" class="btn btn-sm btn-danger" id="clearOrderItems">Clear Items</button>
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
                @include('ams.order.categories-sidebar')
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
>>>>>>> origin/ready-push-main
                            </div>
                        </div>
                    </div>

<<<<<<< HEAD
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
=======
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
                                
                                <!-- Order Status Dropdown -->
                                <div class="mt-2">
                                    <label for="order-status" class="form-label small mb-1">Order Status</label>
                                    <select class="form-select form-select-sm" id="order-status" name="order_status">
                                        <option value="QUOTE" data-color="#FFD8B1">QUOTE</option>
                                        <option value="NEW" data-color="#A9D4F6">NEW</option>
                                        <option value="PROCESSED" data-color="#C0C0C0">PROCESSED</option>
                                        <option value="PROCESSING" data-color="#E8B4B4">PROCESSING</option>
                                        <option value="DEPOSIT" data-color="#B6D7B9">DEPOSIT</option>
                                        <option value="MATERIAL" data-color="#FF5252">MATERIAL</option>
                                    </select>
                                </div>
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
>>>>>>> origin/ready-push-main
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<<<<<<< HEAD
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
=======
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
>>>>>>> origin/ready-push-main
                            </table>
                        </div>
                    </div>
                </div>
<<<<<<< HEAD
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
=======
                
                <!-- Order Totals Section -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Order Totals</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text">Tax Rate (%)</span>
                                    <input type="number" class="form-control" id="taxRate" name="tax_rate" value="0" min="0" max="100" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text">Shipping</span>
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control" id="shipping-cost-value" value="0.00" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="calculateShipping()">Calculate</button>
                                </div>
                                <input type="hidden" id="shipping-cost" name="shipping_cost" value="0">
                                <input type="hidden" id="shipping-method" name="shipping_method" value="">
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Total:</span>
                                    <span class="fw-bold" id="total-display">$0.00</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary" onclick="calculateShipping()">
                                    <i class="fas fa-shipping-fast me-1"></i> Calculate Shipping
                                </button>
                                <button type="button" class="btn btn-danger" onclick="deleteShipping()">Delete Shipping</button>
                                
                                <div class="d-inline-block ms-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="tax-exempt" name="tax_exempt" value="1">
                                        <label class="form-check-label" for="tax-exempt">Tax Exempt</label>
                                    </div>
                                </div>
                                
                                <div class="d-inline-block ms-3">
                                    <span class="me-2">Deposit</span>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="deposit" id="deposit-1st" value="1st">
                                        <label class="form-check-label" for="deposit-1st">1st</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="deposit" id="deposit-2nd" value="2nd">
                                        <label class="form-check-label" for="deposit-2nd">2nd</label>
                                    </div>
                                    <span class="ms-2 text-muted">50% deposit required</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Hidden inputs for form submission -->
                        <input type="hidden" id="subtotal" name="subtotal" value="0">
                        <input type="hidden" id="tax_amount" name="tax_amount" value="0">
                        <input type="hidden" id="total" name="total" value="0">
                        <input type="hidden" id="orderItemsJson" name="order_items" value="[]">
                    </div>
                </div>
                
                <!-- Shipping Modal -->
                <div class="modal fade" id="shippingModal" tabindex="-1" aria-labelledby="shippingModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="shippingModalLabel">Shipping</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Shipping Rates List -->
                                <div id="shippingRates" class="mb-3">
                                    <!-- Shipping rates will be populated here -->
                                    <div class="text-center p-4">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mt-2">Calculating shipping rates...</p>
                                    </div>
                                </div>
                                
                                <!-- UPS Shipping Section -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">UPS Shipping</h5>
                                    </div>
                                    <div class="card-body">
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
                                </div>
                                
                                <!-- Freight Shipping Section -->
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Freight Shipping</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Select</th>
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
                                
                                <!-- Shipping Estimate Organizer -->
                                <div class="card mt-3">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Shipping Estimate Organizer</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="shipping-organizer-carrier" class="form-label">Carrier</label>
                                                    <input type="text" class="form-control" id="shipping-organizer-carrier" name="shipping_organizer_carrier">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="shipping-organizer-weight" class="form-label">Weight</label>
                                                    <input type="text" class="form-control" id="shipping-organizer-weight" name="shipping_organizer_weight">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="shipping-organizer-class" class="form-label">Class</label>
                                                    <input type="text" class="form-control" id="shipping-organizer-class" name="shipping_organizer_class">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="shipping-organizer-cost" class="form-label">Cost Price</label>
                                                    <input type="text" class="form-control" id="shipping-organizer-cost" name="shipping_organizer_cost">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="shipping-organizer-zip" class="form-label">Zip</label>
                                                    <input type="text" class="form-control" id="shipping-organizer-zip" name="shipping_organizer_zip">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="shipping-organizer-res-date" class="form-label">Res Date</label>
                                                    <input type="date" class="form-control" id="shipping-organizer-res-date" name="shipping_organizer_res_date" value="{{ date('Y-m-d') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="shipping-organizer-packages" class="form-label">Packages</label>
                                                    <input type="text" class="form-control" id="shipping-organizer-packages" name="shipping_organizer_packages">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="shipping-organizer-quoted-by" class="form-label">Quoted by</label>
                                                    <input type="text" class="form-control" id="shipping-organizer-quoted-by" name="shipping_organizer_quoted_by" value="sunny">
                                                </div>
                                            </div>
                                            <div class="col-md-8 d-flex align-items-end">
                                                <button type="button" class="btn btn-primary" id="addShippingEstimate">Add to Order</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" class="btn btn-success" id="populateToOrder">Populate to Order</button>
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
>>>>>>> origin/ready-push-main
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<<<<<<< HEAD

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

=======
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/order-categories.js') }}"></script>
    <script src="{{ asset('js/order-products.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize order items table
            updateOrderItemsTable();
            
            // Initialize datepicker
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
            
            // Handle form submission
            $('#orderForm').on('submit', function(e) {
                // Don't clear localStorage on form submission
                // This allows the items to persist even after page reload
                
                // Ensure order items are included in form submission
                $('#orderItemsJson').val(JSON.stringify(getOrderItems()));
            });
            
            // Initialize address lookup
            $('#customer_id').on('change', function() {
                const customerId = $(this).val();
                if (customerId) {
                    $.ajax({
                        url: `/api/customers/${customerId}/addresses`,
                        method: 'GET',
                        success: function(data) {
                            populateAddresses(data);
                        },
                        error: function(xhr) {
                            console.error('Error fetching addresses:', xhr);
                        }
                    });
                }
            });
            
            // Clear existing items from previous implementations
            $('#clearOrderItems').on('click', function() {
                if (confirm('Are you sure you want to clear all order items?')) {
                    clearOrderItems(); // This function is defined in order-products.js
                }
            });
            
            // Connect the calculate shipping button
            $('button[onclick="calculateShipping()"]').on('click', function() {
                if (typeof window.calculateShipping === 'function') {
                    window.calculateShipping();
                } else {
                    console.error('calculateShipping function not found');
                    alert('Shipping calculation is not available. Please check the console for errors.');
                }
            });
            
            // If categories don't load after 3 seconds, initialize with default categories
            setTimeout(function() {
                if ($('#categoriesList .spinner-border').length > 0) {
                    console.log('Categories not loaded after timeout, initializing with defaults');
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
            }, 3000);
        });
        
        function calculateOrderTotals() {
            const subtotal = parseFloat(document.getElementById('subtotal-display').textContent.replace('$', '')) || 0;
            const taxRate = parseFloat(document.getElementById('taxRate').value) || 0;
            const taxAmount = subtotal * (taxRate / 100);
            const shippingCost = parseFloat(document.getElementById('shipping-cost').value) || 0;
            
            // Update tax amount display if it exists
            const taxDisplay = document.getElementById('tax-display');
            if (taxDisplay) {
                taxDisplay.textContent = '$' + taxAmount.toFixed(2);
            }
            
            // Calculate and update total
            const total = subtotal + taxAmount + shippingCost;
            const totalDisplay = document.getElementById('total-display');
            if (totalDisplay) {
                totalDisplay.textContent = '$' + total.toFixed(2);
            }
            
            // Update hidden fields for form submission
            document.getElementById('subtotal').value = subtotal.toFixed(2);
            document.getElementById('tax_amount').value = taxAmount.toFixed(2);
            document.getElementById('total').value = total.toFixed(2);
            
            console.log('Order totals updated:', { subtotal, taxAmount, shippingCost, total });
        }
        
        // Initialize tax rate change listener
        document.getElementById('taxRate').addEventListener('change', calculateOrderTotals);
        
        // Helper function to get order items (for compatibility)
        function getOrderItems() {
            return JSON.parse(localStorage.getItem('orderItems') || '[]');
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const orderStatusDropdown = document.getElementById('order-status');
            orderStatusDropdown.addEventListener('change', function() {
                applyOrderStatusColor(this);
            });
            
            // Initialize the color on page load
            if (orderStatusDropdown) {
                applyOrderStatusColor(orderStatusDropdown);
            }
            
            // Save Order Button Event Listener
            const saveOrderBtn = document.getElementById('save-order');
            if (saveOrderBtn) {
                saveOrderBtn.addEventListener('click', function() {
                    // Get all the order data including the order status
                    const formData = {
                        customer_id: document.getElementById('customer-select').value,
                        call_date: document.getElementById('call-date').value,
                        quote_number: document.getElementById('quote-number').value,
                        sold_number: document.getElementById('sold-number').value,
                        sales_person: document.getElementById('sales-person').value,
                        shipping_name: document.getElementById('shipping-name')?.value,
                        shipping_company: document.getElementById('shipping-company')?.value,
                        shipping_address: document.getElementById('shipping-address')?.value,
                        shipping_address2: document.getElementById('shipping-address2')?.value,
                        shipping_city: document.getElementById('shipping-city')?.value,
                        shipping_state: document.getElementById('shipping-state')?.value,
                        shipping_zip: document.getElementById('shipping-zip')?.value,
                        shipping_phone: document.getElementById('shipping-phone')?.value,
                        
                        subtotal: document.getElementById('subtotal')?.value,
                        tax_amount: document.getElementById('tax_amount')?.value,
                        shipping_cost: document.getElementById('shipping-cost')?.value,
                        total: document.getElementById('total')?.value,
                        
                        // This is the key change - include the order status
                        order_status: document.getElementById('order-status')?.value
                    };
                    
                    // Send the data to the server
                    fetch('/ams/orders', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(formData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Order saved successfully!');
                            // Always redirect to the activity page instead of trying to view the order
                            window.location.href = '/ams/activity';
                        } else {
                            alert('Error saving order: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error saving order:', error);
                        alert('Error saving order. Please try again.');
                    });
                });
            }
        });
        
        function applyOrderStatusColor(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const color = selectedOption.getAttribute('data-color');
            selectElement.style.backgroundColor = color;
            selectElement.style.color = '#fff';
        }
    </script>
>>>>>>> origin/ready-push-main
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<<<<<<< HEAD
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
=======
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css">
    <style>
        .card-sm {
            border: 1px solid rgba(0, 0, 0, 0.125);
>>>>>>> origin/ready-push-main
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
<<<<<<< HEAD
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
=======
        
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
        
        /* Order Status Styling */
        .order-status {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-weight: bold;
            text-align: center;
            min-width: 80px;
        }
        
        .order-status-QUOTE {
            background-color: #FFD8B1;
            color: #000;
        }
        
        .order-status-PROCESSED {
            background-color: #C0C0C0;
            color: #000;
        }
        
        .order-status-DEPOSIT {
            background-color: #B6D7B9;
            color: #000;
        }
        
        .order-status-NEW {
            background-color: #A9D4F6;
            color: #000;
        }
        
        .order-status-PROCESSING {
            background-color: #E8B4B4;
            color: #000;
        }
        
        .order-status-MATERIAL {
            background-color: #FF5252;
            color: #fff;
        }
    </style>
@endsection
>>>>>>> origin/ready-push-main
