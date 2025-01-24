@extends('layouts.ams')

@section('title', 'Order Details')

@section('content')
    <div class="order-details">
        <!-- Order Summary -->
        <div class="section order-summary">
            <h1 class="section-title">Order Details - #{{ $order->original_customer_order_id }}</h1>
            <p><strong>Customer:</strong>
                {{ $order->customer->name ?? 'N/A' }}
                @if ($order->customer->company)
                    ({{ $order->customer->company }})
                @endif
            </p>
            <p><strong>Email:</strong> {{ $order->customer->email ?? 'N/A' }}</p>
            <p><strong>Order Status:</strong>
                @if ($order->status->sold_date)
                    Sold on {{ \Carbon\Carbon::parse($order->status->sold_date)->format('F j, Y, g:i a') }}
                @elseif ($order->status->quote_date)
                    Quoted on {{ \Carbon\Carbon::parse($order->status->quote_date)->format('F j, Y, g:i a') }}
                @else
                    Pending
                @endif
            </p>
        </div>
        <!-- Shipping Details -->
        <div class="section shipping-details">
            <h2 class="section-title">Shipping Information</h2>
            @if ($order->shippingDetails)
                <p><strong>Carrier:</strong> {{ $order->shippingDetails->carrier ?? 'N/A' }}</p>
                <p><strong>Shipped By:</strong> {{ $order->shippingDetails->shipby ?? 'N/A' }}</p>
                <p><strong>Status:</strong> {{ $order->shippingDetails->status ?? 'N/A' }}</p>
                <p><strong>Tracking No:</strong> {{ $order->shippingDetails->tracking_no ?? 'N/A' }}</p>
                <p><strong>Actual Shipping Cost:</strong>
                    ${{ number_format($order->shippingDetails->actual_shipping_cost, 2) }}</p>
                <p><strong>Shipping Cost Markup:</strong>
                    ${{ number_format($order->shippingDetails->shipping_cost_markup, 2) }}</p>
            @else
                <p>No shipping details available for this order.</p>
            @endif
        </div>
        <!-- Shipping and Billing Info -->
        <div class="section address-info">
            <h2 class="section-title">Shipping & Billing Information</h2>
            <div class="info-block">
                <h3>Shipping Info</h3>
                <p>
                    @if ($order->shippingAddress)
                        {{ $order->shippingAddress->address_1 }},
                        {{ $order->shippingAddress->city }},
                        {{ $order->shippingAddress->state }}
                        {{ $order->shippingAddress->zipcode }}
                    @else
                        Shipping address not available
                    @endif
                </p>
            </div>
            <div class="info-block">
                <h3>Billing Info</h3>
                <p>
                    @if ($order->billingAddress)
                        {{ $order->billingAddress->address_1 ?? 'N/A' }},
                        {{ $order->billingAddress->city ?? 'N/A' }},
                        {{ $order->billingAddress->state ?? 'N/A' }}
                        {{ $order->billingAddress->zipcode ?? 'N/A' }}
                    @else
                        Billing address not available
                    @endif
                </p>
            </div>
        </div>

        <!-- Order Items -->
        <div class="section order-items">
            <h2 class="section-title">Items</h2>
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
        <div class="section payment-info">
            <h2 class="section-title">Payment Information</h2>
            <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
            <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
        </div>

        <!-- Other Orders by Customer -->
        <div class="section other-orders">
            <h2 class="section-title">Other Orders by {{ $order->customer->name ?? 'this Customer' }}</h2>
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
                                    {{ $customerOrder->status->sold_date ? \Carbon\Carbon::parse($customerOrder->status->sold_date)->format('F j, Y') : 'N/A' }}
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
        padding: 30px;
        background: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .section {
        margin-bottom: 30px;
        padding: 20px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    .section-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 15px;
        color: #333;
        border-bottom: 2px solid #007bff;
        padding-bottom: 5px;
    }

    .info-block {
        margin-bottom: 15px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th,
    table td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
    }

    table th {
        background-color: #f4f4f4;
        font-weight: bold;
    }

    .view-details-btn {
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
    }

    .view-details-btn:hover {
        text-decoration: underline;
    }

    p {
        margin: 5px 0;
        font-size: 14px;
    }
</style>
