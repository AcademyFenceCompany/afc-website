@extends('layouts.ams')

@section('title', 'New Order')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Create New Order</h4>
                    </div>
                    <div class="card-body">
                        <!-- Customer Selection Section -->
                        <div class="customer-selection mb-4">
                            <h5>Select Customer Type</h5>
                            <div class="d-flex gap-3 mt-3">
                                <button class="btn btn-primary" onclick="showExistingCustomerForm()">
                                    Existing Customer
                                </button>
                                <button class="btn btn-success" onclick="showNewCustomerForm()">
                                    New Customer
                                </button>
                            </div>
                        </div>

                        <!-- Existing Customer Search Form -->
                        <div id="existingCustomerForm" class="customer-form" style="display: none;">
                            <h5>Search Existing Customer</h5>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="customerSearch"
                                    placeholder="Search by name, email, or phone..." oninput="searchCustomers(this.value)">
                            </div>
                            <div id="searchResults" class="list-group mb-4">
                                <!-- Search results will be dynamically populated here -->
                            </div>
                        </div>

                        <!-- New Customer Form -->
                        <div id="newCustomerForm" class="customer-form" style="display: none;">
                            <h5>Add New Customer</h5>
                            <form id="customerForm" action="{{ route('customers.store') }}" method="POST">
                                @csrf
                                <!-- Customer Details -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Full Name *</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="company" class="form-label">Company</label>
                                        <input type="text" class="form-control" id="company" name="company">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="phone" class="form-label">Phone *</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" required>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="phone_ext" class="form-label">Extension</label>
                                        <input type="text" class="form-control" id="phone_ext" name="phone_ext">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="alt_phone" class="form-label">Alternative Phone</label>
                                        <input type="tel" class="form-control" id="alt_phone" name="alt_phone">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="alt_phone_ext" class="form-label">Alt. Ext</label>
                                        <input type="text" class="form-control" id="alt_phone_ext" name="alt_phone_ext">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="fax" class="form-label">Fax</label>
                                        <input type="text" class="form-control" id="fax" name="fax">
                                    </div>
                                </div>

                                <!-- Address Section -->
                                <h5 class="mt-4">Primary Address</h5>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="address_name" class="form-label">Address Name/Label</label>
                                        <input type="text" class="form-control" id="address_name" name="address_name">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="address_1" class="form-label">Address Line 1 *</label>
                                        <input type="text" class="form-control" id="address_1" name="address_1"
                                            required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="address_2" class="form-label">Address Line 2</label>
                                        <input type="text" class="form-control" id="address_2" name="address_2">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="city" class="form-label">City *</label>
                                        <input type="text" class="form-control" id="city" name="city"
                                            required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="state" class="form-label">State *</label>
                                        <input type="text" class="form-control" id="state" name="state"
                                            required>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="zipcode" class="form-label">Zipcode *</label>
                                        <input type="text" class="form-control" id="zipcode" name="zipcode"
                                            required>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="billing_flag"
                                                name="billing_flag" value="1">
                                            <label class="form-check-label" for="billing_flag">
                                                Use as Billing Address
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="shipping_flag"
                                                name="shipping_flag" value="1">
                                            <label class="form-check-label" for="shipping_flag">
                                                Use as Shipping Address
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Add Customer & Continue to
                                        Order</button>
                                    <button type="button" class="btn btn-secondary"
                                        onclick="showExistingCustomerForm()">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function showExistingCustomerForm() {
                document.getElementById('existingCustomerForm').style.display = 'block';
                document.getElementById('newCustomerForm').style.display = 'none';
            }

            function showNewCustomerForm() {
                document.getElementById('existingCustomerForm').style.display = 'none';
                document.getElementById('newCustomerForm').style.display = 'block';
            }

            function searchCustomers(query) {
                if (query.length < 2) {
                    document.getElementById('searchResults').innerHTML = '';
                    return;
                }

                fetch(`/api/customers/search?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        const resultsDiv = document.getElementById('searchResults');
                        resultsDiv.innerHTML = '';

                        data.forEach(customer => {
                            resultsDiv.innerHTML += `
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">${customer.name}</h6>
                                <small>${customer.email || ''} ${customer.phone ? '| ' + customer.phone : ''}</small>
                            </div>
                            <button class="btn btn-sm btn-primary" onclick="selectCustomer(${customer.id})">
                                Select
                            </button>
                        </div>
                    </div>
                `;
                        });
                    });
            }

            function selectCustomer(customerId) {
                // Proceed to order details page with selected customer
                window.location.href = `/orders/create/details/${customerId}`;
            }
        </script>
    @endpush
@endsection
