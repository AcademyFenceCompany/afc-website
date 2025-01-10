{{-- <pre>{{ dd($products) }}</pre> --}}
@extends('layouts.ams')

@section('title', 'Products')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Products</h3>
                @if (auth()->user()->level === 'God' || auth()->user()->level === 'Admin')
                    <a href="{{ route('products.create') }}" class="btn btn-primary">Add New Product</a>
                @endif
            </div>
            <div class="card-body">
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Search & Filters</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('products.index') }}" method="GET" id="filterForm">
                            <div class="row g-3">
                                <!-- Left Column -->
                                <div class="col-md-8">
                                    <div class="row g-2">
                                        <!-- Search -->
                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                                <input type="text" name="search" class="form-control"
                                                    placeholder="Search by product name, item number or description"
                                                    value="{{ request('search') }}">
                                            </div>
                                        </div>

                                        <!-- Category and Stock Status -->
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label small">Category</label>
                                            <select name="category" class="form-select form-select-sm">
                                                <option value="">All Categories</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->family_category_id }}"
                                                        {{ request('category') == $category->family_category_id ? 'selected' : '' }}>
                                                        {{ $category->family_category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <label class="form-label small">Stock Status</label>
                                            <select name="stock_status" class="form-select form-select-sm">
                                                <option value="">All Stock Status</option>
                                                <option value="in_stock"
                                                    {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>In Stock
                                                </option>
                                                <option value="low_stock"
                                                    {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Low Stock
                                                </option>
                                                <option value="out_of_stock"
                                                    {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Out of
                                                    Stock</option>
                                            </select>
                                        </div>

                                        <!-- Price Range -->
                                        <div class="col-md-12">
                                            <label class="form-label small">Price Range</label>
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">$</span>
                                                        <input type="number" name="price_min" class="form-control"
                                                            placeholder="Min" step="0.01"
                                                            value="{{ request('price_min') }}">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">$</span>
                                                        <input type="number" name="price_max" class="form-control"
                                                            placeholder="Max" step="0.01"
                                                            value="{{ request('price_max') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-4">
                                    <div class="row g-2">
                                        <!-- Sort and Per Page Options -->
                                        <div class="col-12 mb-2">
                                            <label class="form-label small">Sort By</label>
                                            <select name="sort" class="form-select form-select-sm">
                                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                                                    Newest First</option>
                                                <option value="price_asc"
                                                    {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price (Low to
                                                    High)</option>
                                                <option value="price_desc"
                                                    {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price (High to
                                                    Low)</option>
                                                <option value="name_asc"
                                                    {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)
                                                </option>
                                                <option value="name_desc"
                                                    {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-12 mb-2">
                                            <label class="form-label small">Items Per Page</label>
                                            <select name="per_page" class="form-select form-select-sm">
                                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10
                                                    per page</option>
                                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25
                                                    per page</option>
                                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50
                                                    per page</option>
                                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>
                                                    100 per page</option>
                                            </select>
                                        </div>

                                        <!-- Filter Buttons -->
                                        <div class="col-12">
                                            <div class="d-grid gap-2">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="bi bi-funnel"></i> Apply Filters
                                                </button>
                                                <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
                                                    <i class="bi bi-x-circle"></i> Reset Filters
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Results Count -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="text-muted small">
                        @if ($products->total() > 0)
                            Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of
                            {{ $products->total() }} results
                        @else
                            No results found
                        @endif
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
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
                                    <!-- Add this debug line temporarily -->
                                    @php
                                        \Log::info('Product data:', [
                                            'product_id' => $product->product_id,
                                            'has_inventory' => $product->inventory ? 'yes' : 'no',
                                            'has_category' => $product->familyCategory ? 'yes' : 'no',
                                            'raw_product' => $product->toArray(),
                                        ]);
                                    @endphp
                                    <td>{{ $product->item_no }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->familyCategory->family_category_name ?? 'N/A' }}</td>
                                    <td>${{ number_format($product->price_per_unit, 2) }}</td>
                                    <td>{{ $product->inventory->in_stock_hq ?? 0 }}</td>
                                    <td>{{ $product->inventory->in_stock_warehouse ?? 0 }}</td>
                                    <td>
                                        @if (auth()->user()->level === 'God' || auth()->user()->level === 'Admin')
                                            <a href="{{ route('products.edit', $product->product_id) }}"
                                                class="btn btn-sm btn-primary">
                                                Edit
                                            </a>
                                            {{-- <form action="{{ route('products.destroy', $product->product_id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this product?')">
                                                    Delete
                                                </button>
                                            </form> --}}
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No products found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        @if ($products->total() > 0)
                            Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of
                            {{ $products->total() }} results
                        @endif
                    </div>
                    <div>
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
