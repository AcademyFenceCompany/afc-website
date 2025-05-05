@extends('layouts.ams')

@section('title', 'Product Query')

@section('content')
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Product Management</h5>
                    <a href="{{ route('ams.product-query.create') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-plus-circle"></i> Add New Product
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('ams.product-query.search') }}" method="GET" id="product-search-form">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="q" placeholder="Search by ID, Item No, or Product Name" value="{{ request('q') }}">
                                    <button class="btn btn-outline-primary" type="submit">Search</button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="search_type" class="form-select">
                                    <option value="all" {{ request('search_type') == 'all' ? 'selected' : '' }}>All Fields</option>
                                    <option value="id" {{ request('search_type') == 'id' ? 'selected' : '' }}>Product ID</option>
                                    <option value="item_no" {{ request('search_type') == 'item_no' ? 'selected' : '' }}>Item Number</option>
                                    <option value="name" {{ request('search_type') == 'name' ? 'selected' : '' }}>Product Name</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Categories</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="category-tree">
                        @foreach ($productTree as $major => $categories)
                            <li class="category-item">
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-sm btn-link toggle-btn" type="button">
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                                    <span class="category-link fw-bold">{{ $major }}</span>
                                </div>
                                <ul class="nested ps-3">
                                    @foreach ($categories as $catName => $group)
                                        <li>
                                            <a href="javascript:void(0);" class="subcategory-link d-block py-1 px-2"
                                               data-cat-id="{{ $group['category_id'] }}">
                                                {{ $catName }}
                                                <span class="badge bg-secondary float-end">{{ $group['paginator']->total() }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Product Display -->
        <div class="col-md-9" id="product-panel">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Select a category to see products</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">No category selected.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Toggle category tree items
        document.querySelectorAll('.toggle-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const nested = btn.closest('li').querySelector('.nested');
                const icon = btn.querySelector('i');
                nested.classList.toggle('active');
                icon.classList.toggle('bi-chevron-right');
                icon.classList.toggle('bi-chevron-down');
            });
        });

        // Load category products
        document.querySelectorAll('.subcategory-link').forEach(link => {
            link.addEventListener('click', () => {
                const catId = link.getAttribute('data-cat-id');
                loadCategoryProducts(catId);
            });
        });
        
        // Handle pagination clicks using event delegation
        document.getElementById('product-panel').addEventListener('click', function(e) {
            // Check if the clicked element is a pagination link
            if (e.target.tagName === 'A' && e.target.closest('.pagination')) {
                e.preventDefault();
                
                // Get the URL from the pagination link
                const url = e.target.getAttribute('href');
                if (!url) return;
                
                // Fetch the content via AJAX
                fetch(url)
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('product-panel').innerHTML = html;
                    })
                    .catch(err => {
                        console.error(err);
                        alert("Failed to load products.");
                    });
            }
        });
        
        // Function to load category products
        function loadCategoryProducts(catId, page = 1) {
            const url = `/ams/product-query/category/${catId}${page > 1 ? '?page=' + page : ''}`;
            fetch(url)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('product-panel').innerHTML = html;
                })
                .catch(err => {
                    console.error(err);
                    alert("Failed to load products.");
                });
        }
    });
</script>
@endsection

@section('styles')
<style>
    .category-tree, .nested { list-style: none; padding-left: 0; }
    .nested { display: none; margin-top: 5px; }
    .nested.active { display: block; }
    .toggle-btn { padding: 0 5px; border: none; background: transparent; cursor: pointer; }
    .category-link, .subcategory-link {
        cursor: pointer;
        display: block;
        padding: 4px 8px;
        text-decoration: none;
    }
    .subcategory-link:hover {
        background: #f0f0f0;
    }
</style>
@endsection
