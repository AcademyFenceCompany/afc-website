@extends('layouts.ams')

@section('styles')
<style>
    .preview-image {
        max-width: 200px;
        max-height: 200px;
        margin-top: 10px;
    }
    .card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }
    .card-body {
        padding: 2rem;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #4e4c67;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Category Page</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('ams.cms.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="family_category_id" class="form-label">Category</label>
                            <select name="family_category_id" id="family_category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->family_category_id }}" 
                                        {{ $page->family_category_id == $category->family_category_id ? 'selected' : '' }}>
                                        {{ $category->family_category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="template" class="form-label">Template</label>
                            <select name="template" id="template" class="form-control" required>
                                <option value="standard" {{ $page->template == 'standard' ? 'selected' : '' }}>Standard Template</option>
                                <option value="welded_wire" {{ $page->template == 'welded_wire' ? 'selected' : '' }}>Welded Wire Template</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Header Section -->
                <h4>Header Section</h4>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" 
                                value="{{ $page->title }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="subtitle" class="form-label">Subtitle</label>
                            <input type="text" name="subtitle" id="subtitle" class="form-control" 
                                value="{{ $page->subtitle }}">
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="bulletin_board" class="form-label">Bulletin Board</label>
                            <textarea name="bulletin_board" id="bulletin_board" class="form-control tinymce">
                                {!! $page->bulletin_board !!}
                            </textarea>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product_image" class="form-label">Product Image</label>
                            <input type="file" name="product_image" id="product_image" class="form-control" accept="image/*">
                            @if($page->product_image)
                                <img src="{{ Storage::url($page->product_image) }}" class="preview-image" alt="Product Image">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product_text" class="form-label">Product Text</label>
                            <textarea name="product_text" id="product_text" class="form-control tinymce">
                                {!! $page->product_text !!}
                            </textarea>
                        </div>
                    </div>
                </div>

                <!-- Footer Section -->
                <h4>Footer Section</h4>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="category_tidbit_1" class="form-label">Category Tidbit 1</label>
                            <textarea name="category_tidbit_1" id="category_tidbit_1" class="form-control tinymce">
                                {!! $page->category_tidbit_1 !!}
                            </textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="category_tidbit_2" class="form-label">Category Tidbit 2</label>
                            <textarea name="category_tidbit_2" id="category_tidbit_2" class="form-control tinymce">
                                {!! $page->category_tidbit_2 !!}
                            </textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="category_tidbit_3" class="form-label">Category Tidbit 3</label>
                            <textarea name="category_tidbit_3" id="category_tidbit_3" class="form-control tinymce">
                                {!! $page->category_tidbit_3 !!}
                            </textarea>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="footer_subtitle" class="form-label">Footer Subtitle</label>
                            <input type="text" name="footer_subtitle" id="footer_subtitle" class="form-control" 
                                value="{{ $page->footer_subtitle }}">
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="footer_product_image" class="form-label">Footer Product Image</label>
                            <input type="file" name="footer_product_image" id="footer_product_image" class="form-control" accept="image/*">
                            @if($page->footer_product_image)
                                <img src="{{ Storage::url($page->footer_product_image) }}" class="preview-image" alt="Footer Product Image">
                            @endif
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Page</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.tiny.cloud/1/fqzaaogo06nq3byhp6e1ia5t3r29nvwitty5q04x54v9dgak/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '.tinymce',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        height: 300,
        image_class_list: [
            { title: 'Responsive', value: 'img-fluid' }
        ],
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
        },
        images_upload_url: '/ams/upload-image',
        automatic_uploads: true,
        images_reuse_filename: true,
        relative_urls: false,
        remove_script_host: false,
        convert_urls: true
    });
</script>
@endpush
