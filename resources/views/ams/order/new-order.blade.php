@extends('layouts.ams')

@section('title', 'New Order Process')

@section('content')
    <div class="container mt-4">
        <!-- Initial Selection -->
        <div class="row justify-content-center" id="customerTypeSelection">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Select Customer Type</h4>
                    </div>
                    <div class="card-body text-center">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="p-4 border rounded h-100">
                                    <i class="bi bi-person-plus display-4"></i>
                                    <h5 class="mt-3">New Customer</h5>
                                    <p class="text-muted">Create a new customer profile</p>
                                    <button class="btn btn-primary" onclick="showNewCustomerForm()">
                                        Create New Customer
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-4 border rounded h-100">
                                    <i class="bi bi-people display-4"></i>
                                    <h5 class="mt-3">Existing Customer</h5>
                                    <p class="text-muted">Search for existing customer</p>
                                    <button class="btn btn-success" onclick="showCustomerSearch()">
                                        Find Customer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Search Section -->
        <div class="row justify-content-center" id="customerSearchSection" style="display: none;">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Search Customer</h4>
                        <button class="btn btn-secondary" onclick="showCustomerTypeSelection()">
                            Back
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg"
                                        placeholder="Search by name, company, email, or phone..." id="customerSearchInput"
                                        onkeyup="debounceSearch(this.value)">
                                    <button class="btn btn-primary">
                                        <i class="bi bi-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Search Results -->
                        <div id="searchResults"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- New Customer Form Section -->
        <div class="row justify-content-center" id="newCustomerSection" style="display: none;">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Create New Customer</h4>
                        <button class="btn btn-secondary" onclick="showCustomerTypeSelection()">
                            Back
                        </button>
                    </div>
                    <div class="card-body">
                        <form id="newCustomerForm" action="{{ route('customers.store') }}" method="POST">
                            @csrf
                            <!-- Customer Information -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h5>Customer Information</h5>
                                    <hr>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Full Name *</label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Company</label>
                                        <input type="text" class="form-control" name="company">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Phone *</label>
                                        <input type="tel" class="form-control" name="phone" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Phone Extension</label>
                                        <input type="text" class="form-control" name="phone_ext">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Alternative Phone</label>
                                        <input type="tel" class="form-control" name="alt_phone">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Alt. Phone Extension</label>
                                        <input type="text" class="form-control" name="alt_phone_ext">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Fax</label>
                                        <input type="text" class="form-control" name="fax">
                                    </div>
                                </div>
                            </div>

                            <!-- Address Information -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h5>Address Information</h5>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Address Label/Name</label>
                                        <input type="text" class="form-control" name="address_name"
                                            placeholder="e.g., Main Office, Home, etc.">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Address Line 1 *</label>
                                        <input type="text" class="form-control" name="address_1" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Address Line 2</label>
                                        <input type="text" class="form-control" name="address_2">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">City *</label>
                                        <input type="text" class="form-control" name="city" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">State *</label>
                                        <input type="text" class="form-control" name="state" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Zipcode *</label>
                                        <input type="text" class="form-control" name="zipcode" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="billing_flag"
                                                value="1" checked>
                                            <label class="form-check-label">Use as Billing Address</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="shipping_flag"
                                                value="1" checked>
                                            <label class="form-check-label">Use as Shipping Address</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        Create Customer
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Section visibility functions
            function showCustomerTypeSelection() {
                document.getElementById('customerTypeSelection').style.display = 'flex';
                document.getElementById('customerSearchSection').style.display = 'none';
                document.getElementById('newCustomerSection').style.display = 'none';
            }

            function showNewCustomerForm() {
                document.getElementById('customerTypeSelection').style.display = 'none';
                document.getElementById('customerSearchSection').style.display = 'none';
                document.getElementById('newCustomerSection').style.display = 'block';
            }

            function showCustomerSearch() {
                document.getElementById('customerTypeSelection').style.display = 'none';
                document.getElementById('customerSearchSection').style.display = 'block';
                document.getElementById('newCustomerSection').style.display = 'none';
            }

            // Debounce function for search
            let debounceTimeout;

            function debounceSearch(query) {
                clearTimeout(debounceTimeout);
                debounceTimeout = setTimeout(() => {
                    searchCustomers(query);
                }, 300);
            }

            // Customer search function
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
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="mb-1">${customer.name}</h5>
                                    ${customer.company ? `<p class="text-muted mb-1">${customer.company}</p>` : ''}
                                    <p class="mb-1">
                                        ${customer.phone}
                                        ${customer.email ? `<br>${customer.email}` : ''}
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <strong>Addresses:</strong><br>
                                    ${customer.addresses.map(addr => 
                                        `${addr.city}, ${addr.state}`
                                    ).join('<br>')}
                                </div>
                                <div class="col-md-2 text-end">
                                    <button class="btn btn-primary" 
                                            onclick="viewCustomerDetails(${customer.id})">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                        });
                    });
            }

            // View customer details
            function viewCustomerDetails(customerId) {
                window.location.href = `/customers/${customerId}`;
            }
        </script>
    @endpush
@endsection
