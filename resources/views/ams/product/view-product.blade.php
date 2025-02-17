@extends('layouts.ams')

@section('title', 'Products')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Category Tree Sidebar -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Categories</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="category-tree">
                            @foreach ($categories as $category)
                                @if ($category->parent_category_id === null)
                                    <li class="category-item">
                                        <div class="d-flex align-items-center">
                                            @if (count($category->children) > 0)
                                                <button class="btn btn-sm btn-link toggle-btn" type="button">
                                                    <i class="bi bi-chevron-right"></i>
                                                </button>
                                            @else
                                                <span class="ps-3"></span>
                                            @endif
                                            <a href="javascript:void(0)"
                                                onclick="loadProductsByCategory('{{ $category->family_category_id }}')"
                                                class="category-link {{ request('category') == $category->family_category_id ? 'active' : '' }}"
                                                data-category-id="{{ $category->family_category_id }}">
                                                {{ $category->family_category_name }}
                                                <span
                                                    class="badge bg-secondary float-end">{{ $category->products_count ?? 0 }}</span>
                                            </a>
                                        </div>
                                        @if (count($category->children) > 0)
                                            <ul class="nested">
                                                @include('ams.partials.category-tree-items', [
                                                    'categories' => $category->children,
                                                ])
                                            </ul>
                                        @endif
                                    </li>
                                @endif
                            @endforeach
                        </ul>
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

                    <!-- Filters -->
                    <div class="card-body border-bottom">
                        <form action="{{ route('products.index') }}" method="GET" id="filterForm">
                            @if (request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label small">Search</label>
                                    <input type="text" name="search" class="form-control form-control-sm"
                                        placeholder="Search by name or item number" value="{{ request('search') }}">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label small">Stock Status</label>
                                    <select name="stock_status" class="form-select form-select-sm">
                                        <option value="">All Status</option>
                                        <option value="in_stock"
                                            {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                                        <option value="low_stock"
                                            {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Low Stock
                                        </option>
                                        <option value="out_of_stock"
                                            {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label small">Sort By</label>
                                    <select name="sort" class="form-select form-select-sm">
                                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest
                                            First</option>
                                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                            Price (Low to High)</option>
                                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                            Price (High to Low)</option>
                                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name
                                            (A-Z)</option>
                                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>
                                            Name (Z-A)</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label small">Per Page</label>
                                    <select name="per_page" class="form-select form-select-sm">
                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10
                                        </option>
                                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25
                                        </option>
                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50
                                        </option>
                                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="bi bi-funnel"></i> Apply Filters
                                        </button>
                                        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
                                            <i class="bi bi-x-circle"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
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
                                <tbody>
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

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted small">
                                @if ($products->total() > 0)
                                    Showing {{ $products->firstItem() }} to {{ $products->lastItem() }}
                                    of {{ $products->total() }} results
                                @endif
                            </div>
                            <div>
                                {{ $products->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
