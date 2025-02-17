@extends('layouts.ams')

@section('title', 'Activity')

@section('content')

<div class="container">
    <!-- Page Title -->
    <div class="row add_product__title text-center">
        <h2>ADD NEW CATEGORY</h2>
    </div>

    <div class="row justify-content-md-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">Add New Category</div>
                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="category_name" class="form-label">Category Name</label>
                                <input type="text" id="category_name" name="category_name" class="form-control"
                                    placeholder="Type category name..." required>
                            </div>
                            <div class="col-md-6">
                                <label for="category_url" class="form-label">URL Name</label>
                                <input type="text" id="category_url" name="category_url" class="form-control"
                                    placeholder="Type URL name...">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="category_meta_title" class="form-label">Category Meta Title</label>
                                <input type="text" id="category_meta_title" name="category_meta_title"
                                    class="form-control" placeholder="Type Category Meta Title..." required>
                            </div>
                            <div class="col-md-6">
                                <label for="category_meta_keywords" class="form-label">Category Meta Keywords</label>
                                <input type="text" id="category_meta_keywords" name="category_meta_keywords"
                                    class="form-control" placeholder="Type Category Meta Keywords...">
                            </div>
                        </div>

                        <!-- Category Meta Description -->
                        <div class="row">
                            <div class="card__input">
                                <label for="category_meta_description" class="form-label">Category Meta
                                    Description</label>

                                <textarea name="category_meta_description" id="category_meta_description"
                                    class="form-control" rows="3"
                                    placeholder="Type Category Meta Description..."></textarea>
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
