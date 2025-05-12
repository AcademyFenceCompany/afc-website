@extends('layouts.main')

@section('title', 'Aluminum Fence')

@section('styles')
<style>
    /* Ensure these styles take precedence */
    .bg-brown {
        background-color: #8B4513 !important;
    }
    .page-title {
<<<<<<< HEAD
        font-size: 24px !important;
=======
        font-size: 24px ;
>>>>>>> origin/ready-push-main
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
<<<<<<< HEAD
=======
    @media (max-width: 767.98px) {
        .about-flex {
            flex-direction: column;
            align-items: center;
        }
        .page-title {
            font-size: 15px !important;
        }
    }
>>>>>>> origin/ready-push-main
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
<<<<<<< HEAD
                <div class="d-flex">
=======
                <div class="d-flex about-flex">
>>>>>>> origin/ready-push-main
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
        <div class="row mb-5">
            <!-- OnGuard Section (First Half) -->
<<<<<<< HEAD
            <div class="col-md-6">
=======
            <div class="col-md-8">
>>>>>>> origin/ready-push-main
                @foreach ($aluminum_categories as $category)
                    @if ($category['family_category_id'] == 1055)
                        <div class="card">
                            <div class="text-center p-2">
                                @if (isset($category['image']))
                                    <a href="{{ route('aluminumfence.index') }}" class="text-brown" style="text-decoration: none;"><img src="{{ $category['image'] }}" class="rounded" style="width: 100%; height: 300px; object-fit: cover;"></a>
                                @endif
                                <div class="text-center pt-2">
                                    <h4 class="card-title text-brown fw-bold"><a href="{{ route('aluminumfence.index') }}" class="text-brown" style="text-decoration: none;">{{ $category['family_category_name'] }}</a></h4>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            
            <!-- Other Brands Section (Second Half) -->
<<<<<<< HEAD
            <div class="col-md-6">
=======
            <div class="col-md-4">
>>>>>>> origin/ready-push-main
                <div class="row g-4">
                    @foreach ($aluminum_categories as $category)
                        @if ($category['family_category_id'] != 1055)
                            <div class="col-6">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="text-center p-2">
                                        @if (isset($category['image']))
<<<<<<< HEAD
                                            <img src="{{ $category['image'] }}" class="rounded" style="width: 100%; height: 150px; object-fit: cover;">
=======

                                        <img src="{{ $category['image'] }}" class="rounded" style="width: 100%; height: 150px; object-fit: cover;">
>>>>>>> origin/ready-push-main
                                        @endif
                                        <div class="text-center pt-2">
                                            <h6 class="card-title text-brown fw-bold">{{ $category['family_category_name'] }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    <div class="notes" style="font-size: 14px;">
                        <p>Use the form get a quote for above brands to send us required material list or call/email us. Phone:(973) 674-0600 | Email:info@academyfence.com</p>
                        <a href="" class="btn btn-sm btn-brown btn-small-text" style="background-color: #8B4513 !important; color: white !important;">GET QUOTE</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
