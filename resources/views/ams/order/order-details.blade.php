@extends('layouts.ams')

@section('title', 'Order Details')

@section('content')
    <div class="order-details">
        <!-- Order Summary -->
        <h1>Order Details - #{{ $order->original_customer_order_id }}</h1>
        <div class="order-summary">
            @if ($order->customer->name && $order->customer->company)
                <p><strong>Customer:</strong> {{ $order->customer->name }}({{ $order->customer->company }})</p>
            @elseif ($order->customer->name)
                <p><strong>Customer:</strong> {{ $order->customer->name }}</p>
            @elseif ($order->customer->company)
                <p><strong>Company:</strong> {{ $order->customer->company }}</p>
            @else
                <p><strong>Customer:</strong> N/A</p>
            @endif
            <p><strong>Email:</strong> {{ $order->customer->email }}</p>
            <p><strong>Order Status:</strong>
                @if ($order->status->sold_date)
                    Sold on {{ \Carbon\Carbon::parse($order->status->sold_date)->format('F j, Y, g:i a') }}
                @elseif($order->status->quote_date)
                    Quoted on {{ \Carbon\Carbon::parse($order->status->quote_date)->format('F j, Y, g:i a') }}
                @elseif($order->status->customer_confirmed_date)
                    Customer Confirmed on
                    {{ \Carbon\Carbon::parse($order->status->customer_confirmed_date)->format('F j, Y, g:i a') }}
                @elseif($order->status->shipped_confirmed_date)
                    Shipped on {{ \Carbon\Carbon::parse($order->status->shipped_confirmed_date)->format('F j, Y, g:i a') }}
                @else
                    Status Unknown
                @endif
            </p>
            @if ($order->status->sold_date)
                <p><strong>Sold Date:</strong> {{ $order->status->sold_date }}</p>
            @endif
            @if ($order->status->quote_date)
                <p><strong>Quote Date:</strong> {{ $order->status->quote_date }}</p>
            @endif
            @if ($order->status->customer_confirmed_date)
                <p><strong>Customer Confirmed Date:</strong> {{ $order->status->customer_confirmed_date }}</p>
            @endif
            @if ($order->status->shipped_confirmed_date)
                <p><strong>Shipped Confirmed Date:</strong> {{ $order->status->shipped_confirmed_date }}</p>
            @endif
        </div>

        <!-- Shipping and Billing Info -->
        <div class="address-info">
            <h3>Shipping Info</h3>
            @if ($order->shippingAddress)
                <p>{{ $order->shippingAddress->name }}, {{ $order->shippingAddress->address_1 }},
                    {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }}
                    {{ $order->shippingAddress->zipcode }}</p>
            @else
                <p>Shipping address not available</p>
            @endif

            <h3>Billing Info</h3>
            @if ($order->billingAddress)
                <p>{{ $order->billingAddress->name }}</p>
                <p>{{ $order->billingAddress->address_1 ?? 'N/A' }}</p>
                <p>{{ $order->billingAddress->city ?? 'N/A' }}, {{ $order->billingAddress->state ?? 'N/A' }}
                    {{ $order->billingAddress->zipcode ?? 'N/A' }}
                </p>
            @else
                <p>Billing address not available</p>
            @endif
        </div>

        <!-- Order Items -->
        <div class="order-items">
            <h3>Items</h3>
            <table>
                <thead>
                    <tr>
                        <th>Item #</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->order as $item)
                        <tr>
                            <td>{{ $item->product ? $item->product->item_no : 'N/A' }}</td>
                            <td>{{ $item->product ? $item->product->product_name : 'Unknown Product' }}</td>
                            <td>{{ $item->product_quantity }}</td>
                            <td>${{ number_format($item->product_price_at_time_of_purchase, 2) }}</td>
                            <td>${{ number_format($item->product_quantity * $item->product_price_at_time_of_purchase, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Payment Information -->
        <div class="payment-info">
            <h3>Payment Info</h3>
            <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
            <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
        </div>

        <!-- Other Orders by Customer -->
        <div class="other-orders">
            <h3>Other Orders by {{ $order->customer->name ?? 'this Customer' }}</h3>
            @if ($customerOrders->isNotEmpty())
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customerOrders as $customerOrder)
                            <tr>
                                <td>
                                    <a href="{{ route('orders.show', $customerOrder->original_customer_order_id) }}">
                                        #{{ $customerOrder->original_customer_order_id }}
                                    </a>
                                </td>
                                <td>
                                    {{ $customerOrder->created_at ? $customerOrder->created_at->format('F j, Y') : 'N/A' }}
                                </td>
                                <td>
                                    @if ($customerOrder->status)
                                        @if ($customerOrder->status->sold_date)
                                            Sold
                                        @elseif ($customerOrder->status->quote_date)
                                            Quoted
                                        @else
                                            Pending
                                        @endif
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>${{ number_format($customerOrder->total, 2) }}</td>
                                <td>
                                    <a href="{{ route('orders.show', $customerOrder->original_customer_order_id) }}"
                                        class="view-details-btn">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No other orders found for this customer.</p>
            @endif
        </div>
    </div>
@endsection
<style>
    .order-details {
        padding: 20px;
        background: #f9f9f9;
    }

    .order-summary,
    .address-info,
    .order-items,
    .payment-info,
    .order-history {
        margin-bottom: 20px;
        padding: 15px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    h3 {
        margin-bottom: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th,
    table td {
        padding: 8px;
        text-align: left;
        border: 1px solid #ddd;
    }
</style>
