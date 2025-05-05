@extends('layouts.ams')

@section('title', 'Product Search Results')

@section('content')
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Search Results</h5>
                    <a href="{{ route('ams.product-query.index') }}" class="btn btn-sm btn-light">Back to Categories</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('ams.product-query.search') }}" method="GET" id="product-search-form">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="q" placeholder="Search by ID, Item No, or Product Name" value="{{ $query }}">
                                    <button class="btn btn-outline-primary" type="submit">Search</button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="search_type" class="form-select">
                                    <option value="all" {{ $searchType == 'all' ? 'selected' : '' }}>All Fields</option>
                                    <option value="id" {{ $searchType == 'id' ? 'selected' : '' }}>Product ID</option>
                                    <option value="item_no" {{ $searchType == 'item_no' ? 'selected' : '' }}>Item Number</option>
                                    <option value="name" {{ $searchType == 'name' ? 'selected' : '' }}>Product Name</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Found {{ $products->total() }} products for "{{ $query }}"</h5>
                </div>
                <div class="card-body p-0">
                    @if($products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Item No</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Enabled</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td>
                                                @if($product->img_small)
                                                    <img src="{{ url('storage/products/' . $product->img_small) }}" 
                                                         alt="{{ $product->product_name }}" 
                                                         class="img-thumbnail" style="max-width: 50px;">
                                                @else
                                                    <div class="no-image text-center text-muted">No Image</div>
                                                @endif
                                            </td>
                                            <td>{{ $product->item_no }}</td>
                                            <td>{{ $product->product_name }}</td>
                                            <td>{{ $product->category_name ?? 'Uncategorized' }}</td>
                                            <td>${{ number_format($product->price, 2) }}</td>
                                            <td>
                                                <span class="badge {{ $product->web_enabled ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $product->web_enabled ? 'Yes' : 'No' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('ams.product-query.edit', $product->id) }}" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                <a href="{{ route('ams.product-query.duplicate', $product->id) }}" 
                                                   class="btn btn-sm btn-success">
                                                    <i class="bi bi-files"></i> Duplicate
                                                </a>
                                                <a href="{{ route('product.show', $product->id) }}" 
                                                   class="btn btn-sm btn-info" target="_blank">
                                                    <i class="bi bi-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="alert alert-info m-3">
                            No products found matching your search criteria.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .no-image {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        border-radius: 4px;
        font-size: 0.7rem;
    }
</style>
@endsection
