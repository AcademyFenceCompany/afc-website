@extends('layouts.ams')

@section('title', 'Activity')

@section('content')

<div class="container">
    <!-- Page Title -->
    <div class="row add_product__title text-center">
        <h2>DELIVERY LOG</h2>
    </div>
    <!-- Search Form -->
    <div class="row">
        <div class="col-md-4">
            <label for="shipper_type" class="form-label">Shipper Type</label>
            <div class="dropdown-wrapper position-relative">
                <i class="fa-solid fa-chevron-down dropdown-icon"></i>
                <select id="shipper_type" class="form-control" required>
                    <option value="">Select Shipper</option>
                </select>
            </div>
        </div>
        <div class="col-md-8">
            <label for="shipper-search" class="form-label">Search:</label>
            <div class="input-group">
                <input type="text" id="shipper-search" class="form-control" placeholder="Enter Shipper search key.....">
                <button id="searchButton" class="btn btn-primary">Search</button>
            </div>
        </div>
    </div>

    <!-- Small Package - Shipping Log -->
    <!-- Table Header -->
    <div class="mt-3">
        <div class="row table-header text-white p-2 d-flex flex-nowrap">
            <div class="col text-center text-truncate" style="min-width: 60px;">Ship Date</div>
            <div class="col text-center text-truncate" style="min-width: 60px;">Sold Date</div>
            <div class="col text-center text-truncate" style="min-width: 80px;">Order ID</div>
            <div class="col text-center text-truncate" style="min-width: 200px;">Ship to</div>
            <div class="col text-center text-truncate" style="min-width: 120px;">State/Zip Code</div>
            <div class="col text-center text-truncate" style="min-width: 100px;">Item#</div>
            <div class="col text-center text-truncate" style="min-width: 80px;">Carrier</div>
            <div class="col text-center text-truncate" style="min-width: 80px;">Weight</div>
            <div class="col text-center text-truncate" style="min-width: 90px;">Ship Est.</div>
            <div class="col text-center text-truncate" style="min-width: 140px;">Tracking#</div>
        </div>
    </div>

    <!-- Table Row -->
    <div class="row table-row align-items-center p-1">
        <div class="col text-center text-truncate" style="min-width: 60px;">02.03.2025</div>
        <div class="col text-center text-truncate" style="min-width: 60px;">02.01.2025</div>
        <div class="col text-center text-truncate" style="min-width: 80px;">123456</div>
        <div class="col text-center text-truncate" style="min-width: 200px;">Sheetmetal Specialists in HVAC, Inc.</div>
        <div class="col text-center text-truncate" style="min-width: 120px;">NJ/07050</div>
        <div class="col text-center text-truncate" style="min-width: 100px;">WW151910048</div>
        <div class="col text-center text-truncate" style="min-width: 80px;">UPS Ground</div>
        <div class="col text-center text-truncate" style="min-width: 80px;">105lbs</div>
        <div class="col text-center text-truncate" style="min-width: 90px;">$240.49</div>
        <div class="col text-center text-truncate" style="min-width: 140px;">
            <div class="text-center mt-1 button-group">
                <button class="btn btn-secondary btn-sm">View</button>
            </div>
        </div>
    </div>
</div>

@endsection