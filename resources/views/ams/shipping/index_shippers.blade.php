@extends('layouts.ams')

@section('title', 'Activity')

@section('content')

<div class="container">
    <!-- Page Title -->
    <div class="row add_product__title text-center">
        <h2>VIEW SHIPPERS</h2>
    </div>

    <!-- Search Form -->
    <div class="row">
        <div class="col-md-6">         
                <label for="shipper-search" class="form-label">Search:</label>
                <div class="input-group">
                    <input type="text" id="shipper-search" class="form-control" placeholder="Enter Shipper search key.....">
                    <button id="searchButton" class="btn btn-primary">Search</button>
                </div>
        </div>
    </div>


    <div class="container mt-1">
        <!-- Table Header -->
        <div class="row table-header text-white p-3">
            <div class="col-1">#</div>
            <div class="col-3">Shipper's Name</div>
            <div class="col-2">Shipping Type</div>
            <div class="col-2">Dispatcher</div>
            <div class="col-3">Dispatcher Phone Number</div>
            <div class="col-1 text-center">Action</div>
        </div>

        <!-- Table Row -->
        <div class="row table-row align-items-center p-1">
            <div class="col-1">1</div>
            <div class="col-3">Shipper's Name</div>
            <div class="col-2">Shipping Type</div>
            <div class="col-2">Dispatcher</div>
            <div class="col-3">Dispatcher Phone Number</div>
            <div class="col-1 text-center">
                <div class="text-center mt-1 button-group">
                    <button class="btn btn-primary btn-sm">Edit</button>
                    <button class="btn btn-secondary btn-sm">View</button>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection