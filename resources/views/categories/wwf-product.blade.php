{{-- @dd($meshSize_products) ; --}}
@extends('layouts.main')

@section('title', 'Welded Wire')

@section('content')


<style>
   .ww_title {
    font-size: 24px !important;
    color: #fff !important;
    font-weight: bold !important;
    padding: 10px 0 !important;
   }

   .border-bottom {
            font-size: 12px;
        }

        .call__ahead {
            font-size: 14px;
        }

        .mesh__title {
            font-size: 20px;
        }

        .card-header {
            font-size: 14px;
            background-color: #f7f9fa !important;
            color: #000 !important;
            font-weight: 700 !important;
        }

        .item-number {
        font-weight: 500;
        text-decoration: none;
        color: #000;
        }

        .item-number:hover {
            color: #007bff;
        }

        .table th {
            background-color: #343a40 !important;
            font-weight: 500 !important;
            color: #fff !important;
        }

        .quantity-input::-webkit-inner-spin-button,
        .quantity-input::-webkit-outer-spin-button {
         -webkit-appearance: none;
         margin: 0;
        }

        .quantity-input {
            border: none;
            width: 20px;
            text-align: center;
        }

        .product_img {
    transition: transform 0.3s ease-in-out;
    cursor: pointer;
}

.product_img.zoomed {
    transform: scale(1.6); 
    z-index: 1000;
    position: relative;
}

        
</style>
    
    <!-- Welded Wire Products by Gauge -->
    @foreach ($meshSize_products->groupBy('size3') as $gauge => $products)
        <!-- Gauge Section -->
        <div class="mt-0">
            <div class="bg-danger text-white text-center py-2 rounded">
                <h4 class="m-0 mesh__title">{{ $gauge }}</h4>
            </div>
            <div class="row mt-1">
                <!-- Left Image -->
                <div class="col-md-2 text-center mb-4 mb-md-0">
    <div class="card shadow-sm">
        <div class="card-header bg-danger text-white fw-bold py-1 rounded">
                        <!-- <img src="{{ $products->first()->large_image ?? '/resources/images/default.png' }}"
                        alt="{{ $products->first()->product_name }}" class="img-fluid rounded"> -->
                        <img src="/resources/images/4x4 vinyl.png"
                alt="{{ $products->first()->product_name }}" class="img-fluid rounded product_img">
            <div class="mt-1">
                {{ $products->first()->size2 ?? 'Mesh Size' }} {{ $gauge ?? 'Gauge' }}
            </div>
        </div>
    </div>
