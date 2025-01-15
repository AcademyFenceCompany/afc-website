@extends('layouts.ams')
@section('title', 'Products')
@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Category Tree Sidebar -->
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 fw-semibold">Categories</h5>
                    </div>
                    <div class="card-body p-0">
<<<<<<< Updated upstream
                        @if (isset($categories) && $categories->isNotEmpty())
                            <div id="category-container" data-categories="{{ $categories->toJson() }}" class="d-none"></div>
                            <ul class="category-tree">
                                @foreach ($categories as $category)
                                    <li class="category-item">
                                        <div class="d-flex align-items-center">
                                            @if ($category->children->count() > 0)
                                                <button class="btn btn-sm btn-link toggle-btn" type="button">
                                                    <i class="bi bi-chevron-right"></i>
                                                </button>
                                            @else
                                                <span class="ps-3"></span>
                                            @endif
                                            <a href="{{ route('products.index', ['category' => $category->family_category_id]) }}"
                                                class="category-link {{ request('category') == $category->family_category_id ? 'active' : '' }}">
                                                {{ $category->family_category_name }}
                                            </a>
                                        </div>
                                        @if ($category->children->count() > 0)
                                            <ul class="nested">
                                                @include('ams.partials.category-tree-items', [
                                                    'categories' => $category->children,
                                                ])
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-danger p-3">No categories available.</p>
                        @endif
=======
                        <ul class="category-tree list-unstyled mb-0">
                            @foreach ($categories as $category)
                                @include('ams.partials.category-tree-items', ['category' => $category])
                            @endforeach
                        </ul>
>>>>>>> Stashed changes
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Products</h5>
                        @if (auth()->user()->level === 'God' || auth()->user()->level === 'Admin')
                            <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">Add New Product</a>
                        @endif
                    </div>

                    <!-- Products Table -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Item No</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Stock (HQ)</th>
                                        <th>Stock (WH)</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="productsTableBody">
                                    @forelse($products as $product)
                                        <tr>
                                            <td>{{ $product->item_no }}</td>
                                            <td>{{ $product->product_name }}</td>
                                            <td>{{ $product->familyCategory->family_category_name ?? 'N/A' }}</td>
                                            <td>${{ number_format($product->price_per_unit, 2) }}</td>
                                            <td>{{ $product->inventory->in_stock_hq ?? 0 }}</td>
                                            <td>{{ $product->inventory->in_stock_warehouse ?? 0 }}</td>
                                            <td>
                                                @if (auth()->user()->level === 'God' || auth()->user()->level === 'Admin')
                                                    <a href="{{ route('products.edit', $product->product_id) }}"
                                                        class="btn btn-sm btn-primary">Edit</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">No products found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
