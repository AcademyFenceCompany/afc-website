@extends('layouts.main')

@section('title', 'Aluminum Fence')

@section('styles')
<style>
    /* Ensure these styles take precedence */
    .bg-brown {
        background-color: #8B4513 !important;
    }
    .page-title {
        font-size: 24px !important;
        color: #fff !important;
        font-weight: bold !important;
        padding: 10px 0 !important;
    }
    .page-description {
        font-size: 14px !important;
        font-weight: 500 !important;
        line-height: 1.5 !important;
        margin-bottom: 1rem !important;
    }
    /* Custom button styles */
    .btn.btn-brown {
        background-color: #8B4513 !important;
        color: white !important;
        border-color: #8B4513 !important;
    }
    .btn.btn-brown:hover {
        background-color: #6B3100 !important;
        color: white !important;
    }
    .about-image {
        width: 180px !important;
        height: 180px !important;
        object-fit: cover !important;
    }
    .bg-light-yellow {
        background-color: #FFFFD4 !important;
    }
    .small-font {
        font-size: 14px !important;
    }
    .brand-card {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
    }
    .brand-card:hover {
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        transform: translateY(-5px);
    }
    .brand-logo {
        max-width: 100%;
        height: auto;
        margin-bottom: 15px;
        max-height: 150px;
    }
    .brand-name {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #6B3100
    }
    .brand-description {
        font-size: 14px;
        margin-bottom: 15px;
    }
</style>
@endsection

@section('content')
    <main class="container">
        <!-- Header Section -->
        <div class="rounded bg-brown">
            <h1 class="page-title text-center mb-0">ALUMINUM ORNAMENTAL FENCE</h1>
            <div class="text-center mb-4 border-bottom">
                <p class="mb-0 text-white">(Sometimes referred to as wrought-iron fence)</p>
            </div>
        </div>
        <!-- Info Section -->
        <div class="row g-4 mb-4">
            <!-- Left Section - About -->
            <div class="col-md-6 wf-about">
                <div class="d-flex">
                    <img src="{{ url('storage/products/homepage2.jpg') }}" alt="Aluminum Fence" class="me-4 rounded about-image">
                    <div>
                        <h4 class="mb-3">In Stock - Quick Shipping - Home Installation - Pick Up</h4>
                        <p class="page-description mb-2">
                            Academy offers Onguard aluminum fence. All aluminum fence is available for pick-up or at-home installation. 
                            Ornamental Aluminum fencing comes in four standard grades (residential, residential wide, commercial and industrial). 
                            Although its most popular use is for pool code enclosures and backyard fencing, it can be used for gardens, children, dogs, 
                            perimeter security, etc.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Middle Section - Brochures -->
            <div class="col-md-2 text-center">
                <h4 class="text-brown mb-3">Brochures</h4>
                <div class="d-flex flex-column gap-2">
                    <button class="btn btn-light border w-100 text-center">
                        Aluminum Fence Brochure
                    </button>
                    <button class="btn btn-light border w-100 text-center">
                        Installation Guide
                    </button>
                    <button class="btn btn-brown w-100">
                        Get a Quote
                    </button>
                </div>
            </div>

            <!-- Right Section - Manufacturer Info -->
            <div class="col-md-4">
                <div class="p-3 rounded bg-light-yellow">
                    <ul class="small-font mb-0">
                        <li>We have numerous styles of aluminum fence in stock for immediate pickup or delivery</li>
                        <li>Residential, Commercial, and Industrial grades</li>
                        <li>Wide variety of styles, gates, posts and caps</li>
                        <li>Pick up available in NJ</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Choose below to see pricing for all styles -->
        <div class="text-center mb-4">
            <h5>Choose below to see pricing for all styles</h5>
        </div>

        <!-- Brand Section -->
        <div class="row g-4 mb-5">
            @foreach ($aluminum_categories as $category)
                <div class="col-6 col-sm-4 col-md-4 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="text-center p-2">
                            @if (isset($category['image']))
                                <img src="{{ $category['image'] }}" class="rounded " style="width: 350px; height: 250px; object-fit: cover;">
                            @endif
                            <div class="text-center pt-2">
                                <h6 class="card-title text-brown fw-bold">{{ $category['family_category_name'] }}</h6>
                            </div>
                            
                            @if ($category['family_category_id'] == 1055)
                                <a href="{{ route('aluminumfence.index') }}" class="btn btn-sm btn-brown btn-small-text mt-2" style="background-color: #8B4513 !important; color: white !important;">VIEW</a>
                            @else
                                <a href="#" class="btn btn-sm btn-brown btn-small-text mt-2" style="background-color: #8B4513 !important; color: white !important;">VIEW</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
@endsection
