@extends('layouts.ams')

@section('title', 'Edit Product')

@section('content')
<div class="container mt-4">
    <h3>Edit Product: {{ $product->product_name }}</h3>
    <form method="POST" action="{{ route('ams.product-query.update', $product->id) }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input type="text" name="product_name" value="{{ $product->product_name }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Item No</label>
            <input type="text" name="item_no" value="{{ $product->item_no }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Web Enabled</label>
            <select name="web_enabled" class="form-select">
                <option value="1" {{ $product->web_enabled ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ !$product->web_enabled ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Short Description</label>
            <textarea name="desc_short" class="form-control">{{ $product->desc_short }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="categories_id" class="form-select">
                @foreach ($categories as $id => $name)
                    <option value="{{ $id }}" {{ $id == $product->category_id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Small Image</label><br>
            @if ($product->img_small)
                <img src="{{ asset('storage/products/' . $product->img_small) }}" width="80" class="mb-2"><br>
            @endif
            <input type="file" name="img_small" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Large Image</label><br>
            @if ($product->img_large)
                <img src="{{ asset('storage/products/' . $product->img_large) }}" width="80" class="mb-2"><br>
            @endif
            <input type="file" name="img_large" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="{{ route('ams.product-query.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
