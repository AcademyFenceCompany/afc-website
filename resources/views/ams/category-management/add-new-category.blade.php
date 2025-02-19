@extends('layouts.ams')

@section('title', 'Add New Category')

@section('content')

<div class="container">
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

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Category Creation Form -->
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf <!-- CSRF protection -->

                        <div class="row mb-3">
                            <!-- Category Name -->
                            <div class="col-md-6">
                                <label for="family_category_name" class="form-label">Category Name</label>
                                <input type="text" id="family_category_name" name="family_category_name"
                                    class="form-control" placeholder="Enter category name..." required>
                            </div>

                            <!-- Category Description -->
                            <div class="col-md-6">
                                <label for="category_description" class="form-label">Category Description</label>
                                <input type="text" id="category_description" name="category_description"
                                    class="form-control" placeholder="Enter category description...">
                            </div>
                        </div>

                        <!-- Parent Category Selection -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="parent_category_id" class="form-label">Parent Category (Optional)</label>
                                <select id="parent_category_id" name="parent_category_id" class="form-control">
                                    <option value="">None</option>
                                    @foreach ($familyCategories as $familyCategory)
                                        <option value="{{ $familyCategory->family_category_id }}">
                                            {{ $familyCategory->family_category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Submit & Cancel Buttons -->
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('categories.create') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection