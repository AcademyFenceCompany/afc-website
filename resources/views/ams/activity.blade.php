@extends('layouts.ams')

@section('title', 'Activity')

@section('content')
    <!-- Header Section -->
    <div class="header">
        <h2>Order Activity</h2>
        <div class="header-buttons">
            <button class="btn btn-primary">New Order</button>
            <button class="btn btn-danger">Log Out</button>
        </div>
    </div>
    <!-- Filters Section -->
    <div class="filters">
        <div class="search-wrapper">
            <input type="text" class="search-input" placeholder="Search by Order ID, Name, or Email" />
            <button class="search-btn">Search</button>
        </div>
        <div class="filter-options">
            <div class="filter-group">
                <label for="activity-date">Today's Activity for:</label>
                <input type="date" id="activity-date" class="filter-input" />
            </div>
            <div class="filter-group">
                <label for="time-range">Time Range:</label>
                <select id="time-range" class="filter-select">
                    <option value="today">Today</option>
                    <option value="yesterday">Yesterday</option>
                    <option value="this-week">This Week</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="status">Status:</label>
                <select id="status" class="filter-select">
                    <option value="all-orders">All Orders</option>
                    <option value="new">New Orders</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
        </div>
    </div>
    <div class="filters mt-3">
        <input type="text" placeholder="Search by Order ID, Name or Email" class="search-input">
        <button class="search-btn">Search</button>
    </div>

    <table class="table mt-4">
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
            <!-- Add more rows as needed -->
        </tbody>
    </table>
@endsection
