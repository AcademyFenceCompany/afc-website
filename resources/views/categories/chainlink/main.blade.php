@extends('layouts.main')

@section('title', 'Chain Link Fence')

@section('styles')
<style>
    .main-header {
        background-color: #1a4d2e;
        color: white;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
    }
    
    .about-image-chainlink {
        border: 2px solid #1a4d2e;
    }
    
    .page-description {
        line-height: 1.6;
    }
    
    .group-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .group-card {
        width: calc(33.333% - 20px);
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .group-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .group-image {
        height: 200px;
        width: 100%;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    
    .group-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .group-info {
        padding: 15px;
    }
    
    .group-title {
        font-weight: bold;
        margin-bottom: 5px;
        color: #000;
        font-size: 1.2rem;
    }
    
    .group-description {
        color: #555;
        font-size: 0.9rem;
        margin-bottom: 15px;
    }
    
    .group-code {
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 10px;
    }
    
    .section-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #000;
        border-bottom: 2px solid #1a4d2e;
        padding-bottom: 10px;
    }
    
    @media (max-width: 992px) {
        .group-card {
            width: calc(50% - 20px);
        }
    }
    
    @media (max-width: 576px) {
        .group-card {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="rounded bg-brown mb-2">
        <h1 class="page-title text-center mb-0">Chain Link Fence</h1>
    </div>
    <div class="row g-4 mb-6">
        <!-- Left Section - About -->
        <div class="col-md-8 wf-about mb-2">
            <div class="d-flex">
                <img src="{{ $headerImage }}" alt="Chain Link Fence" style="width: 180px; height: 180px; object-fit: cover;" class="me-4 rounded about-image-chainlink">
                <div>
                    <h4 class="mb-3">In Stock - Quick Shipping - Home Installation - Pick Up</h4>
                    <p class="page-description mb-2">
                        We offer from our fully stocked warehouse inventory, 
                        many heights, mesh sizes, colors and gauges of mesh fabric. We also have a complete 
                        line of posts, rail, pipe, fittings, hardware, hinges, latches, accessories and gates; 
                        all in stock and ready to pick up or ship.
                    </p>
                    <a href="#" class="btn btn-danger">See what's available for pickup</a>
                </div>
            </div>
        </div>

        <!-- Right Section - Manufacturer Info -->
        <div class="col-md-4">
            <div class="p-3 rounded bg-light-yellow">
                <ul class="small-font mb-0">
                    <li><strong><i class="bi bi-currency-dollar text-brown me-2"></i>Multiple Heights Available</strong></li>
                    <li><strong><i class="bi bi-shield-check text-brown me-2"></i>Variety of Mesh Sizes</strong></li>
                    <li><strong><i class="bi bi-tools text-brown me-2"></i>Complete Line of Accessories</strong></li>
                    <li><strong><i class="bi bi-check-circle text-brown me-2"></i>Ready to Pick Up or Ship</strong></li>
                </ul>

            </div>
        </div>
    </div>

   
    <!-- Parent Groups Section -->
    <div class="row mb-4 mt-4">
        <div class="col-12">
            <h2 class="section-title">Complete Chain Link Fence Systems</h2>
            <div class="group-grid">
                @foreach($parentGroups as $group)
                    <div class="group-card">
                        <a href="{{ route('chainlink.height', ['height' => explode('ft', $group['title'])[0] . 'ft']) }}" class="text-decoration-none">
                            <div class="group-image">
                                <img src="{{ $group['image'] }}" alt="{{ $group['title'] }}">
                            </div>
                            <div class="group-info">
                                <div class="group-title">{{ $group['title'] }}</div>
                                {{-- <div class="group-code">Item #: {{ $group['code'] }}</div> --}}
                                <div class="group-description">{{ $group['description'] }}</div>
                                {{-- <div class="text-center">
                                    <button class="btn btn-sm btn-danger">View Products</button>
                                </div> --}}
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Categories Section -->
    {{-- @if(count($chainlink_categories) > 0)
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="section-title">Chain Link Fence Categories</h2>
            <div class="group-grid">
                @foreach($chainlink_categories as $category)
                    <div class="group-card">
                        <a href="#" class="text-decoration-none">
                            <div class="group-image">
                                <img src="{{ $category['image'] }}" alt="{{ $category['family_category_name'] }}">
                            </div>
                            <div class="group-info">
                                <div class="group-title">{{ $category['family_category_name'] }}</div>
                                <div class="group-description">{{ Str::limit($category['cat_desc_long'], 100) }}</div>
                                <div class="text-center">
                                    <button class="btn btn-sm btn-danger">View Category</button>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif --}}
</div>
@endsection
