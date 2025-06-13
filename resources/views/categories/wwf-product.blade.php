{{-- @dd($meshSize_products) ; --}}
@extends('layouts.main2')

@section('title', 'Welded Wire')

@section('content')
@include('partials.header')
<x-cart-sidebar :cart="$cart"/>

<main class="container">
<!-- Using global breadcrumb from header -->


<style>
    tr {
        padding: 0px !important;
    }
    td {
        padding: 0px !important;
    }
   .ww_title {
    font-size: 24px !important;
    color: #fff !important;
    font-weight: bold !important;
    padding: 10px 0 !important;
   }
    .bg-secondary {
        --bs-bg-opacity: 1;
        background-color: rgb(179, 202, 217) !important;
    }
   .border-bottom {
            font-size: 12px;
        }

        .call__ahead {
            font-size: 14px;
        }

        .mesh__title {
            font-size: 15px;
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
            background-color: #f0f0f0 !important;
            font-weight: 500 !important;
            color: #000 !important;
            font-size: 12px !important;
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
        transform: scale(1.8); 
        z-index: 1000;
        position: relative;
    }

        
</style>

    {{-- @dd($groupedByGauge) --}}
    @if(count($groupedByGauge) > 0)
    <div class="bg-black rounded mb-3">
        <h1 class="ww_title text-center py-0 mb-0 mt-3">{{ $groupedByGauge->first()->first()->size2 }} {{ $groupedByGauge->first()->first()->product_name }}</h1>
    </div>
    @endif
    <!-- Welded Wire Products grouped by Mesh Size and Gauge -->
    @foreach ($groupedByGauge as $displaySize => $products)
        @php
            $meshSize = $products->first()->display_size_2 ?? $products->first()->size2 ?? $displaySize;
        @endphp
        <!-- Mesh Size & Gauge Section -->
        <div class="mt-0">
            <div class="bg-secondary text-dark text-center py-2 rounded">
                <h4 class="m-0 mesh__title">{{ $meshSize }} - {{ $products->first()->material }}</h4>
            </div>
            <div class="row mt-1">
                <!-- Left Image -->
                <div class="col-md-2 text-center mb-4 mb-md-0">
                <div class="card shadow-sm">
                    <div class="card-header bg-danger text-white fw-bold py-1 rounded">
                                    <img src={{$products->first()->img_url}} alt="{{ $products->first()->product_name }}" class="img-fluid rounded product_img">
                        <div class="mt-1">
                            {{ $meshSize }}
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
                                    <th>weight</th>
                                    <th>Color</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <a class="item-number" href="{{ route('product.show', ['id' => $product->id]) }}">
                                                {{ $product->item_no }}
                                                </a>
                                            </div> 
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                {{ $product->size }}
                                            </div>
                                        </td>
                                        <td>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                        {{ $product->size2 }} {{ $product->size3 }}
                                        </div>
                                    </td>
                                        <td>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                        {{ $product->weight_lbs ?? 'N/A' }} lbs
                                        </div>
                                    </td>
                                        <td class="{{ strtolower($product->color) }}">
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            {{ $product->color }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <input type="number" class="form-control incre-qty" data-product-id="{{$product->id}}" name="quantity" min="1" value="1" style="width: 70px;">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-between mt-2">
                                                <span class="dynamic-price">${{ number_format($product->price, 2) }}</span>
                                                
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger text-white btn-add-cart add-to-cart-btn d-none" 
                                                data-id="{{ $product->id }}"
                                                data-item_no="{{ $product->item_no }}" 
                                                data-product_name="{{ $product->product_name }}"
                                                data-price="{{ $product->price }}"
                                                data-color="{{ $product->color ?? '' }}"
                                                data-size="{{ $product->size ?? '' }}"
                                                data-size_in="{{ $product->size_in ?? '' }}"
                                                data-size_wt="{{ $product->size_wt ?? '' }}"
                                                data-size_ht="{{ $product->size_ht ?? '' }}"
                                                data-weight_lbs="{{ $product->weight_lbs ?? '' }}"
                                                data-img_small="{{ $product->img_small ?? '' }}"
                                                data-img_large="{{ $product->img_large ?? '' }}"
                                                data-display_size_2="{{ $product->display_size_2 ?? '' }}"
                                                data-size2="{{ $product->size2 ?? '' }}"
                                                data-size3="{{ $product->size3 ?? '' }}"
                                                data-material="{{ $product->material ?? '' }}"
                                                data-spacing="{{ $product->spacing ?? '' }}"
                                                data-coating="{{ $product->coating ?? '' }}"
                                                data-style="{{ $product->style ?? '' }}"
                                                data-speciality="{{ $product->speciality ?? '' }}"
                                                data-free_shipping="{{ $product->free_shipping ?? '0' }}"
                                                data-special_shipping="{{ $product->special_shipping ?? '0' }}"
                                                data-amount_per_box="{{ $product->amount_per_box ?? '1' }}"
                                                data-class="{{ $product->class ?? '' }}"
                                                data-ship_length="{{ $product->ship_length ?? '' }}"
                                                data-ship_width="{{ $product->ship_width ?? '' }}"
                                                data-ship_height="{{ $product->ship_height ?? '' }}"
                                                data-categories_id="{{ $product->categories_id ?? '' }}"
                                                data-shipping_method="{{ $product->shipping_method ?? '' }}">
                                                Add to Cart
                                            </button>

                                        <button class="btn btn-primary m-2 add-to-cart" data-product-id="{{ $product->id }}">Add to Cart</button>

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
                                        <a href="{{ route('product.show', ['id' => $product->id]) }}" class="fw-bold">
                                            {{ $product->item_no }}
                                        </a>
                                        <span class="badge bg-primary">{{ $product->color }}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-6 fw-bold">Size:</div>
                                        <div class="col-6">{{ $product->size }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6 fw-bold">Mesh Size:</div>
                                        <div class="col-6">{{ $product->size2 }} {{ $product->size3 }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6 fw-bold">weight_lbs:</div>
                                        <div class="col-6">{{ $product->weight_lbs ?? 'N/A' }} lbs</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6 fw-bold">Price:</div>
                                        <div class="col-6 dynamic-price">${{ number_format($product->price, 2) }}</div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-outline-secondary btn-sm quantity-decrease">-</button>
                                            <input type="number" class="quantity-input text-center mx-2" value="1"
                                                min="1" style="width: 40px;" data-price="{{ $product->price }}" />
                                            <button class="btn btn-outline-secondary btn-sm quantity-increase">+</button>
                                        </div>
                                        <button class="btn btn-danger text-white btn-add-cart add-to-cart-btn" 
                                            data-id="{{ $product->id }}"
                                            data-item_no="{{ $product->item_no }}" 
                                            data-product_name="{{ $product->product_name }}"
                                            data-price="{{ $product->price }}"
                                            data-color="{{ $product->color ?? '' }}"
                                            data-size="{{ $product->size ?? '' }}"
                                            data-size_in="{{ $product->size_in ?? '' }}"
                                            data-size_wt="{{ $product->size_wt ?? '' }}"
                                            data-size_ht="{{ $product->size_ht ?? '' }}"
                                            data-weight_lbs="{{ $product->weight_lbs ?? '' }}"
                                            data-img_small="{{ $product->img_small ?? '' }}"
                                            data-img_large="{{ $product->img_large ?? '' }}"
                                            data-display_size_2="{{ $product->display_size_2 ?? '' }}"
                                            data-size2="{{ $product->size2 ?? '' }}"
                                            data-size3="{{ $product->size3 ?? '' }}"
                                            data-material="{{ $product->material ?? '' }}"
                                            data-spacing="{{ $product->spacing ?? '' }}"
                                            data-coating="{{ $product->coating ?? '' }}"
                                            data-style="{{ $product->style ?? '' }}"
                                            data-speciality="{{ $product->speciality ?? '' }}"
                                            data-free_shipping="{{ $product->free_shipping ?? '0' }}"
                                            data-special_shipping="{{ $product->special_shipping ?? '0' }}"
                                            data-amount_per_box="{{ $product->amount_per_box ?? '1' }}"
                                            data-class="{{ $product->class ?? '' }}"
                                            data-categories_id="{{ $product->categories_id ?? '' }}"
                                            data-shipping_method="{{ $product->shipping_method ?? '' }}">
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
        <div class="bg-secondary text-dark text-center py-2 rounded">
        <h4 class="m-0 mesh__title">Knock-In Posts U-Channel with fastening clips</h4>
    </div>
        <!-- Content -->
        <div class="row mt-1">
            <!-- Left Image -->
            <div class="col-md-2 text-center mb-4 mb-md-0">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white fw-bold py-1 rounded">
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
                                <th>weight_lbs</th>
                                <th>Color</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($knockinpostproducts as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <span class="item-number">{{ $product->item_no }}</span>
                                        </div>
                                    </td>
                                   
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <span>{{ $product->size }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <span>{{ $product->weight_lbs }}</span>
                                        </div>
                                    </td>
                                    <td class="black">
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <span>{{ $product->color }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <input type="number" class="form-control incre-qty" data-product-id="{{$product->id}}" name="quantity" min="1" value="1" style="width: 70px;">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span>{{ $product->price }}</span>
                                            
                                            <button class="btn btn-sm btn-danger text-white ms-2 btn-add-cart add-to-cart-btn  d-none" 
                                                data-id="{{ $product->id }}"
                                                data-item_no="{{ $product->item_no }}" 
                                                data-product_name="{{ $product->product_name }}"
                                                data-price="{{ $product->price }}"
                                                data-color="{{ $product->color ?? '' }}"
                                                data-size="{{ $product->size ?? '' }}"
                                                data-size_in="{{ $product->size_in ?? '' }}"
                                                data-size_wt="{{ $product->size_wt ?? '' }}"
                                                data-size_ht="{{ $product->size_ht ?? '' }}"
                                                data-weight_lbs="{{ $product->weight_lbs ?? '' }}"
                                                data-img_small="{{ $product->img_small ?? '' }}"
                                                data-img_large="{{ $product->img_large ?? '' }}"
                                                data-display_size_2="{{ $product->display_size_2 ?? '' }}"
                                                data-size2="{{ $product->size2 ?? '' }}"
                                                data-size3="{{ $product->size3 ?? '' }}"
                                                data-material="{{ $product->material ?? '' }}"
                                                data-spacing="{{ $product->spacing ?? '' }}"
                                                data-coating="{{ $product->coating ?? '' }}"
                                                data-style="{{ $product->style ?? '' }}"
                                                data-speciality="{{ $product->speciality ?? '' }}"
                                                data-free_shipping="{{ $product->free_shipping ?? '0' }}"
                                                data-special_shipping="{{ $product->special_shipping ?? '0' }}"
                                                data-amount_per_box="{{ $product->amount_per_box ?? '1' }}"
                                                data-class="{{ $product->class ?? '' }}"
                                                data-categories_id="{{ $product->categories_id ?? '' }}"
                                                data-shipping_method="{{ $product->shipping_method ?? '' }}">
                                                Add to Cart
                                            </button>
                                            
                                            <button class="btn btn-primary m-2 add-to-cart" data-product-id="{{ $product->id }}">Add to Cart</button>
                                            
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Mobile Cards (Visible only on Mobile) -->
                <div class="d-md-none">
                    @foreach ($knockinpostproducts as $product)
                        <div class="card mb-3 shadow-sm">
                            <div class="card-header bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">{{ $product->item_no }}</span>
                                    <span class="badge bg-primary">{{ $product->color }}</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-6 fw-bold">Size:</div>
                                    <div class="col-6">{{ $product->size }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6 fw-bold">weight_lbs:</div>
                                    <div class="col-6">{{ $product->weight_lbs }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6 fw-bold">Price:</div>
                                    <div class="col-6">{{ $product->price }}</div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-outline-secondary btn-sm">-</button>
                                        <span class="mx-2">1</span>
                                        <button class="btn btn-outline-secondary btn-sm">+</button>
                                    </div>
                                    <button class="btn btn-danger text-white btn-add-cart add-to-cart-btn d-none" 
                                            data-id="{{ $product->id }}"
                                            data-item_no="{{ $product->item_no }}" 
                                            data-product_name="{{ $product->product_name }}"
                                            data-price="{{ $product->price }}"
                                            data-color="{{ $product->color ?? '' }}"
                                            data-size="{{ $product->size ?? '' }}"
                                            data-size_in="{{ $product->size_in ?? '' }}"
                                            data-size_wt="{{ $product->size_wt ?? '' }}"
                                            data-size_ht="{{ $product->size_ht ?? '' }}"
                                            data-weight_lbs="{{ $product->weight_lbs ?? '' }}"
                                            data-img_small="{{ $product->img_small ?? '' }}"
                                            data-img_large="{{ $product->img_large ?? '' }}"
                                            data-display_size_2="{{ $product->display_size_2 ?? '' }}"
                                            data-size2="{{ $product->size2 ?? '' }}"
                                            data-size3="{{ $product->size3 ?? '' }}"
                                            data-material="{{ $product->material ?? '' }}"
                                            data-spacing="{{ $product->spacing ?? '' }}"
                                            data-coating="{{ $product->coating ?? '' }}"
                                            data-style="{{ $product->style ?? '' }}"
                                            data-speciality="{{ $product->speciality ?? '' }}"
                                            data-free_shipping="{{ $product->free_shipping ?? '0' }}"
                                            data-special_shipping="{{ $product->special_shipping ?? '0' }}"
                                            data-amount_per_box="{{ $product->amount_per_box ?? '1' }}"
                                            data-class="{{ $product->class ?? '' }}"
                                            data-categories_id="{{ $product->categories_id ?? '' }}"
                                            data-shipping_method="{{ $product->shipping_method ?? '' }}">
                                            Add to Cart
                                            </button>   

                                            <button class="btn btn-primary m-2 add-to-cart" data-product-id="{{ $product->id }}">Add to Cart</button>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Product Sections in 2-Column Layout -->
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Vinyl Black Fence Piping Section -->
            <div class="col-md-6 mb-4">
                <div class="mt-0">
                    <!-- Section Title -->
                    <div class="bg-secondary text-white text-center py-2 rounded">
                        <h4 class="m-0 mesh__title">Vinyl Black Fence Piping - 1 5/8in O.D.</h4>
                    </div>
                    
                    <!-- Product Image -->
                    <div class="text-center">
                        {{-- @if(count($vinylPipingProducts) > 0)
                        <img src="{{ $vinylPipingProducts->first()->img_url }}" alt="Vinyl Black Fence Piping" class="img-fluid rounded product_img" style="max-height: 150px; max-width: 150px;">
                        @else --}}
                        <img src="https://images.thdstatic.com/productImages/a1002a60-e0c7-403b-8a32-5844e8b81df4/svn/black-hydromaxx-hydroponic-irrigation-tubing-1402014100-64_1000.jpg" alt="Vinyl Black Fence Piping" class="img-fluid rounded product_img" style="max-height: 150px; max-width: 150px;">
                        {{-- @endif --}}
                    </div>
                    
                    <!-- Content -->
                    <div class="row mt-1">
                        <!-- Table -->
                        <div class="col-12">
                            <p class="text-danger mb-1" style="font-size: 12px;"><strong>note:</strong> call ahead for local pickup!</p>
                            
                            <!-- Desktop Table (Hidden on Mobile) -->
                            <div class="d-none d-md-block">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Item Number</th>
                                            <th>Size</th>
                                            <th>Weight</th>
                                            <th>Price</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($vinylPipingProducts as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <span class="item-number">{{ $product->item_no }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <span>{{ $product->size }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <span>{{ $product->weight_lbs ?? 'N/A' }} lbs</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <span>${{ number_format($product->price, 2) }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-danger text-white ms-2 add-to-cart-btn d-none"
                                                    data-id="{{ $product->id }}"
                                                    data-item_no="{{ $product->item_no }}" 
                                                    data-product_name="{{ $product->product_name }}"
                                                    data-price="{{ $product->price }}"
                                                    data-color="{{ $product->color ?? '' }}"
                                                    data-size="{{ $product->size ?? '' }}"
                                                    data-size_in="{{ $product->size_in ?? '' }}"
                                                    data-size_wt="{{ $product->size_wt ?? '' }}"
                                                    data-size_ht="{{ $product->size_ht ?? '' }}"
                                                    data-weight_lbs="{{ $product->weight_lbs ?? '' }}"
                                                    data-img_small="{{ $product->img_small ?? '' }}"
                                                    data-img_large="{{ $product->img_large ?? '' }}"
                                                    data-display_size_2="{{ $product->display_size_2 ?? '' }}"
                                                    data-size2="{{ $product->size2 ?? '' }}"
                                                    data-size3="{{ $product->size3 ?? '' }}"
                                                    data-material="{{ $product->material ?? '' }}"
                                                    data-spacing="{{ $product->spacing ?? '' }}"
                                                    data-coating="{{ $product->coating ?? '' }}"
                                                    data-style="{{ $product->style ?? '' }}"
                                                    data-speciality="{{ $product->speciality ?? '' }}"
                                                    data-free_shipping="{{ $product->free_shipping ?? '0' }}"
                                                    data-special_shipping="{{ $product->special_shipping ?? '0' }}"
                                                    data-amount_per_box="{{ $product->amount_per_box ?? '1' }}"
                                                    data-class="{{ $product->class ?? '' }}"
                                                    data-categories_id="{{ $product->categories_id ?? '' }}"
                                                    data-shipping_method="{{ $product->shipping_method ?? '' }}">
                                                    Add to Cart
                                                </button>
                                                
                                                <button class="btn btn-primary m-2 add-to-cart" data-product-id="{{ $product->id }}">Add to Cart</button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No vinyl piping products found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Mobile Cards (Visible only on Mobile) -->
                            <div class="d-md-none">
                                @forelse($vinylPipingProducts as $product)
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-header bg-light">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold">{{ $product->item_no }}</span>
                                            <span class="badge bg-primary">{{ $product->color }}</span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-6 fw-bold">Size:</div>
                                            <div class="col-6">{{ $product->size }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6 fw-bold">Weight:</div>
                                            <div class="col-6">{{ $product->weight_lbs ?? 'N/A' }} lbs</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6 fw-bold">Price:</div>
                                            <div class="col-6">${{ number_format($product->price, 2) }}</div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <button class="btn btn-outline-secondary btn-sm quantity-decrease">-</button>
                                                <input type="number" class="quantity-input text-center mx-2" value="1"
                                                    min="1" style="width: 40px;" data-price="{{ $product->price }}" />
                                                <button class="btn btn-outline-secondary btn-sm quantity-increase">+</button>
                                            </div>
                                            <button class="btn btn-danger text-white add-to-cart-btn"   
                                                data-id="{{ $product->id }}"
                                                data-item_no="{{ $product->item_no }}" 
                                                data-product_name="{{ $product->product_name }}"
                                                data-price="{{ $product->price }}"
                                                data-color="{{ $product->color ?? '' }}"
                                                data-size="{{ $product->size ?? '' }}"
                                                data-size_in="{{ $product->size_in ?? '' }}"
                                                data-size_wt="{{ $product->size_wt ?? '' }}"
                                                data-size_ht="{{ $product->size_ht ?? '' }}"
                                                data-weight_lbs="{{ $product->weight_lbs ?? '' }}"
                                                data-img_small="{{ $product->img_small ?? '' }}"
                                                data-img_large="{{ $product->img_large ?? '' }}"
                                                data-display_size_2="{{ $product->display_size_2 ?? '' }}"
                                                data-size2="{{ $product->size2 ?? '' }}"
                                                data-size3="{{ $product->size3 ?? '' }}"
                                                data-material="{{ $product->material ?? '' }}"
                                                data-spacing="{{ $product->spacing ?? '' }}"
                                                data-coating="{{ $product->coating ?? '' }}"
                                                data-style="{{ $product->style ?? '' }}"
                                                data-speciality="{{ $product->speciality ?? '' }}"
                                                data-free_shipping="{{ $product->free_shipping ?? '0' }}"
                                                data-special_shipping="{{ $product->special_shipping ?? '0' }}"
                                                data-amount_per_box="{{ $product->amount_per_box ?? '1' }}"
                                                data-class="{{ $product->class ?? '' }}"
                                                data-categories_id="{{ $product->categories_id ?? '' }}"
                                                data-shipping_method="{{ $product->shipping_method ?? '' }}">
                                                Add to Cart
                                            </button>

                                            <button class="btn btn-primary m-2 add-to-cart" data-product-id="{{ $product->id }}">Add to Cart</button>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="alert alert-info">No vinyl piping products found</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Round Cedar Non Tapered Wood Fence Post Section -->
            <div class="col-md-6 mb-4">
                <div class="mt-0">
                    <!-- Section Title -->
                    <div class="bg-secondary text-white text-center py-2 rounded">
                        <h4 class="m-0 mesh__title">Round Cedar Non Tapered Wood Fence Post</h4>
                    </div>
                    
                    <!-- Product Image -->
                    <div class="text-center mb-3">
                        <img src="https://www.academyfence.com/images/roundrailbundle.jpg" alt="Round Cedar Wood Fence Post" class="img-fluid rounded product_img" style="max-height: 150px; max-width: 150px;">
                    </div>
                    
                    <!-- Content -->
                    <div class="row mt-1">
                        <!-- Table -->
                        <div class="col-12">
                            <p class="text-danger mb-1" style="font-size: 12px;"><strong>note:</strong> call ahead for local pickup!</p>
                            
                            <!-- Desktop Table (Hidden on Mobile) -->
                            <div class="d-none d-md-block">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Item Number</th>
                                            <th>Size</th>
                                            <th>Weight</th>
                                            <th>Price</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($cedarPostProducts as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <span class="item-number">{{ $product->item_no }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <span>{{ $product->size }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <span>{{ $product->weight_lbs ?? 'N/A' }} lbs</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <span>${{ number_format($product->price, 2) }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-danger text-white ms-2 add-to-cart-btn d-none"   
                                                    data-id="{{ $product->id }}"
                                                    data-item_no="{{ $product->item_no }}" 
                                                    data-product_name="{{ $product->product_name }}"
                                                    data-price="{{ $product->price }}"
                                                    data-color="{{ $product->color ?? '' }}"
                                                    data-size="{{ $product->size ?? '' }}"
                                                    data-size_in="{{ $product->size_in ?? '' }}"
                                                    data-size_wt="{{ $product->size_wt ?? '' }}"
                                                    data-size_ht="{{ $product->size_ht ?? '' }}"
                                                    data-weight_lbs="{{ $product->weight_lbs ?? '' }}"
                                                    data-img_small="{{ $product->img_small ?? '' }}"
                                                    data-img_large="{{ $product->img_large ?? '' }}"
                                                    data-display_size_2="{{ $product->display_size_2 ?? '' }}"
                                                    data-size2="{{ $product->size2 ?? '' }}"
                                                    data-size3="{{ $product->size3 ?? '' }}"
                                                    data-material="{{ $product->material ?? '' }}"
                                                    data-spacing="{{ $product->spacing ?? '' }}"
                                                    data-coating="{{ $product->coating ?? '' }}"
                                                    data-style="{{ $product->style ?? '' }}"
                                                    data-speciality="{{ $product->speciality ?? '' }}"
                                                    data-free_shipping="{{ $product->free_shipping ?? '0' }}"
                                                    data-special_shipping="{{ $product->special_shipping ?? '0' }}"
                                                    data-amount_per_box="{{ $product->amount_per_box ?? '1' }}"
                                                    data-class="{{ $product->class ?? '' }}"
                                                    data-categories_id="{{ $product->categories_id ?? '' }}"
                                                    data-shipping_method="{{ $product->shipping_method ?? '' }}">
                                                    Add to Cart
                                                </button>
                                                <button class="btn btn-primary m-2 add-to-cart" data-product-id="{{ $product->id }}">Add to Cart</button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No cedar post products found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Mobile Cards (Visible only on Mobile) -->
                            <div class="d-md-none">
                                @forelse($cedarPostProducts as $product)
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-header bg-light">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold">{{ $product->item_no }}</span>
                                            <span class="badge bg-primary">{{ $product->color ?: 'Cedar' }}</span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-6 fw-bold">Size:</div>
                                            <div class="col-6">{{ $product->size }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6 fw-bold">Weight:</div>
                                            <div class="col-6">{{ $product->weight_lbs ?? 'N/A' }} lbs</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6 fw-bold">Price:</div>
                                            <div class="col-6">${{ number_format($product->price, 2) }}</div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <button class="btn btn-outline-secondary btn-sm quantity-decrease">-</button>
                                                <input type="number" class="quantity-input text-center mx-2" value="1"
                                                    min="1" style="width: 40px;" data-price="{{ $product->price }}" />
                                                <button class="btn btn-outline-secondary btn-sm quantity-increase">+</button>
                                            </div>
                                            <button class="btn btn-danger text-white add-to-cart-btn"   
                                                data-id="{{ $product->id }}"
                                                data-item_no="{{ $product->item_no }}" 
                                                data-product_name="{{ $product->product_name }}"
                                                data-price="{{ $product->price }}"
                                                data-color="{{ $product->color ?? '' }}"
                                                data-size="{{ $product->size ?? '' }}"
                                                data-size_in="{{ $product->size_in ?? '' }}"
                                                data-size_wt="{{ $product->size_wt ?? '' }}"
                                                data-size_ht="{{ $product->size_ht ?? '' }}"
                                                data-weight_lbs="{{ $product->weight_lbs ?? '' }}"
                                                data-img_small="{{ $product->img_small ?? '' }}"
                                                data-img_large="{{ $product->img_large ?? '' }}"
                                                data-display_size_2="{{ $product->display_size_2 ?? '' }}"
                                                data-size2="{{ $product->size2 ?? '' }}"
                                                data-size3="{{ $product->size3 ?? '' }}"
                                                data-material="{{ $product->material ?? '' }}"
                                                data-spacing="{{ $product->spacing ?? '' }}"
                                                data-coating="{{ $product->coating ?? '' }}"
                                                data-style="{{ $product->style ?? '' }}"
                                                data-speciality="{{ $product->speciality ?? '' }}"
                                                data-free_shipping="{{ $product->free_shipping ?? '0' }}"
                                                data-special_shipping="{{ $product->special_shipping ?? '0' }}"
                                                data-amount_per_box="{{ $product->amount_per_box ?? '1' }}"
                                                data-class="{{ $product->class ?? '' }}"
                                                data-categories_id="{{ $product->categories_id ?? '' }}"
                                                data-shipping_method="{{ $product->shipping_method ?? '' }}">
                                                Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="alert alert-info">No cedar post products found</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Bazooka Knock-In Post Driver Section -->
            <div class="col-md-6 mb-4">
                <div class="mt-0">
                    <!-- Section Title -->
                    <div class="bg-secondary text-white text-center py-2 rounded">
                        <h4 class="m-0 mesh__title">Bazooka Knock-In Post Driver</h4>
                    </div>
                    
                    <!-- Product Image -->
                    <div class="text-center mb-3">
                        <img src="https://www.academyfence.com/images/xy/670post_driver_new.jpg" alt="Bazooka Knock-In Post Driver" class="img-fluid rounded product_img" style="max-height: 150px; max-width: 150px;">
                    </div>
                    
                    <!-- Content -->
                    <div class="row mt-1">
                        <!-- Table -->
                        <div class="col-12">
                            <p class="text-danger mb-1" style="font-size: 12px;"><strong>note:</strong> call ahead for local pickup!</p>
                            
                            <!-- Desktop Table (Hidden on Mobile) -->
                            <div class="d-none d-md-block">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        @foreach ($postDriverProducts as $product)
                                        <tr>
                                            <th>Item Number</th>
                                            <th>Size</th>
                                            <th>Weight</th>
                                            <th>Price</th>
                                            <th>Color</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <span class="item-number">{{ $product->item_no }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <span>{{ $product->size }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <span>{{ $product->weight_lbs }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <span>{{ $product->price }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <span>{{ $product->color }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-danger text-white ms-2 add-to-cart-btn"   
                                                    data-id="{{ $product->id }}"
                                                    data-item_no="{{ $product->item_no }}" 
                                                    data-product_name="{{ $product->product_name }}"
                                                    data-price="{{ $product->price }}"
                                                    data-color="{{ $product->color ?? '' }}"
                                                    data-size="{{ $product->size ?? '' }}"
                                                    data-size_in="{{ $product->size_in ?? '' }}"
                                                    data-size_wt="{{ $product->size_wt ?? '' }}"
                                                    data-size_ht="{{ $product->size_ht ?? '' }}"
                                                    data-weight_lbs="{{ $product->weight_lbs ?? '' }}"
                                                    data-img_small="{{ $product->img_small ?? '' }}"
                                                    data-img_large="{{ $product->img_large ?? '' }}"
                                                    data-display_size_2="{{ $product->display_size_2 ?? '' }}"
                                                    data-size2="{{ $product->size2 ?? '' }}"
                                                    data-size3="{{ $product->size3 ?? '' }}"
                                                    data-material="{{ $product->material ?? '' }}"
                                                    data-spacing="{{ $product->spacing ?? '' }}"
                                                    data-coating="{{ $product->coating ?? '' }}"
                                                    data-style="{{ $product->style ?? '' }}"
                                                    data-speciality="{{ $product->speciality ?? '' }}"
                                                    data-free_shipping="{{ $product->free_shipping ?? '0' }}"
                                                    data-special_shipping="{{ $product->special_shipping ?? '0' }}"
                                                    data-amount_per_box="{{ $product->amount_per_box ?? '1' }}"
                                                    data-class="{{ $product->class ?? '' }}"
                                                    data-categories_id="{{ $product->categories_id ?? '' }}"
                                                    data-shipping_method="{{ $product->shipping_method ?? '' }}">
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
                </div>
            </div>

            <!-- Round Pressure Treated Fence Post Section -->
            <div class="col-md-6 mb-4">
                <div class="mt-0">
                    <!-- Section Title -->
                    <div class="bg-secondary text-white text-center py-2 rounded">
                        <h4 class="m-0 mesh__title">Round Pressure Treated Fence Post</h4>
                    </div>
                    
                    <!-- Product Image -->
                    <div class="text-center mb-3">
                        <img src="https://www.academyfence.com/images/5in-round-pt-post.jpg" alt="Round Pressure Treated Fence Post" class="img-fluid rounded product_img" style="max-height: 150px; max-width: 150px;">
                    </div>
                    
                    <!-- Content -->
                    <div class="row mt-1">
                        <!-- Table -->
                        <div class="col-12">
                            <p class="text-danger mb-1" style="font-size: 12px;"><strong>note:</strong> call ahead for local pickup!</p>
                            
                            <!-- Desktop Table (Hidden on Mobile) -->
                            <div class="d-none d-md-block">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Item Number</th>
                                            <th>Size</th>
                                            <th>Weight</th>
                                            <th>Price</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($treatedPostProducts as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <span class="item-number">{{ $product->item_no }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <span>{{ $product->size }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <span>{{ $product->weight_lbs }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <span>{{ $product->price }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-danger text-white ms-2 add-to-cart-btn"   
                                                    data-id="{{ $product->id }}"
                                                    data-item_no="{{ $product->item_no }}" 
                                                    data-product_name="{{ $product->product_name }}"
                                                    data-price="{{ $product->price }}"
                                                    data-color="{{ $product->color ?? '' }}"
                                                    data-size="{{ $product->size ?? '' }}"
                                                    data-size_in="{{ $product->size_in ?? '' }}"
                                                    data-size_wt="{{ $product->size_wt ?? '' }}"
                                                    data-size_ht="{{ $product->size_ht ?? '' }}"
                                                    data-weight_lbs="{{ $product->weight_lbs ?? '' }}"
                                                    data-img_small="{{ $product->img_small ?? '' }}"
                                                    data-img_large="{{ $product->img_large ?? '' }}"
                                                    data-display_size_2="{{ $product->display_size_2 ?? '' }}"
                                                    data-size2="{{ $product->size2 ?? '' }}"
                                                    data-size3="{{ $product->size3 ?? '' }}"
                                                    data-material="{{ $product->material ?? '' }}"
                                                    data-spacing="{{ $product->spacing ?? '' }}"
                                                    data-coating="{{ $product->coating ?? '' }}"
                                                    data-style="{{ $product->style ?? '' }}"
                                                    data-speciality="{{ $product->speciality ?? '' }}"
                                                    data-free_shipping="{{ $product->free_shipping ?? '0' }}"
                                                    data-special_shipping="{{ $product->special_shipping ?? '0' }}"
                                                    data-amount_per_box="{{ $product->amount_per_box ?? '1' }}"
                                                    data-class="{{ $product->class ?? '' }}"
                                                    data-categories_id="{{ $product->categories_id ?? '' }}"
                                                    data-shipping_method="{{ $product->shipping_method ?? '' }}">
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
                </div>
            </div>
        </div>
    </div>

    <!-- Header Section -->

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
</main>
@endsection


@section('scripts')
    <script src="{{ asset('js/mini-cart.js') }}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
@endsection

<!-- Toast Container -->
{{-- <div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="cartToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success">
            <strong class="me-auto">Cart Notification</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Item added to the cart successfully!
        </div>
    </div>
</div> --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.product_img').forEach(img => {
            img.addEventListener('click', function () {
                this.classList.toggle('zoomed');
            });
        });
    });
</script>
