@extends('layouts.ams')

@section('title', 'Create AFC Major Category')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <h2>Create New AFC Major Category</h2>
        <p class="text-muted">Add a new major category to the academyfence database</p>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('ams.mysql-majorcategories.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="cat_name" class="form-label">Category Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('cat_name') is-invalid @enderror" id="cat_name" name="cat_name" value="{{ old('cat_name') }}" required>
                    @error('cat_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="cat_desc" class="form-label">Description</label>
                    <textarea class="form-control @error('cat_desc') is-invalid @enderror" id="cat_desc" name="cat_desc" rows="4">{{ old('cat_desc') }}</textarea>
                    @error('cat_desc')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="enabled" name="enabled" value="1" {{ old('enabled') ? 'checked' : '' }}>
                    <label class="form-check-label" for="enabled">Show on Website</label>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('ams.mysql-majorcategories.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Major Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
