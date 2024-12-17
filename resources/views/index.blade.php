@extends('layouts.main')

@section('title', 'Academy Fence Company')

@section('content')
    <!-- Welcome Header -->
    <div class="bg-black text-white text-center py-3 rounded mb-4">
        <h1 class="mb-0">WELCOME TO ACADEMY FENCE COMPANY</h1>
    </div>

    <!-- Navigation Pills -->
    <div class="d-flex justify-content-center flex-wrap gap-2 mb-4">
        <a href="#" class="btn btn-light">PICK UP</a>
        <a href="#" class="btn btn-light">YARD & GARDEN</a>
        <a href="#" class="btn btn-light">POPULAR</a>
        <a href="#" class="btn btn-light">CONTACT US</a>
        <a href="#" class="btn btn-light">FENCE INSTALL</a>
        <a href="#" class="btn btn-light">GET A QUOTE</a>
        <a href="#" class="btn btn-light">CUSTOMER SERVICE</a>
    </div>

    <!-- Pickup Center Section -->
    <div class="row align-items-center">
        <!-- Left Side - Warehouse Image -->
        <div class="col-md-6">
            <img src="/resources/images/warehouse.png" alt="Warehouse Facility" class="img-fluid rounded shadow">
        </div>

        <!-- Right Side - Content -->
        <div class="col-md-6">
            <h2 class="text-dark mb-3">ACADEMY FENCE COMPANY</h2>
            <p>Academy Fence Company Established in the 1960's we offer a complete line of all types of fencing and railing.
                As installers and designers we are able to offer the best quality available in the industry. Whether it is
                aluminum, vinyl, chain link, wood or welded wire fencing you can be assured that we offer only the best in
                quality and standards.</p>
            <p>We also offer a robust line of outdoor living, yard and garden products.</p>
            <p>Our goal is to offer the best and newest design ideas to beautify and increase the value of your home and
                property. Our product development and design team is committed to offering high quality items for the most
                discriminating home owners...</p>
            <a href="#" class="text-danger">read more</a>
        </div>
    </div>

    <!-- Most Popular Choices -->
    <div class="mb-5">
        <div class="bg-black text-white text-center py-3 rounded mb-4">
            <h2 class="mb-0">MOST POPULAR CHOICES</h2>
        </div>
        <p class="text-center mb-4">We carry wood post caps, solar post caps, and vinyl post caps. Post Caps are normally
            used for a number of projects including fence. We carry a wide selection of post caps in different materials
            including wood, vinyl and aluminum as well as solar post caps in different colors.</p>

        <div class="row g-4">
            <div class="col-12 col-md-6 col-lg-4 d-flex align-items-stretch">
                <div class="card product-card shadow-sm p-3 w-100">
                    <div class="d-flex h-100">
                        <!-- Image Section -->
                        <div class="product-image me-3">
                            <img src="/resources/images/1.png" class="img-fluid rounded" alt="Welded Wire Fence">
                        </div>
                        <!-- Content Section -->
                        <div class="product-details d-flex flex-column justify-content-between flex-grow-1">
                            <div>
                                <h5 class="fw-bold">Welded Wire Fence Vinyl Coated</h5>
                                <p class="text-muted">National Wholesale Warehouse Fencing. Very wide selection of mesh
                                    sizes,gauges, heights, roll lengths, weights and colors.</p>
                            </div>
                            <!-- Check if sizes are defined -->
                            <div class="mt-3">
                                <a href="#" class="btn btn-danger text-white">View Product</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- NJ/NY Metro Area Pickup Center -->
    <div class="mb-5">
        <div class="bg-black text-white text-center py-3 rounded mb-4">
            <h2 class="mb-0">NJ/NY METRO AREA PICK-UP CENTER</h2>
        </div>
        <p class="text-center mb-4">We carry wood post caps, solar post caps, and vinyl post caps. Post Caps are normally
            used for a number of projects including fence. We carry a wide selection of post caps in different materials
            including wood, vinyl and aluminum as well as solar post caps in different colors.</p>

        <!-- Product Grid -->
        <div class="row g-4">
            <!-- First Row -->
            <div class="col-md-4 mb-4">
                <div class="product-card">
                    <img src="/resources/images/welded-wire.jpg" alt="Welded Wire Fence" class="img-fluid mb-3">
                    <h5>Welded Wire Fence Vinyl Coated</h5>
                    <p>National Wholesale Warehouse Fencing. Very wide selection of mesh sizes...</p>
                    <a href="#" class="btn btn-danger">VIEW PRODUCT</a>
                </div>
            </div>
            <!-- Add more product cards following the same structure -->
            <!-- Include all products shown in the design -->
        </div>
    </div>

    <!-- Yard and Garden Material -->
    <div class="mb-5">
        <div class="bg-black text-white text-center py-3 rounded mb-4">
            <h2 class="mb-0">YARD AND GARDEN MATERIAL</h2>
        </div>
        <p class="text-center mb-4">We carry wood post caps, solar post caps, and vinyl post caps. Post Caps are normally
            used for a number of projects including fence. We carry a wide selection of post caps in different materials
            including wood, vinyl and aluminum as well as solar post caps in different colors.</p>

        <!-- Product Grid -->
        <div class="row g-4">
            <!-- Hand Speed-Rail Fittings -->
            <div class="col-md-4 mb-4">
                <div class="product-card">
                    <img src="/resources/images/speed-rail.jpg" alt="Hand Speed-Rail Fittings" class="img-fluid mb-3">
                    <h5>Hand Speed-Rail Fittings</h5>
                    <p>Essential fittings for your railing projects...</p>
                    <a href="#" class="btn btn-danger">VIEW PRODUCT</a>
                </div>
            </div>
            <!-- Add remaining product cards -->
        </div>
    </div>

    <style>
        .product-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            height: 100%;
            transition: all 0.3s ease;
        }

        .product-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-danger {
            background-color: #8B4513;
            border-color: #8B4513;
        }

        .btn-danger:hover {
            background-color: #703610;
            border-color: #703610;
        }

        .btn-light {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 8px 16px;
        }

        .btn-light:hover {
            background-color: #e9ecef;
        }
    </style>
@endsection
