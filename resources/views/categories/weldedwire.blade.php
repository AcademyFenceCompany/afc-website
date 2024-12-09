<pre>{{ dd($products->toArray()) }}</pre>

@extends('layouts.main')

@section('title', 'Welded Wire')


@section('content')
    <!-- Header Section -->
    <div class="bg-black text-white text-center py-3 rounded">
        <h1 class="mb-0">Welded Wire</h1>
    </div>
    <div class="text-center mt-2">
        <p>Specializing in Vinyl Coated Mesh, Hex Netting/Chicken Wire, Hardware Cloth. When comparing welded wire
            prices from different companies, one of the most important factors of Strength and Quality can be determined
            by comparing the specifications and weight of the roll.</p>
        <p class="text-danger fw-bold">CALL AHEAD FOR LOCAL PICKUP!</p>
    </div>

    <!-- Content Section -->
    <div class="row mt-4 align-items-center">
        <!-- Left Column -->
        <div class="col-md-4">
            <div class="bg-warning text-dark p-4 rounded">
                <h4 class="fw-bold text-center">The Original Online Fence Superstore</h4>
                <p class="mb-0 text-center"><em>Family-owned and operated since 1968</em></p>
                <h5 class="mt-3 text-center">Welded Wire Manufacturer</h5>
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
            <img src='/resources/images/Vinyl-coated-fence-category.png' alt="Welded Wire Rolls"
                class="img-fluid rounded shadow-lg">
        </div>

        <!-- Right Column -->
        <div class="col-md-4">
            <h4>{{ $weldedWireCategory->family_category_name ?? 'Academy Welded Wire Fence Manufacturing' }}</h4>
            <p class="text-danger fw-bold">In stock warehouse - Quick Shipping!</p>
            <p>{{ $weldedWireCategory->description ?? 'Academy Fence provides a wide selection of welded wire products for all needs.' }}
            </p>
            <a href="#" class="btn btn-danger text-white">WELDED WIRE SAMPLE</a>

            <!-- Brochures Section -->
            <div class="mt-4">
                <h5>Brochures</h5>
                <a href="#" class="btn btn-secondary btn-sm me-2"><i class="bi bi-file-earmark-text"></i> Welded
                    Wire Brochure</a>
                <a href="#" class="btn btn-secondary btn-sm"><i class="bi bi-printer"></i> Print Order Sheet</a>
            </div>
        </div>
    </div>

    <!-- Product Grid Section -->
    <div class="bg-light mt-5 py-4">
        <div class="custom-container">
            <div class="bg-black text-white text-center py-3 rounded">
                <h1 class="mb-0">Welded Wire Mesh Sizes</h1>
            </div>
            <div class="row justify-content-center g-4 mt-3">
                @foreach ($products as $product)
                    <div class="col-6 col-md-4 col-lg-2 d-flex justify-content-center">
                        <div class="card text-center shadow-sm h-100" style="width: 150px; border: none;">
                            <div class="card-header bg-danger text-white fw-bold py-2">
                                {{ $product->productDetail->size2 ?? 'Size not available' }}
                            </div>
                            <div class="card-body p-2">
                                {{-- <img src="{{ $product->productMedia->general_image ?? '/resources/images/4x4.jpg' }}" 
                                alt="Wire Image" class="img-fluid mb-3 rounded"> --}}
                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-dark btn-sm fw-bold" style="font-size: 12px;">Vinyl
                                        Coated</button>
                                    <button class="btn btn-outline-secondary btn-sm fw-bold"
                                        style="font-size: 12px;">Galvanized</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Other Sections -->
    <div class="row mt-4">
        @foreach ($weldedWireCategory->products as $product)
            <div class="col-lg-4 mb-4">
                <div class="bg-black text-white text-center py-3 rounded">
                    <h5 class="mb-0">{{ $product->product_name }}</h5>
                </div>
                <div class="row mt-3">
                    <div class="col-4">
                        <img src="{{ $product->productMedia->general_image ?? '/resources/images/default.png' }}"
                            alt="{{ $product->product_name }}" class="img-fluid mb-3 rounded shadow-sm">
                    </div>
                    <div class="col-8 prd-sm-text">
                        <p>{{ $product->description }}</p>
                    </div>
                    <div>
                        <h5>Brochures</h5>
                        <a href="#" class="btn btn-secondary btn-sm me-2">Welded Wire Brochure</a>
                        <a href="#" class="btn btn-secondary btn-sm">Print Order Sheet</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
