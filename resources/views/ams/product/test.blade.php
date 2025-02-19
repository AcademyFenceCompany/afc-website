
    

    <!-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif -->

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="family_category_id" class="form-label">Category ID</label>
            <input type="number" class="form-control" name="family_category_id" required>
        </div>

        <div class="mb-3">
            <label for="family_category_name" class="form-label">Category Name</label>
            <input type="text" class="form-control" name="family_category_name" required>
        </div>

        <div class="mb-3">
            <label for="parent_category_id" class="form-label">Parent Category ID (Optional)</label>
            <input type="number" class="form-control" name="parent_category_id">
        </div>

        <div class="mb-3">
            <label for="category_description" class="form-label">Category Description</label>
            <textarea class="form-control" name="category_description"></textarea>
        </div>

        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" name="product_name" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" class="form-control" name="price" required>
        </div>

        <div class="mb-3">
            <label for="stock_quantity" class="form-label">Stock Quantity</label>
            <input type="number" class="form-control" name="stock_quantity" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Product</button>
    </form>
</div>
@endsection





@extends('layouts.ams')

@section('title', 'Activity')

@section('content')

<div class="container">
    <!-- Page Title -->
    <div class="row add_product__title text-center">
        <h2>CREATE NEW CATEGORY</h2>
    </div>

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-md-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">Add New Category</div>
                <div class="card-body">

                    <!-- Display Success Message -->
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Category Creation Form -->
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf  <!-- CSRF protection for security -->

                        <!-- Category Selection Fields -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="family_category_id" class="form-label">Family Category</label>
                                <select id="family_category_id" name="family_category_id" class="form-control" required>
                                    <option value="">Select Family Category</option>
                                    @foreach ($familyCategories as $familyCategory)
                                        <option value="{{ $familyCategory->family_category_id }}">{{ $familyCategory->family_category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="parent_category_id" class="form-label">Parent Category (Optional)</label>
                                <select id="parent_category_id" name="parent_category_id" class="form-control">
                                    <option value="">None</option>
                                    @foreach ($familyCategories as $familyCategory)
                                        <option value="{{ $familyCategory->family_category_id }}">{{ $familyCategory->family_category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Category Name & Description Fields -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="category_name" class="form-label">Category Name</label>
                                <input type="text" id="category_name" name="family_category_name" class="form-control"
                                    placeholder="Type category name..." required>
                            </div>
                            <div class="col-md-6">
                                <label for="category_description" class="form-label">Category Description</label>
                                <input type="text" id="category_description" name="category_description" class="form-control"
                                    placeholder="Type category description...">
                            </div>
                        </div>

                        <!-- Submit & Cancel Buttons -->
                        <div class="text-center mt-4 button-group">
                            <button type="submit" class="btn add-shipper-btn">Save</button>
                            <button type="button" class="btn cancel-btn">Cancel</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
