{{-- <pre>{{ dd($wood_categories) }}</pre> --}}
@extends('layouts.main')

@section('title', 'Wood Fence Products')

@section('styles')
<style>
    .bg-brown {
        background-color: #8B4513;
    }
    .text-brown {
        color: #8B4513;
    }
    .btn-brown {
        background-color: #8B4513;
        color: white;
    }
    .btn-brown:hover {
        background-color: #6B3100;
        color: white;
    }
    /* Custom 5-column layout */
    .col-lg-2-4 {
        width: 20%;
    }
    @media (max-width: 992px) {
        .col-lg-2-4 {
            width: 25%;
        }
    }
    @media (max-width: 768px) {
        .col-lg-2-4 {
            width: 33.333%;
        }
    }
    @media (max-width: 576px) {
        .col-lg-2-4 {
            width: 50%;
        }
    }
</style>
@endsection

@section('content')
    <main class="container">
        <!-- Header Section -->
        <div class="rounded" style="background-color: #8B4513;">
            <h1 class="text-white text-center py-3 mb-0">WOOD FENCE</h1>
        </div>
        <div class="text-center py-2 mb-4 border-bottom">
            <p class="mb-0">Academy Wood Fence - Cedar Fencing Leaders in Wood Fencing for Over 40 Years.</p>
        </div>

        <!-- Info Section -->
        <div class="row g-4 mb-4">
            <!-- Left Section - About -->
            <div class="col-md-6 wf-about">
                <div class="d-flex">
                    <img src="/resources/images/lattice_top_big.jpg" alt="Wood Post Cap" class="me-4 rounded"
                        style="width: 180px; height: 180px; object-fit: cover;">
                    <div>
                        <h4 class="mb-3">Academy Wood Fence - Cedar Fencing</h4>
                        <p class="mb-2" style="font-size: 14px;">
                            Academy Fence offers many different types of wood fencing including, spaced picket wood fencing,
                            solid board wood fencing, board on board and post and rail wood fencing for purchase or install.
                            Academy Fence designs, manufactures, wholesales and professionally installs top quality custom
                            decorative and privacy wood fencing and picket.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Middle Section - Brochures -->
            <div class="col-md-2 text-center">
                <h4 class="text-brown mb-3">Brochures</h4>
                <div class="d-flex flex-column gap-2">
                    <button class="btn btn-light border w-100 text-center">
                        Wood Post Cap Brochure
                    </button>
                    <button class="btn btn-light border w-100 text-center">
                        Wood Post Cap Order Sheet
                    </button>
                    <button class="btn w-100" style="background-color: #8B4513; color: white;">
                        Get a Quote
                    </button>
                </div>
            </div>

            <!-- Right Section - Manufacturer Info -->
            <div class="col-md-4">
                <div class="p-3 rounded" style="background-color: #FFFFD4;">
                    <h5 class="text-center mb-1">The Original online Fence Superstore</h5>
                    <p class="text-center small mb-3 fst-italic">Family owned operated since 1968</p>
                    <ul class="list-unstyled mb-0" style="font-size: 14px;">
                        <li>• Leading custom cedar fence manufacturers since 1968.</li>
                        <li>• Many/most orders in stock, or ready rapidly.</li>
                        <li>• Wide variety of styles, gates, posts and caps</li>
                        <li>• Pick up available in NJ</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Product List Section -->
        <div class="container-fluid px-0">
            <!-- Academy Custom Cedar Fencing Section -->
            <div class="row">
                <div class="col-12">
                    <div class="bg-brown text-white text-center py-2 rounded mb-3">
                        <h4 class="mb-0">Academy Custom Cedar Fencing Sections, Gates and Parts</h4>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                @php
                    $customCedarProducts = $wood_categories->filter(function($item) {
                        return !isset($item['category_group']) || $item['category_group'] === 'custom_cedar';
                    });
                @endphp

                @foreach ($customCedarProducts as $category)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2-4">
                        <div class="card h-100 border-0 shadow-sm">
                           
                            <div class="text-center p-2">
                                @if ($category['image'])
                                    <img src="{{ $category['image'] }}" class="rounded" style="width: 150px; height: 150px; object-fit: cover;">
                                @endif
                                <div class="text-center pt-2">
                                    <h6 class="card-title text-brown fw-bold">{{ $category['family_category_name'] }}</h6>
                                </div>
                                @if (isset($category['spacing']) && !empty($category['spacing']))
                                    <div class="d-flex flex-wrap justify-content-center gap-1 mt-2">
                                        @foreach ($category['spacing'] as $spacing)
                                            @if ($spacing)
                                                <a href="{{ route('woodfence.specs', [
                                                    'subcategoryId' => $category['family_category_id'],
                                                    'spacing' => $spacing,
                                                ]) }}" class="btn btn-sm btn-danger" style="font-size: 0.7rem;">
                                                    {{ $spacing }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <a href="{{ route('woodfence.specs', ['subcategoryId' => $category['family_category_id']]) }}" class="btn btn-sm btn-danger mt-2" style="font-size: 0.7rem;">VIEW</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Other Fencing Sections -->
            <div class="row">
                <div class="col-12">
                    <div class="bg-brown text-white text-center py-2 rounded mb-3">
                        <h4 class="mb-0">Other Fencing Sections, Gates and Parts</h4>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                @php
                    $otherFencingProducts = $wood_categories->filter(function($item) {
                        return isset($item['category_group']) && $item['category_group'] === 'other_fencing';
                    });
                @endphp

                @foreach ($otherFencingProducts as $category)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="text-center pt-2">
                                <h6 class="card-title text-brown small fw-bold">{{ $category['family_category_name'] }}</h6>
                            </div>
                            <div class="text-center p-2">
                                @if ($category['image'])
                                    <img src="{{ $category['image'] }}" class="rounded" style="width: 100px; height: 100px; object-fit: cover;">
                                @endif
                                
                                @if (isset($category['spacing']) && !empty($category['spacing']))
                                    <div class="d-flex flex-wrap justify-content-center gap-1 mt-2">
                                        @foreach ($category['spacing'] as $spacing)
                                            @if ($spacing)
                                                <a href="{{ route('woodfence.specs', [
                                                    'subcategoryId' => $category['family_category_id'],
                                                    'spacing' => $spacing,
                                                ]) }}" class="btn btn-sm btn-brown" style="font-size: 0.7rem;">
                                                    {{ $spacing }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <a href="{{ route('woodfence.specs', ['subcategoryId' => $category['family_category_id']]) }}" class="btn btn-sm btn-brown mt-2" style="font-size: 0.7rem;">VIEW</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Additional Wood Fence Parts -->
            <div class="row">
                <div class="col-12">
                    <div class="bg-brown text-white text-center py-2 rounded mb-3">
                        <h4 class="mb-0">Additional Wood Fence Parts and Accessories</h4>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                @php
                    $accessoryProducts = $wood_categories->filter(function($item) {
                        return isset($item['category_group']) && $item['category_group'] === 'accessories';
                    });
                @endphp

                @foreach ($accessoryProducts as $category)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="text-center pt-2">
                                <h6 class="card-title text-brown small fw-bold">{{ $category['family_category_name'] }}</h6>
                            </div>
                            <div class="text-center p-2">
                                @if ($category['image'])
                                    <img src="{{ $category['image'] }}" class="rounded" style="width: 100px; height: 100px; object-fit: cover;">
                                @endif
                                
                                @if (isset($category['spacing']) && !empty($category['spacing']))
                                    <div class="d-flex flex-wrap justify-content-center gap-1 mt-2">
                                        @foreach ($category['spacing'] as $spacing)
                                            @if ($spacing)
                                                <a href="{{ route('woodfence.specs', [
                                                    'subcategoryId' => $category['family_category_id'],
                                                    'spacing' => $spacing,
                                                ]) }}" class="btn btn-sm btn-brown" style="font-size: 0.7rem;">
                                                    {{ $spacing }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <a href="{{ route('woodfence.specs', ['subcategoryId' => $category['family_category_id']]) }}" class="btn btn-sm btn-brown mt-2" style="font-size: 0.7rem;">VIEW</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
