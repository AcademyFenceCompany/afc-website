{{-- @dd($orders); --}}
@extends('layouts.ams')

@section('title', 'Activity')

@section('content')
    <!-- Filters Section -->
    <div class="filters">
        <form method="GET" action="" class="filters-form">
            <input type="text" name="search" class="search-input" placeholder="Search by Order ID, Name or Email"
                value="{{ request('search') }}" />
            <input type="date" name="activity_date" id="activity-date" class="filter-input"
                value="{{ request('activity_date') }}" />
            <select name="status" id="status" class="filter-select">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Orders</option>
                <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New Orders</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
            <button class="filter-btn" type="submit">Apply Filters</button>
        </form>
    </div>

    <!-- Orders List -->
    <div class="orders-list">
        @forelse ($orders as $order)
            <!-- Order Header -->
            <div class="order-header">
                <span class="order-id">#{{ $order->original_customer_order_id }}</span>
                <span
                    class="customer-name">{{ $order->customer ? $order->customer->name ?? $order->customer->company : 'N/A' }}</span>
                <span class="order-location">{{ $order->shippingAddress->city ?? 'N/A' }},
                    {{ $order->shippingAddress->state ?? 'N/A' }}</span>

                <!-- Determine the Order Date -->
                <span class="order-date">
                    @if ($order->status->sold_date)
                        {{ \Carbon\Carbon::parse($order->status->sold_date)->format('Y-m-d H:i:s') }}
                    @elseif ($order->status->quote_date)
                        {{ \Carbon\Carbon::parse($order->status->quote_date)->format('Y-m-d H:i:s') }}
                    @endif
                </span>

                <span class="order-total">${{ number_format($order->total, 2) }}</span>

                <!-- Status Buttons -->
                <div class="order-status-buttons">
                    @if ($order->status->sold_date)
                        <button class="status-button sold" title="Sold">S</button>
                    @endif
                    @if ($order->status->quote_date)
                        <button class="status-button quoted" title="Quoted">Q</button>
                    @endif
                    @if ($order->status->customer_confirmed_date)
                        <button class="status-button customer-confirmed" title="Customer Confirmed">CC</button>
                    @endif
                    @if ($order->status->shipped_confirmed_date)
                        <button class="status-button shipped" title="Shipped">SC</button>
                    @endif
                </div>
                <!-- Toggle Button -->
                <button class="toggle-items-btn" type="button" data-id="{{ $order->original_customer_order_id }}">
                    Order Summary </button>
            </div>

            <!-- Order Items -->
            <div class="order-items collapse" id="order-items-{{ $order->original_customer_order_id }}">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item #</th>
                            <th>Description</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->order as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->product ? $item->product->item_no : 'N/A' }}</td>
                                <td>{{ $item->product ? $item->product->product_name : 'Unknown Product' }}</td>
                                <td>{{ $item->product->details->size1 ?? 'N/A' }}</td>
                                <td>{{ $item->product_quantity }}</td>
                                <td>${{ number_format($item->product_price_at_time_of_purchase, 2) }}</td>
                                <td>${{ number_format($item->product_price_at_time_of_purchase * $item->product_quantity, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Notes Section -->
                <div class="order-notes">
                    <p><strong>Notes:</strong> {{ $order->notes ?? 'No additional notes.' }}</p>
                </div>
            </div>
        @empty
            <div class="no-orders">No orders found</div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pagination">
        {{ $orders->links() }}
    </div>
@endsection

<style>
    /* Filters Section */
    .filters {
        margin-bottom: 20px;
    }

    .filters-form {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
    }

    .search-input,
    .filter-input,
    .filter-select,
    .filter-btn {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .filter-btn {
        background-color: #007bff;
        color: white;
        cursor: pointer;
    }

    .filter-btn:hover {
        background-color: #0056b3;
    }

    /* Orders List */
    .orders-list {
        margin-top: 20px;
    }

    .order-header {
        display: flex;
        align-items: center;
        /* Align items vertically */
        justify-content: space-between;
        /* Distribute space between items */
        padding: 10px;
        background-color: #f4f4f4;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 5px;
        gap: 10px;
        /* Add spacing between elements */
    }

    .order-header>* {
        flex: 1;
        /* Equal space for all items */
        text-align: center;
        /* Center align the text */
    }

    .order-id {
        font-weight: bold;
        color: #007bff;
        text-align: left;
        /* Align order ID to the left */
    }

    .customer-name {
        font-weight: bold;
        text-align: left;
        /* Align customer name to the left */
    }

    .order-location {
        text-align: left;
        /* Align location to the left */
    }

    .order-date {
        text-align: center;
        /* Center align the date */
    }

    .order-total {
        text-align: right;
        /* Align total to the right */
    }

    .order-status-buttons {
        display: flex;
        justify-content: center;
        /* Center align status buttons */
        gap: 5px;
    }

    .status-button {
        border: none;
        padding: 5px 10px;
        border-radius: 3px;
        font-weight: bold;
        cursor: pointer;
    }

    .status-button.sold {
        background-color: #28a745;
        color: #fff;
    }

    .status-button.quoted {
        background-color: #ffc107;
        color: #fff;
    }

    .status-button.customer-confirmed {
        background-color: #17a2b8;
        color: #fff;
    }

    .status-button.shipped {
        background-color: #6610f2;
        color: #fff;
    }

    .toggle-items-btn {
        background-color: #007bff;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
    }

    .toggle-items-btn:hover {
        background-color: #0056b3;
    }

    .order-status-buttons {
        display: flex;
        gap: 5px;
    }

    .status-button {
        border: none;
        padding: 5px 10px;
        border-radius: 3px;
        font-weight: bold;
        cursor: pointer;
    }

    .status-button.sold {
        background-color: #28a745;
        color: #fff;
    }

    .status-button.quoted {
        background-color: #ffc107;
        color: #fff;
    }

    .status-button.customer-confirmed {
        background-color: #17a2b8;
        color: #fff;
    }

    .status-button.shipped {
        background-color: #6610f2;
        color: #fff;
    }

    .order-items {
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
    }

    .table-sm th,
    .table-sm td {
        padding: 5px;
        font-size: 0.875rem;
    }

    .order-notes {
        margin-top: 10px;
        font-style: italic;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .pagination a,
    .pagination span {
        margin: 0 5px;
        padding: 5px 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        text-decoration: none;
        color: #000;
    }

    .pagination .active {
        background-color: #007bff;
        color: #fff;
    }

    .pagination .disabled {
        opacity: 0.5;
        pointer-events: none;
    }

    .order-items {
        display: none;
        /* Hide initially */
        padding: 10px;
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-top: 10px;
    }

    .order-items.show {
        display: block;
        /* Show when toggled */
    }

    .toggle-items-btn {
        background-color: #007bff;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        margin-top: 5px;
    }

    .toggle-items-btn:hover {
        background-color: #0056b3;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Add event listener to all toggle buttons
        document.querySelectorAll('.toggle-items-btn').forEach((button) => {
            button.addEventListener('click', () => {
                const orderId = button.getAttribute('data-id');
                const target = document.querySelector(`#order-items-${orderId}`);

                // Hide all other collapses
                document.querySelectorAll('.order-items').forEach((item) => {
                    if (item !== target) {
                        item.classList.remove('show');
                    }
                });

                // Toggle the current collapse
                target.classList.toggle('show');
            });
        });
    });
</script>
