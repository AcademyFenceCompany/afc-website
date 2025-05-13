@extends('layouts.main')

@section('title', 'OnGuard Aluminum Fence - ' . $type . ' ' . $model)

@section('styles')
<<<<<<< HEAD
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
=======
>>>>>>> afc-webdev-c
<style>
    .product-header {
        background-color: #8B4513;
        color: white;
        padding: 10px;
    }
    
    .filter-section {
        background-color: #f8f9fa;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
    }
    
    .filter-title {
        font-weight: bold;
        font-size: 1.2rem;
        margin-bottom: 15px;
        color: #8B4513;
    }
    
    .filter-label {
        font-weight: bold;
        margin-bottom: 8px;
        color: #555;
    }
    
    .filter-group {
        margin-bottom: 15px;
    }
    
    .product-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .product-table th, .product-table td {
        padding: 0;
        border: 1px solid #ddd;
    }
    
    .product-table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }
    
    .product-row:nth-child(even) {
        background-color: #f9f9f9;
    }
    
    .product-image-container {
        position: relative;
        width: 290px;
        height: 200px;
        overflow: hidden;
    }
    
    .primary-image, .hover-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        border: 1px solid #ddd;
        border-radius: 5px;
        position: absolute;
        top: 0;
        left: 0;
        transition: opacity 0.3s ease;
    }
    
    .hover-image {
        opacity: 0;
    }
    
    .product-image-container:hover .primary-image {
        opacity: 0;
    }
    
    .product-image-container:hover .hover-image {
        opacity: 1;
    }
    
    .btn-add-cart {
        background-color: #8B4513;
        color: white;
        border: none;
        padding: 2px 10px;
        border-radius: 3px;
        cursor: pointer;
    }
    
    .btn-add-cart:hover {
        background-color: #218838;
    }
    
    .quantity-input {
        width: 60px;
        padding: 5px;
        border: 1px solid #ddd;
        border-radius: 3px;
    }
    
    .color-swatch {
        display: inline-block;
        width: 15px;
        height: 15px;
        margin-right: 5px;
        border: 1px solid #ccc;
        vertical-align: middle;
    }
    
    .black-swatch {
        background-color: #000;
    }
    
    .bronze-swatch {
        background-color: #8c7853;
    }
    
    .white-swatch {
        background-color: #fff;
    }
    
    .green-swatch {
        background-color: #006400;
    }
    
    .color-option {
        margin-bottom: 5px;
    }
    
    .color-option label {
        display: flex;
        align-items: center;
    }
    
    .model-description {
        margin-bottom: 20px;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 5px;
        border-left: 4px solid #8B4513;
    }
    
    .main-header {
        margin-bottom: 30px;
    }
    
    /* Navigation buttons */
    .nav-buttons {
        margin-bottom: 20px;
    }
    
    .nav-buttons .btn {
        margin-right: 10px;
    }
    
    /* Size selector */
    .size-selector {
        margin-top: 20px;
        padding: 15px;
        background-color: #8B4513;
        border-radius: 5px;
        color: white;
    }
    
    .size-selector h5 {
        margin-bottom: 15px;
        text-align: center;
    }
    
    .size-option {
        margin-bottom: 10px;
    }
    
    .size-option label {
        display: block;
        cursor: pointer;
    }
    
<<<<<<< HEAD
    .size-options-desktop {
        display: none;
    }
    
    .size-dropdown-mobile {
        display: none;
    }
    .mobile-title {
        display: none;
    }
    /* Media query for mobile devices */
    @media (max-width: 767.98px) {
        .product-header {
            font-size: 14px;
        }
        .mobile-title {
            display: block;
            font-weight: bold;
            font-size: 14px;
        }
        .size-options-desktop {
            display: none;
        }
        
        .size-dropdown-mobile {
            display: block;
            width: 100%;
            margin-top: 10px;
            background-color: white;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 8px;
        }
        .size-selector {
            background-color: #fff;
            color: #000;
            padding: 0;
        }
        .size-selector h5 {
            font-weight: bold;
            text-align: left;
            font-size: 16px;
        }
        
        .nav-buttons .btn {
            margin-right: 0;
            font-size: 11px;
        }
        
        /* Mobile product card styles */
        .product-table {
            display: none;
        }
        
        .mobile-product-cards {
            display: block;
        }
        
        .product-card {
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 15px;
            background-color: #fff;
        }
        
        .product-card-body {
            padding: 12px;
        }
        
        .product-card-row {
            display: flex;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .product-card-label {
            font-weight: bold;
            width: 70px;
            flex-shrink: 0;
        }
        
        .product-card-value {
            flex-grow: 1;
        }
        
        .product-card-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 12px;
        }
        
        .section-title{
            font-size: 13px;
        }
        .section-title-mobile {
            background-color: #6c757d;
            color: white;
            padding: 7px;
            margin-bottom: 10px;
            border-radius: 5px;
            font-size: 12px;
            cursor: pointer;
            position: relative;
        }
        
        .section-title-mobile::after {
            content: '\f107';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            right: 15px;
        }
        
        .section-title-mobile.collapsed::after {
            content: '\f105';
        }
        
        .section-products-mobile {
            margin-bottom: 20px;
        }
    }
    
    /* Desktop-only styles */
    @media (min-width: 768px) {
        .mobile-product-cards {
            display: none;
        }
    }
    
