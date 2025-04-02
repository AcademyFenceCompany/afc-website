{{-- Debug variables
<pre>
Route parameters: {{ print_r(request()->route()->parameters(), true) }}
Request all: {{ print_r(request()->all(), true) }}
StyleTitle: {{ $styleTitle ?? 'Not set' }}
Spacing: {{ $spacing ?? 'Not set' }}
</pre> --}}

@extends('layouts.main')
@section('title', isset($styleTitle) ? $styleTitle : 'Wood Fence Products')

@section('styles')
<style>
    /* Override styles for this page only */
    .bg-brown {
        background-color: #8B4513 !important;
    }
    .page-title {
        font-size: 24px !important;
        color: #fff !important;
        font-weight: bold !important;
        padding: 10px 0 !important;
    }
    .btn.btn-brown {
        background-color: #8B4513 !important;
        color: white !important;
        border-color: #8B4513 !important;
    }
    .btn.btn-brown:hover {
        background-color: #6B3100 !important;
    }
</style>
@endsection

@section('content')
    <main class="container">
         <!-- Header Section -->
       <div class="rounded bg-brown">
            <h1 class="page-title text-center py-2 mb-0">
                @if(isset($styleTitle) && isset($spacing))
                    {{ $styleTitle }} - {{ $spacing }}
                @elseif(isset($styleTitle))
                    {{ $styleTitle }}
                @else
                    WOOD FENCE
                @endif
            </h1>
        </div>
        <!-- Product List Section -->
        @if($groupBy === 'style')
            @foreach ($styleGroups as $styleGroup)
                <div class="mb-4">
                    <div class="rounded" style="background-color: #000;">
                        <h2 class="text-white text-center py-2 my-0 text-uppercase fs-2">{{ $styleGroup['style'] }}</h2>
                    </div>
                    
                    <!-- Group by speciality within each style -->
                    @php
                        $specialityProducts = $styleGroup['combos']->groupBy('speciality');
                    @endphp
                    
                    <div class="row mt-3">
                        @foreach($specialityProducts as $speciality => $products)
                            @if(!empty($speciality))
                                <div class="col-md-6 mb-4">
                                    <div class="rounded" style="background-color: #444;">
                                        <h3 class="text-white text-center py-1 my-0 fs-5">{{ $speciality }}</h3>
                                    </div>
                                    <div class="card product-card shadow-sm h-100">
                                        @php
                                            // Take just the first product as representative of this speciality
                                            $product = $products->first();
                                        @endphp
                                        <div class="d-flex flex-column align-items-center p-3">
                                            <div class="product-image align-items-center">
                                                <a href="{{ route('product.show', ['id' => $product['product_id']]) }}">
                                                    <img src="{{ $product['general_image'] }}"
                                                        alt="Product Image" class="img-fluid rounded"
                                                        style="max-height: 250px; max-width: 250px;">
                                                </a>
                                            </div>
                                            <div class="product-details mt-3 d-flex flex-column justify-content-between flex-grow-1 align-items-center">
                                                <p class="mb-1"><strong>Style:</strong> {{ $styleGroup['style'] }}</p>
                                                <p class="mb-1"><strong>speciality:</strong> {{ $speciality }}</p>
                                                @if(isset($product['spacing']) && $product['spacing'])
                                                    <p class="mb-1"><strong>Spacing:</strong> {{ $product['spacing'] }}</p>
                                                @endif
                                                @if(isset($product['material']) && $product['material'])
                                                    <p class="mb-1"><strong>Material:</strong> {{ $product['material'] }}</p>
                                                @endif
                                                @if(isset($product['price']) && $product['price'])
                                                    <p class="mb-3"><strong>Starting at:</strong> ${{ number_format($product['price'], 2) }} per LF</p>
                                                @endif
                                                <a href="{{ route('product.show', ['id' => $product['product_id']]) }}" class="btn btn-brown">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    
                    <!-- Products with no speciality -->
                    @php
                        $nospecialityProducts = $styleGroup['combos']->filter(function($item) {
                            return empty($item['speciality']) || $item['speciality'] === null;
                        });
                        
                        // If there are products with no speciality, show them under a "Standard" heading
                        if ($nospecialityProducts->count() > 0) {
                            // Group the no-speciality products by material if available
                            $groupedNospeciality = $nospecialityProducts->groupBy(function($item) {
                                return $item['material'] ?? 'Standard';
                            });
                        }
                    @endphp
                    
                    @if(isset($groupedNospeciality) && $groupedNospeciality->count() > 0)
                        <div class="mt-4 mb-3">
                            <div class="rounded" style="background-color: #444;">
                                <h3 class="text-white text-center py-1 my-0 fs-4">Standard</h3>
                            </div>
                            
                            <div class="row mt-3">
                                @foreach ($groupedNospeciality as $material => $products)
                                    @php
                                        // Take just the first product of each material group
                                        $product = $products->first();
                                    @endphp
                                    <div class="col-md-6 mb-4">
                                        <div class="card product-card shadow-sm h-100">
                                            <div class="d-flex flex-column align-items-center p-3">
                                                <div class="product-image align-items-center">
                                                    <a href="{{ route('product.show', ['id' => $product['product_id']]) }}">
                                                        <img src="{{ $product['general_image'] }}"
                                                            alt="Product Image" class="img-fluid rounded"
                                                            style="max-height: 250px; max-width: 250px;">
                                                    </a>
                                                </div>
                                                <div class="product-details mt-3 d-flex flex-column justify-content-between flex-grow-1 align-items-center">
                                                    <p class="mb-1"><strong>Style:</strong> {{ $styleGroup['style'] }}</p>
                                                    <p class="mb-1"><strong>Material:</strong> {{ $material }}</p>
                                                    @if(isset($product['spacing']) && $product['spacing'])
                                                        <p class="mb-1"><strong>Spacing:</strong> {{ $product['spacing'] }}</p>
                                                    @endif
                                                    @if(isset($product['price']) && $product['price'])
                                                        <p class="mb-3"><strong>Starting at:</strong> ${{ number_format($product['price'], 2) }} per LF</p>
                                                    @endif
                                                    <a href="{{ route('product.show', ['id' => $product['product_id']]) }}" class="btn btn-brown">View Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        @elseif($groupBy === 'speciality')
            @foreach ($specialityGroups as $specialityGroup)
                @php
                    // Skip Dog Ear, Flat Top, and Knob Top speciality groups
                    if (in_array($specialityGroup['speciality'], ['Dog Ear', 'Flat Top', 'Knob Top'])) continue;
                @endphp
                <div class="mb-4">
                    <div class="rounded" style="background-color: #000;">
                        <h2 class="text-white text-center py-2 my-0 text-uppercase fs-2">{{ $specialityGroup['speciality'] }}</h2>
                    </div>
                    <div class="container text-center">
                        <div class="row align-items">
                            @php
                                // Take just the first product as representative of this speciality
                                $product = $specialityGroup['products']->first();
                            @endphp
                            <div class="col-md-6 p-2">
                                <div class="card product-card shadow-sm w-100">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="product-image me-3 align-items-center">
                                            <a href="{{ route('product.show', ['id' => $product['product_id']]) }}">
                                                <img src="{{ $product['general_image'] }}"
                                                    alt="Product Image" class="img-fluid rounded"
                                                    style="max-height: 300px; max-width: 300px;">
                                            </a>
                                        </div>
                                        <div class="product-details mt-2 d-flex flex-column justify-content-between flex-grow-1 align-items-center">
                                            <p>Picket Style: {{ $specialityGroup['speciality'] }}</p>
                                            @if($product['spacing'])
                                                <p>Spacing: {{ $product['spacing'] }}</p>
                                            @endif
                                            @if($product['material'])
                                                <p>Material: {{ $product['material'] }}</p>
                                            @endif
                                            <p>Price: From ${{ number_format($product['price'], 2) }}</p>
                                            <div class="mt-3">
                                                <a href="{{ route('product.show', ['id' => $product['product_id']]) }}"
                                                    class="btn btn-brown text-white">View Product</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="container">
                <div class="row">
                    @foreach($products as $product)
                        @php
                            // Skip products with Dog Ear, Flat Top, or Knob Top speciality
                            if (in_array($product['speciality'], ['Dog Ear', 'Flat Top', 'Knob Top'])) continue;
                        @endphp
                        <div class="col-4 p-2">
                            <div class="card product-card shadow-sm w-100">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="product-image me-3 align-items-center">
                                        <a href="{{ route('product.show', ['id' => $product['product_id']]) }}">
                                            <img src="{{ $product['general_image'] }}"
                                                alt="Product Image" class="img-fluid rounded"
                                                style="max-height: 300px; max-width: 300px;">
                                        </a>
                                    </div>
                                    <div class="product-details mt-2 d-flex flex-column justify-content-between flex-grow-1 align-items-center">
                                        @if($product['spacing'])
                                            <p>Spacing: {{ $product['spacing'] }}</p>
                                        @endif
                                        @if($product['material'])
                                            <p>Material: {{ $product['material'] }}</p>
                                        @endif
                                        <p>Price: From ${{ number_format($product['price'], 2) }}</p>
                                        <div class="mt-3">
                                            <a href="{{ route('product.show', ['id' => $product['product_id']]) }}"
                                                class="btn btn-brown text-white">View Product</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </main>
@endsection
