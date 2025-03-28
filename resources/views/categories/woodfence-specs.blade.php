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
                <div class="row m-2">
                    <div class="rounded" style="background-color: #000;">
                        <h2 class="text-white text-center py-2 my-0 text-uppercase fs-2">{{ $styleGroup->get('style') }}</h2>
                    </div>
                    <div class="container text-center">
                        <div class="row align-items">
                            @foreach ($styleGroup->get('combos') as $product)
                                @php
                                    $specialty = $product->get('specialty');
                                    // Skip Dog Ear, Flat Top, and Knob Top specialties
                                    if (in_array($specialty, ['Dog Ear', 'Flat Top', 'Knob Top'])) continue;
                                @endphp
                                <div class="col-4 p-2">
                                    <div class="card product-card shadow-sm w-100">
                                        <div class="d-flex flex-column align-items-center">
                                            <h5 class="fw-bold">{{ $specialty }}</h5>
                                            <div class="product-image me-3 align-items-center">
                                                <a href="{{ route('product.show', ['id' => $product->get('product_id')]) }}">
                                                    <img src="{{ $product->get('general_image') }}"
                                                        alt="{{ $specialty }}" class="img-fluid rounded"
                                                        style="max-height: 300px; max-width: 300px;">
                                                </a>
                                            </div>
                                            <div class="product-details mt-2 d-flex flex-column justify-content-between flex-grow-1 align-items-center">
                                                <p>Section Top Style: {{ $styleGroup->get('style') }}</p>
                                                <p>Picket Style: {{ $specialty }}</p>
                                                @if($product->get('spacing'))
                                                    <p>Spacing: {{ $product->get('spacing') }}</p>
                                                @endif
                                                @if($product->get('material'))
                                                    <p>Material: {{ $product->get('material') }}</p>
                                                @endif
                                                @if (in_array($product->get('family_category_id'), [17, 18, 19]))
                                                    <p>Heights: 3ft, 42in, 4ft, 5ft, 6ft, 7ft, 8ft</p>
                                                @else
                                                    <p>Heights:5ft, 6ft, 7ft, 8ft</p>
                                                @endif
                                                <p>Price: From ${{ number_format($product->get('price'), 2) }}</p>
                                                <div class="mt-3">
                                                    <a href="{{ route('product.show', ['id' => $product->get('product_id')]) }}"
                                                        class="btn btn-brown text-white">View Product</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        @elseif($groupBy === 'specialty')
            @foreach ($specialtyGroups as $specialtyGroup)
                @php
                    // Skip Dog Ear, Flat Top, and Knob Top specialty groups
                    if (in_array($specialtyGroup['specialty'], ['Dog Ear', 'Flat Top', 'Knob Top'])) continue;
                @endphp
                <div class="mb-4">
                    <div class="rounded" style="background-color: #000;">
                        <h2 class="text-white text-center py-2 my-0 text-uppercase fs-2">{{ $specialtyGroup['specialty'] }}</h2>
                    </div>
                    <div class="container text-center">
                        <div class="row align-items">
                            @foreach ($specialtyGroup['products'] as $product)
                                <div class="col-4 p-2">
                                    <div class="card product-card shadow-sm w-100">
                                        <div class="d-flex flex-column align-items-center">
                                            <div class="product-image me-3 align-items-center">
                                                <a href="{{ route('product.show', ['id' => $product->get('product_id')]) }}">
                                                    <img src="{{ $product->get('general_image') }}"
                                                        alt="Product Image" class="img-fluid rounded"
                                                        style="max-height: 300px; max-width: 300px;">
                                                </a>
                                            </div>
                                            <div class="product-details mt-2 d-flex flex-column justify-content-between flex-grow-1 align-items-center">
                                                <p>Picket Style: {{ $specialtyGroup['specialty'] }}</p>
                                                @if($product->get('spacing'))
                                                    <p>Spacing: {{ $product->get('spacing') }}</p>
                                                @endif
                                                @if($product->get('material'))
                                                    <p>Material: {{ $product->get('material') }}</p>
                                                @endif
                                                <p>Price: From ${{ number_format($product->get('price'), 2) }}</p>
                                                <div class="mt-3">
                                                    <a href="{{ route('product.show', ['id' => $product->get('product_id')]) }}"
                                                        class="btn btn-brown text-white">View Product</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="container">
                <div class="row">
                    @foreach($products as $product)
                        @php
                            // Skip products with Dog Ear, Flat Top, or Knob Top specialty
                            if (in_array($product->get('specialty'), ['Dog Ear', 'Flat Top', 'Knob Top'])) continue;
                        @endphp
                        <div class="col-4 p-2">
                            <div class="card product-card shadow-sm w-100">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="product-image me-3 align-items-center">
                                        <a href="{{ route('product.show', ['id' => $product->get('product_id')]) }}">
                                            <img src="{{ $product->get('general_image') }}"
                                                alt="Product Image" class="img-fluid rounded"
                                                style="max-height: 300px; max-width: 300px;">
                                        </a>
                                    </div>
                                    <div class="product-details mt-2 d-flex flex-column justify-content-between flex-grow-1 align-items-center">
                                        @if($product->get('spacing'))
                                            <p>Spacing: {{ $product->get('spacing') }}</p>
                                        @endif
                                        @if($product->get('material'))
                                            <p>Material: {{ $product->get('material') }}</p>
                                        @endif
                                        <p>Price: From ${{ number_format($product->get('price'), 2) }}</p>
                                        <div class="mt-3">
                                            <a href="{{ route('product.show', ['id' => $product->get('product_id')]) }}"
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
