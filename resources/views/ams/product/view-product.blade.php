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
                                            <td>{{ $product->familyCategory->family_category_name ?? ($product->subcategory->family_category_name ?? 'N/A') }}
                                            </td>
                                            <td>${{ number_format($product->price_per_unit, 2) }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $product->inventory && $product->inventory->in_stock_hq > 0 ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $product->inventory->in_stock_hq ?? 0 }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge {{ $product->inventory && $product->inventory->in_stock_warehouse > 0 ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $product->inventory->in_stock_warehouse ?? 0 }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('products.edit', $product->product_id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    @if (auth()->user()->level === 'God' || auth()->user()->level === 'Admin')
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            onclick="deleteProduct({{ $product->product_id }})">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>
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

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle category tree toggle
            document.querySelectorAll('.toggle-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const categoryItem = this.closest('.category-item');
                    const nestedList = categoryItem.querySelector('.nested');
                    const icon = this.querySelector('i');

                    if (nestedList) {
                        nestedList.classList.toggle('active');
                        icon.classList.toggle('bi-chevron-right');
                        icon.classList.toggle('bi-chevron-down');
                    }
                });
            });

            // Handle category click
            document.querySelectorAll('.category-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const categoryId = this.getAttribute('data-category-id');
                    loadProductsByCategory(categoryId);

                    // Update active state
                    document.querySelectorAll('.category-link').forEach(l => l.classList.remove(
                        'active'));
                    this.classList.add('active');
                });
            });
        });

        function loadProductsByCategory(categoryId) {
            // Show loading state
            const productsTable = document.querySelector('.table-responsive');
            if (productsTable) {
                productsTable.style.opacity = '0.5';
            }

            // Update hidden category input
            const categoryInput = document.querySelector('input[name="category"]');
            if (categoryInput) {
                categoryInput.value = categoryId;
            }

            // Make the AJAX request
            fetch(`/ams/products?category=${categoryId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => Promise.reject(err));
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.message || 'Failed to load products');
                    }

                    // Update the products table
                    const tableBody = document.querySelector('.table tbody');
                    if (tableBody && Array.isArray(data.products)) {
                        if (data.products.length === 0) {
                            tableBody.innerHTML =
                                '<tr><td colspan="5" class="text-center">No products found in this category</td></tr>';
                        } else {
                            tableBody.innerHTML = data.products.map(product => `
                    <tr>
                        <td>${product.item_no || ''}</td>
                        <td>${product.product_name || ''}</td>
                        <td>${product.family_category?.name || 'N/A'}</td>
                        <td>$${product.price || '0.00'}</td>
                        <td>
                            <span class="badge ${product.stock?.hq > 0 ? 'bg-success' : 'bg-danger'}">
                                ${product.stock?.hq || '0'}
                            </span>
                        </td>
                        <td>
                            <span class="badge ${product.stock?.warehouse > 0 ? 'bg-success' : 'bg-danger'}">
                                ${product.stock?.warehouse || '0'}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="/ams/products/${product.id}/edit" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteProduct(${product.id})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `).join('');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Show error message in the table
                    const tableBody = document.querySelector('.table tbody');
                    if (tableBody) {
                        tableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center text-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        ${error.message || 'Failed to load products. Please try again.'}
                    </td>
                </tr>
            `;
                    }
                })
                .finally(() => {
                    // Restore opacity
                    if (productsTable) {
                        productsTable.style.opacity = '1';
                    }
                });
        }

        // Delete product function
        function deleteProduct(productId) {
            if (!confirm('Are you sure you want to delete this product?')) {
                return;
            }

            fetch(`/ams/products/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => Promise.reject(err));
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Remove the row from the table
                        const row = document.querySelector(`button[onclick="deleteProduct(${productId})"]`).closest(
                            'tr');
                        row.remove();

                        // Show success message
                        alert('Product deleted successfully');
                    } else {
                        throw new Error(data.message || 'Failed to delete product');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message || 'Failed to delete product. Please try again.');
                });
        }

        // Add some CSS for the nested categories
        const style = document.createElement('style');
        style.textContent = `
    .category-tree {
        list-style: none;
        padding-left: 0;
    }
    .category-item {
        padding: 5px 0;
    }
    .nested {
        display: none;
        list-style: none;
        padding-left: 20px;
    }
    .nested.active {
        display: block;
    }
    .category-link {
        text-decoration: none;
        color: #333;
        flex-grow: 1;
        padding: 5px;
        cursor: pointer;
    }
    .category-link:hover {
        background-color: #f8f9fa;
    }
    .category-link.active {
        background-color: #e9ecef;
        font-weight: 500;
    }
    .toggle-btn {
        padding: 0;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: transparent;
        cursor: pointer;
    }
    .toggle-btn:hover {
        background-color: #f8f9fa;
        border-radius: 4px;
    }
    .btn-group {
        display: flex;
        gap: 5px;
    }
    .badge {
        font-size: 0.85em;
        padding: 0.35em 0.65em;
    }
`;
        document.head.appendChild(style);
    </script>
@endsection
