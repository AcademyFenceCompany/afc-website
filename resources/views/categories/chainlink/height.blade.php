@extends('layouts.main')

@section('title', $pageTitle)

@section('styles')
<style>
    .main-header {
        background-color: #1a4d2e;
        color: white;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
    }
    
    .product-group {
        margin-bottom: 30px;
    }
    
    .product-group-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 15px;
        color: #1a4d2e;
        border-bottom: 2px solid #1a4d2e;
        padding-bottom: 10px;
    }
    
    .product-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .product-image {
        height: 180px;
        width: 100%;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    
    .product-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    
    .product-info {
        padding: 15px;
    }
    
    .product-title {
        font-weight: bold;
        margin-bottom: 5px;
        color: #333;
        font-size: 1rem;
    }
    
    .product-code {
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 10px;
    }
    
    .product-price {
        font-weight: bold;
        color: #dc3545;
        margin-bottom: 15px;
        font-size: 1.1rem;
    }
    
    .product-description {
        color: #555;
        font-size: 0.9rem;
        margin-bottom: 15px;
    }
    
    .back-button {
        margin-bottom: 20px;
    }
    
    .add-to-cart-btn {
        width: 100%;
    }
    
    .quantity-control {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .quantity-input {
        width: 60px;
        text-align: center;
        margin: 0 10px;
    }
    
    .quantity-btn {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 4px;
        cursor: pointer;
    }
    
    .quantity-btn:hover {
        background-color: #e9ecef;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="rounded bg-brown mb-2">
        <h1 class="page-title text-center mb-0">{{ $height }} Chain Link Fence</h1>
    </div>
    
    <!-- Product Groups -->
    @foreach($productGroups as $groupName => $group)
        <div class="product-group">
            <h2 class="product-group-title">{{ $groupName }}</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                @foreach($group['products'] as $product)
                    <div class="col">
                        <div class="product-card">
                            <div class="product-image">
                                <img src="{{ $product->img_large ? url('storage/products/' . $product->img_large) : ($product->img_small ? url('storage/products/' . $product->img_small) : url('storage/products/default.png')) }}" 
                                     alt="{{ $product->product_name }}" 
                                     onerror="this.src='{{ url('storage/products/default.png') }}'">
                            </div>
                            <div class="product-info">
                                <div class="product-title">{{ $product->product_name }}</div>
                                <div class="product-code">Item #: {{ $product->item_no }}</div>
                                <div class="product-price">${{ number_format($product->price, 2) }}</div>
                                <div class="product-description">
                                    {{ Str::limit($product->desc_short ?? 'No description available', 100) }}
                                </div>
                                <div class="quantity-control">
                                    <div class="quantity-btn quantity-minus"><i class="bi bi-dash"></i></div>
                                    <input type="number" class="form-control quantity-input" value="1" min="1">
                                    <div class="quantity-btn quantity-plus"><i class="bi bi-plus"></i></div>
                                </div>
                                <button class="btn btn-danger add-to-cart-btn" 
                                        data-item="{{ $product->item_no }}" 
                                        data-name="{{ $product->product_name }}" 
                                        data-price="{{ $product->price }}">
                                    <i class="bi bi-cart-plus"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
    
    @if(count($productGroups) === 0)
        <div class="alert alert-info">
            No products found for {{ $height }} Chain Link Fence. Please check back later or contact us for more information.
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Handle quantity plus button clicks
        $('.quantity-plus').click(function() {
            var input = $(this).closest('.quantity-control').find('.quantity-input');
            var value = parseInt(input.val());
            input.val(value + 1);
        });
        
        // Handle quantity minus button clicks
        $('.quantity-minus').click(function() {
            var input = $(this).closest('.quantity-control').find('.quantity-input');
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
            var quantity = button.closest('.product-info').find('.quantity-input').val();
            
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
    });
</script>
@endsection
