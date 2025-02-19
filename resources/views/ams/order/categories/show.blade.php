@extends('layouts.ams')

@section('title', $category->family_category_name)

@section('content')
    <div class="container-fluid py-2">
        <div class="row">
            <div class="col-12 mb-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('ams.orders.categories') }}">Categories</a>
                        </li>
                        @if ($category->parent)
                            <li class="breadcrumb-item">
                                <a href="{{ route('ams.orders.category.show', $category->parent->family_category_id) }}">
                                    {{ $category->parent->family_category_name }}
                                </a>
                            </li>
                        @endif
                        <li class="breadcrumb-item active">{{ $category->family_category_name }}</li>
                    </ol>
                </nav>
            </div>

            @if ($category->children->count() > 0)
                <!-- Show subcategories -->
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">{{ $category->family_category_name }} Categories</h5>
                            <div class="row row-cols-1 row-cols-md-4 g-4">
                                @foreach ($category->children as $child)
                                    <div class="col">
                                        <a href="{{ route('ams.orders.category.show', $child->family_category_id) }}"
                                            class="card h-100 text-decoration-none">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary">{{ $child->family_category_name }}</h5>
                                                @if ($child->children_count > 0)
                                                    <p class="card-text text-muted">
                                                        {{ $child->children_count }} subcategories
                                                    </p>
                                                @endif
                                                @if ($child->products_count > 0)
                                                    <p class="card-text text-muted">
                                                        {{ $child->products_count }} products
                                                    </p>
                                                @endif
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Products Section -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">{{ $category->family_category_name }} Products</h5>

                        @if ($groupedProducts->isNotEmpty())
                            <div class="row">
                                @foreach ($groupedProducts as $title => $products)
                                    <div class="col-md-4 mb-4">
                                        <div class="card">
                                            <h6 class="card-header bg-dark text-white">{{ $title }}</h6>
                                            <div class="card-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-hover mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Size</th>
                                                                <th>Price</th>
                                                                <th>Item Number</th>
                                                                <th>Qty</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($products as $product)
                                                                <tr>
                                                                    <td>{{ $product->size1 }}</td>
                                                                    <td>${{ number_format($product->price_per_unit, 2) }}
                                                                    </td>
                                                                    <td>{{ $product->item_no }}</td>
                                                                    <td>
                                                                        <input type="number"
                                                                            class="form-control form-control-sm product-quantity"
                                                                            style="width: 60px" value="1"
                                                                            min="1">
                                                                    </td>
                                                                    <td>
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-primary add-single-product"
                                                                            data-product-id="{{ $product->product_id }}"
                                                                            data-product-name="{{ $product->product_name }}"
                                                                            data-product-price="{{ $product->price_per_unit }}">
                                                                            Add
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
                        @else
                            <div class="text-center py-5">
                                <h6 class="text-muted">No products found in this category</h6>
                            </div>
                        @endif
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
                window.location.href = '{{ route('ams.orders.create') }}';
            });
        });
    </script>
@endsection

@section('styles')
    <style>
        .size-section {
            margin-bottom: 2rem;
        }

        .table th {
            background-color: #f8f9fa;
            position: sticky;
            top: 0;
        }

        .table td {
            padding: 0.5rem !important;
        }

        .product-quantity {
            width: 60px !important;
        }
    </style>
@endsection
