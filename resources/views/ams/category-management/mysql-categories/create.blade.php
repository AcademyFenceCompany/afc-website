@extends('layouts.ams')

@section('title', 'AFC Category Management')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <h2>Create New AFC Category</h2>
        <p class="text-muted">Add a new category to the academyfence database</p>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('ams.mysql-categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label for="cat_name" class="form-label">Category Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('cat_name') is-invalid @enderror" id="cat_name" name="cat_name" value="{{ old('cat_name') }}" required>
                    @error('cat_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="seo_name" class="form-label">SEO Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('seo_name') is-invalid @enderror" id="seo_name" name="seo_name" value="{{ old('seo_name') }}" required>
                    <small class="text-muted">URL-friendly version of the category name (no spaces, lowercase)</small>
                    @error('seo_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="majorcategories_id" class="form-label">Major Category <span class="text-danger">*</span></label>
                    <select class="form-select @error('majorcategories_id') is-invalid @enderror" id="majorcategories_id" name="majorcategories_id" required>
                        <option value="">Select Major Category</option>
                        @foreach($majorCategories as $majorCategory)
                            <option value="{{ $majorCategory->id }}" {{ old('majorcategories_id') == $majorCategory->id ? 'selected' : '' }}>
                                {{ $majorCategory->cat_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('majorcategories_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="cat_desc_short" class="form-label">Short Description</label>
                    <textarea class="form-control @error('cat_desc_short') is-invalid @enderror" id="cat_desc_short" name="cat_desc_short" rows="2">{{ old('cat_desc_short') }}</textarea>
                    @error('cat_desc_short')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="cat_desc_long" class="form-label">Long Description</label>
                    <textarea class="form-control @error('cat_desc_long') is-invalid @enderror" id="cat_desc_long" name="cat_desc_long" rows="5">{{ old('cat_desc_long') }}</textarea>
                    @error('cat_desc_long')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="image" class="form-label">Category Image</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Upload an image for this category</small>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="web_enabled" name="web_enabled" value="1" {{ old('web_enabled') ? 'checked' : '' }}>
                    <label class="form-check-label" for="web_enabled">Show on Website</label>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('ams.mysql-categories.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-generate SEO name from category name
    document.getElementById('cat_name').addEventListener('input', function() {
        const seoName = this.value.toLowerCase().replace(/[^a-z0-9]/g, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
        document.getElementById('seo_name').value = seoName;
    });
</script>
@endsection
