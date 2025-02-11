@extends('layouts.ams')

@section('title', 'Create New Order')

@section('content')
    <div class="container-fluid py-2">
        <!-- Header Info -->
        <div class="row g-2 mb-2">
            <div class="col-md-12">
                <div class="d-flex align-items-center gap-2">
                    <div class="input-group input-group-sm" style="width: auto;">
                        <span class="input-group-text">Call Date</span>
                        <input type="date" class="form-control form-control-sm" id="call-date" value="{{ date('Y-m-d') }}"
                            readonly>
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
                <button type="button" class="btn btn-sm btn-primary" id="addItemsBtn" data-bs-toggle="modal" data-bs-target="#productModal">
                    Add Items
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
                                <button type="button" class="btn btn-sm btn-outline-primary py-0" data-bs-toggle="modal" data-bs-target="#addressBookModal">View Address Book</button>
                            </div>
                            <div class="form-check form-check-inline mb-2">
                                <input class="form-check-input" type="checkbox" id="non-residential">
                                <label class="form-check-label small" for="non-residential">Non-residential</label>
                            </div>
                            <select class="form-select form-select-sm" id="shipping-address">
                                <option value="">Select Address</option>
                            </select>
                        </div>
                    </div>

                    <!-- Billing Info -->
                    <div class="card card-sm mb-2">
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="card-title mb-0">Billing Information</h6>
                                <button type="button" class="btn btn-sm btn-outline-primary py-0" data-bs-toggle="modal" data-bs-target="#addressBookModal">View Address Book</button>
                            </div>
                            <select class="form-select form-select-sm" id="billing-address">
                                <option value="">Select Address</option>
                            </select>
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
            <div class="card card-sm">
                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover" id="orderItemsTable">
                            <thead>
                                <tr>
                                    <th>Item #</th>
                                    <th>Description</th>
                                    <th>Color</th>
                                    <th>Size</th>
                                    <th>Size 2</th>
                                    <th>Style</th>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="10" class="text-center">No items added yet</td>
                                </tr>
                            </tbody>
                        </table>
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
                                            <input class="form-check-input mt-0" type="radio" name="deposit" value="1st">
                                            <label class="form-check-label ms-1">1st</label>
                                        </div>
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0" type="radio" name="deposit" value="2nd">
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
                                    <input type="date" class="form-control form-control-sm" id="res-date" value="{{ date('Y-m-d') }}">
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

    <!-- Product Selection Modal -->
    <div class="modal fade" id="productModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Products</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Category Tree -->
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body p-2">
                                    <div class="input-group input-group-sm mb-2">
                                        <span class="input-group-text">Search</span>
                                        <input type="text" class="form-control" id="categorySearch" placeholder="Search categories...">
                                    </div>
                                    <ul class="category-tree">
                                        @include('ams.partials.category-tree-items', ['categories' => $categories])
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Products Table -->
                        <div class="col-md-9">
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text">Search</span>
                                <input type="text" class="form-control" id="productSearch" placeholder="Search products...">
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover" id="productsTable">
                                    <thead>
                                        <tr>
                                            <th>Item #</th>
                                            <th>Description</th>
                                            <th>Color</th>
                                            <th>Size</th>
                                            <th>Size 2</th>
                                            <th>Style</th>
                                            <th>Unit Price</th>
                                            <th>Stock</th>
                                            <th>Quantity</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="10" class="text-center">Select a category to view products</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-primary" id="addSelectedProducts">Add Selected</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Address Book Modal -->
    <div class="modal fade" id="addressBookModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Address Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <select class="form-select form-select-sm mb-2" id="customerSelect">
                            <option value="">Select Customer...</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="addressList">
                        <!-- Addresses will be loaded here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-primary" id="selectAddress">Select Address</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
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
    <script src="{{ secure_asset('js/order-management.js') }}"></script>
@endsection
