@extends('layouts.ams')

@section('title', 'Edit AFC Major Category')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <h2>Edit AFC Major Category</h2>
        <p class="text-muted">Update major category information in the academyfence database</p>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('ams.mysql-majorcategories.update', $majorCategory->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="cat_name" class="form-label">Category Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('cat_name') is-invalid @enderror" id="cat_name" name="cat_name" value="{{ old('cat_name', $majorCategory->cat_name) }}" required>
                    @error('cat_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="cat_desc" class="form-label">Description</label>
                    <textarea class="form-control @error('cat_desc') is-invalid @enderror" id="cat_desc" name="cat_desc" rows="4">{{ old('cat_desc', $majorCategory->cat_desc) }}</textarea>
                    @error('cat_desc')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="enabled" name="enabled" value="1" {{ old('enabled', $majorCategory->enabled) ? 'checked' : '' }}>
                    <label class="form-check-label" for="enabled">Show on Website</label>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('ams.mysql-majorcategories.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Major Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
