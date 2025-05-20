@extends('layouts.ams')

@section('title', 'Add New Product')

@section('content')
<div class="container mt-4">
    <h3>Add New Product</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('ams.product-query.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Product Name*</label>
                                <input type="text" name="product_name" value="{{ old('product_name') }}" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Item No*</label>
                                <input type="text" name="item_no" value="{{ old('item_no') }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">SEO Name</label>
                                <input type="text" name="seo_name" value="{{ old('seo_name') }}" class="form-control">
                                <small class="text-muted">Leave blank to auto-generate from product name</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category*</label>
                                <select name="categories_id" class="form-select" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $id => $name)
                                        <option value="{{ $id }}" {{ old('categories_id') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Short Description</label>
                            <textarea name="desc_short" class="form-control" rows="2">{{ old('desc_short') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Long Description</label>
                            <textarea name="desc_long" class="form-control" rows="4">{{ old('desc_long') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Product Specifications</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Color</label>
                                <input type="text" name="color" value="{{ old('color') }}" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Size</label>
                                <input type="text" name="size" value="{{ old('size') }}" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Weight (lbs)</label>
                                <input type="number" step="0.01" name="weight_lbs" value="{{ old('weight_lbs') }}" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Size2</label>
                                <input type="text" name="size2" value="{{ old('size2') }}" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Size3</label>
                                <input type="text" name="size3" value="{{ old('size3') }}" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Display Size</label>
                                <input type="text" name="display_size_2" value="{{ old('display_size_2') }}" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Material</label>
                                <input type="text" name="material" value="{{ old('material') }}" class="form-control">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Style</label>
                                <input type="text" name="style" value="{{ old('style') }}" class="form-control">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Speciality</label>
                                <input type="text" name="speciality" value="{{ old('speciality') }}" class="form-control">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Spacing</label>
                                <input type="text" name="spacing" value="{{ old('spacing') }}" class="form-control">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Product Grouping Code</label>
                                <input type="text" name="parent" value="{{ old('parent') }}" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Coating</label>
                                <input type="text" name="coating" value="{{ old('coating') }}" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gauge</label>
                                <input type="number" step="0.01" name="gauge" value="{{ old('gauge') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Pricing Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">List Price</label>
                                <input type="number" step="0.01" name="list" value="{{ old('list') }}" class="form-control">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Cost</label>
                                <input type="number" step="0.01" name="cost" value="{{ old('cost') }}" class="form-control">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Price*</label>
                                <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="form-control" required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Wholesale Price</label>
                                <input type="number" step="0.01" name="ws_price" value="{{ old('ws_price') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Shipping Information</h5>
                    </div>
                    <div class="card-body row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Shipping Length</label>
                            <input type="number" name="ship_length" value="{{ old('ship_length') }}" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Shipping width</label>
                            <input type="number" name="ship_width" value="{{ old('ship_width') }}" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Shipping height</label>
                            <input type="number" name="ship_height" value="{{ old('ship_height') }}" class="form-control">
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Amount Per Box</label>
                            <input type="number" name="amount_per_box" value="{{ old('amount_per_box') }}" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">SEO Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" value="{{ old('meta_title') }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Keywords</label>
                            <textarea name="meta_keywords" class="form-control" rows="2">{{ old('meta_keywords') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Product Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Web Enabled</label>
                            <select name="enabled" class="form-select">
                                <option value="1" {{ old('enabled', '1') == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('enabled') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Shippable</label>
                            <select name="shippable" class="form-select">
                                <option value="1" {{ old('shippable', '1') == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('shippable') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Inventory Status</label>
                            <input type="text" value="N/A" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="card-header">
                        <h5 class="mb-0">Associated Products</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Necessary Associated Products</label>
                            <input type="text" name="product_assoc" value="{{ old('product_assoc') }}" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Product Images</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Small Image</label>
                            <input type="file" name="img_small" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Large Image</label>
                            <input type="file" name="img_large" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <button type="submit" class="btn btn-primary">Create Product</button>
            <a href="{{ route('ams.product-query.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
