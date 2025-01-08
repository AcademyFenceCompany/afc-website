@extends('layouts.ams')

@section('title', 'Activity')

@section('content')
    <!-- Filters Section -->
    <div class="filters">
        <input type="text" class="search-input" placeholder="Search by Order ID, Name or Email" />
        <button class="search-btn">Search</button>
        <div class="filter-group">
            <label for="activity-date">Today's Activity for:</label>
            <input type="date" id="activity-date" class="filter-input" />
        </div>
        <div class="filter-group">
            <label for="time-range">Time Range:</label>
            <select id="time-range" class="filter-select">
                <option value="today">Today</option>
                <option value="yesterday">Yesterday</option>
                <option value="week">This Week</option>
            </select>
        </div>
        <div class="filter-group">
            <label for="status">Status:</label>
            <select id="status" class="filter-select">
                <option value="all">All Orders</option>
                <option value="new">New Orders</option>
                <option value="completed">Completed</option>
            </select>
        </div>
    </div>

    <!-- Orders Table -->
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Details</th>
                <th>Location</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>#123123</td>
                <td>Johnny Depp (6)</td>
                <td>(AFC Stock, Pickup AFC) Hex Netting - Deer Fence</td>
                <td>Jersey City, NJ</td>
                <td>12/23/2024</td>
                <td><span class="status-oms">OMS</span></td>
            </tr>
        </tbody>
    </table>

    <!-- Footer Section -->
    <div class="footer">
        Order Totals: $573.71
    </div>
@endsection
