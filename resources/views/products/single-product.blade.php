{{-- @dd($productDetails); --}}
@extends('layouts.main')

@section('title', $productDetails->product_name)

@section('content')
    <div class="container py-5">
        <!-- Product Details Section -->
        <div class="row g-5 mb-5 align-items-start">
            <!-- Product Image Section -->
            <div class="col-md-4">
                <div class="card shadow-sm text-center">
                    <img id="product-image" src="{{ $productDetails->large_image ?? $productDetails->general_image }} "
                        alt="{{ $productDetails->product_name }}" class="img-fluid p-3">
                </div>
            </div>

            <!-- Product Information Section -->
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <h1 id="product-name" style="font-size: 1.7rem">
                            {{ $productDetails->product_name }}
                            </br>
                            {{ $productDetails->size1 }}
                            </br>
                            @if ($productDetails->family_category_id === 16)
                                <!-- Check if it's Wood Fence -->
                                @if ($productDetails->style)
                                    {{ $productDetails->style }}
                                @endif
                                @if ($productDetails->speciality)
                                    </br>{{ $productDetails->speciality }}
                                @endif
                                @if ($productDetails->spacing)
                                    </br>{{ $productDetails->spacing }}
                                @endif
                            @else
                                <!-- For non-Wood Fence categories -->
                                {{ $productDetails->size2 }} {{ $productDetails->size3 }}
                            @endif
                        </h1>
                        <p class="text-success fw-bold">In Stock</p>
                        <p><strong>Item Number:</strong> <span id="item-number">{{ $productDetails->item_no }}</span></p>
                        @if (!is_null($productDetails->weight))
                            <p><strong>Weight:</strong> <span id="weight">{{ $productDetails->weight }} lbs</span></p>
                        @endif
                        <div class="product-options-container" style="position: relative; width: 250px;">
                            <!-- Constrain width -->
                            <label for="product-option" class="form-label fw-bold">Size - Color:</label>
                            <select id="product-option" class="form-select bg-white mb-2"
                                style="max-height: 38px; max-width:fit-content;">
                                @foreach ($productVariations as $option)
                                    <option value="{{ $option->product_id }}">
                                        @if ($option->size3)
                                            {{ $option->size1 }} ---- {{ $option->color }} --- {{ $option->size3 }}
                                        @else
                                            {{ $option->size1 }} ---- {{ $option->color }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <p><strong>Material:</strong> {{ $productDetails->material }}</p> --}}
                        <div class="row mb-3">
                            <div class="col-6">
                                {{-- <label for="material" class="form-label fw-bold">Material:</label> --}}
                                {{-- <input type="text" id="material" value="{{ $productDetails->material }}"
                                    class="form-control bg-white mb-2" readonly> --}}
                                {{-- <label for="height" class="form-label fw-bold">Height:</label>
                                <select id="height" class="form-select bg-white mb-2">
                                    @foreach ($heightVariations as $variation)
                                        <option value="{{ $variation->product_id }}"
                                            {{ $variation->product_id == $productDetails->product_id ? 'selected' : '' }}>
                                            {{ $variation->size1 }}
                                        </option>
                                    @endforeach
                                </select> --}}
                                <div class="d-flex align-items-center mb-3">
                                    <label for="quantity" class="me-3 fw-bold">Quantity:</label>
                                    <button class="btn btn-outline-secondary btn-sm me-2 quantity-decrease">-</button>
                                    <input type="number" class="quantity-input text-center" value="1" min="1"
                                        data-price="{{ $productDetails->price_per_unit }}" />
                                    <button class="btn btn-outline-secondary btn-sm quantity-increase">+</button>
                                </div>
                                {{-- <p><strong>Price:</strong> <span id="product-price" class="dynamic-price">
                                        ${{ number_format($productDetails->price_per_unit, 2) }}</span>
                                </p> --}}
                                <h5>Price:</h5>
                                <p id="product-price">${{ number_format($productDetails->price_per_unit, 2) }}</p>

                                <button class="btn btn-sm btn-danger text-white ms-2 add-to-cart-btn"
                                    data-item="{{ $productDetails->item_no }}"
                                    data-name="{{ $productDetails->product_name }}"
                                    data-price="{{ $productDetails->price_per_unit }}"
                                    data-color="{{ $productDetails->color }}" data-size1="{{ $productDetails->size1 }}"
                                    data-size2="{{ $productDetails->size2 }}" data-size3="{{ $productDetails->size3 }}"
                                    data-specialty="{{ $productDetails->specialty }}"
                                    data-material="{{ $productDetails->material }}"
                                    data-spacing="{{ $productDetails->spacing }}"
                                    data-coating="{{ $productDetails->coating }}"
                                    data-weight="{{ $productDetails->weight }}"
                                    data-family_category="{{ $productDetails->family_category_id }}"
                                    data-general_image="{{ $productDetails->general_image }}"
                                    data-small_image="{{ $productDetails->small_image }}"
                                    data-large_image="{{ $productDetails->large_image }}"
                                    data-free_shipping="{{ $productDetails->free_shipping }}"
                                    data-special_shipping="{{ $productDetails->special_shipping }}"
                                    data-amount_per_box="{{ $productDetails->amount_per_box }}"
                                    data-description="{{ $productDetails->description }}"
                                    data-subcategory_id="{{ $productDetails->subcategory_id }}"
                                    data-shipping_length="{{ $productDetails->shipping_length }}"
                                    data-shipping_width="{{ $productDetails->shipping_width }}"
                                    data-shipping_height="{{ $productDetails->shipping_height }}"
                                    data-shipping_class="{{ $productDetails->shipping_class }}">
                                    Add to Cart
                                </button>

                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-white shadow rounded">
                            <h5 class="text-center">About this item</h5>
                            <p>{{ $productDetails->description }}</p>
                        </div>
                        <div class="p-3 bg-white shadow rounded mt-4">
                            <h5 class="text-center">To Place Order - Get Quick Quote/Price</h5>
                            <p>If you know what parts you need - Add items to the cart for total price with shipping.</p>
                            <a href="#" class="btn btn-outline-dark mt-2">Print Quote Sheet</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Associated Products Section -->
        <div class="mt-5">
            <h4 class="bg-danger text-white py-2 px-3 rounded">Associated Products</h4>
            <div class="table-responsive mt-3">
                <table class="table table-bordered text-center">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Item Number</th>
                            <th>Name</th>
                            <th>Size</th>
                            <th>Material</th>
                            <th>Weight</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($associatedProducts as $product)
                            <tr>
                                <td>{{ $product->item_no }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->size1 }}</td>
                                <td>{{ $product->material }}</td>
                                <td>{{ $product->weight }} lbs</td>
                                <td>
                                    <button class="btn btn-outline-secondary btn-sm decrease-qty">-</button>
                                    <input type="number" class="quantity-input text-center" value="1" min="1"
                                        data-price="{{ $product->price_per_unit }}">
                                    <button class="btn btn-outline-secondary btn-sm increase-qty">+</button>
                                </td>
                                <td>
                                    <span>${{ number_format($product->price_per_unit, 2) }}</span>
                                    {{-- <button class="btn btn-danger btn-sm add-to-cart-btn"
                                        data-item="{{ $product->item_no }}" data-name="{{ $product->product_name }}"
                                        data-price="{{ $product->price_per_unit }}">
                                        Add to Cart
                                    </button> --}}
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
    <script src="{{ asset('js/mini-cart.js') }}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
    <script src="{{ asset('js/single-product.js') }}"></script>
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