=======
>>>>>>> afc-webdev-c
    .necessary-products-box {
        margin-top: 5px;
        border-radius: 5px;
        background-color: #fff;
    }
    
    .necessary-products-title {
<<<<<<< HEAD
        background-color: #fff;
        color: #000;
        padding: 5px;
=======
        background-color: #8B4513;
        color: white;
        padding: 10px;
>>>>>>> afc-webdev-c
        text-align: center;
        border-radius: 5px 5px 0 0;
    }
    
    .section-container {
        margin-bottom: 20px;
<<<<<<< HEAD
        position: relative;
    }
    
    .section-image {
        display: none;
        width: 140px;
        height: 72px;
        object-fit: contain;
        margin-right: 15px;
    }
    
    .section-table-container {
        display: flex;
        align-items: flex-start;
    }
    
    .section-table-container .product-table {
        flex: 1;
    }
    
    .hidden-products {
        display: none;
    }

    .see-all-btn {
    text-transform: uppercase;
    padding: 0;
    color: #000;
    font-weight: bold;
    margin-top: 2px;
    cursor: pointer;
    font-size: 11px;
    width: 15%;
    background-color: #f8f9fa;
}
    
    .see-all-btn:hover {
        background-color: #e9ecef;
    }
    
    .font-size-14 {
        font-size: 14px;
    }
    
    .font-size-12 {
        font-size: 12px;
=======
    }
    
    .section-title {
        font-size: 13px;
        padding: 10px;
        border-radius: 5px 5px 0 0;
>>>>>>> afc-webdev-c
    }
    
    .model-list {
        margin-top: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
    
    .model-list-header {
        background-color: #8B4513;
        color: white;
        padding: 10px;
        text-align: center;
        border-radius: 5px 5px 0 0;
    }
    
    .model-list-item {
        padding: 8px 15px;
        border-bottom: 1px solid #ddd;
    }
    
    .model-list-item:last-child {
        border-bottom: none;
    }
    
    .model-list-item a {
        color: #333;
        text-decoration: none;
    }
    
    .model-list-item a:hover {
        color: #8B4513;
    }
    
    .model-list-item.active {
        background-color: #f5f5f5;
        font-weight: bold;
    }
    
    .model-list-item.active a {
        color: #8B4513;
    }
<<<<<<< HEAD
    
    /* Accordion styles */
    .accordion-item {
        border: none;
        margin-bottom: 10px;
    }
    
    .accordion-button {
        padding: 0;
        background: none;
        box-shadow: none;
    }
    
    .accordion-button:not(.collapsed) {
        background-color: transparent;
        box-shadow: none;
    }
    
    .accordion-button::after {
        display: none;
    }
    
    .accordion-button span {
        width: 100%;
        display: block;
    }
    
    .accordion-body {
        padding: 0;
    }
    
    .see-all-btn {
        margin: 10px auto;
        display: block;
    }
    
    .model-type-header {
        cursor: pointer;
        position: relative;
        padding-right: 30px;
        transition: background-color 0.3s;
    }
    
    .model-type-header:hover {
        background-color: #6c757d;
    }
    
    .model-type-header::after {
        content: '\f107'; /* Font Awesome down arrow */
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        transition: transform 0.3s;
    }
    
    .model-type-header.collapsed::after {
        transform: translateY(-50%) rotate(-90deg);
    }
    
    .model-type-items {
        display: none;
        border-left: 1px solid #ddd;
        border-right: 1px solid #ddd;
    }
    
    .model-type-items.show {
        display: block;
    }
    
    /* Make mobile accordion buttons more touch-friendly */
    .d-block.d-md-none .accordion-button {
        padding: 2px 0px;
    }
    
    .d-block.d-md-none .accordion-button span {
        padding: 10px !important;
    }
    
    /* Fix for accordion opening/closing */
    .accordion-button:not(.collapsed)::after {
        display: none;
    }
    
    .accordion-button::after {
        display: none;
    }
    
    .accordion-icon {
        display: inline-block;
        margin-left: 5px;
        font-size: 14px;
    }
    
    .accordion-icon-up {
        display: none;
        margin-left: 5px;
        font-size: 14px;
    }
    
    .accordion-button.collapsed .accordion-icon {
        display: inline-block;
    }
    
    .accordion-button.collapsed .accordion-icon-up {
        display: none;
    }
    
    .accordion-button:not(.collapsed) .accordion-icon {
        display: none;
    }
    
    .accordion-button:not(.collapsed) .accordion-icon-up {
        display: inline-block;
    }
    
    /* Custom accordion styling */
    .accordion-button:focus {
        box-shadow: none;
    }
    
    .accordion-button {
        padding: 0;
        background: transparent;
        box-shadow: none;
    }
=======
>>>>>>> afc-webdev-c
</style>
@endsection

@section('content')
<div class="container mt-4">
    <!-- Navigation Buttons -->
    <div class="row nav-buttons">
        <div class="col-12">
            <a href="{{ route('aluminumfence.index') }}" class="btn btn-secondary">Back to All OnGuard Styles</a>
            <a href="{{ route('aluminumfence.pickup') }}" class="btn btn-danger">See what's available for pickup</a>
        </div>
    </div>
    
    <!-- Product Details Section -->
    <div class="row mb-4">
        <!-- Product Image and Size Selector -->
        <div class="col-md-3">
<<<<<<< HEAD
            <p class="mobile-title">ONGUARD {{ strtoupper($type) }} ALUMINUM FENCE - {{ strtoupper($model) }}</p>
            <div class="product-image-container" id="product-image-container"> 
                <img src="{{ $selectedProduct->img_large ? url('storage/products/' . $selectedProduct->img_large) : url('storage/products/default.jpg') }}" 
                     alt="{{ $type }} {{ $model }}" 
                     class="primary-image" 
                     id="primary-product-image"
                     onerror="this.src='{{ url('storage/products/default.jpg') }}'" 
                     onclick="openImageModal(this.src, this.alt)">
                <img src="{{ $selectedProduct->img_small ? url('storage/products/' . $selectedProduct->img_small) : url('storage/products/default.jpg') }}" 
                     alt="{{ $type }} {{ $model }}" 
                     class="hover-image" 
                     id="hover-product-image"
                     onerror="this.src='{{ url('storage/products/default.jpg') }}'" 
                     onclick="openImageModal(this.src, this.alt)">
=======
            <div class="product-image-container">
                <img src="{{ $modelImage }}" alt="{{ $type }} {{ $model }}" class="primary-image" onerror="this.src='{{ url('storage/products/default.png') }}'">
                <img src="{{ $selectedProduct->img_small ? url('storage/products/' . $selectedProduct->img_small) : url('storage/products/default.png') }}" alt="{{ $type }} {{ $model }} Hover" class="hover-image" onerror="this.src='{{ url('storage/products/default.png') }}'">
>>>>>>> afc-webdev-c
            </div>
            
            <!-- Size Filter -->
            <div class="size-selector">
                <h5 class="mb-0">SELECT HEIGHT</h5>
<<<<<<< HEAD
                
                <!-- Desktop size radio buttons -->
                <div class="d-none d-md-block mt-3 size-options-desktop">
=======
                <div class="d-flex flex-column mt-3">
>>>>>>> afc-webdev-c
                    @foreach($sizes as $size)
                        <div class="size-option">
                            <label>
                                <input type="radio" name="size" class="size-filter" value="{{ $size }}" {{ $loop->first ? 'checked' : '' }}>
                                <span class="ms-2">{{ $size }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
<<<<<<< HEAD
                
                <!-- Mobile size dropdown -->
                <div class="d-block d-md-none size-dropdown-mobile">
                    <select id="size-select-mobile" class="form-select size-filter-mobile">
                        @foreach($sizes as $size)
                            <option value="{{ $size }}" {{ $loop->first ? 'selected' : '' }}>{{ $size }}</option>
                        @endforeach
                    </select>
                </div>
=======
>>>>>>> afc-webdev-c
            </div>
            
            <!-- Color Dropdown -->
            @if(count($colors) > 1)
            <div class="mt-3">
                <label for="color-select" class="form-label fw-bold">COLOR</label>
                <select id="color-select" class="form-select">
                    @foreach($colors as $color)
                        <option value="{{ $color }}">{{ $color }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            
            <!-- Model List -->
            <div class="model-list mt-4">
                <div class="model-list-content">
                    @foreach($fenceTypes as $fenceType => $typeData)
<<<<<<< HEAD
                        <div class="model-type-section mb-2">
                            <div class="model-type-header bg-secondary text-white p-2 {{ $type == $fenceType ? '' : 'collapsed' }}" data-fence-type="{{ $fenceType }}">
                                <i class="fas fa-bars me-2"></i> {{ $fenceType }}
                            </div>
                            <div class="model-type-items {{ $type == $fenceType ? 'show' : '' }}">
                                @foreach($typeData['models'] as $modelName => $modelData)
                                    <div class="model-list-item {{ ($type == $fenceType && $model == $modelName) ? 'active' : '' }}">
                                        <a href="{{ route('aluminumfence.product', ['type' => $fenceType, 'model' => $modelName]) }}">
                                            <i class="fas fa-angle-right me-2"></i> {{ $modelName }}
=======
                        <div class="model-type-section">
                            <div class="model-type-header bg-secondary text-white p-2">
                                {{ $fenceType }}
                            </div>
                            <div class="model-type-items">
                                @foreach($typeData['models'] as $modelName => $modelData)
                                    <div class="model-list-item {{ ($type == $fenceType && $model == $modelName) ? 'active' : '' }}">
                                        <a href="{{ route('aluminumfence.product', ['type' => $fenceType, 'model' => $modelName]) }}">
                                            {{ $modelName }}
>>>>>>> afc-webdev-c
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Product Info -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header product-header">
                    <p class="text-center text-white mb-0">ONGUARD {{ strtoupper($type) }} ALUMINUM FENCE - {{ strtoupper($model) }}</p>
                </div>
                <div class="card-body p-0">
<<<<<<< HEAD
                    <!-- Desktop table view -->
                    <table class="product-table" id="products-table">
                        <tbody>
                            @if($selectedProduct)
                                <tr style="font-weight: bold">
=======
                    <table class="product-table" id="products-table">
                        <tbody>
                            @if($selectedProduct)
                                <tr class="product-row" 
                                    data-color="{{ $selectedProduct->color }}" 
                                    data-size="{{ $selectedProduct->size }}">
>>>>>>> afc-webdev-c
                                    <td>{{ $selectedProduct->item_no }}</td>
                                    <td>{{ $selectedProduct->product_name }}</td>
                                    <td>{{ $selectedProduct->size }}</td>
                                    <td>{{ $selectedProduct->color }}</td>
                                    <td class="price">${{ number_format($selectedProduct->price, 2) }}</td>
                                    <td>
                                        <input type="number" class="quantity-input" value="1" min="1">
                                    </td>
                                    <td>
<<<<<<< HEAD
                                        <button class="btn-add-cart add-to-cart-btn" 
                                            data-id="{{ $selectedProduct->id }}"
                                            data-item_no="{{ $selectedProduct->item_no }}" 
                                            data-product_name="{{ $selectedProduct->product_name }}"
                                            data-price="{{ $selectedProduct->price }}"
                                            data-color="{{ $selectedProduct->color ?? '' }}"
                                            data-size="{{ $selectedProduct->size ?? '' }}"
                                            data-size_in="{{ $selectedProduct->size_in ?? '' }}"
                                            data-size_wt="{{ $selectedProduct->size_wt ?? '' }}"
                                            data-size_ht="{{ $selectedProduct->size_ht ?? '' }}"
                                            data-weight_lbs="{{ $selectedProduct->weight_lbs ?? '' }}"
                                            data-img_small="{{ $selectedProduct->img_small ?? '' }}"
                                            data-img_large="{{ $selectedProduct->img_large ?? '' }}"
                                            data-display_size_2="{{ $selectedProduct->display_size_2 ?? '' }}"
                                            data-size2="{{ $selectedProduct->size2 ?? '' }}"
                                            data-size3="{{ $selectedProduct->size3 ?? '' }}"
                                            data-material="{{ $selectedProduct->material ?? '' }}"
                                            data-spacing="{{ $selectedProduct->spacing ?? '' }}"
                                            data-coating="{{ $selectedProduct->coating ?? '' }}"
                                            data-style="{{ $selectedProduct->style ?? '' }}"
                                            data-speciality="{{ $selectedProduct->speciality ?? '' }}"
                                            data-free_shipping="{{ $selectedProduct->free_shipping ?? '0' }}"
                                            data-special_shipping="{{ $selectedProduct->special_shipping ?? '0' }}"
                                            data-amount_per_box="{{ $selectedProduct->amount_per_box ?? '1' }}"
                                            data-class="{{ $selectedProduct->class ?? '' }}"
                                            data-categories_id="{{ $selectedProduct->categories_id ?? '' }}"
                                            data-shipping_method="{{ $selectedProduct->shipping_method ?? '' }}">
=======
                                        <button class="btn-add-cart" 
                                            data-item="{{ $selectedProduct->item_no }}" 
                                            data-name="{{ $selectedProduct->product_name }}" 
                                            data-price="{{ $selectedProduct->price }}">
>>>>>>> afc-webdev-c
                                            Add
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
<<<<<<< HEAD
                    
                    <!-- Mobile card view -->
                    <div class="mobile-product-cards">
                        @if($selectedProduct)
                            <div class="product-card">
                                <div class="product-card-body">
                                    <div class="product-card-row">
                                        <div class="product-card-label">Item #:</div>
                                        <div class="product-card-value">{{ $selectedProduct->item_no }}</div>
                                    </div>
                                    <div class="product-card-row">
                                        <div class="product-card-label">Name:</div>
                                        <div class="product-card-value">{{ $selectedProduct->product_name }}</div>
                                    </div>
                                    <div class="product-card-row">
                                        <div class="product-card-label">Size:</div>
                                        <div class="product-card-value">{{ $selectedProduct->size }}</div>
                                    </div>
                                    <div class="product-card-row">
                                        <div class="product-card-label">Color:</div>
                                        <div class="product-card-value">{{ $selectedProduct->color }}</div>
                                    </div>
                                    <div class="product-card-row">
                                        <div class="product-card-label">Price:</div>
                                        <div class="product-card-value">$ {{ number_format($selectedProduct->price, 2) }}</div>
                                    </div>
                                    <div class="product-card-actions">
                                        <div>
                                            <label for="mobile-qty" class="me-2">Qty:</label>
                                            <input type="number" id="mobile-qty" class="quantity-input" value="1" min="1" style="width: 60px;">
                                        </div>
                                        <button class="btn-add-cart add-to-cart-btn" 
                                            data-id="{{ $selectedProduct->id }}"
                                            data-item_no="{{ $selectedProduct->item_no }}" 
                                            data-product_name="{{ $selectedProduct->product_name }}"
                                            data-price="{{ $selectedProduct->price }}"
                                            data-color="{{ $selectedProduct->color ?? '' }}"
                                            data-size="{{ $selectedProduct->size ?? '' }}"
                                            data-size2="{{ $selectedProduct->size2 ?? '' }}"
                                            data-size3="{{ $selectedProduct->size3 ?? '' }}"
                                            data-img_small="{{ $selectedProduct->img_small ?? '' }}"
                                            data-img_large="{{ $selectedProduct->img_large ?? '' }}">
                                            Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
=======
>>>>>>> afc-webdev-c
                </div>
            </div>
            
            <!-- Necessary Products Box -->
            @if(!empty($associatedSections))
            <div class="necessary-products-box">
<<<<<<< HEAD
                <!-- Desktop View -->
                <div class="d-none d-md-block">
                    <h5 class="mt-3 text-center" style="font-size: 15px;">NECESSARY ASSOCIATED PRODUCTS</h5>
                    <div class="accordion" id="associatedProductsAccordion">
                        @foreach($associatedSections as $index => $section)
                        <div class="accordion-item section-container mb-2">
                            <h6 class="accordion-header">
                                <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#section-collapse-{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="section-collapse-{{ $index }}">
                                    <span class="bg-secondary text-white p-2 w-100 text-center" style="font-size: 13px;">{{ $section['title'] }}
                                        <i class="accordion-icon bi bi-chevron-down"></i>
                                        <i class="accordion-icon-up bi bi-chevron-up"></i>
                                    </span>
                                </button>
                            </h6>
                            <div id="section-collapse-{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}">
                                <div class="accordion-body p-0">
                                    <div class="section-table-container">
                                        @if(isset($section['products'][0]))
                                        {{-- <img src="{{ url('storage/products/' . $section['products'][0]->img_small) }}" alt="{{ $section['products'][0]->product_name }}" class="section-image"> --}}
                                        {{-- <img src="{{ $section['products'][0]->img_small ? url('storage/products/' . $section['products'][0]->img_small) : url('storage/products/default.jpg') }}" alt="{{ $section['products'][0]->product_name }}" class="section-image" onerror="this.src='{{ url('storage/products/default.jpg') }}'"> --}}
                                        @endif
                                        <table class="product-table">
                                            <tbody>
                                                @foreach($section['products'] as $product)
                                                    <tr>
                                                        <td>{{ $product->item_no }}</td>
                                                        <td>{{ $product->product_name }}</td>
                                                        <td>{{ $product->size }}</td>
                                                        <td>{{ $product->color }}</td>
                                                        <td class="price">$ {{ number_format($product->price, 2) }}</td>
                                                        <td>
                                                            <input type="number" class="quantity-input" value="1" min="1">
                                                        </td>
                                                        <td>
                                                            <button class="btn-add-cart add-to-cart-btn" 
                                                                data-id="{{ $product->id }}"
                                                                data-item_no="{{ $product->item_no }}" 
                                                                data-product_name="{{ $product->product_name }}"
                                                                data-price="{{ $product->price }}"
                                                                data-color="{{ $product->color ?? '' }}"
                                                                data-size="{{ $product->size ?? '' }}"
                                                                data-size2="{{ $product->size2 ?? '' }}"
                                                                data-size3="{{ $product->size3 ?? '' }}"
                                                                data-img_small="{{ $product->img_small ?? '' }}"
                                                                data-img_large="{{ $product->img_large ?? '' }}">
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
                        @endforeach
                    </div>
                </div>
                
                <!-- Mobile View -->
                <div class="d-block d-md-none">
                    <h5 class="mt-3 text-center" style="font-size: 15px;">NECESSARY ASSOCIATED PRODUCTS</h5>
                    <div class="accordion" id="mobileAssociatedProductsAccordion">
                        @foreach($associatedSections as $index => $section)
                        <div class="accordion-item section-container mb-2">
                            <h6 class="accordion-header">
                                <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#mobile-section-{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="mobile-section-{{ $index }}">
                                    <span class="bg-secondary text-white p-2 w-100 text-center" style="font-size: 13px;">{{ $section['title'] }}
                                        <i class="accordion-icon bi bi-chevron-down"></i>
                                        <i class="accordion-icon-up bi bi-chevron-up"></i>
                                    </span>
                                </button>
                            </h6>
                            <div id="mobile-section-{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}">
                                <div class="accordion-body p-0">
                                    @foreach($section['products'] as $product)
                                    <div class="product-card">
                                        <div class="product-card-body">
                                            <div class="product-card-row">
                                                <div class="product-card-label">Item #:</div>
                                                <div class="product-card-value">{{ $product->item_no }}</div>
                                            </div>
                                            <div class="product-card-row">
                                                <div class="product-card-label">Name:</div>
                                                <div class="product-card-value">{{ $product->product_name }}</div>
                                            </div>
                                            <div class="product-card-row">
                                                <div class="product-card-label">Size:</div>
                                                <div class="product-card-value">{{ $product->size }}</div>
                                            </div>
                                            <div class="product-card-row">
                                                <div class="product-card-label">Color:</div>
                                                <div class="product-card-value">{{ $product->color }}</div>
                                            </div>
                                            <div class="product-card-row">
                                                <div class="product-card-label">Price:</div>
                                                <div class="product-card-value">$ {{ number_format($product->price, 2) }}</div>
                                            </div>
                                            <div class="product-card-actions">
                                                <div>
                                                    <label for="mobile-assoc-qty-{{ $product->item_no }}" class="me-2">Qty:</label>
                                                    <input type="number" id="mobile-assoc-qty-{{ $product->item_no }}" class="quantity-input" value="1" min="1" style="width: 60px;">
                                                </div>
                                                <button class="btn-add-cart add-to-cart-btn" 
                                                    data-id="{{ $product->id }}"
                                                    data-item_no="{{ $product->item_no }}" 
                                                    data-product_name="{{ $product->product_name }}"
                                                    data-price="{{ $product->price }}"
                                                    data-color="{{ $product->color ?? '' }}"
                                                    data-size="{{ $product->size ?? '' }}"
                                                    data-size2="{{ $product->size2 ?? '' }}"
                                                    data-size3="{{ $product->size3 ?? '' }}"
                                                    data-img_small="{{ $product->img_small ?? '' }}"
                                                    data-img_large="{{ $product->img_large ?? '' }}">
                                                    Add to Cart
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
=======
                @foreach($associatedSections as $section)
                <div class="section-container mb-2">
                    <h6 class="section-title bg-secondary text-white p-2">{{ $section['title'] }}</h6>
                    <table class="product-table">
                        <tbody>
                            @foreach($section['products'] as $product)
                                <tr>
                                    <td>{{ $product->item_no }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->size }}</td>
                                    <td>{{ $product->color }}</td>
                                    <td class="price">${{ number_format($product->price, 2) }}</td>
                                    <td>
                                        <input type="number" class="quantity-input" value="1" min="1">
                                    </td>
                                    <td>
                                        <button class="btn-add-cart" 
                                            data-item="{{ $product->item_no }}" 
                                            data-name="{{ $product->product_name }}" 
                                            data-price="{{ $product->price }}">
                                            Add
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endforeach
>>>>>>> afc-webdev-c
            </div>
            @endif
        </div>
    </div>
</div>
<<<<<<< HEAD

<!-- Image Modal -->
<div id="imageModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Product Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" class="img-fluid" src="" alt="">
            </div>
        </div>
    </div>
</div>

=======
>>>>>>> afc-webdev-c
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof jQuery === 'undefined') {
            console.error('jQuery is not loaded!');
            return;
        }
        
        (function($) {
            console.log('Document ready');
            
            const sizeInputs = $('input[name="size"]');
            const colorSelect = $('#color-select');
<<<<<<< HEAD
            const sizeSelectMobile = $('#size-select-mobile');
            
            console.log('Size inputs found:', sizeInputs.length);
            console.log('Color select found:', colorSelect.length);
            console.log('Size select mobile found:', sizeSelectMobile.length);
            
            // Get initial values from either desktop or mobile selector
            const defaultSize = sizeInputs.filter(':checked').val() || sizeSelectMobile.val();
            const defaultColor = colorSelect.val();
            
            // Make sure both selectors are in sync initially
            if (defaultSize) {
                sizeInputs.filter('[value="' + defaultSize + '"]').prop('checked', true);
                sizeSelectMobile.val(defaultSize);
            }
            
            console.log('Default size:', defaultSize);
            console.log('Default color:', defaultColor);
            
            // We don't need to filter on initial load since the server already provided the correct product
            // Only set up the event handlers for when filters change
            
            sizeInputs.on('change', function() {
                console.log('Size changed (desktop)');
=======
            
            console.log('Size inputs found:', sizeInputs.length);
            console.log('Color select found:', colorSelect.length);
            
            const defaultSize = sizeInputs.filter(':checked').val();
            const defaultColor = colorSelect.val();
            
            console.log('Default size:', defaultSize);
            console.log('Default color:', defaultColor);
            
            if (defaultSize) {
                console.log('Filtering with initial values');
                filterProducts(defaultSize, defaultColor || '');
            } else {
                console.log('No default size found, skipping initial filter');
            }
            
            sizeInputs.on('change', function() {
                console.log('Size changed');
>>>>>>> afc-webdev-c
                const selectedSize = $(this).val();
                const selectedColor = colorSelect.val() || '';
                console.log('Selected size:', selectedSize);
                console.log('Selected color:', selectedColor);
<<<<<<< HEAD
                
                // Sync with mobile dropdown
                sizeSelectMobile.val(selectedSize);
                
                // Show loading indicator before filtering
                $('#products-table tbody').html('<tr><td colspan="7" class="text-center">Loading...</td></tr>');
                $('.mobile-product-cards').html('<div class="p-3 text-center">Loading...</div>');
                
                filterProducts(selectedSize, selectedColor);
            });
            
            sizeSelectMobile.on('change', function() {
                console.log('Size changed (mobile)');
                const selectedSize = $(this).val();
                const selectedColor = colorSelect.val() || '';
                console.log('Selected size:', selectedSize);
                console.log('Selected color:', selectedColor);
                
                // Sync with desktop radio buttons
                sizeInputs.filter('[value="' + selectedSize + '"]').prop('checked', true);
                
                // Show loading indicator before filtering
                $('#products-table tbody').html('<tr><td colspan="7" class="text-center">Loading...</td></tr>');
                $('.mobile-product-cards').html('<div class="p-3 text-center">Loading...</div>');
                
=======
>>>>>>> afc-webdev-c
                filterProducts(selectedSize, selectedColor);
            });
            
            colorSelect.on('change', function() {
                console.log('Color changed');
                const selectedColor = $(this).val();
<<<<<<< HEAD
                const selectedSize = sizeInputs.filter(':checked').val() || sizeSelectMobile.val();
                console.log('Selected size:', selectedSize);
                console.log('Selected color:', selectedColor);
                
                // Show loading indicator before filtering
                $('#products-table tbody').html('<tr><td colspan="7" class="text-center">Loading...</td></tr>');
                $('.mobile-product-cards').html('<div class="p-3 text-center">Loading...</div>');
                
=======
                const selectedSize = sizeInputs.filter(':checked').val();
                console.log('Selected size:', selectedSize);
                console.log('Selected color:', selectedColor);
>>>>>>> afc-webdev-c
                filterProducts(selectedSize, selectedColor);
            });
            
            function filterProducts(size, color) {
                console.log('Filtering products - Size:', size, 'Color:', color);
                
<<<<<<< HEAD
                // Cache key for storing filtered results
                const cacheKey = `${size}-${color}-{{ $type }}-{{ $model }}`;
                
                // Initialize cache in memory if it doesn't exist
                if (!window.productCache) {
                    window.productCache = {};
                }
                
                // Check if we have cached results in memory
                if (window.productCache[cacheKey]) {
                    console.log('Using cached results for:', cacheKey);
                    updateProductDisplay(window.productCache[cacheKey]);
                    updateAssociatedProducts(window.productCache[cacheKey]);
=======
                // Show loading indicator
                $('#products-table tbody').html('<tr><td colspan="7" class="text-center">Loading...</td></tr>');
                
                // Cache key for storing filtered results
                const cacheKey = `${size}-${color}-{{ $type }}-{{ $model }}`;
                
                // Check if we have cached results
                if (window.productCache && window.productCache[cacheKey]) {
                    console.log('Using cached results');
                    processFilterResponse(window.productCache[cacheKey]);
>>>>>>> afc-webdev-c
                    return;
                }
                
                $.ajax({
                    url: '{{ route("aluminumfence.filter") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
<<<<<<< HEAD
                        size: size,
                        color: color,
                        type: '{{ $type }}',
                        model: '{{ $model }}'
                    },
                    beforeSend: function() {
                        console.log('AJAX request sending with data:', {
                            size: size,
                            color: color,
                            type: '{{ $type }}',
                            model: '{{ $model }}'
                        });
                    },
                    success: function(response) {
                        console.log('Filter response:', response);
                        
                        // Cache the results in memory instead of sessionStorage
                        try {
                            window.productCache[cacheKey] = response;
                        } catch (e) {
                            console.error('Error caching results:', e);
                            // If we can't cache for some reason, still update the display
                        }
                        
                        updateProductDisplay(response);
                        updateAssociatedProducts(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error filtering products:', error);
                        console.error('Status:', status);
                        console.error('Response:', xhr.responseText);
                        
                        $('#products-table tbody').html('<tr><td colspan="7" class="text-center">Error loading product. Please try again.</td></tr>');
                        $('.mobile-product-cards').html('<div class="p-3 text-center">Error loading product. Please try again.</div>');
=======
                        type: '{{ $type }}',
                        model: '{{ $model }}',
                        size: size,
                        color: color
                    },
                    beforeSend: function() {
                        console.log('AJAX request sending with data:', {
                            type: '{{ $type }}',
                            model: '{{ $model }}',
                            size: size,
                            color: color
                        });
                    },
                    success: function(response) {
                        console.log('AJAX success response:', response);
                        
                        // Cache the response
                        if (!window.productCache) window.productCache = {};
                        window.productCache[cacheKey] = response;
                        
                        // Process the response
                        processFilterResponse(response);
                    },
                    error: function(error) {
                        console.error('Error filtering products:', error);
                        $('#products-table tbody').html('<tr><td colspan="7" class="text-center">Error loading product. Please try again.</td></tr>');
>>>>>>> afc-webdev-c
                    }
                });
            }
            
<<<<<<< HEAD
            function updateProductDisplay(response) {
=======
            function processFilterResponse(response) {
>>>>>>> afc-webdev-c
                if (response.product) {
                    const product = response.product;
                    console.log('Product found:', product);
                    
<<<<<<< HEAD
                    // Update the product images
                    updateProductImages(product);
                    
                    // Update desktop table view
                    const newRow = `
                        <tr class="product-row" data-color="${product.color}" data-size="${product.size}">
                            <td>${product.item_no}</td>
                            <td>${product.product_name}- ${product.display_size_2}</td>
=======
                    const newRow = `
                        <tr class="product-row" data-color="${product.color}" data-size="${product.size}">
                            <td>${product.item_no}</td>
                            <td>${product.product_name}</td>
>>>>>>> afc-webdev-c
                            <td>${product.size}</td>
                            <td>${product.color}</td>
                            <td class="price">$${parseFloat(product.price).toFixed(2)}</td>
                            <td>
                                <input type="number" class="quantity-input" value="1" min="1">
                            </td>
                            <td>
<<<<<<< HEAD
                                <button class="btn-add-cart add-to-cart-btn" 
                                    data-id="${product.id}"
                                    data-item_no="${product.item_no}" 
                                    data-product_name="${product.product_name}"
                                    data-price="${product.price}"
                                    data-color="${product.color ?? ''}"
                                    data-size="${product.size ?? ''}"
                                    data-size_in="${product.size_in ?? ''}"
                                    data-size_wt="${product.size_wt ?? ''}"
                                    data-size_ht="${product.size_ht ?? ''}"
                                    data-weight_lbs="${product.weight_lbs ?? ''}"
                                    data-img_small="${product.img_small ?? ''}"
                                    data-img_large="${product.img_large ?? ''}"
                                    data-display_size_2="${product.display_size_2 ?? ''}"
                                    data-size2="${product.size2 ?? ''}"
                                    data-size3="${product.size3 ?? ''}"
                                    data-material="${product.material ?? ''}"
                                    data-spacing="${product.spacing ?? ''}"
                                    data-coating="${product.coating ?? ''}"
                                    data-style="${product.style ?? ''}"
                                    data-speciality="${product.speciality ?? ''}"
                                    data-free_shipping="${product.free_shipping ?? '0' }"
                                    data-special_shipping="${product.special_shipping ?? '0' }"
                                    data-amount_per_box="${product.amount_per_box ?? '1' }"
                                    data-class="${product.class ?? '' }"
                                    data-categories_id="${product.categories_id ?? '' }"
                                    data-shipping_method="${product.shipping_method ?? '' }">
=======
                                <button class="btn-add-cart" 
                                    data-item="${product.item_no}" 
                                    data-name="${product.product_name}" 
                                    data-price="${product.price}">
>>>>>>> afc-webdev-c
                                    Add
                                </button>
                            </td>
                        </tr>
                    `;
                    
                    $('#products-table tbody').html(newRow);
<<<<<<< HEAD
                    
                    // Update mobile card view
                    const mobileCard = `
                        <div class="product-card">
                            <div class="product-card-body">
                                <div class="product-card-row">
                                    <div class="product-card-label">Item #:</div>
                                    <div class="product-card-value">${product.item_no}</div>
                                </div>
                                <div class="product-card-row">
                                    <div class="product-card-label">Name:</div>
                                    <div class="product-card-value">${product.product_name}- ${product.display_size_2}</div>
                                </div>
                                <div class="product-card-row">
                                    <div class="product-card-label">Size:</div>
                                    <div class="product-card-value">${product.size}</div>
                                </div>
                                <div class="product-card-row">
                                    <div class="product-card-label">Color:</div>
                                    <div class="product-card-value">${product.color}</div>
                                </div>
                                <div class="product-card-row">
                                    <div class="product-card-label">Price:</div>
                                    <div class="product-card-value">$${parseFloat(product.price).toFixed(2)}</div>
                                </div>
                                <div class="product-card-actions">
                                    <div>
                                        <label for="mobile-qty" class="me-2">Qty:</label>
                                        <input type="number" id="mobile-qty" class="quantity-input" value="1" min="1" style="width: 60px;">
                                    </div>
                                    <button class="btn-add-cart add-to-cart-btn" 
                                        data-id="${product.id}"
                                        data-item_no="${product.item_no}" 
                                        data-product_name="${product.product_name}"
                                        data-price="${product.price}"
                                        data-color="${product.color ?? ''}"
                                        data-size="${product.size ?? ''}"
                                        data-size2="${product.size2 ?? ''}"
                                        data-size3="${product.size3 ?? ''}"
                                        data-img_small="${product.img_small ?? ''}"
                                        data-img_large="${product.img_large ?? ''}">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    $('.mobile-product-cards').html(mobileCard);
                } else {
                    console.log('No product found in response');
                    $('#products-table tbody').html('<tr><td colspan="7" class="text-center">No matching product found.</td></tr>');
                    $('.mobile-product-cards').html('<div class="p-3 text-center">No matching product found.</div>');
=======
                } else {
                    console.log('No product found in response');
                    $('#products-table tbody').html('<tr><td colspan="7" class="text-center">No matching product found.</td></tr>');
>>>>>>> afc-webdev-c
                }
                
                updateAssociatedProducts(response);
            }
            
<<<<<<< HEAD
            // Function to update product images when product changes
            function updateProductImages(product) {
                console.log('Updating product images for:', product);
                
                // Get the image container
                const imageContainer = $('#product-image-container');
                const primaryImage = $('#primary-product-image');
                const hoverImage = $('#hover-product-image');
                
                // Default image path
                const defaultImage = '{{ url('storage/products/default.jpg') }}';
                
                // Set the primary image
                let primaryImageSrc = defaultImage;
                if (product.img_large) {
                    primaryImageSrc = '{{ url('storage/products/') }}/' + product.img_large;
                }
                
                // Set the hover image - use img_small if available, otherwise use the main image
                let hoverImageSrc = product.img_small ? 
                    '{{ url('storage/products/') }}/' + product.img_small : 
                    primaryImageSrc; // Use main image for hover if no specific hover image
                
                // Update the src attributes
                primaryImage.attr('src', primaryImageSrc);
                hoverImage.attr('src', hoverImageSrc);
                
                // Update alt attributes
                const altText = `${product.material} ${product.style}`;
                primaryImage.attr('alt', altText);
                hoverImage.attr('alt', altText + ' Hover');
                
                console.log('Images updated:', {primary: primaryImageSrc, hover: hoverImageSrc});
            }
            
            function updateAssociatedProducts(response) {
                if (response.associatedSections && response.associatedSections.length > 0) {
                    // Desktop view
                    let associatedHtml = '<h5 class="mt-3 text-center" style="font-size: 15px;">NECESSARY ASSOCIATED PRODUCTS</h5>';
                    
                    response.associatedSections.forEach(function(section, index) {
                        // Get the first product image for the section
                        const firstProductImage = section.products.length > 0 ? 
                            (section.products[0].img_small ? 
                                `{{ url('storage/products/') }}/${section.products[0].img_small}` : 
                                `{{ url('storage/products/default.jpg') }}`) : 
                            `{{ url('storage/products/default.jpg') }}`;
                        
                        associatedHtml += `
                            <div class="accordion-item section-container mb-2">
                                <h6 class="accordion-header">
                                    <button class="accordion-button ${index > 0 ? 'collapsed' : ''}" type="button" data-bs-toggle="collapse" data-bs-target="#section-collapse-${index}" aria-expanded="${index === 0 ? 'true' : 'false'}" aria-controls="section-collapse-${index}">
                                        <span class="bg-secondary text-white p-2 w-100 text-center" style="font-size: 13px;">${section.title}
                                            <i class="accordion-icon bi bi-chevron-down"></i>
                                            <i class="accordion-icon-up bi bi-chevron-up"></i>
                                        </span>
                                    </button>
                                </h6>
                                <div id="section-collapse-${index}" class="accordion-collapse collapse ${index === 0 ? 'show' : ''}">
                                    <div class="accordion-body p-0">
                                        <div class="section-table-container">
                                            <table class="product-table">
                                                <tbody>
                                                    ${section.products.map(function(product) {
                                                        return `
                                                            <tr>
                                                                <td>${product.item_no}</td>
                                                                <td>${product.product_name}</td>
                                                                <td>${product.size}</td>
                                                                <td>${product.color}</td>
                                                                <td class="price">$${parseFloat(product.price).toFixed(2)}</td>
                                                                <td>
                                                                    <input type="number" class="quantity-input" value="1" min="1">
                                                                </td>
                                                                <td>
                                                                    <button class="btn-add-cart add-to-cart-btn" 
                                                                        data-id="${product.id}"
                                                                        data-item_no="${product.item_no}" 
                                                                        data-product_name="${product.product_name}"
                                                                        data-price="${product.price}"
                                                                        data-color="${product.color || ''}"
                                                                        data-size="${product.size || ''}"
                                                                        data-size2="${product.size2 || ''}"
                                                                        data-size3="${product.size3 || ''}"
                                                                        data-img_small="${product.img_small || ''}"
                                                                        data-img_large="${product.img_large || ''}">
                                                                        Add to Cart
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        `;
                                                    }).join('')}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    // Mobile view
                    let mobileSectionsHtml = '<h5 class="mb-3 text-center font-size-14">NECESSARY ASSOCIATED PRODUCTS</h5>';
                    
                    response.associatedSections.forEach(function(section, index) {
                        let mobileProductsHtml = '';
                        
                        section.products.forEach(function(product) {
                            mobileProductsHtml += `
                                <div class="product-card">
                                    <div class="product-card-body">
                                        <div class="product-card-row">
                                            <div class="product-card-label">Item #:</div>
                                            <div class="product-card-value">${product.item_no}</div>
                                        </div>
                                        <div class="product-card-row">
                                            <div class="product-card-label">Name:</div>
                                            <div class="product-card-value">${product.product_name}</div>
                                        </div>
                                        <div class="product-card-row">
                                            <div class="product-card-label">Size:</div>
                                            <div class="product-card-value">${product.size}</div>
                                        </div>
                                        <div class="product-card-row">
                                            <div class="product-card-label">Color:</div>
                                            <div class="product-card-value">${product.color}</div>
                                        </div>
                                        <div class="product-card-row">
                                            <div class="product-card-label">Price:</div>
                                            <div class="product-card-value">$${parseFloat(product.price).toFixed(2)}</div>
                                        </div>
                                        <div class="product-card-actions">
                                            <div>
                                                <label for="mobile-assoc-qty-${product.item_no}" class="me-2">Qty:</label>
                                                <input type="number" id="mobile-assoc-qty-${product.item_no}" class="quantity-input" value="1" min="1" style="width: 60px;">
                                            </div>
                                            <button class="btn-add-cart add-to-cart-btn" 
                                                data-id="${product.id}"
                                                data-item_no="${product.item_no}" 
                                                data-product_name="${product.product_name}"
                                                data-price="${product.price}"
                                                data-color="${product.color || ''}"
                                                data-size="${product.size || ''}"
                                                data-size2="${product.size2 || ''}"
                                                data-size3="${product.size3 || ''}"
                                                data-img_small="${product.img_small || ''}"
                                                data-img_large="${product.img_large || ''}">
                                                Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        
                        mobileSectionsHtml += `
                            <div class="accordion-item section-container mb-2">
                                <h6 class="accordion-header">
                                    <button class="accordion-button ${index > 0 ? 'collapsed' : ''}" type="button" data-bs-toggle="collapse" data-bs-target="#mobile-section-ajax-${index}" aria-expanded="${index === 0 ? 'true' : 'false'}" aria-controls="mobile-section-ajax-${index}">
                                        <span class="bg-secondary text-white p-2 w-100 text-center" style="font-size: 13px;">${section.title}
                                            <i class="accordion-icon bi bi-chevron-down"></i>
                                            <i class="accordion-icon-up bi bi-chevron-up"></i>
                                        </span>
                                    </button>
                                </h6>
                                <div id="mobile-section-ajax-${index}" class="accordion-collapse collapse ${index === 0 ? 'show' : ''}">
                                    <div class="accordion-body p-0">
                                        ${mobileProductsHtml}
                                    </div>
                                </div>
=======
            function updateAssociatedProducts(response) {
                if (response.associatedSections && response.associatedSections.length > 0) {
                    let associatedHtml = '';
                    
                    response.associatedSections.forEach(function(section) {
                        associatedHtml += `
                            <div class="section-container mb-4">
                                <h6 class="section-title bg-secondary text-white p-2">${section.title}</h6>
                                <table class="product-table">
                                    <thead>
                                        <tr>
                                            <th>Item #</th>
                                            <th>Name</th>
                                            <th>Size</th>
                                            <th>Color</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Add</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${section.products.map(function(product) {
                                            return `
                                                <tr>
                                                    <td>${product.item_no}</td>
                                                    <td>${product.product_name}</td>
                                                    <td>${product.size}</td>
                                                    <td>${product.color}</td>
                                                    <td class="price">$${parseFloat(product.price).toFixed(2)}</td>
                                                    <td>
                                                        <input type="number" class="quantity-input" value="1" min="1">
                                                    </td>
                                                    <td>
                                                        <button class="btn-add-cart" 
                                                            data-item="${product.item_no}" 
                                                            data-name="${product.product_name}" 
                                                            data-price="${product.price}">
                                                            Add
                                                        </button>
                                                    </td>
                                                </tr>
                                            `;
                                        }).join('')}
                                    </tbody>
                                </table>
>>>>>>> afc-webdev-c
                            </div>
                        `;
                    });
                    
                    if ($('.necessary-products-box').length === 0) {
                        const necessaryProductsBox = `
                            <div class="necessary-products-box mt-4">
<<<<<<< HEAD
                                <div class="d-none d-md-block">
                                    <div class="accordion" id="associatedProductsAccordion">
                                        ${associatedHtml}
                                    </div>
                                </div>
                                <div class="d-block d-md-none">
                                    <div class="accordion" id="mobileAssociatedProductsAccordion">
                                        ${mobileSectionsHtml}
                                    </div>
                                </div>
                            </div>
                        `;
                        $('.products-container').append(necessaryProductsBox);
                    } else {
                        $('.necessary-products-box .d-none.d-md-block').html(`<div class="accordion" id="associatedProductsAccordion">${associatedHtml}</div>`);
                        $('.necessary-products-box .d-block.d-md-none').html(`<div class="accordion" id="mobileAssociatedProductsAccordion">${mobileSectionsHtml}</div>`);
                    }

                    // Initialize accordions after dynamic content is loaded
                    setTimeout(function() {
                        // Initialize any new Bootstrap components after dynamic loading
                        document.querySelectorAll('.accordion-button').forEach(function(button) {
                            button.addEventListener('click', function() {
                                const target = document.querySelector(button.getAttribute('data-bs-target'));
                                if (target) {
                                    if (target.classList.contains('show')) {
                                        target.classList.remove('show');
                                        button.classList.add('collapsed');
                                        button.setAttribute('aria-expanded', 'false');
                                    } else {
                                        target.classList.add('show');
                                        button.classList.remove('collapsed');
                                        button.setAttribute('aria-expanded', 'true');
                                    }
                                }
                            });
                        });
                    }, 100);
=======
                                <div class="necessary-products-title">
                                    <h5 class="mb-0">NECESSARY ASSOCIATED PRODUCTS</h5>
                                </div>
                                ${associatedHtml}
                            </div>
                        `;
                        $('#products-table').closest('.card').after(necessaryProductsBox);
                    } else {
                        $('.necessary-products-box').html(`
                            <div class="necessary-products-title">
                                <h5 class="mb-0">NECESSARY ASSOCIATED PRODUCTS</h5>
                            </div>
                            ${associatedHtml}
                        `);
                    }
>>>>>>> afc-webdev-c
                } else {
                    $('.necessary-products-box').remove();
                }
            }
            
<<<<<<< HEAD
            $(document).on('click', '.model-type-header', function() {
                const $this = $(this);
                const $items = $this.next('.model-type-items');
                
                if ($this.hasClass('collapsed')) {
                    $this.removeClass('collapsed');
                    $items.addClass('show');
                } else {
                    $this.addClass('collapsed');
                    $items.removeClass('show');
                }
            });
            
            // Toggle mobile section collapsible
            $(document).on('click', '.section-title-mobile', function() {
                const $this = $(this);
                const $content = $this.next('.section-content-mobile');
                
                if ($this.hasClass('collapsed')) {
                    $this.removeClass('collapsed');
                    $content.removeClass('d-none');
                } else {
                    $this.addClass('collapsed');
                    $content.addClass('d-none');
                }
=======
            $(document).on('click', '.btn-add-cart', function() {
                const item = $(this).data('item');
                const name = $(this).data('name');
                const price = $(this).data('price');
                const quantity = $(this).closest('tr').find('.quantity-input').val();
                
                alert(`Added to cart: ${quantity} x ${name} (${item}) - $${price * quantity}`);
>>>>>>> afc-webdev-c
            });
        })(jQuery);
    });
</script>
<<<<<<< HEAD

<script>
    function openImageModal(src, alt) {
        $('#modalImage').attr('src', src);
        $('#modalImage').attr('alt', alt);
        $('#imageModalLabel').text(alt);
        $('#imageModal').modal('show');
    }
    
    $(document).ready(function() {
        // Close modal with ESC key
        $(document).keydown(function(e) {
            if (e.key === "Escape") {
                $('#imageModal').modal('hide');
            }
        });
    });
</script>
@endsection
=======
@endsection
>>>>>>> afc-webdev-c
