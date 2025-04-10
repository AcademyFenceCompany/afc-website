@extends('layouts.main')

@section('title', 'OnGuard Aluminum Fence')

@section('styles')
<style>
    .main-header {
        background-color: #001755;
        color: white;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
    }
    
    .onguard-description {
        margin: 20px 0;
        line-height: 1.6;
    }
    
    .type-selector {
        display: flex;
        justify-content: center;
        gap: 15px;
    }
    
    .type-button {
        padding: 10px 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        transition: all 0.3s ease;
    }
    
    .type-button:hover {
        background-color: #e9ecef;
    }
    
    .type-button.active {
        background-color: #001755;
        color: white;
        border-color: #001755;
    }
    

    
    .model-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .model-card {
        width: calc(25% - 20px);
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .model-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .model-image {
        width: 100%;
        height: 150px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .model-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
    }
    
    
    .model-name {
        font-weight: bold;
        margin-bottom: 5px;
        color: #000;
        text-transform: uppercase;
    }
    
    .model-count {
        font-size: 12px;
        color: #6c757d;
    }
    
    .section-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #001755;
        border-bottom: 2px solid #001755;
        padding-bottom: 10px;
    }
    
    .product-section {
        margin-top: 40px;
    }
    
    .product-header {
        background-color: #001755;
        color: white;
        padding: 10px;
        text-align: center;
        margin-bottom: 20px;
        border-radius: 5px;
    }
    
    .table th {
        background-color: #f8f9fa;
    }
    
    .quantity-input {
        text-align: center;
    }
    
    @media (max-width: 992px) {
        .model-card {
            width: calc(33.333% - 20px);
        }
    }
    
    @media (max-width: 768px) {
        .model-card {
            width: calc(50% - 20px);
        }
        
        .type-selector {
            flex-direction: column;
            align-items: center;
        }
        
        .type-button {
            width: 100%;
            max-width: 300px;
        }
    }
    
    @media (max-width: 576px) {
        .model-card {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <!-- OnGuard Header -->
    <div class="row">
        <div class="col-12">
            <div class="main-header">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <img src="{{ url('storage/products/Onguard-FenceTown-400x400.jpg') }}" alt="OnGuard Logo" class="img-fluid" style="max-width: 250px;">
                    </div>
                    <div class="col-md-8">
                        <h2 class="mb-0">OnGuard Fence Systems</h2>
                        <div class="mt-2">
                            <p>OnGuard extrudes and manufactures high-quality aluminum fence components for residential and commercial applications where long-lasting durability and beauty are required. OnGuard products are easy to install, come in classic colors and are offered in a wide array of beautiful designs and classic finish options.</p>
                            <a href="/aluminum-fence/onguard/pickup" class="btn btn-danger mt-2">See what's available for pickup</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- <!-- OnGuard Description -->
    <div class="row">
        <div class="col-12">
            <div class="onguard-description">
                <p>The OnGuard Difference - Unlike some other brands, all OnGuard Fence Systems rails and posts are powder coated after punching and notching, re-sealing all exposed surfaces with a protective powder coat finish for long-lasting quality.</p>
                
                <p>OnGuard offers single and double gates to match all fence styles and colors. Constructed of heavy-walled frames and welded with the newest aluminum welding technology, our gates are one of the strongest in the industry, resistant to sagging.</p>
                
                <p>All gates are available in u-frame construction with or without diagonal braces. To personalize your design, OnGuard offers arched and scalloped gates along with a full line of accessories, including a variety of self-closing latches and adjustable hinges.</p>
            </div>
        </div>
    </div> --}}
    
    <!-- Type Selector Buttons -->
    <div class="row">
        <div class="col-12">
            <div class="type-selector">
                @foreach($fenceTypes as $typeName => $typeData)
                    <div class="type-button btn btn-danger {{ $loop->first ? 'active' : '' }}" data-type="{{ $typeName }}">
                        <span style="font-size: 1.2rem; text-transform: uppercase;">{{ $typeName }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Models Container -->
    <div class="models-container">
        @foreach($fenceTypes as $typeName => $typeData)
            <div class="type-models" id="{{ strtolower($typeName) }}-models" style="{{ $loop->first ? '' : 'display: none;' }}">
                <div class="section-title">{{ $typeName }}</div>
                
                <div class="row mb-4">
                    <div class="col-md-8">
                        <p>{{ $typeData['description'] }}</p>
                        <div class="specs-box bg-light rounded mt-3">
                            <h5>Specifications:</h5>
                            <div>{!! nl2br($typeData['specs']) !!}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ url('storage/products/' . strtolower($typeName) . '.jpg') }}" 
                             alt="{{ $typeName }} Fence" 
                             class="img-fluid"
                             onerror="this.src='{{ url('storage/products/default.png') }}'">
                    </div>
                </div>
                
                <div class="model-grid">
                    @foreach($typeData['models'] as $modelName => $model)
                        <div class="model-card" data-type="{{ $typeName }}" data-model="{{ $modelName }}">
                            <div class="model-image">
                                <img src="{{ $representativeImages[$typeName][$modelName] ?? url('storage/products/default.png') }}" 
                                     alt="{{ $modelName }} {{ $typeName }}" 
                                     onerror="this.src='{{ url('storage/products/default.png') }}'">
                            </div>
                            <div class="model-info">
                                <div class="model-name text-center ">{{ $modelName }}</div>
                                {{-- <div class="model-count">{{ $model['total'] }} items available</div>
                                <button class="btn btn-sm btn-danger mt-2 view-products-btn">View Products</button> --}}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Product Section - Initially hidden -->
    <div id="product-section" class="product-section" style="{{ count($products) > 0 ? '' : 'display: none;' }}">
        <div class="product-header">
            <h5 class="mb-0" id="product-title">
                @if($selectedFenceType && $selectedModel)
                    {{ $selectedModel }} {{ $selectedFenceType }} Aluminum Fence
                @else
                    Aluminum Fence Products
                @endif
            </h5>
        </div>
        
        @if(count($products) > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Item Number</th>
                        <th>Name</th>
                        <th>Size</th>
                        <th>Color</th>
                        <th>Quantity</th>
                        <th>Price / Add to Cart</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->item_no }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->size }}</td>
                            <td>{{ $product->color }}</td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-outline-secondary quantity-minus" type="button">-</button>
                                    <input type="text" class="form-control quantity-input" value="1" min="1" style="max-width: 50px;">
                                    <button class="btn btn-outline-secondary quantity-plus" type="button">+</button>
                                </div>
                            </td>
                            <td class="text-center">
                                <div>${{ number_format($product->price, 2) }}</div>
                                <button class="btn btn-danger btn-sm add-to-cart-btn" 
                                        data-item="{{ $product->item_no }}" 
                                        data-name="{{ $product->product_name }}" 
                                        data-price="{{ $product->price }}"
                                        style="padding: 1px 5px;font-size: 12px;">
                                    Add to Cart
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info">
                Please select a fence model to view available products.
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Handle type button clicks
        $('.type-button').click(function() {
            var selectedType = $(this).data('type');
            
            // Update active button
            $('.type-button').removeClass('active');
            $(this).addClass('active');
            
            // Show selected type models
            $('.type-models').hide();
            $('#' + selectedType.toLowerCase() + '-models').show();
            
            // Hide product section when changing types
            $('#product-section').hide();
        });
        
        // Handle model card clicks
        $('.model-card').click(function() {
            var type = $(this).data('type');
            var model = $(this).data('model');
            
            // Redirect to the product page for the selected type and model
            window.location.href = '/aluminum-fence/onguard/' + type + '-' + model;
        });
        
        // Handle view products button clicks
        $('.view-products-btn').click(function(e) {
            e.stopPropagation(); // Prevent triggering the parent card click
            
            var card = $(this).closest('.model-card');
            var type = card.data('type');
            var model = card.data('model');
            
            // Redirect to the product page for the selected type and model
            window.location.href = '/aluminum-fence/onguard/' + type + '-' + model;
        });
        
        // Handle quantity plus button clicks
        $(document).on('click', '.quantity-plus', function() {
            var input = $(this).closest('.input-group').find('.quantity-input');
            var value = parseInt(input.val());
            input.val(value + 1);
        });
        
        // Handle quantity minus button clicks
        $(document).on('click', '.quantity-minus', function() {
            var input = $(this).closest('.input-group').find('.quantity-input');
            var value = parseInt(input.val());
            if (value > 1) {
                input.val(value - 1);
            }
        });
        
        // Handle add to cart button clicks
        $('.add-to-cart-btn').click(function() {
            var button = $(this);
            var itemNo = button.data('item');
            var name = button.data('name');
            var price = button.data('price');
            var quantity = button.closest('tr').find('.quantity-input').val();
            
            // Add to cart AJAX call
            $.ajax({
                url: '{{ route("cart.add") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    item_no: itemNo,
                    product_name: name,
                    price: price,
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        alert('Item added to cart!');
                        
                        // Update cart count in the header if it exists
                        if ($('.cart-count').length > 0) {
                            $('.cart-count').text(response.cartCount);
                        }
                    } else {
                        alert('Error adding item to cart');
                    }
                },
                error: function(xhr) {
                    alert('Error adding item to cart');
                    console.error(xhr.responseText);
                }
            });
        });
        
        // Set default type to Residential
        @if($selectedFenceType)
            // If there's a selected type from the URL, activate that button
            $('.type-button[data-type="{{ $selectedFenceType }}"]').click();
        @else
            // Default to first type (should be Residential)
            $('.type-button:first').click();
        @endif
    });
</script>
@endsection
