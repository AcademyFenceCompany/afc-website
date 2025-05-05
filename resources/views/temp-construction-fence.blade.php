@extends('layouts.main')

@section('title', $page->title ?? 'Temporary Construction Fence')

@section('content')

    <style>
        .border-bottom {
            font-size: 12px;
        }
    </style>

    <!-- Header Section -->
    <div class="rounded bg-brown">
        <h1 class="page-title text-center py-2 mb-0">TEMPORARY CONSTRUCTION FENCE</h1>
    </div>
    <div class="text-center py-2 mb-4 border-bottom">
        <p class="mb-0">Portable, Self-Standing Temporary Construction Fence &ndash; Quick Setup, No Digging, Reusable &
            Maintenance-Free.</p>
    </div>


    <!-- Info Section -->
    <div class="row g-4 mb-3">
        <!-- Left Section - About -->
        <div class="col-md-7 wf-about">
            <div class="d-flex">
                <img src="/resources/images/pentemp1.jpg" alt="Welded Wire Rolls" class="me-4 rounded about-image">
                <div>
                    <h4 class="mb-2">Temporary Construction Fence</h4>
                    <p class="page-description mb-2">
                        Academy Fence manufactures portable self standing temporary fence panels for building site projects
                        and construction sites. Easy to put up and take down. No digging required. A two man team can have
                        the perimeter temp fence up in a few minutes. We manufacture the temporary fences out of regular
                        chain link fencing material. These modular fences are re-useable with no maintenance.
                    </p>
                    <p class="text-danger fw-bold">CALL AHEAD FOR LOCAL PICKUP!</p>
                </div>
            </div>
        </div>

        <!-- Middle Section - Brochures -->
        <div class="col-md-2 text-center">
            <h5 class="text-brown mb-2">Brochures</h5>
            <div class="d-flex flex-column gap-2">
                <button class="btn btn-light border w-100 text-center">
                    Temporary Construction Fence Brochure
                </button>
                <button class="btn btn-brown w-100" style="background-color: #8B4513 !important; color: white !important;">
                    Get a Quote
                </button>
            </div>
        </div>

        <!-- Right Section - Manufacturer Info -->
        <div class="col-md-3">
            <div class="p-3 rounded bg-light-yellow">
                <h6 class="text-center mb-1"><strong>Temporary Construction Fence</strong></h6>
                <p class="text-center small mb-1 fst-italic">Family owned operated since 1968</p>
                <ul class=" list-unstyled mb-0 small-font">
                    <li><strong>Economy Plus Model:</strong></li>
                    <ul>
                        <li>1 3/8in OD .065 Wall Frame</li>
                        <li>2 3/8in Mesh, 11.5 Gauge Wire</li>
                        <li>1 Vertical Support</li>
                        <li>1 Horizontal Support</li>
                        <li>Pickup available in NJ</li>
                    </ul>

                </ul>
            </div>
        </div>
    </div>


    <div class="row">
        <!-- Image Carousel -->
        <div class="col-md-6">
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <!-- Image 1 -->
                    <div class="carousel-item active">
                        <img src="/resources/images/pentemp1.jpg" class="d-block w-100 rounded" alt="Image 1">
                    </div>
                    <!-- Image 2 -->
                    <div class="carousel-item">
                        <img src="/resources/images/pentemp3.jpg" class="d-block w-100 rounded" alt="Image 2">
                    </div>
                    <!-- Image 3 -->
                    <div class="carousel-item">
                        <img src="/resources/images/pentempcorner.jpg" class="d-block w-100 rounded" alt="Image 3">
                    </div>
                </div>
                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>

        <!-- Product Table -->
        <div class="col-md-6">
            <table class="table table-bordered text-center" style="background-color: #ddd;">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>6 X 12</td>
                        <td>$150.00</td>
                        <td><button class="btn btn-outline-dark btn-sm">Add Cart</button></td>
                    </tr>
                    <tr>
                        <td>1 Peg Stand</td>
                        <td>$30.00</td>
                        <td><button class="btn btn-outline-dark btn-sm">Add Cart</button></td>
                    </tr>
                    <tr>
                        <td>2 Peg Stand</td>
                        <td>$30.00</td>
                        <td><button class="btn btn-outline-dark btn-sm">Add Cart</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>






@endsection