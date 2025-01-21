@dd($orders)
@extends('layouts.ams')

@section('title', 'Activity')

@section('content')
    <!-- Filters Section -->
    <div class="filters">
        <form method="GET" action="">
            <input type="text" name="search" class="search-input" placeholder="Search by Order ID, Name or Email"
                value="{{ request('search') }}" />
            <button class="search-btn" type="submit">Search</button>
            <div class="filter-group">
                <label for="activity-date">Today's Activity for:</label>
                <input type="date" name="activity_date" id="activity-date" class="filter-input"
                    value="{{ request('activity_date') }}" />
            </div>
            <div class="filter-group">
                <label for="status">Status:</label>
                <select name="status" id="status" class="filter-select">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Orders</option>
                    <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New Orders</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <button class="filter-btn" type="submit">Apply Filters</button>
        </form>
    </div>

    <!-- Orders Table -->
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Details</th>
                <th>Address</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>#{{ $order->original_customer_order_id }}</td>
                    <td>{{ $order->customer->name }} ({{ $order->customer->customer_id }})</td>
                    <td>
                        @foreach ($order->items as $item)
                            {{ $item->product->name ?? 'Unknown Product' }}
                            ({{ $item->product_quantity }})
                        @endforeach
                    </td>
                    <td>{{ $order->address->address_1 ?? '' }}{{ $order->address->address_2 ?? '' }},
                        {{ $order->address->city ?? '' }},
                        {{ $order->address->state ?? '' }}, {{ $order->address->zipcode ?? '' }}
                    </td>
                    {{-- <td>{{ $order->created_at->format('m/d/Y') }}</td> --}}
                    <td><span class="status-{{ strtolower($order->status) }}">{{ $order->status }}</span></td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No orders found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="pagination">
        {{ $orders->links() }}
    </div>

    <!-- Footer Section -->
    <div class="footer">
        Order Totals: ${{ number_format($orders->sum('total'), 2) }}
    </div>
@endsection

<style>
    .pagination {
        margin-top: 20px;
        display: flex;
        justify-content: center;
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
</style>
