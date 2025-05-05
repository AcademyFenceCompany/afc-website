@extends('layouts.main')

@section('title', $pageTitle ?? 'OnGuard Aluminum Fence Accessories')

@section('styles')
<style>
    .main-header {
        background-color: #001755;
        color: white;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
    }
    
    .section-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #001755;
        border-bottom: 2px solid #001755;
        padding-bottom: 10px;
    }
    
    .back-button {
        margin-bottom: 20px;
    }
    
    .accessory-sidebar {
        border-right: 1px solid #ddd;
        padding-right: 15px;
    }
    
    .accessory-group-item {
        padding: 2px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
    }
    
    .accessory-group-item:hover {
        background-color: #e9ecef;
        transform: translateX(5px);
    }
    
    .accessory-group-item.active {
        background-color: #001755;
        color: white;
        border-color: #001755;
    }
    
    .accessory-group-title {
        font-weight: bold;
        font-size: 12px;

    }
    
    .accessory-group-item.active .accessory-group-count {
        color: #ced4da;
    }
    
    .product-header {
        background-color: #001755;
        color: white;
        padding: 10px 15px;
        margin-bottom: 20px;
        border-radius: 5px;
    }
    
    .product-table {
        width: 100%;
        margin-bottom: 20px;
    }
    
    .product-table th {
        background-color: #e9ecef;
        padding: 10px;
        border-bottom: 2px solid #dee2e6;
    }
    
    .product-table td {
        padding: 3px;
        border-bottom: 1px solid #dee2e6;
        vertical-align: middle;
    }
    
    .product-image {
        max-height: 60px;
        max-width: 60px;
    }
    
    .product-category-header {
        background-color: #f8f9fa;
        padding: 10px;
        margin-top: 20px;
        margin-bottom: 10px;
        border-left: 4px solid #001755;
        font-weight: bold;
    }
    
    .quantity-control {
        display: flex;
        align-items: center;
    }
    
    .quantity-input {
        width: 50px;
        text-align: center;
        margin: 0 5px;
    }
    
    @media (max-width: 768px) {
        .accessory-sidebar {
            border-right: none;
            border-bottom: 1px solid #ddd;
            padding-right: 0;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    @if(isset($accessoryGroups) && count($accessoryGroups) > 0)
        <div class="row">
            <!-- Accessory Groups Sidebar -->
            <div class="col-md-3 accessory-sidebar">
                <h4 class="mb-3">Accessory Categories</h4>
                <div class="accessory-groups-list">
                    @foreach($accessoryGroups as $groupName => $group)
                        <div class="accessory-group-item" data-group="{{ $groupName }}">
                            <div class="accessory-group-title">{{ $group['title'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Products Display Area -->
            <div class="col-md-9 product-content">
                <div id="products-container">
                    <div class="initial-message text-center py-5">
                        <i class="bi bi-arrow-left-circle" style="font-size: 3rem; color: #6c757d;"></i>
                        <h4 class="mt-3">Select a category from the left to view products</h4>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            No accessories are currently available. Please check back later.
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Store accessory groups data
        const accessoryGroups = @json($accessoryGroups ?? []);
        
        // Handle accessory group item clicks
        $('.accessory-group-item').click(function() {
            // Update active state
            $('.accessory-group-item').removeClass('active');
            $(this).addClass('active');
            
            const groupName = $(this).data('group');
            showProducts(groupName);
        });
        
        // Function to show products for a group
        function showProducts(groupName) {
            if (!accessoryGroups[groupName]) return;
            
            // Clear products container
            $('#products-container').empty();
            
            
            // Create table for products
            const table = $(`
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Item No</th>
                            <th>Size</th>
                            <th>Color</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            `);
            
            // Group products by common attributes
            const groupedProducts = {};
            
            // Process products
            accessoryGroups[groupName].products.forEach(function(product) {
                // Create a simplified product name for grouping
                // Remove sizes, colors, and other specifics
                let baseProductName = product.product_name.replace(/\s+\d+(\.\d+)?"|\s+\([^)]+\)|\s+[A-Z]+$/g, '').trim();
                
                if (!groupedProducts[baseProductName]) {
                    groupedProducts[baseProductName] = [];
                }
                
                groupedProducts[baseProductName].push(product);
            });
            
            // Add products to table by groups
            Object.keys(groupedProducts).forEach(function(productGroup) {
                // Add category header
                table.find('tbody').append(`
                    <tr>
                        <td colspan="6" class="product-category-header">${productGroup}</td>
                    </tr>
                `);
                
                // Add products in this group
                groupedProducts[productGroup].forEach(function(product) {
                    const row = $(`
                        <tr>
                            <td>${product.product_name}</td>
                            <td>${product.item_no}</td>
                            <td>${product.size}</td>
                            <td>${product.color}</td>
                            <td>$${parseFloat(product.price).toFixed(2)}</td>
                            <td>
                                <div class="quantity-control">
                                    <button class="btn btn-sm btn-outline-secondary quantity-minus" type="button">-</button>
                                    <input type="text" class="form-control quantity-input" value="1">
                                    <button class="btn btn-sm btn-outline-secondary quantity-plus" type="button">+</button>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-danger add-to-cart-btn" 
                                        data-item="${product.item_no}" 
                                        data-name="${product.product_name}" 
                                        data-price="${product.price}">
                                    Add to Cart
                                </button>
                            </td>
                        </tr>
                    `);
                    
                    table.find('tbody').append(row);
                });
            });
            
            // Add table to container
            $('#products-container').append(table);
        }
        
        // Handle quantity plus button clicks
        $(document).on('click', '.quantity-plus', function() {
            const input = $(this).siblings('.quantity-input');
            const value = parseInt(input.val());
            input.val(value + 1);
        });
        
        // Handle quantity minus button clicks
        $(document).on('click', '.quantity-minus', function() {
            const input = $(this).siblings('.quantity-input');
            const value = parseInt(input.val());
            if (value > 1) {
                input.val(value - 1);
            }
        });
        
        // Handle add to cart button clicks
        $(document).on('click', '.add-to-cart-btn', function() {
            const button = $(this);
            const itemNo = button.data('item');
            const name = button.data('name');
            const price = button.data('price');
            const quantity = button.closest('tr').find('.quantity-input').val();
            
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
        
        // Auto-select first accessory group
        if ($('.accessory-group-item').length > 0) {
            $('.accessory-group-item:first').click();
        }
    });
</script>
@endsection
