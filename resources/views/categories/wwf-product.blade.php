@extends('layouts.main')

@section('title', 'Welded Wire')

@section('content')
    <!-- Header Section -->
    <div class="bg-black text-white text-center py-3 rounded">
        <h1 class="mb-0">Welded Wire</h1>
    </div>
    <div class="text-center mt-2">
        <p>Specializing in Vinyl Coated Mesh, Hex Netting/Chicken Wire, Hardware Cloth. When comparing welded wire prices
            from different companies, one of the most important factors of Strength and Quality can be determined by
            comparing the specifications and weight of the roll.</p>
        <p class="text-danger fw-bold">CALL AHEAD FOR LOCAL PICKUP!</p>
    </div>

    <!-- Main Section -->
    <div class="row mt-4 align-items-center">
        <!-- Left Column -->
        <div class="col-md-4">
            <div class="bg-warning text-dark p-4 rounded shadow-sm">
                <h4 class="fw-bold">The Original online Fence Superstore</h4>
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
            <img src='/resources/images/image 103.png' alt="Welded Wire Diagram" class="img-fluid rounded shadow-sm">
        </div>

        <!-- Right Column -->
        <div class="col-md-4">
            <h5 class="text-danger fw-bold">Vinyl PVC Coated Welded Wire Fence</h5>
            <p><strong>In stock warehouse - Quick Shipping!</strong></p>
            <p><strong>4in x 4in Vinyl PVC Coated Mesh</strong></p>
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
    @foreach ($meshSize_products->groupBy('size3') as $gauge => $products)
        <!-- Gauge Section -->
        <div class="mt-5">
            <div class="bg-danger text-white text-center py-2 rounded">
                <h4>{{ $gauge }} Gauge</h4>
            </div>
            <div class="row mt-3">
                <!-- Left Image -->
                <div class="col-md-3 text-center">
                    <div class="card shadow-sm">
                        <div class="card-header bg-danger text-white fw-bold py-2">
                            {{ $products->first()->size2 ?? 'Mesh Size' }},
                            {{ $gauge ?? 'Gauge' }}
                        </div>
                        <div class="card-body">
                            <img src="{{ $products->first()->large_image ?? '/resources/images/default.png' }}"
                                alt="{{ $products->first()->product_name }}" class="img-fluid rounded">
                        </div>
                    </div>
                </div>

                <!-- Product Table -->
                <div class="col-md-9">
                    <p class="text-danger"><strong>Note:</strong> call ahead for local pickup!</p>
                    <table class="table table-bordered">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th>Item Number</th>
                                <th>Size</th>
                                <th>Mesh Size</th>
                                <th>Weight</th>
                                <th>Color</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>
                                        <a href="{{ route('product.show', ['id' => $product->product_id]) }}">
                                            {{ $product->item_no }}
                                        </a>
                                    </td>
                                    <td>{{ $product->size1 }}</td>
                                    <td>{{ $product->size2 }} {{ $product->size3 }}</td>
                                    <td>{{ $product->weight ?? 'N/A' }} lbs</td>
                                    <td class="{{ strtolower($product->color) }}">
                                        {{ $product->color }}
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-outline-secondary btn-sm me-2 quantity-decrease">-</button>
                                        <input type="number" class="quantity-input text-center" value="1"
                                            min="1" data-price="{{ $product->price_per_unit }}" />
                                        <button class="btn btn-outline-secondary btn-sm quantity-increase">+</button>
                                    </td>
                                    <td class="d-flex align-items-center justify-content-between">
                                        <span
                                            class="dynamic-price">${{ number_format($product->price_per_unit, 2) }}</span>
                                        <button class="btn btn-sm btn-danger text-white ms-2 add-to-cart-btn"
                                            data-item="{{ $product->item_no }}" data-name="{{ $product->product_name }}"
                                            data-price="{{ $product->price_per_unit }}" data-color="{{ $product->color }}"
                                            data-size="{{ $product->size1 }}"
                                            data-mesh="{{ $product->size2 }} {{ $product->size3 }}">
                                            Add to Cart
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Knock-In Posts Section -->
    <div class="mt-5">
        <!-- Section Title -->
        <div class="bg-danger text-white text-center py-2 rounded">
            <h4>Knock-In Posts U-Channel with fastening clips</h4>
        </div>
        <!-- Content -->
        <div class="row align-items-center mt-3">
            <!-- Left Image -->
            <div class="col-md-3 text-center">
                <div class="card shadow-sm">
                    <div class="card-header bg-danger text-white fw-bold py-2">
                        Knock-In Posts
                    </div>
                    <div class="card-body">
                        <img src="/resources/images/image 104.png" alt="Knock-In Posts" class="img-fluid rounded">
                    </div>
                </div>
            </div>

            <!-- Right Table -->
            <div class="col-md-9">
                <p class="text-danger"><strong>Note:</strong> call ahead for local pickup!</p>
                <table class="table table-bordered">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="bg-dark text-white">Item Number</th>
                            <th class="bg-dark text-white">Size</th>
                            <th class="bg-dark text-white">Weight</th>
                            <th class="bg-dark text-white">Color</th>
                            <th class="bg-dark text-white">Quantity</th>
                            <th class="bg-dark text-white">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ([['WWHD125', '5ft H', '4.60 lbs', 'Black', '$11.00'], ['WWHD126', '6ft H', '5.50 lbs', 'Black', '$12.00'], ['WWHD127', '7ft H', '6.40 lbs', 'Green', '$14.00'], ['WWHD128', '8ft H', '8.00 lbs', 'Black', '$15.00'], ['WWHD106', '10ft 6in H', '10.50 lbs', 'Black', '$20.00']] as $item)
                            <tr>
                                <td>{{ $item[0] }}</td>
                                <td>{{ $item[1] }}</td>
                                <td>{{ $item[2] }}</td>
                                <td>
                                    <select class="form-select form-select-sm">
                                        <option selected>{{ $item[3] }}</option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-dark">-</button>
                                    <span class="mx-2">1</span>
                                    <button class="btn btn-sm btn-outline-dark">+</button>
                                </td>
                                <td class="d-flex align-items-center justify-content-between">
                                    <span>{{ $item[4] }}</span>
                                    <button class="btn btn-sm btn-danger text-white ms-2">Add to Cart</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script src="{{ asset('js/cart.js') }}"></script>
@endsection

<!-- Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="cartToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success">
            <strong class="me-auto">Cart Notification</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Item added to the cart successfully!
        </div>
    </div>
</div>
