@extends('layouts.ams')

@section('title', 'Order Details')

@section('content')
    <div class="order-details">
        <!-- Order Summary and Shipping Info -->
        <div class="grid-container">
            <div class="section order-summary">
                <h2 class="section-title"><i class="fas fa-receipt"></i> Order Summary</h2>
                <p><strong>Customer:</strong>
                    {{ $order->customer->name ?? 'N/A' }}
                    @if ($order->customer->company)
                        ({{ $order->customer->company }})
                    @endif
                </p>
                <p><strong>Email:</strong> {{ $order->customer->email ?? 'N/A' }}</p>
                <p><strong>Order Status:</strong>
                    @if ($order->status->sold_date)
                        <span class="status sold">Sold on
                            {{ \Carbon\Carbon::parse($order->status->sold_date)->format('F j, Y, g:i a') }}</span>
                    @elseif ($order->status->quote_date)
                        <span class="status quote">Quoted on
                            {{ \Carbon\Carbon::parse($order->status->quote_date)->format('F j, Y, g:i a') }}</span>
                    @else
                        <span class="status pending">Pending</span>
                    @endif
                </p>
            </div>

            <div class="section shipping-details">
                <h2 class="section-title"><i class="fas fa-shipping-fast"></i> Shipping Information</h2>
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
        </div>

        <!-- Shipping & Billing Info -->
        <div class="grid-container">
            <div class="section address-info">
                <h2 class="section-title"><i class="fas fa-map-marker-alt"></i> Shipping Address</h2>
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

            <div class="section address-info">
                <h2 class="section-title"><i class="fas fa-bill"></i> Billing Address</h2>
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
            <h2 class="section-title"><i class="fas fa-box"></i> Order Items</h2>
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

        <!-- Payment Info -->
        <div class="section payment-info">
            <h2 class="section-title"><i class="fas fa-credit-card"></i> Payment Information</h2>
            <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
            <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
        </div>

        <!-- Other Orders by Customer -->
        <div class="section other-orders">
            <h2 class="section-title"><i class="fas fa-history"></i> Other Orders</h2>
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
                                    <a href="{{ route('orders.show', $customerOrder->original_order_id) }}">
                                        #{{ $customerOrder->original_order_id }}
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
                                    <a href="{{ route('orders.show', $customerOrder->original_order_id) }}"
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
        border-radius: 10px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
    }

    .grid-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .section {
        padding: 15px;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 18px;
        color: #333;
        margin-bottom: 15px;
        border-bottom: 2px solid #007bff;
        padding-bottom: 5px;
    }

    .status {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
        color: white;
        font-size: 12px;
    }

    .status.sold {
        background-color: #28a745;
    }

    .status.quote {
        background-color: #ffc107;
        color: black;
    }

    .status.pending {
        background-color: #6c757d;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    table th,
    table td {
        text-align: left;
        padding: 10px;
        border: 1px solid #ddd;
    }

    table th {
        background: #f4f4f4;
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
</style>