</div>

                <!-- Product Table -->
                <div class="col-md-9">
                    <p class="text-danger mb-1" style="font-size: 12px;"><strong>note:</strong> call ahead for local pickup!</p>
                    
                    <!-- Desktop Table (Hidden on Mobile) -->
                    <div class="d-none d-md-block">
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
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <a class="item-number" href="{{ route('product.show', ['id' => $product->product_id]) }}">
                                                {{ $product->item_no }}
                                                </a>
                                            </div> 
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                {{ $product->size1 }}
                                            </div>
                                        </td>
                                        <td>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                        {{ $product->size2 }} {{ $product->size3 }}
                                        </div>
                                    </td>
                                        <td>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                        {{ $product->weight ?? 'N/A' }} lbs
                                        </div>
                                    </td>
                                        <td class="{{ strtolower($product->color) }}">
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            {{ $product->color }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <button class="btn btn-outline-secondary btn-sm me-2 quantity-decrease">-</button>
                                                <input type="number" class="quantity-input text-center" value="1"
                                                    min="1" data-price="{{ $product->price_per_unit }}" />
                                                <button class="btn btn-outline-secondary btn-sm ms-2 quantity-increase">+</button>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="dynamic-price">${{ number_format($product->price_per_unit, 2) }}</span>
                                                <button class="btn btn-sm btn-danger text-white ms-2 add-to-cart-btn"
                                                    data-item="{{ $product->item_no }}" data-name="{{ $product->product_name }}"
                                                    data-price="{{ $product->price_per_unit }}" data-color="{{ $product->color }}"
                                                    data-size1="{{ $product->size1 }}" data-size2="{{ $product->size2 }}"
                                                    {{-- data-size3="{{ $product->size3 }}" data-speciality="{{ $product->speciality }}" --}}
                                                    data-material="{{ $product->material }}"
                                                    data-spacing="{{ $product->spacing }}" data-coating="{{ $product->coating }}"
                                                    data-weight="{{ $product->weight }}"
                                                    data-family_category="{{ $product->family_category_id }}"
                                                    data-general_image="{{ $product->general_image }}"
                                                    data-small_image="{{ $product->small_image }}"
                                                    data-large_image="{{ $product->large_image }}"
                                                    data-free_shipping="{{ $product->free_shipping }}"
                                                    data-special_shipping="{{ $product->special_shipping }}"
                                                    data-amount_per_box="{{ $product->amount_per_box }}"
                                                    data-description="{{ $product->description }}"
                                                    data-subcategory_id="{{ $product->subcategory_id }}"
                                                    data-shipping_length="{{ $product->shipping_length }}"
                                                    data-shipping_width="{{ $product->shipping_width }}"
                                                    data-shipping_height="{{ $product->shipping_height }}"
                                                    data-shipping_class="{{ $product->shipping_class }}">
                                                    Add to Cart
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Mobile Cards (Visible only on Mobile) -->
                    <div class="d-md-none">
                        @foreach ($products as $product)
                            <div class="card mb-3 shadow-sm">
                                <div class="card-header bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('product.show', ['id' => $product->product_id]) }}" class="fw-bold">
                                            {{ $product->item_no }}
                                        </a>
                                        <span class="badge bg-primary">{{ $product->color }}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-6 fw-bold">Size:</div>
                                        <div class="col-6">{{ $product->size1 }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6 fw-bold">Mesh Size:</div>
                                        <div class="col-6">{{ $product->size2 }} {{ $product->size3 }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6 fw-bold">Weight:</div>
                                        <div class="col-6">{{ $product->weight ?? 'N/A' }} lbs</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6 fw-bold">Price:</div>
                                        <div class="col-6 dynamic-price">${{ number_format($product->price_per_unit, 2) }}</div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-outline-secondary btn-sm quantity-decrease">-</button>
                                            <input type="number" class="quantity-input text-center mx-2" value="1"
                                                min="1" style="width: 40px;" data-price="{{ $product->price_per_unit }}" />
                                            <button class="btn btn-outline-secondary btn-sm quantity-increase">+</button>
                                        </div>
                                        <button class="btn btn-danger text-white add-to-cart-btn"
                                            data-item="{{ $product->item_no }}" data-name="{{ $product->product_name }}"
                                            data-price="{{ $product->price_per_unit }}" data-color="{{ $product->color }}"
                                            data-size1="{{ $product->size1 }}" data-size2="{{ $product->size2 }}"
                                            {{-- data-size3="{{ $product->size3 }}" data-speciality="{{ $product->speciality }}" --}}
                                            data-material="{{ $product->material }}"
                                            data-spacing="{{ $product->spacing }}" data-coating="{{ $product->coating }}"
                                            data-weight="{{ $product->weight }}"
                                            data-family_category="{{ $product->family_category_id }}"
                                            data-general_image="{{ $product->general_image }}"
                                            data-small_image="{{ $product->small_image }}"
                                            data-large_image="{{ $product->large_image }}"
                                            data-free_shipping="{{ $product->free_shipping }}"
                                            data-special_shipping="{{ $product->special_shipping }}"
                                            data-amount_per_box="{{ $product->amount_per_box }}"
                                            data-description="{{ $product->description }}"
                                            data-subcategory_id="{{ $product->subcategory_id }}"
                                            data-shipping_length="{{ $product->shipping_length }}"
                                            data-shipping_width="{{ $product->shipping_width }}"
                                            data-shipping_height="{{ $product->shipping_height }}"
                                            data-shipping_class="{{ $product->shipping_class }}">
                                            Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach




    <!-- Knock-In Posts Section -->
    <div class="mt-0">
        <!-- Section Title -->
        <div class="bg-danger text-white text-center py-2 rounded">
        <h4 class="m-0 mesh__title">Knock-In Posts U-Channel with fastening clips</h4>
    </div>
        <!-- Content -->
        <div class="row mt-1">
            <!-- Left Image -->
            <div class="col-md-2 text-center mb-4 mb-md-0">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white fw-bold py-1 rounded">
                    <img src="/resources/images/image 104.png" alt="Knock-In Posts" class="img-fluid rounded product_img" >
                    <div class="mt-1">U-Channel</div>
                </div>
                <!-- <div class="card-body">
                    
                </div> -->
            </div>
        </div>

            
            
            <!-- Right Table -->
            <div class="col-md-9">
                <p class="text-danger mb-1" style="font-size: 12px;"><strong>note:</strong> call ahead for local pickup!</p>
                
                <!-- Desktop Table (Hidden on Mobile) -->
                <div class="d-none d-md-block">
                    <table class="table table-bordered">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th>Item Number</th>
                                <th>Size</th>
                                <th>Weight</th>
                                <th>Color</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ([['WWHD125', '5ft H', '4.60 lbs', 'Black', '$11.00'], ['WWHD126', '6ft H', '5.50 lbs', 'Black', '$12.00'], ['WWHD127', '7ft H', '6.40 lbs', 'Green', '$14.00'], ['WWHD128', '8ft H', '8.00 lbs', 'Black', '$15.00'], ['WWHD106', '10ft 6in H', '10.50 lbs', 'Black', '$20.00']] as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <span class="item-number">{{ $item[0] }}</span>
                                        </div>
                                    </td>
                                   
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <span>{{ $item[1] }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <span>{{ $item[2] }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <select class="form-select form-select-sm">
                                            <option selected>{{ $item[3] }}</option>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <button class="btn btn-sm btn-outline-dark">-</button>
                                            <span class="mx-2" style="width: 20px;">1</span>
                                            <button class="btn btn-sm btn-outline-dark">+</button>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span>{{ $item[4] }}</span>
                                            <button class="btn btn-sm btn-danger text-white ms-2">Add to Cart</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Mobile Cards (Visible only on Mobile) -->
                <div class="d-md-none">
                    @foreach ([['WWHD125', '5ft H', '4.60 lbs', 'Black', '$11.00'], ['WWHD126', '6ft H', '5.50 lbs', 'Black', '$12.00'], ['WWHD127', '7ft H', '6.40 lbs', 'Green', '$14.00'], ['WWHD128', '8ft H', '8.00 lbs', 'Black', '$15.00'], ['WWHD106', '10ft 6in H', '10.50 lbs', 'Black', '$20.00']] as $item)
                        <div class="card mb-3 shadow-sm">
                            <div class="card-header bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">{{ $item[0] }}</span>
                                    <span class="badge bg-primary">{{ $item[3] }}</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-6 fw-bold">Size:</div>
                                    <div class="col-6">{{ $item[1] }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6 fw-bold">Weight:</div>
                                    <div class="col-6">{{ $item[2] }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6 fw-bold">Price:</div>
                                    <div class="col-6">{{ $item[4] }}</div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-outline-secondary btn-sm">-</button>
                                        <span class="mx-2">1</span>
                                        <button class="btn btn-outline-secondary btn-sm">+</button>
                                    </div>
                                    <button class="btn btn-danger text-white">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


<!-- Header Section -->
<div class="bg-black rounded">
        <h1 class="ww_title text-center py-0 mb-0 mt-3">WELDED WIRE</h1>
    </div>
    <div class="text-center py-2 mb-4 border-bottom">
        <p class="mb-0">Specializing in Vinyl Coated Mesh, Hex Netting/Chicken Wire, Hardware Cloth. When comparing welded wire prices
            from different companies, one of the most important factors of Strength and Quality can be determined by
            comparing the specifications and weight of the roll.</p>
        <p class="text-danger fw-bold call__ahead">CALL AHEAD FOR LOCAL PICKUP!</p>
    </div>

    <!-- Info Section -->
    <div class="row g-4 mb-3">
        <!-- Left Section - About -->
        <div class="col-md-7 wf-about">
            <div class="d-flex">
                <img src="/resources/images/image 103.png" alt="Welded Wire Rolls"
                    class="me-4 rounded about-image">
                <div>
                    <h4 class="mb-2">Vinyl PVC Coated Welded Wire Fence</h4>
                    <p class="page-description mb-2">
                        We manufacture and supply a wide range of welded wire fence products, offering various mesh sizes,
                        gauges, heights, colors, and roll lengths. From our US-based warehouses, we retail and wholesale
                        single rolls to truckloads. We specialize in black and green vinyl-coated, galvanized welded wire,
                        chicken wire, poultry netting, and hardware cloth.
                    </p>
                    <p class="text-danger fw-bold">CALL AHEAD FOR LOCAL PICKUP!</p>
                </div>
            </div>
        </div>

        <!-- Middle Section - Brochures -->
        <div class="col-md-2 text-center">
            <h5 class="text-brown mb-2">Brochures</h5>
            <div class="d-flex flex-column gap-2">
                <button class="btn btn-light border w-100 text-center">
                    Welded Wire Brochure
                </button>
                <button class="btn btn-light border w-100 text-center">
                    Welded Wire Sample
                </button>
                <button class="btn btn-brown w-100" style="background-color: #8B4513 !important; color: white !important;">
                    Get a Quote
                </button>
            </div>
        </div>

        <!-- Right Section - Manufacturer Info -->
        <div class="col-md-3">
            <div class="p-3 rounded bg-light-yellow">
                <h6 class="text-center mb-1"><strong>Welded Wire Manufacturer</strong></h6>
                <p class="text-center small mb-1 fst-italic">Family owned operated since 1968</p>
                <ul class="list-unstyled mb-0 small-font">
                    <li>Our manufacture specifications:
                        <ul>
                            <li>Full gauge steel core</li>
                            <li>Hot dip galvanized</li>
                            <li>Then quality PVC coated</li>
                        </ul>
                    </li>
                    <li>• Widest variety of mesh size and gauges</li>
                    <li>• Direct Ship from our warehouse</li>
                    <li>• Pick up available in NJ</li>
                </ul>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script src="{{ asset('js/mini-cart.js') }}"></script>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.product_img').forEach(img => {
            img.addEventListener('click', function () {
                this.classList.toggle('zoomed');
            });
        });
    });
</script>

