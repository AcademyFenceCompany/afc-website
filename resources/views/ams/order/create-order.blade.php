@extends('layouts.ams')

@section('title', 'Create New Order')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('/assets/css/style.css')}}" >
<style>
    .content {
    padding:0rem;
    background-color:rgb(255, 255, 255);
    }
    .header{
        border-radius:0;
    }
    .breadcrumb-item + .breadcrumb-item::before{
        content: ">";
    }
    @media print {
        form{
            display: none;
        }
        .d-print-none {
           display: none;
       }
    }
</style>
@endsection
@section('content')
    <div class="container-fluid p-4">
        <!-- Header Info -->
        <div class="row g-2 mb-2 d-none">
            <div class="col-md-12">
                <div class="d-flex align-items-center gap-2">
                    <div class="input-group input-group" style="width: auto;">
                        <span class="input-group-text">Customer</span>
                        <select class="form-select form-select" id="customer-select" style="min-width: 200px;">
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
                        <a href="{{ route('customers.index') }}" class="btn btn-outline-primary btn">
                            <i class="bi bi-search"></i> Find Customer
                        </a>
                    </div>
                    <div class="input-group input-group" style="width: auto;">
                        <span class="input-group-text">Call Date</span>
                        <input type="date" class="form-control form-control" id="call-date"
                            value="{{ date('Y-m-d') }}" readonly>
                    </div>
                    <div class="input-group input-group" style="width: auto;">
                        <span class="input-group-text">Quote</span>
                        <input type="text" class="form-control form-control" id="quote-number"
                            value="{{ auth()->user()->username ?? '' }}">
                    </div>
                    <div class="input-group input-group" style="width: auto;">
                        <span class="input-group-text">Sold</span>
                        <input type="text" class="form-control form-control" id="sold-number">
                    </div>
                    <div class="input-group input-group ms-2" style="width: auto;">
                        <span class="input-group-text">Sales Person</span>
                        <select class="form-select form-select" id="sales-person" style="width: 100px;">
                            <option value="">N/A</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-end mb-2">
                <button type="button" class="btn btn btn-success me-1" id="save-order">Save and Finish</button>
                <button type="button" class="btn btn btn-danger" id="clearOrderItems">Clear Items</button>
            </div>
        </div>
        <!-- Header2 Info -->
        <section>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="mb-3">Find Customer</h5>
                            <div class="input-group">
                                <input type="search" class="form-control rounded customer-search" id="customer-search" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                                <button type="button" class="btn btn-outline-primary" data-mdb-ripple-init>search</button>
                            </div>
                            <div>
                                <ul class="list-group customer-results d-none">
                                    <li class="list-group-item"><strong>Customer Name</strong> <span class="float-end">(324.342.2342)</span></li>
                                    <li class="list-group-item"><strong>Customer Name</strong> (324.342.2342)</li>
                                    <li class="list-group-item"><strong>Customer Name</strong> (324.342.2342)</li>
                                    <li class="list-group-item"><strong>Customer Name</strong> (324.342.2342)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="mb-3">Save and Confirm</h5>
                            <button type="button" class="btn btn-success w-100 mb-2" id="saveOrderBtn">
                                <i class="fas fa-save me-1"></i> Save Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            

        </section>
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
                <div class="row mb-3">
                    
                    <div class="col-md-6">
                        <!-- Shipping Info -->
                        <div class="card card mb-3">
                            <div class="card-header bg-light p-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="card-title mb-0">Shipping Information</h6>
                                    <button type="button" class="btn btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#addressBookModal">
                                        <i class="bi bi-book"></i> Address Book
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div class="input-group input-group mb-1">
                                    <span class="input-group-text">Name</span>
                                    <input type="text" class="form-control form-control" id="shipping-name" 
                                        value="{{ isset($selectedCustomer) ? $selectedCustomer->name : '' }}">
                                </div>
                                <div class="input-group input-group mb-1">
                                    <span class="input-group-text">Company</span>
                                    <input type="text" class="form-control form-control" id="shipping-company"
                                        value="{{ isset($selectedCustomer) ? $selectedCustomer->company : '' }}">
                                </div>
                                <div class="input-group input-group mb-1">
                                    <span class="input-group-text">Address</span>
                                    <input type="text" class="form-control form-control" id="shipping-address"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_address : '' }}">
                                </div>
                                <div class="input-group input-group mb-1">
                                    <span class="input-group-text">Address 2</span>
                                    <input type="text" class="form-control form-control" id="shipping-address2"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_address2 : '' }}">
                                </div>
                                <div class="input-group input-group mb-1">
                                    <span class="input-group-text">City</span>
                                    <input type="text" class="form-control form-control" id="shipping-city"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_city : '' }}">
                                </div>
                                <div class="input-group input-group mb-1">
                                    <span class="input-group-text">State</span>
                                    <input type="text" class="form-control form-control" id="shipping-state"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_state : '' }}">
                                </div>
                                <div class="input-group input-group mb-1">
                                    <span class="input-group-text">ZIP</span>
                                    <input type="text" class="form-control form-control" id="shipping-zip"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_postcode : '' }}">
                                </div>
                                <div class="input-group input-group mb-1">
                                    <span class="input-group-text">Country</span>
                                    <input type="text" class="form-control form-control" id="shipping-country"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_country : 'USA' }}">
                                </div>
                                <div class="input-group input-group mb-1">
                                    <span class="input-group-text">Phone</span>
                                    <input type="text" class="form-control form-control" id="shipping-phone"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_phone : (isset($selectedCustomer) ? $selectedCustomer->phone : '') }}">
                                </div>
                                <input type="hidden" id="shipping-address-id" value="{{ isset($order->shipping_address) ? $order->shipping_address->id : '' }}">
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" id="same-as-shipping">
                                    <label class="form-check-label small" for="same-as-shipping">Same as Shipping</label>
                                </div>
                            </div>
                        </div>
                        <!-- Billing Information -->
                        <div class="card card d-none">
                            <div class="card-header bg-light p-2">
                                <h6 class="card-title mb-0">Billing Information</h6>
                            </div>
                            <div class="card-body p-2">
                                <div class="input-group input-group mb-1">
                                    <span class="input-group-text">Name</span>
                                    <input type="text" class="form-control form-control" id="billing-name"
                                        value="{{ isset($order->billing_info) ? $order->billing_info->name : (isset($selectedCustomer) ? $selectedCustomer->name : '') }}">
                                </div>
                                <div class="input-group input-group mb-1">
                                    <span class="input-group-text">Company</span>
                                    <input type="text" class="form-control form-control" id="billing-company"
                                        value="{{ isset($order->billing_info) ? $order->billing_info->company : (isset($selectedCustomer) ? $selectedCustomer->company : '') }}">
                                </div>
                                <div class="input-group input-group mb-1">
                                    <span class="input-group-text">Address</span>
                                    <input type="text" class="form-control form-control" id="billing-address"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_address : '' }}">
                                </div>
                                <div class="input-group input-group mb-1">
                                    <span class="input-group-text">Address 2</span>
                                    <input type="text" class="form-control form-control" id="billing-address2"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_address2 : '' }}">
                                </div>
                                <div class="input-group input-group mb-1">
                                    <span class="input-group-text">City</span>
                                    <input type="text" class="form-control form-control" id="billing-city"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_city : '' }}">
                                </div>
                                <div class="input-group input-group mb-1">
                                    <span class="input-group-text">State</span>
                                    <input type="text" class="form-control form-control" id="billing-state"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_state : '' }}">
                                </div>
                                <div class="input-group input-group mb-1">
                                    <span class="input-group-text">ZIP</span>
                                    <input type="text" class="form-control form-control" id="billing-zip"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_postcode : '' }}">
                                </div>
                                <div class="input-group input-group mb-1">
                                    <span class="input-group-text">Country</span>
                                    <input type="text" class="form-control form-control" id="billing-country"
                                        value="{{ isset($order->shipping_address) ? $order->shipping_address->addr_country : 'USA' }}">
                                </div>
                                <input type="hidden" id="billing-info-id" value="{{ isset($order->billing_info) ? $order->billing_info->id : '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Payment Information -->
                        <div class="card mb-4 p-3">
                            <div class="card-body p-2">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="card-title mb-0">Payment Information</h6>
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input" type="checkbox" id="add-po">
                                        <label class="form-check-label small" for="add-po">Add PO</label>
                                    </div>
                                </div>
                                <select class="form-select form-select" id="payment-method">
                                    <option value="">Select Payment</option>
                                    <option value="cash">Cash</option>
                                    <option value="check">Check</option>
                                    <option value="paypal">PayPal</option>
                                    <option value="account_card">Account Card</option>
                                    <option value="office_card">Office Card</option>
                                </select>
                                <!-- Credit Card Fields -->
                                <div id="credit-card-fields" class="mt-3">
                                    <div class="input-group input-group mb-2">
                                        <span class="input-group-text">Card Number</span>
                                        <input type="text" class="form-control" id="cc-number" maxlength="19" autocomplete="cc-number" placeholder="•••• •••• •••• ••••">
                                    </div>
                                    <div class="row g-2 mb-2">
                                        <div class="col">
                                            <div class="input-group input-group">
                                                <span class="input-group-text">Exp. Month</span>
                                                <input type="text" class="form-control" id="cc-exp-month" maxlength="2" autocomplete="cc-exp-month" placeholder="MM">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="input-group input-group">
                                                <span class="input-group-text">Exp. Year</span>
                                                <input type="text" class="form-control" id="cc-exp-year" maxlength="4" autocomplete="cc-exp-year" placeholder="YYYY">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="input-group input-group">
                                                <span class="input-group-text">CVV</span>
                                                <input type="text" class="form-control" id="cc-cvv" maxlength="4" autocomplete="cc-csc" placeholder="CVV">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group input-group mb-2">
                                        <span class="input-group-text">Cardholder Name</span>
                                        <input type="text" class="form-control" id="cc-name" autocomplete="cc-name" placeholder="Name on Card">
                                    </div>
                                    <div class="input-group input-group mb-2">
                                        <span class="input-group-text">Billing ZIP</span>
                                        <input type="text" class="form-control" id="cc-zip" maxlength="10" autocomplete="postal-code" placeholder="ZIP Code">
                                    </div>
                                </div>
                                <div class="d-grid gap-2 my-3">
                                    <button type="button" class="btn btn-lg btn-primary fw-bold" id="process-order-btn">
                                        <i class="fas fa-credit-card me-2"></i> Process Order
                                    </button>
                                </div>
                                
                                <!-- Order Status Dropdown -->
                                <div class="mt-2 d-none">
                                    <label for="order-status" class="form-label small mb-1">Order Status</label>
                                    <select class="form-select form-select" id="order-status" name="order_status">
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

                        <!-- Origin and Shipping -->
                        <div class="card mb-4">
                            <div class="card-body p-2">
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <h6 class="card-title small mb-2">Origin</h6>
                                        <div class="btn-group-vertical w-100" role="group">
                                            <input type="radio" class="btn-check" name="origin" id="origin-afc-stock"
                                                value="afc_stock" checked>
                                            <label class="btn btn btn-outline-secondary py-0" for="origin-afc-stock">AFC
                                                Stock</label>
                                            <input type="radio" class="btn-check" name="origin" id="origin-afc-make"
                                                value="afc_make">
                                            <label class="btn btn btn-outline-secondary py-0" for="origin-afc-make">AFC
                                                Make</label>
                                            <input type="radio" class="btn-check" name="origin" id="origin-afc-acquire"
                                                value="afc_acquire">
                                            <label class="btn btn btn-outline-secondary py-0" for="origin-afc-acquire">AFC
                                                Acquire</label>
                                            <input type="radio" class="btn-check" name="origin" id="origin-drop-ship"
                                                value="drop_ship">
                                            <label class="btn btn btn-outline-secondary py-0" for="origin-drop-ship">Drop
                                                Ship</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="card-title small mb-2">Shipping Method</h6>
                                        <div class="btn-group-vertical w-100" role="group">
                                            <input type="radio" class="btn-check" name="shipping_method"
                                                id="shippingall-package" value="small_package">
                                            <label class="btn btn btn-outline-secondary py-0"
                                                for="shippingall-package">Small Package</label>
                                            <input type="radio" class="btn-check" name="shipping_method"
                                                id="shipping-freight" value="freight">
                                            <label class="btn btn btn-outline-secondary py-0"
                                                for="shipping-freight">Freight</label>
                                            <input type="radio" class="btn-check" name="shipping_method"
                                                id="shipping-delivery-afc" value="delivery_afc">
                                            <label class="btn btn btn-outline-secondary py-0"
                                                for="shipping-delivery-afc">Delivery AFC</label>
                                            <input type="radio" class="btn-check" name="shipping_method"
                                                id="shipping-pickup-afc" value="pickup_afc">
                                            <label class="btn btn btn-outline-secondary py-0"
                                                for="shipping-pickup-afc">Pickup AFC</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Correspondence -->
                        <div class="card p-3">
                            <div class="card-body p-2">
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <h6 class="card-title small mb-2">Customer</h6>
                                        <div class="dropdown">
                                            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><span class="dropdown-text">Print Documents</span>
                                            <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li><a href="#"><label><input type="checkbox" class="selectall" /><span class="select-text"> Select</span> All</label></a></li>
                                                <li class="divider"></li>
                                                <li><a class="option-link" href="#"><label><input name='options[]' type="checkbox" class="option justone" value='Option 1 '/> Option 1</label></a></li>
                                                <li><a href="#"><label><input name='options[]' type="checkbox" class="option justone" value='Option 2 '/> Option 2</label></a></li>
                                                <li><a href="#"><label><input name='options[]' type="checkbox" class="option justone" value='Option 3 '/> Option 3</label></a></li>
                                            </ul>
                                        </div>
                                        <select class="form-select form-select mb-2" id="customer-print">
                                            <option value="">Print Fax Order</option>
                                            <option value="ship_request">Print Ship Request</option>
                                        </select>
                                        <select class="form-select form-select" id="customer-email">
                                            <option value="">Email Customer</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="card-title small mb-2">Supplier</h6>
                                        <select class="form-select form-select mb-2" id="supplier-print">
                                            <option value="">Print Fax Order</option>
                                            <option value="ship_request">Print Ship Request</option>
                                        </select>
                                        <select class="form-select form-select" id="supplier-email">
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
                                <div id="searchResults" class="position-absolute bg-white border rounded shadow d-none" style="z-index: 1000; width: 95%; max-height: 300px; overflow-y: auto;"></div>
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
                                    <!-- Shipper Information -->
                                    <div id="shipperInfo"></div>
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
                                        <h5 class="mb-0">UPS Small Package</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table">
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
                                            <table class="table table-bordered table">
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
                                            <table class="table table-bordered table">
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
                                    <button type="button" class="btn btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                        <i class="fas fa-plus"></i> Add New Address
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table table-hover">
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
            </div>
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
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css">
    <style>
        .card {
            border: 1px solid rgba(0, 0, 0, 0.125);
            margin-bottom: 0.5rem;
        }

        .card .card-body {
            padding: 0.5rem;
        }

        .form-control,
        .form-select {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .btn {
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
