@extends('layouts.main')

@section('title', $page->title ?? 'Welded Wire')

@section('content')
    <!-- Header Section -->
    <div class="bg-black text-white text-center py-3 rounded">
        <h1 class="mb-0">{{ $page->title }}</h1>
    </div>
    <div class="text-center mt-2">
        <p>{{ $page->bulletin_board }}</p>
        <p class="text-danger fw-bold">CALL AHEAD FOR LOCAL PICKUP!</p>
    </div>

    <!-- Main Section -->
    <div class="row mt-4 align-items-center">
        <!-- Left Column -->
        <div class="col-md-4">
            <div class="bg-warning text-dark p-4 rounded shadow-sm">
                <h4 class="fw-bold">{{ $page->subtitle }}</h4>
                <p class="mb-0"><em>Family owned operated since 1968</em></p>
                <h5 class="mt-3">Welded Wire Manufacturer</h5>
                <ul class="mt-3">
                    <li>Widest variety of mesh size and gauges</li>
                    <li>Direct Ship from our warehouse</li>
                    <li>Our manufacture specifications:
                        <ul>
                            <li>Full gauge steel core</li>
                            <li>Hot dip galvanized</li>
                            <li>Then quality PVC coated</li>
                        </ul>
                    </li>
                    <li>Pick up available in NJ</li>
                </ul>
            </div>
        </div>

        <!-- Center Image -->
        <div class="col-md-4 text-center">
            @if ($page->product_image)
                <img src="{{ Storage::url($page->product_image) }}" alt="{{ $page->title }}"
                    class="img-fluid rounded shadow-sm">
            @endif
        </div>

        <!-- Right Column -->
        <div class="col-md-4">
            <h5 class="text-danger fw-bold">{{ $page->category_tidbit_1 }}</h5>
            <p><strong>{{ $page->category_tidbit_2 }}</strong></p>
            <p><strong>{{ $page->category_tidbit_3 }}</strong></p>
            <div class="row">
                <div class="col-6">
                    <h6>Benefits:</h6>
                    <ul>
                        <li>Easy to Install</li>
                        <li>Weather Proof</li>
                        <li>Attractive Durable</li>
                        <li>Rust-Resistant</li>
                        <li>Long Lasting</li>
                    </ul>
                </div>
                <div class="col-6">
                    <h6>Attach to:</h6>
                    <ul>
                        <li>Post and Rail Fence</li>
                        <li>Stakes</li>
                        <li>Trees and Shrubs</li>
                    </ul>
                </div>
            </div>
            <a href="#" class="btn btn-danger text-white mt-3">WELDED WIRE SAMPLE</a>
            <div class="mt-4">
                <h6>Brochures</h6>
                <a href="#" class="btn btn-secondary btn-sm me-2"><i class="bi bi-file-earmark-text"></i> Welded Wire
                    Brochure</a>
                <a href="#" class="btn btn-secondary btn-sm"><i class="bi bi-printer"></i> Print Order Sheet</a>
            </div>
        </div>
    </div>

    <!-- Welded Wire Products by Gauge -->
    @foreach ($meshSize_products as $gauge => $meshSizeGroups)
        <!-- Gauge Section -->
        <div class="mt-5">
            <div class="bg-danger text-white text-center py-2 rounded">
                <h4>{{ $gauge }} Gauge</h4>
            </div>

            @foreach ($meshSizeGroups as $meshSize => $heightProducts)
                <div class="row mt-3">
                    <!-- Left Image -->
                    <div class="col-md-3 text-center">
                        <div class="card shadow-sm">
                            <div class="card-header bg-danger text-white fw-bold py-2">
                                {{ $meshSize }},
                                {{ $gauge }}
                            </div>
                            <div class="card-body">
                                <img src="{{ optional($heightProducts->first())->large_image ?? '/resources/images/default.png' }}"
                                    alt="{{ optional($heightProducts->first())->product_name ?? 'Product Image' }}"
                                    class="img-fluid rounded">
                            </div>
                        </div>
                    </div>

                    <!-- Product Table -->
                    <div class="col-md-9">
                        <p class="text-danger"><strong>Note:</strong> call ahead for local pickup!</p>
                        <table class="table table-bordered">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>Mesh Size</th>
                                    <th>Height</th>
                                    <th>Length</th>
                                    <th>Color</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($heightProducts as $product)
                                    @foreach ($product->available_colors as $color)
                                        @php
                                            $variant = $product->color_variants[$color];
                                        @endphp
                                        <tr>
                                            <td>{{ $product->size2 }}</td>
                                            <td>{{ $product->size1 }}</td>
                                            <td>{{ $product->shipping_length ?? 'N/A' }}</td>
                                            <td>{{ $color }}</td>
                                            <td>${{ number_format($product->price_per_unit, 2) }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary add-to-cart"
                                                    data-product-id="{{ $variant['product_id'] }}"
                                                    data-product-name="{{ $product->product_name }} - {{ $color }}"
                                                    data-product-price="{{ $product->price_per_unit }}">
                                                    Add to Cart
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
@endsection

@section('scripts')
    <script src="{{ asset('js/mini-cart.js') }}"></script>
@endsection
