@extends('layouts.main')

@section('title', 'OnGuard Aluminum Fence - ' . $type . ' ' . $model)

@section('styles')
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
    
    .product-image {
        width: 290px !important;
        height: 200px !important;
        object-fit: contain;
        border: 1px solid #ddd;
        border-radius: 5px;
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
    
    .necessary-products-box {
        margin-top: 5px;
        border-radius: 5px;
        background-color: #fff;
    }
    
    .necessary-products-title {
        background-color: #8B4513;
        color: white;
        padding: 10px;
        text-align: center;
        margin: -15px -15px 15px -15px;
        border-radius: 5px 5px 0 0;
    }
    
    .section-container {
        margin-bottom: 20px;
    }
    
    .section-title {
        font-size: 13px;
        padding: 10px;
        border-radius: 5px 5px 0 0;
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
            <img src="{{ $modelImage }}" alt="{{ $type }} {{ $model }}" class="product-image" onerror="this.src='{{ url('storage/products/default.png') }}'">
            
            <!-- Size Filter -->
            <div class="size-selector">
                <h5 class="mb-0">SELECT SIZE</h5>
                <div class="d-flex flex-column mt-3">
                    @foreach($sizes as $size)
                        <div class="size-option">
                            <label>
                                <input type="radio" name="size" class="size-filter" value="{{ $size }}" {{ $loop->first ? 'checked' : '' }}>
                                <span class="ms-2">{{ $size }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
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
                <div class="model-list-header">
                    <h6 class="mb-0">AVAILABLE MODELS</h6>
                </div>
                <div class="model-list-content">
                    @foreach($fenceTypes as $fenceType => $typeData)
                        <div class="model-type-section">
                            <div class="model-type-header bg-secondary text-white p-2">
                                {{ $fenceType }}
                            </div>
                            <div class="model-type-items">
                                @foreach($typeData['models'] as $modelName => $modelData)
                                    <div class="model-list-item {{ ($type == $fenceType && $model == $modelName) ? 'active' : '' }}">
                                        <a href="{{ route('aluminumfence.product', ['type' => $fenceType, 'model' => $modelName]) }}">
                                            {{ $modelName }}
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
                    <table class="product-table" id="products-table">
                        <tbody>
                            @if($selectedProduct)
                                <tr class="product-row" 
                                    data-color="{{ $selectedProduct->color }}" 
                                    data-size="{{ $selectedProduct->size }}">
                                    <td>{{ $selectedProduct->item_no }}</td>
                                    <td>{{ $selectedProduct->product_name }}</td>
                                    <td>{{ $selectedProduct->size }}</td>
                                    <td>{{ $selectedProduct->color }}</td>
                                    <td class="price">${{ number_format($selectedProduct->price, 2) }}</td>
                                    <td>
                                        <input type="number" class="quantity-input" value="1" min="1">
                                    </td>
                                    <td>
                                        <button class="btn-add-cart" 
                                            data-item="{{ $selectedProduct->item_no }}" 
                                            data-name="{{ $selectedProduct->product_name }}" 
                                            data-price="{{ $selectedProduct->price }}">
                                            Add
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Necessary Products Box -->
            @if(!empty($associatedSections))
            <div class="necessary-products-box">
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
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initial load of products based on default size
        const defaultSize = $('input[name="size"]:checked').val();
        filterProductsBySize(defaultSize);
        
        // Filter products when size is changed
        $('.size-filter').on('change', function() {
            const selectedSize = $(this).val();
            filterProductsBySize(selectedSize);
        });
        
        // Handle color select change
        $('#color-select').on('change', function() {
            const selectedColor = $(this).val();
            // Here you can add logic to filter by color if needed
        });
        
        // Function to filter products by size
        function filterProductsBySize(size) {
            // Show loading indicator
            $('#products-table tbody').html('<tr><td colspan="7" class="text-center">Loading...</td></tr>');
            
            // Hide the current product and fetch the new one via AJAX
            $.ajax({
                url: '{{ route("aluminumfence.filter") }}',
                method: 'GET',
                data: {
                    type: '{{ $type }}',
                    model: '{{ $model }}',
                    size: size
                },
                success: function(response) {
                    // Update the product table with the filtered product
                    if (response.product) {
                        const product = response.product;
                        
                        // Create new row HTML
                        const newRow = `
                            <tr class="product-row" data-color="${product.color}" data-size="${product.size}">
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
                        
                        // Replace the current row with the new one
                        $('#products-table tbody').html(newRow);
                        
                        // Update associated products
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
                                    </div>
                                `;
                            });
                            
                            // If necessary products box doesn't exist, create it
                            if ($('.necessary-products-box').length === 0) {
                                const necessaryProductsBox = `
                                    <div class="necessary-products-box mt-4">
                                        <div class="necessary-products-title">
                                            <h5 class="mb-0">NECESSARY PRODUCTS</h5>
                                        </div>
                                        ${associatedHtml}
                                    </div>
                                `;
                                $('#products-table').closest('.card').after(necessaryProductsBox);
                            } else {
                                // Update existing necessary products box
                                $('.necessary-products-box').html(`
                                    <div class="necessary-products-title">
                                        <h5 class="mb-0">NECESSARY PRODUCTS</h5>
                                    </div>
                                    ${associatedHtml}
                                `);
                            }
                        } else {
                            // Remove necessary products box if no associated products
                            $('.necessary-products-box').remove();
                        }
                    }
                },
                error: function(error) {
                    console.error('Error filtering products:', error);
                    $('#products-table tbody').html('<tr><td colspan="7" class="text-center">Error loading product. Please try again.</td></tr>');
                }
            });
        }
        
        // Add to cart functionality
        $(document).on('click', '.btn-add-cart', function() {
            const item = $(this).data('item');
            const name = $(this).data('name');
            const price = $(this).data('price');
            const quantity = $(this).closest('tr').find('.quantity-input').val();
            
            // Add to cart logic here
            // For example, using a simple alert for now
            alert(`Added to cart: ${quantity} x ${name} (${item}) - $${price * quantity}`);
            
            // In a real implementation, you would send this to a cart controller
        });
    });
</script>
@endsection
