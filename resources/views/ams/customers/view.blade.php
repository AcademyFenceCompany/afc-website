{{-- @dd($customer) --}}
@extends('layouts.ams')

@section('title', 'Customer Details')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Customer Details</h1>

        <!-- Customer Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Customer Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $customer->name ?: 'N/A' }}</p>
                <p><strong>Company:</strong> {{ $customer->company ?: 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $customer->email ?: 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ $customer->phone ?: 'N/A' }}</p>
            </div>
        </div>

        <!-- Addresses -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Addresses</h5>
            </div>
            <div class="card-body">
                @forelse ($customer->addresses as $address)
                    <div class="mb-3">
                        <p><strong>Address:</strong> {{ $address->address_1 }}, {{ $address->city }}, {{ $address->state }}
                            {{ $address->zipcode }}</p>
                        <p>
                            @if ($address->billing_flag)
                                <span class="badge bg-primary">Billing</span>
                            @endif
                            @if ($address->shipping_flag)
                                <span class="badge bg-success">Shipping</span>
                            @endif
                        </p>
                    </div>
                @empty
                    <p>No addresses found.</p>
                @endforelse
            </div>
        </div>

        <!-- Orders -->
        <div class="card">
            <div class="card-header">
                <h5>Orders</h5>
            </div>
            <div class="card-body">
                @if ($customer->orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customer->orders as $order)
                                    <tr>
                                        <td>{{ $order->customer_order_id }}</td>
                                        <td>{{ $order->created_at ? $order->created_at->format('M d, Y H:i') : 'N/A' }}</td>
                                        <td>${{ number_format($order->total, 2) }}</td>
                                        <td>{{ ucfirst($order->status) }}</td>
                                        <td>
                                            <a href="/orders/{{ $order->id }}" class="btn btn-sm btn-primary">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No orders found for this customer.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
