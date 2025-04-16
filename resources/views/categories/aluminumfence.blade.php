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
    
    /* OnGuard Info Box Styles */
    .onguard-info-box {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 20px;
        margin: 20px 0;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .info-item:last-child {
        margin-bottom: 0;
    }
    
    .info-icon {
        width: 40px;
        height: 40px;
        background-color: #f0f8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        color: #4a7c59;
        font-size: 20px;
    }
    
    .info-content {
        flex: 1;
    }
    
    .info-title {
        font-weight: bold;
        margin-bottom: 2px;
        color: #333;
    }
    
    .info-description {
        font-size: 14px;
        color: #555;
    }
    
    .model-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .model-card {
        /* width: calc(25% - 20px); */
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
        height: 150px;
        width: 100%;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    
    .model-image img {
        max-width: 100%;
        max-height: 100%;
    }
    
    .primary-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        transition: opacity 0.3s ease;
    }
    
    .hover-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .model-card:hover .primary-image {
        opacity: 0;
    }
    
    .model-card:hover .hover-image {
        opacity: 1;
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
    
    .accessories-button {
        background-color: #001755;
        border-color: #001755;
        font-size: 1.25rem;
        padding: 15px 30px;
        transition: all 0.3s ease;
    }
    
    .accessories-button:hover {
        background-color: #002b80;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="rounded bg-brown mb-2">
        <h1 class="page-title text-center mb-0">OnGuard Aluminum Fence</h1>
    </div>
    <!-- Info Section -->
    <div class="row g-4 mb-6">
        <!-- Left Section - About -->
        <div class="col-md-8 wf-about mb-2">
            <div class="d-flex">
                <img src="{{ url('storage/products/onguard-fencetown-400x400.jpg') }}" alt="OnGuard Fence" style="width: 180px; height: 180px; object-fit: cover;" class="me-4 rounded about-image-onguard">
                <div>
                    <h4 class="mb-3">In Stock - Quick Shipping - Home Installation - Pick Up</h4>
                    <p class="page-description mb-2">
                        OnGuard extrudes and manufactures high-quality aluminum fence components for residential and commercial applications where
                        long-lasting durability and beauty are required. OnGuard products are 
                        easy to install, come in classic colors and are offered in a wide array of
                        beautiful designs and classic finish options.
                    </p>
                    <a href="{{ route('aluminumfence.pickup') }}" class="btn btn-danger">See what's available for pickup</a>

                </div>

            </div>
        </div>

        <!-- Right Section - Manufacturer Info -->
        <div class="col-md-4">
            <div class="p-3 rounded bg-light-yellow">
                <ul class="small-font mb-0">
                    <li><strong><i class="bi bi-currency-dollar text-brown me-2"></i>Delivered in 2–6 Weeks</strong></li>
                    <li><strong><i class="bi bi-truck text-brown me-2"></i>Unbeatable Low Price</strong></li>
                    <li><strong><i class="bi bi-plus-circle text-brown me-2"></i>Backed by a Lifetime Warranty</strong></li>
                    <li><strong><i class="bi bi-star text-brown me-2"></i>Add-On Puppy Picket Option for Extra Safety</strong></li>
                    <li><strong><i class="bi bi-check-circle text-brown me-2"></i>Sleek Beveled Rail for a Refined Look</strong></li>
                </ul>

            </div>
        </div>
    </div>
   
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
                
                <!-- The Most Popular Section -->
                <h4 class="section-title mt-4 mb-3">The Most Popular</h4>
                <div class="row mb-4">
                    @foreach(['Starling', 'Siskin', 'Longspur', 'Heron'] as $modelName)
                        @if(isset($typeData['models'][$modelName]))
                            <div class="col-md-3 mb-3">
                                <div class="model-card" data-type="{{ $typeName }}" data-model="{{ $modelName }}">
                                    <a href="{{ route('aluminumfence.product', ['type' => $typeName, 'model' => $modelName]) }}" class="text-decoration-none">
                                        <div class="model-image">
                                            <img src="{{ $typeData['models'][$modelName]['image'] ?? $representativeImages[$typeName][$modelName]['main'] ?? url('storage/products/default.png') }}" 
                                                 alt="{{ $modelName }} {{ $typeName }}" 
                                                 class="primary-image"
                                                 onerror="this.src='{{ url('storage/products/default.png') }}'">
                                            <img src="{{ $representativeImages[$typeName][$modelName]['hover'] ?? url('storage/products/default.png') }}" 
                                                 alt="{{ $modelName }} {{ $typeName }} Hover" 
                                                 class="hover-image">
                                        </div>
                                        <div class="model-info">
                                            <div class="model-name text-center">{{ $modelName }}</div>
                                            <div class="text-center mb-2">
                                                <button class="btn btn-sm btn-danger">View Products</button>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                
                <!-- Other Models Section -->
                <div class="row mb-4">
                    @foreach(['Ibis', 'Kestral', 'Willet', 'Bunting', 'Kinglet'] as $modelName)
                        @if(isset($typeData['models'][$modelName]))
                            <div class="col-md-2.4" style="flex: 0 0 20%; max-width: 20%;">
                                <div class="model-card" data-type="{{ $typeName }}" data-model="{{ $modelName }}">
                                    <a href="{{ route('aluminumfence.product', ['type' => $typeName, 'model' => $modelName]) }}" class="text-decoration-none">
                                        <div class="model-image">
                                            <img src="{{ $typeData['models'][$modelName]['image'] ?? $representativeImages[$typeName][$modelName]['main'] ?? url('storage/products/default.png') }}" 
                                                 alt="{{ $modelName }} {{ $typeName }}" 
                                                 class="primary-image"
                                                 onerror="this.src='{{ url('storage/products/default.png') }}'">
                                            <img src="{{ $representativeImages[$typeName][$modelName]['hover'] ?? url('storage/products/default.png') }}" 
                                                 alt="{{ $modelName }} {{ $typeName }} Hover" 
                                                 class="hover-image">
                                        </div>
                                        <div class="model-info">
                                            <div class="model-name text-center">{{ $modelName }}</div>
                                            <div class="text-center mb-2">
                                                <button class="btn btn-sm btn-danger">View Products</button>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                
                <!-- Puppy Pickets Section -->
                <h4 class="section-title mt-4 mb-3">Puppy Pickets</h4>
                <div class="row mb-4">
                    @foreach(['Puppy 1', 'Puppy 2', 'Puppy 3'] as $modelName)
                        @if(isset($typeData['models'][$modelName]))
                            <div class="col-md-4 mb-3">
                                <div class="model-card" data-type="{{ $typeName }}" data-model="{{ $modelName }}">
                                    <a href="{{ route('aluminumfence.product', ['type' => $typeName, 'model' => $modelName]) }}" class="text-decoration-none">
                                        <div class="model-image">
                                            <img src="{{ $typeData['models'][$modelName]['image'] ?? $representativeImages[$typeName][$modelName]['main'] ?? url('storage/products/default.png') }}" 
                                                 alt="{{ $modelName }} {{ $typeName }}" 
                                                 class="primary-image"
                                                 onerror="this.src='{{ url('storage/products/default.png') }}'">
                                            <img src="{{ $representativeImages[$typeName][$modelName]['hover'] ?? url('storage/products/default.png') }}" 
                                                 alt="{{ $modelName }} {{ $typeName }} Hover" 
                                                 class="hover-image">
                                        </div>
                                        <div class="model-info">
                                            <div class="model-name text-center">{{ $modelName }}</div>
                                            <div class="text-center mb-2">
                                                <button class="btn btn-sm btn-danger">View Products</button>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                
                <!-- All Other Models (if any) -->
                <div class="row mb-4">
                    @foreach($typeData['models'] as $modelName => $model)
                        @if(!in_array($modelName, ['Starling', 'Siskin', 'Longspur', 'Heron', 'Ibis', 'Kestral', 'Willet', 'Bunting', 'Kinglet', 'Puppy 1', 'Puppy 2', 'Puppy 3']))
                            <div class="col-md-3 mb-3">
                                <div class="model-card" data-type="{{ $typeName }}" data-model="{{ $modelName }}">
                                    <a href="{{ route('aluminumfence.product', ['type' => $typeName, 'model' => $modelName]) }}" class="text-decoration-none">
                                        <div class="model-image">
                                            <img src="{{ $model['image'] ?? $representativeImages[$typeName][$modelName]['main'] ?? url('storage/products/default.png') }}" 
                                                 alt="{{ $modelName }} {{ $typeName }}" 
                                                 class="primary-image"
                                                 onerror="this.src='{{ url('storage/products/default.png') }}'">
                                            <img src="{{ $representativeImages[$typeName][$modelName]['hover'] ?? url('storage/products/default.png') }}" 
                                                 alt="{{ $modelName }} {{ $typeName }} Hover" 
                                                 class="hover-image">
                                        </div>
                                        <div class="model-info">
                                            <div class="model-name text-center">{{ $modelName }}</div>
                                            <div class="text-center mb-2">
                                                <button class="btn btn-sm btn-danger">View Products</button>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- OnGuard Accessories Button -->
    <div class="row mt-5 mb-5">
        <div class="col-12 text-center">
            <div class="section-title">OnGuard Accessories</div>
            <p class="mb-4">Complete your OnGuard aluminum fence with essential accessories designed to work perfectly with all fence systems.</p>
            
            <a href="{{ route('aluminumfence.accessories') }}" class="btn btn-primary btn-lg accessories-button">
                <i class="bi bi-tools me-2"></i> View All OnGuard Accessories
            </a>
        </div>
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
        @if(isset($selectedFenceType) && $selectedFenceType)
            // If there's a selected type from the URL, activate that button
            $('.type-button[data-type="{{ $selectedFenceType }}"]').click();
        @else
            // Default to first type (should be Residential)
            $('.type-button:first').click();
        @endif
    });
</script>
@endsection
