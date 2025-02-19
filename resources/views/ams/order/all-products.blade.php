@extends('layouts.ams')

@section('title', 'All Products')

@section('content')
<div class="container-fluid py-2">
    <div class="row">
        <!-- Categories Sidebar -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Categories</h5>
                    <div class="category-tree">
                        @foreach($categories as $category)
                            <div class="category-item">
                                <a href="#" class="category-link" data-category-id="{{ $category->family_category_id }}">
                                    {{ $category->family_category_name }}
                                </a>
                                @if($category->children->count() > 0)
                                    <div class="nested">
                                        @foreach($category->children as $child)
                                            <div class="category-item ps-3">
                                                <a href="#" class="category-link" data-category-id="{{ $child->family_category_id }}">
                                                    {{ $child->family_category_name }}
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Products</h5>
                        <div class="d-flex gap-2">
                            <input type="text" class="form-control form-control-sm" id="productSearch" placeholder="Search products...">
                            <button type="button" class="btn btn-primary btn-sm" id="addSelectedToOrder">
                                Add Selected to Order
                            </button>
                        </div>
                    </div>

                    @foreach($groupedProducts as $size => $colorGroups)
                        <div class="size-group mb-4">
                            <h6 class="border-bottom pb-2">Size: {{ $size }}</h6>
                            @foreach($colorGroups as $color => $products)
                                <div class="color-group mb-3">
                                    <h6 class="small">Color: {{ $color }}</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" class="select-all-group"></th>
                                                    <th>Item Number</th>
                                                    <th>Name</th>
                                                    <th>Description</th>
                                                    <th>Style</th>
                                                    <th>Material</th>
                                                    <th>Spacing</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($products as $product)
                                                    <tr data-category="{{ $product->family_category_id }}">
                                                        <td>
                                                            <input type="checkbox" class="product-select" 
                                                                data-product-id="{{ $product->product_id }}"
                                                                data-product-name="{{ $product->product_name }}"
                                                                data-product-price="{{ $product->price_per_unit }}">
                                                        </td>
                                                        <td>{{ $product->item_no }}</td>
                                                        <td>{{ $product->product_name }}</td>
                                                        <td>{{ $product->description }}</td>
                                                        <td>{{ $product->details->style }}</td>
                                                        <td>{{ $product->details->material }}</td>
                                                        <td>{{ $product->details->spacing }}</td>
                                                        <td>${{ number_format($product->price_per_unit, 2) }}</td>
                                                        <td>
                                                            <input type="number" class="form-control form-control-sm product-quantity" 
                                                                style="width: 80px" value="1" min="1">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-primary add-single-product"
                                                                data-product-id="{{ $product->product_id }}">
                                                                Add
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Return to Order Modal -->
<div class="modal fade" id="returnToOrderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Return to Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Do you want to return to the order? Your selected products will be added to the order.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continue Shopping</button>
                <button type="button" class="btn btn-primary" id="confirmReturn">Return to Order</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Handle category clicks
    $('.category-link').click(function(e) {
        e.preventDefault();
        const categoryId = $(this).data('category-id');
        
        // Toggle nested categories
        $(this).siblings('.nested').slideToggle();
        
        // Filter products by category
        if (categoryId) {
            $('tr').hide();
            $(`tr[data-category="${categoryId}"]`).show();
            $('.size-group').each(function() {
                if ($(this).find('tr:visible').length > 0) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        } else {
            $('tr, .size-group').show();
        }
    });

    // Handle product search
    $('#productSearch').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        
        if (searchTerm.length >= 2) {
            $('tr').hide();
            $('tr').each(function() {
                const text = $(this).text().toLowerCase();
                if (text.includes(searchTerm)) {
                    $(this).show();
                }
            });
            
            $('.size-group').each(function() {
                if ($(this).find('tr:visible').length > 0) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        } else {
            $('tr, .size-group').show();
        }
    });

    // Handle select all for group
    $('.select-all-group').change(function() {
        const checked = $(this).prop('checked');
        $(this).closest('table').find('.product-select').prop('checked', checked);
    });

    // Add single product
    $('.add-single-product').click(function() {
        const row = $(this).closest('tr');
        const productId = $(this).data('product-id');
        const quantity = row.find('.product-quantity').val();
        
        addProductsToOrder([{
            productId: productId,
            quantity: quantity
        }]);
    });

    // Add selected products
    $('#addSelectedToOrder').click(function() {
        const selectedProducts = [];
        
        $('.product-select:checked').each(function() {
            const row = $(this).closest('tr');
            selectedProducts.push({
                productId: $(this).data('product-id'),
                quantity: row.find('.product-quantity').val()
            });
        });
        
        if (selectedProducts.length > 0) {
            addProductsToOrder(selectedProducts);
        } else {
            alert('Please select at least one product');
        }
    });

    // Add products to order and store in localStorage
    function addProductsToOrder(products) {
        // Get existing order items from localStorage
        let orderItems = JSON.parse(localStorage.getItem('orderItems') || '[]');
        
        // Add new products
        products.forEach(product => {
            orderItems.push({
                productId: product.productId,
                quantity: product.quantity
            });
        });
        
        // Save back to localStorage
        localStorage.setItem('orderItems', JSON.stringify(orderItems));
        
        // Show return to order modal
        $('#returnToOrderModal').modal('show');
    }

    // Handle return to order
    $('#confirmReturn').click(function() {
        window.location.href = '{{ route("ams.orders.create") }}';
    });
});
</script>
@endsection

@section('styles')
<style>
.size-group {
    margin-bottom: 2rem;
}

.color-group {
    margin-bottom: 1.5rem;
}

.category-tree {
    max-height: calc(100vh - 200px);
    overflow-y: auto;
}

.category-link {
    display: block;
    padding: 0.25rem 0;
    color: #333;
    text-decoration: none;
}

.category-link:hover {
    color: #0d6efd;
}

.nested {
    display: none;
    margin-left: 1rem;
}

.table th {
    background-color: #f8f9fa;
    position: sticky;
    top: 0;
}

.product-quantity {
    width: 80px !important;
}
</style>
@endsection
