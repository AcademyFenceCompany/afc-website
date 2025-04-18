@extends('layouts.main')

@section('title', 'Wood Post Caps')

@section('styles')
<style>
    .page-title {
        text-align: center;
        margin-bottom: 30px;
    }
    .main-header {
        background-color: #000;
        color: white;
        text-align: center;
        padding: 10px;
        margin-bottom: 20px;
        font-weight: bold;
    }
    .cap-box {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        height: 100%;
    }
    .cap-box:hover {
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        transform: translateY(-5px);
    }
    .cap-box.active {
        border-color: #8B4513;
        box-shadow: 0 0 10px rgba(139, 69, 19, 0.3);
    }
    .cap-box img {
        max-width: 100%;
        height: auto;
        margin-bottom: 10px;
    }
    .cap-box h5 {
        font-size: 14px;
        margin-bottom: 0;
    }
    .product-table {
        width: 100%;
        margin-top: 30px;
        border-collapse: collapse;
    }
    .product-table th, .product-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }
    .product-table th {
        background-color: #8B4513;
        color: white;
    }
    .product-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    .btn-add {
        background-color: #8B4513;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
    }
    .btn-add:hover {
        background-color: #6B3100;
    }
    .product-image {
        max-height: 200px;
        max-width: 100%;
        object-fit: contain;
    }
    .note-box {
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
        border-left: 4px solid #8B4513;
    }
    .product-header {
        background-color: #8B4513;
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
</style>
@endsection

@section('content')
<div class="container mt-4">


    <div class="row">
        <div class="col-12">
            <div class="main-header">
                <h4 class="mb-0" id="cap-title">Pyramid Wood Post Caps</h4>
            </div>
        </div>
    </div>
    
    <!-- Cap Types Grid - All in one row with 5 columns -->
    <div class="row">
        @php
            $allParentCodes = ['AFCWPCP', 'AFCWPCPD', 'AFCWPCPC', 'AFCWPCB3', 'AFCWPCBD3', 'AFCWPCB5', 'AFCWPCF', 'AFCWPCFD', 'AFCWPCFC'];
        @endphp
        
        @foreach ($allParentCodes as $parentCode)
            @if (isset($representativeProducts[$parentCode]))
                <div class="col-md-2 col-sm-4 col-6 mb-3">
                    <div class="cap-box {{ isset($selectedParent) && $selectedParent == $parentCode ? 'active' : '' }}" data-parent="{{ $parentCode }}">
                        @php
                            $product = $representativeProducts[$parentCode];
                            $imagePath = $product->img_large ? url('storage/products/' . $product->img_large) : url('storage/products/default.png');
                        @endphp
                        <img src="{{ $imagePath }}" alt="{{ $parentGroups[$parentCode] ?? 'Wood Post Cap' }}">
                        <h5>{{ $parentGroups[$parentCode] ?? 'Wood Post Cap' }}</h5>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    
    <!-- Note Box -->
    <div class="note-box mt-4">
        Note: Measure your post for Actual Post Size before ordering.
    </div>
    
    <!-- Product Tables - One for each parent type, initially hidden -->
    <div id="product-sections">
        @foreach ($productsByParent as $parentCode => $products)
            @if(count($products) > 0)
                <div class="product-section" id="products-{{ $parentCode }}" style="display: none;">
                    <div class="product-header" style="background-color: #8B4513; color: white; padding: 10px; text-align: center; margin-bottom: 20px;">
                        <h5 class="mb-0">{{ strtoupper($parentGroups[$parentCode] ?? 'WOOD POST CAPS') }}</h5>
                    </div>
                    
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
                                    <td>{{ $product->color ?? 'Pressure Treated' }}</td>
                                    <td class="text-center">
                                        <div class="input-group input-group-sm" style="width: 100px; margin: 0 auto;">
                                            <button class="btn btn-outline-secondary quantity-minus" type="button">-</button>
                                            <input type="text" class="form-control text-center quantity-input" value="1">
                                            <button class="btn btn-outline-secondary quantity-plus" type="button">+</button>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div>${{ number_format($product->price, 2) }}</div>
                                        <button class="btn btn-danger btn-sm add-to-cart-btn" 
                                            data-item="{{ $product->item_no }}" 
                                            data-name="{{ $product->product_name }}"
                                            data-price="{{ $product->price }}" 
                                            data-product-id="{{ $product->id ?? '' }}"
                                            style="padding: 1px 5px;font-size: 12px;">
                                            Add to Cart
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @endforeach
    </div>
</div>

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Handle cap box clicks
        $('.cap-box').click(function() {
            // Remove active class from all cap boxes
            $('.cap-box').removeClass('active');
            
            // Add active class to clicked cap box
            $(this).addClass('active');
            
            // Get the parent code
            var parentCode = $(this).data('parent');
            
            // Get the parent name for the title
            var parentName = $(this).find('h5').text();
            
            // Update the title
            $('#cap-title').text(parentName + ' Wood Post Caps');
            
            // Hide all product sections
            $('.product-section').hide();
            
            // Show the product section for the selected parent
            $('#products-' + parentCode).show();
            
            // Scroll to the product section but keep the parent items visible
            $('html, body').animate({
                scrollTop: $('.note-box').offset().top - 20
            }, 500);
            
            // Update URL without page reload (for bookmarking)
            if (history.pushState) {
                var newUrl = window.location.protocol + "//" + window.location.host + 
                             window.location.pathname.split('/').slice(0, -1).join('/') + 
                             '/' + parentCode;
                window.history.pushState({path: newUrl}, '', newUrl);
            }
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
        
        // If there's a selected parent from the URL, trigger click on that cap box
        @if(isset($selectedParent))
            $('.cap-box[data-parent="{{ $selectedParent }}"]').click();
        @else
            // Show the first product section by default if no style is selected
            if ($('.cap-box').length > 0) {
                $('.cap-box').first().click();
            }
        @endif
    });
</script>
@endsection
@endsection
