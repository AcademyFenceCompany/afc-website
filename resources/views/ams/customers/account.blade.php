@extends('layouts.ams')
@section('selected', 'Customers')
@section('content')
<div class="container-fluid p-4 h-100" style="background-color: #eee;">
    <div class="">
        <h4><i class="bi text-primary bi-person-circle me-2"></i>Account Overview</h4>
        <p class="text-muted">Here you can view and manage your account details, orders, addresses, and payment information.</p>
    </div>

    <div class="row ">
        <!-- Left Column: Profile Info -->
        <div class="col-md-4 mb-4">
            <div class="card mb-4 py-3">
                <div class="card-body text-center">
                    <img src="{{asset('assets/images/user-avatar.png')}}" alt="avatar"
                    class="rounded-circle img-fluid py-4" style="width: 150px;">
                    <h5 class="my-3">{{$customer->name}}</h5>
                    @if(!empty($customer->company))
                        <p class="text-muted mb-1">{{ $customer->company }}</p>
                    @endif
                    @if(!empty($customer->address) && !empty($customer->city) && !empty($customer->state))
                        <p class="text-muted mb-4">{{ $customer->address }}, {{ $customer->city }}, {{ $customer->state }}</p>
                    @endif
                    <p class="text-muted mb-4">
                        <i class="bi bi-envelope-fill"></i> {{ $customer->email ?? 'N/A' }}<br>
                        <i class="bi bi-telephone-fill"></i> {{ $customer->phone ?? 'N/A' }}
                    </p>
                    <div class="d-flex justify-content-center mb-2">
                        <a href="{{ route('ams.create-cus-order', ['id' => $customer->id]) }}" data-mdb-button-init data-mdb-ripple-init class="btn btn-success text-light">Create Order</a>
                        <a  href="#" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary ms-2">Edit</a>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">Orders</small>
                            <div class="h5">0</div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Member Since</small>
                            <div class="h5">Jan 01, 2024</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Tabs -->
        <div class="col-md-8">
            <ul class="nav nav-tabs" id="accountTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab">Orders</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="addresses-tab" data-bs-toggle="tab" data-bs-target="#addresses" type="button" role="tab">Addresses</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="payments-tab" data-bs-toggle="tab" data-bs-target="#payments" type="button" role="tab">Payment Info</button>
                </li>
            </ul>
            <div class="tab-content p-4 border" id="accountTabsContent"  style="background-color: #fff;">
                <!-- Orders Tab -->
                <div class="tab-pane fade show active" id="orders" role="tabpanel">
                    <p class="mb-4">
                        Below is a list of your recent orders and quotes. You can view details, track status, and take action on each order. For more information about a specific order, click the "View" button.
                    </p>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Example rows -->
                                <tr>
                                    <td>1</td>
                                    <td>Jan 01, 2024</td>
                                    <td><span class="badge bg-warning text-dark">Quote</span></td>
                                    <td>
                                        <span class="badge bg-outline-success border border-success text-success">Completed</span>
                                    </td>
                                    <td>$100.00</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Feb 15, 2024</td>
                                    <td><span class="badge bg-success">Sale</span></td>
                                    <td><span class="badge bg-outline-warning border border-warning text-warning">Pending</span></td>
                                    <td>$250.00</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Mar 10, 2024</td>
                                    <td><span class="badge bg-warning text-dark">Quote</span></td>
                                    <td><span class="badge bg-danger">Cancelled</span></td>
                                    <td>$0.00</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Apr 05, 2024</td>
                                    <td><span class="badge bg-success">Sale</span></td>
                                    <td><span class="badge bg-secondary">Processing</span></td>
                                    <td>$320.00</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Addresses Tab -->
                <div class="tab-pane fade" id="addresses" role="tabpanel">
                    <!-- Add Address Button -->
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="fw-bold">Add a new address</span>
                        <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#add-address-modal">
                            <i class="bi bi-plus-circle"></i> Add Address
                        </button>
                    </div>
                    <p class="text-muted mb-4">
                        Manage your shipping and billing addresses below. Click "Add Address" to enter a new address, or use the Edit and Delete buttons to update or remove existing addresses.
                    </p>
                    <div class="row">
                        <!-- Example address -->
                        <div class="col-md-6 mb-3">
                            <div class="bg-white card addresses-item  border border-primary">
                                <div class="gold-members p-4">
                                    <div class="media">
                                        <div class="mr-3">
                                            <i class="bi bi-truck text-primary"></i>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="mb-1 text-secondary">John Doe</h4>
                                            <p class="text-black">
                                                Osahan House, Jawaddi Kalan, Ludhiana, Punjab 141002, India
                                            </p>
                                            <p class="mb-0 text-black font-weight-bold">
                                                <button type="button" class="btn btn-sm btn-secondary me-2" data-bs-toggle="modal" data-bs-target="#add-address-modal">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete-address-modal">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="bg-white card addresses-item  border border-primary">
                                <div class="gold-members p-4">
                                    <div class="media">
                                        <div class="mr-3">
                                            <i class="bi bi-truck text-primary"></i>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="mb-1 text-secondary">John Doe</h4>
                                            <p class="text-black">
                                                Osahan House, Jawaddi Kalan, Ludhiana, Punjab 141002, India
                                            </p>
                                            <p class="mb-0 text-black font-weight-bold">
                                                <button type="button" class="btn btn-sm btn-secondary me-2" data-bs-toggle="modal" data-bs-target="#add-address-modal">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete-address-modal">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="bg-white card addresses-item mb-4 border border-primary">
                                <div class="gold-members p-4">
                                    <div class="media">
                                        <div class="mr-3">
                                            <i class="bi bi-truck text-primary"></i>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="mb-1 text-secondary">John Doe</h4>
                                            <p class="text-black">
                                                Osahan House, Jawaddi Kalan, Ludhiana, Punjab 141002, India
                                            </p>
                                            <p class="mb-0 text-black font-weight-bold">
                                                <button type="button" class="btn btn-sm btn-secondary me-2" data-bs-toggle="modal" data-bs-target="#add-address-modal">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete-address-modal">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- No addresses message -->
                        <div class="col-12 text-center">
                            <p>No addresses found.</p>
                        </div>
                    </div>
                </div>
                <!-- Payment Info Tab -->
                <div class="tab-pane fade" id="payments" role="tabpanel">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="fw-bold">Add a new payment method</span>
                        <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#add-payment-modal">
                            <i class="bi bi-plus-circle"></i> Add Payment
                        </button>
                    </div>
                    <p class="text-muted mb-4">
                        Manage your payment methods below. Click "Add Payment" to enter a new payment method, or use the Edit and Delete buttons to update or remove existing methods.
                    </p>
                    <div class="row">
                        <!-- Example payment -->
                        <div class="col-md-6 mb-3">
                            <div class="bg-white card addresses-item border border-primary">
                                <div class="gold-members p-4">
                                    <div class="media">
                                        <div class="mr-3">
                                            <i class="bi bi-credit-card text-primary"></i>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="mb-1 text-secondary">Credit Card</h4>
                                            <p class="text-black">
                                                **** **** **** 1234<br>
                                                Expires: 12/2025
                                            </p>
                                            <p class="mb-0 text-black font-weight-bold">
                                                <button type="button" class="btn btn-sm btn-secondary me-2" data-bs-toggle="modal" data-bs-target="#edit-payment-modal">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete-payment-modal">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- No payment info message -->
                        <div class="col-12 text-center">
                            <p>No payment information found.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
