@extends('layouts.ams')

@section('title', 'Edit Product')

@section('content')
<div class="container mt-4">
    <h3>Edit Product: {{ $product->product_name }}</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
{{-- @dump($product) --}}
    <form method="POST" action="{{ route('ams.product-query.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="old_product_name" value="{{ $product->product_name }}">

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
                                <input type="text" name="product_name" value="{{ $product->product_name }}" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Item No*</label>
                                <input type="text" name="item_no" value="{{ $product->item_no }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">SEO Name</label>
                                <input type="text" name="seo_name" value="{{ $product->seo_name }}" class="form-control">
                                <small class="text-muted">Leave blank to auto-generate from product name</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category*</label>
                                <select name="categories_id" class="form-select" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $id => $name)
                                        <option value="{{ $id }}" {{ $id == $product->categories_id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Short Description</label>
                            <textarea name="desc_short" class="form-control" rows="2">{{ $product->desc_short }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Long Description</label>
                            <textarea name="desc_long" class="form-control" rows="4">{{ $product->desc_long }}</textarea>
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
                                <input type="text" name="color" value="{{ $product->color }}" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                @if($product->categories_id == 82)
                                <label class="form-label">Nominal Size</label>
                                <input type="text" name="size" value="{{ $product->size }}" class="form-control">
                                @else
                                <label class="form-label">Size</label>
                                <input type="text" name="size" value="{{ $product->size }}" class="form-control">
                                @endif
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Weight (lbs)</label>
                                <input type="number" step="0.01" name="weight_lbs" value="{{ $product->weight_lbs }}" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                @if($product->categories_id == 82)
                                <label class="form-label">Cap Opening</label>
                                <input type="text" name="size2" value="{{ $product->size2 }}" class="form-control">
                                @else
                                <label class="form-label">Size2</label>
                                <input type="text" name="size2" value="{{ $product->size2 }}" class="form-control">
                                @endif
                            </div>

                            <div class="col-md-4 mb-3">
                                @if($product->categories_id == 82)
                                <label class="form-label">Fits Post Size</label>
                                <input type="text" name="size3" value="{{ $product->size3 }}" class="form-control">
                                @else
                                <label class="form-label">Size3</label>
                                <input type="text" name="size3" value="{{ $product->size3 }}" class="form-control">
                                @endif
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Display Size</label>
                                <input type="text" name="display_size_2" value="{{ $product->display_size_2 }}" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Material</label>
                                <input type="text" name="material" value="{{ $product->material }}" class="form-control">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Style</label>
                                <input type="text" name="style" value="{{ $product->style }}" class="form-control">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Speciality</label>
                                <input type="text" name="speciality" value="{{ $product->speciality }}" class="form-control">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Spacing</label>
                                <input type="text" name="spacing" value="{{ $product->spacing }}" class="form-control">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Product Grouping Code</label>
                                <input type="text" name="parent" value="{{ $product->parent }}" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Coating</label>
                                <input type="text" name="coating" value="{{ $product->coating }}" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gauge</label>
                                <input type="number" step="0.01" name="gauge" value="{{ $product->gauge }}" class="form-control">
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
                                <input type="number" step="0.01" name="list" value="{{ $product->list }}" class="form-control">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Cost</label>
                                <input type="number" step="0.01" name="cost" value="{{ $product->cost }}" class="form-control">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Price*</label>
                                <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="form-control" required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Wholesale Price</label>
                                <input type="number" step="0.01" name="ws_price" value="{{ $product->ws_price }}" class="form-control">
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
                            <input type="number" name="ship_length" value="{{ $product->ship_length }}" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Shipping width</label>
                            <input type="number" name="ship_width" value="{{ $product->ship_width }}" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Shipping height</label>
                            <input type="number" name="ship_height" value="{{ $product->ship_height }}" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Amount Per Box</label>
                            <input type="number" name="amount_per_box" value="{{ $product->amount_per_box }}" class="form-control">
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
                            <input type="text" name="meta_title" value="{{ $product->meta_title }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="2">{{ $product->meta_description }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Keywords</label>
                            <textarea name="meta_keywords" class="form-control" rows="2">{{ $product->meta_keywords }}</textarea>
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
                                <option value="1" {{ $product->enabled ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ !$product->enabled ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Shippable</label>
                            <select name="shippable" class="form-select">
                                <option value="1" {{ $product->shippable ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ !$product->shippable ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Inventory Status</label>
                            <input type="text" value="{{ $product->inv_orange ?? 'N/A' }}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="card-header">
                        <h5 class="mb-0">Associated Products</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Necessary Associated Products</label>
                            <input type="text" value="{{ $product->product_assoc ?? 'N/A' }}" class="form-control" name="product_assoc">
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
                            @if ($product->img_small)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/products/' . $product->img_small) }}" class="img-thumbnail" style="max-width: 100%; max-height: 150px;">
                                    <button type="button" class="btn btn-sm btn-danger mt-1 delete-image" data-id="{{ $product->id }}" data-type="img_small">
                                        <i class="bi bi-trash"></i> Remove
                                    </button>
                                </div>
                            @endif
                            <input type="file" name="img_small" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Large Image</label>
                            @if ($product->img_large)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/products/' . $product->img_large) }}" class="img-thumbnail" style="max-width: 100%; max-height: 200px;">
                                    <button type="button" class="btn btn-sm btn-danger mt-1 delete-image" data-id="{{ $product->id }}" data-type="img_large">
                                        <i class="bi bi-trash"></i> Remove
                                    </button>
                                </div>
                            @endif
                            <input type="file" name="img_large" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mb-4">
            <div>
                <button type="submit" class="btn btn-primary">Update Product</button>
                <a href="{{ route('ams.product-query.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
            <div>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    Delete Product
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this product? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('ams.product-query.destroy', $product->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image deletion
        const deleteButtons = document.querySelectorAll('.delete-image');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const type = this.getAttribute('data-type');
                
                if (confirm('Are you sure you want to delete this image?')) {
                    fetch(`/ams/product-query/${id}/delete-image/${type}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove the image and button from the DOM
                            this.parentElement.remove();
                            alert('Image deleted successfully');
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the image');
                    });
                }
            });
        });
    });
</script>
@endsection
