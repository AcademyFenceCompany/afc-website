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

                        @if ($columns->isNotEmpty())
                            <div class="row g-4">
                                @foreach ($columns as $columnGroups)
                                    <div class="col-md-4">
                                        @foreach ($columnGroups as $title => $products)
                                            <div class="product-group mb-4">
                                                <div class="header bg-dark text-white py-2 px-3">{{ $title }}</div>
                                                <div class="table-responsive">
                                                    <table class="table table-sm mb-0">
                                                        <thead>
                                                            <tr class="bg-secondary text-white">
                                                                <th class="px-2" style="width: 20%">Size</th>
                                                                <th class="px-2" style="width: 12%">Price</th>
                                                                <th class="px-2" style="width: 20%">Item #</th>
                                                                <th class="px-2" style="width: 10%">WT</th>
                                                                <th class="px-2" style="width: 8%">EO</th>
                                                                <th class="px-2" style="width: 8%">HQ</th>
                                                                <th class="px-2" style="width: 12%">Qty</th>
                                                                <th class="px-2" style="width: 10%"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($products as $product)
                                                                <tr>
                                                                    <td class="px-2">{{ $product->size1 }}</td>
                                                                    <td class="px-2">${{ number_format($product->price_per_unit, 2) }}</td>
                                                                    <td class="px-2">{{ $product->item_no }}</td>
                                                                    <td class="px-2">{{ $product->weight }}</td>
                                                                    <td class="px-2">{{ $product->in_stock_warehouse }}</td>
                                                                    <td class="px-2">{{ $product->in_stock_hq }}</td>
                                                                    <td class="px-2">
                                                                        <input type="number"
                                                                            class="form-control form-control-sm product-quantity"
                                                                            value="1" min="1">
                                                                    </td>
                                                                    <td class="px-2">
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-primary add-single-product w-100"
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
                                        @endforeach
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
        .product-group {
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            overflow: hidden;
        }

        .product-group .header {
            font-size: 0.9rem;
            font-weight: 500;
        }

        .table {
            margin-bottom: 0;
            white-space: nowrap;
        }

        .table td,
        .table th {
            padding: 0.25rem 0.5rem;
            vertical-align: middle;
            font-size: 11px;
            line-height: 1.2;
        }

        .table thead th {
            border-bottom: 0;
            background-color: #6c757d;
            font-weight: 500;
            white-space: nowrap;
        }

        .product-quantity {
            width: 45px !important;
            padding: 0.15rem 0.25rem;
            text-align: center;
            font-size: 11px;
            height: 22px;
        }

        .btn-primary {
            padding: 0.15rem 0.25rem;
            font-size: 11px;
            height: 22px;
            line-height: 1;
        }

        .row.g-4 {
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 1.5rem;
        }

        .row.g-4>* {
            margin-bottom: 1.5rem;
        }

        .table-responsive {
            margin-bottom: -1px;
        }
    </style>
@endsection
