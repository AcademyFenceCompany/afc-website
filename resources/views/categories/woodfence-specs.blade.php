<pre>{{ dd($styleGroups) }}</pre>
{{-- <pre>{{ dd($spacing) }}</pre> --}}

@extends('layouts.main')
@section('title', 'Wood Fence Products')

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
            <div class="col-md-6">
                <div class="d-flex">
                    <img src="/resources/images/woodfenceabt.png" alt="Wood Post Cap" class="me-4 rounded"
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
                    <button class="btn btn-light border w-100 text-center">Wood Post Cap Brochure</button>
                    <button class="btn btn-light border w-100 text-center">Wood Post Cap Order Sheet</button>
                    <button class="btn w-100" style="background-color: #8B4513; color: white;">Get a Quote</button>
                </div>
            </div>

            <!-- Right Section - Manufacturer Info -->
            <div class="col-md-4">
                <div class="p-3 rounded" style="background-color: #FFFFD4;">
                    <h5 class="text-center mb-1">The Original online Fence Superstore</h5>
                    <p class="text-center small mb-3 fst-italic">Family owned operated since 1968</p>

                    <h5 class="text-brown mb-2">Welded Wire Manufacturer</h5>
                    <ul class="list-unstyled mb-0" style="font-size: 14px;">
                        <li>• Widest variety of mesh size and gauges</li>
                        <li>• Direct Ship from our warehouse</li>
                        <li>• Our manufacture specifications:
                            <ul class="list-unstyled ps-3 mb-0">
                                <li>• Full gauge steel core</li>
                                <li>• Hot dip galvanized</li>
                                <li>• Then quality PVC coated</li>
                            </ul>
                        </li>
                        <li>• Pick up available in NJ</li>
                    </ul>
                </div>
            </div>
        </div>

        @php
            // Manual mapping of product IDs for each speciality
            $manualProductIds = [
                'Straight on Top' => [
                    'French Gothic' => 1001, // Replace 1001 with the actual product ID
                    'Slant Ear' => 1985, // Replace 1002 with the actual product ID
                    'Gothic Point' => 1003, // Replace 1003 with the actual product ID
                ],
                'Concave' => [
                    'French Gothic' => 2001,
                    'Slant Ear' => 2002,
                    'Gothic Point' => 2003,
                ],
                'Convex' => [
                    'French Gothic' => 3001,
                    'Slant Ear' => 3002,
                    'Gothic Point' => 3003,
                ],
            ];
        @endphp <!-- Product List Section -->
        @foreach ($styleGroups as $styleGroup)
            <div class="row g-4 m-2">
                <div class="rounded" style="background-color: #000;">
                    <h2 class="text-white text-center py-2 my-0 text-uppercase fs-2">{{ $styleGroup['style'] }}</h2>
                </div>
                <div class="col-12 d-flex align-items-stretch">
                    @foreach ($styleGroup['products'] as $speciality => $productCollection)
                        @php
                            // Get product ID manually from the mapping
                            $productId = $manualProductIds[$styleGroup['style']][$speciality] ?? null;
                        @endphp
                        @if ($productId)
                            <div class="col-md-4 m-2">
                                <div class="card product-card shadow-sm p-3 w-100">
                                    <div class="d-flex flex-column align-items-center">
                                        <h5 class="fw-bold">{{ $speciality }}</h5>
                                        <div
                                            class="product-details mt-2 d-flex flex-column justify-content-between flex-grow-1 align-items-center">
                                            <p>Section Top Style: {{ $styleGroup['style'] }}</p>
                                            <p>Picket Style: {{ $speciality }}</p>
                                            {{-- <p>Spacing: {{ $formattedSpacing }}</p> --}}
                                            <p>Material: 100% Cedar Wood</p>
                                            <p>Price: From
                                                ${{ number_format($productCollection->first()->price_per_unit ?? 0, 2) }}
                                            </p>

                                            <!-- Button with manual product ID -->
                                            <div class="mt-3">
                                                <a href="{{ route('product.show', ['id' => $productId]) }}"
                                                    class="btn btn-danger text-white">View Product</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    </main>
@endsection
