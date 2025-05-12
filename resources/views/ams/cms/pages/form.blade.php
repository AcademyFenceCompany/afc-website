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
    .form-control {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 0.75rem;
    }
    .form-control:focus {
        border-color: #4e4c67;
        box-shadow: 0 0 0 0.2rem rgba(78, 76, 103, 0.25);
    }
    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }
    .btn-primary {
        background-color: #4e4c67;
        border-color: #4e4c67;
        padding: 0.75rem 2rem;
        font-weight: 500;
    }
    .btn-primary:hover {
        background-color: #3d3b52;
        border-color: #3d3b52;
    }
    h4 {
        color: #4e4c67;
        margin: 2rem 0 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #eee;
        font-weight: 600;
    }
    h4:first-of-type {
        margin-top: 0;
    }
    select.form-control {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1em;
        padding-right: 2.5rem;
    }
    .form-control[type="file"] {
        padding: 0.5rem;
        line-height: 1.5;
    }
    .preview-image {
        border-radius: 4px;
        border: 1px solid #ddd;
        padding: 0.25rem;
        margin-top: 1rem;
    }
</style>
@endsection

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-body">
<<<<<<< HEAD
            <form action="{{ isset($page) ? route('ams.cms.pages.update', $page) : route('ams.cms.pages.store') }}" 
=======
            <form action="{{ isset($page) ? route('ams.cms.pages.update', $page->id) : route('ams.cms.pages.store') }}" 
>>>>>>> origin/ready-push-main
                  method="POST" 
                  enctype="multipart/form-data"
                  class="needs-validation"
                  novalidate>
                @csrf
                @if(isset($page))
                    @method('PUT')
                @endif

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="family_category_id" class="form-label">Category</label>
                            <select name="family_category_id" id="family_category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
<<<<<<< HEAD
                                    <option value="{{ $category->family_category_id }}" 
                                        {{ (isset($page) && $page->family_category_id == $category->family_category_id) ? 'selected' : '' }}>
                                        {{ $category->family_category_name }}
=======
                                    <option value="{{ $category->id }}" 
                                        {{ (isset($page) && $page->family_category_id == $category->id) ? 'selected' : '' }}>
                                        {{ $category->cat_name }}
>>>>>>> origin/ready-push-main
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Please select a category.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="template" class="form-label">Template</label>
                            <select name="template" id="template" class="form-control" required>
                                <option value="standard" {{ (isset($page) && $page->template == 'standard') ? 'selected' : '' }}>Standard Template</option>
                                <option value="welded_wire" {{ (isset($page) && $page->template == 'welded_wire') ? 'selected' : '' }}>Welded Wire Template</option>
                                <option value="razor_wire" {{ (isset($page) && $page->template == 'razor_wire') ? 'selected' : '' }}>Razor Wire Template</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a template.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menu Settings -->
                <h4>Menu Settings</h4>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="menu_type" class="form-label">Menu Location</label>
                            <select name="menu_type" id="menu_type" class="form-control">
                                <option value="">Not in Menu</option>
                                <option value="main_menu" {{ (isset($page) && $page->menu_type == 'main_menu') ? 'selected' : '' }}>Main Menu</option>
                                <option value="quick_menu" {{ (isset($page) && $page->menu_type == 'quick_menu') ? 'selected' : '' }}>Quick Menu</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="menu_order" class="form-label">Menu Order</label>
                            <input type="number" name="menu_order" id="menu_order" class="form-control"
                                value="{{ isset($page) ? $page->menu_order : old('menu_order', 0) }}"
                                min="0" placeholder="Enter menu order (0 = first)">
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
                                value="{{ isset($page) ? $page->title : old('title') }}"
                                placeholder="Enter title">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="subtitle" class="form-label">Subtitle</label>
                            <input type="text" name="subtitle" id="subtitle" class="form-control" 
                                value="{{ isset($page) ? $page->subtitle : old('subtitle') }}"
                                placeholder="Enter subtitle">
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="bulletin_board" class="form-label">Bulletin Board</label>
                            <textarea name="bulletin_board" id="bulletin_board" class="form-control" 
                                rows="4" placeholder="Enter bulletin board content">{{ isset($page) ? $page->bulletin_board : old('bulletin_board') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product_image" class="form-label">Product Image</label>
                            <input type="file" name="product_image" id="product_image" class="form-control" accept="image/*">
                            @if(isset($page) && $page->product_image)
                                <img src="{{ Storage::url($page->product_image) }}" class="preview-image" alt="Product Image">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product_text" class="form-label">Product Text</label>
                            <textarea name="product_text" id="product_text" class="form-control" 
                                rows="4" placeholder="Enter product text">{{ isset($page) ? $page->product_text : old('product_text') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Footer Section -->
                <h4>Footer Section</h4>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="category_tidbit_1" class="form-label">Category Tidbit 1</label>
                            <textarea name="category_tidbit_1" id="category_tidbit_1" class="form-control" 
                                rows="3" placeholder="Enter tidbit content">{{ isset($page) ? $page->category_tidbit_1 : old('category_tidbit_1') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="category_tidbit_2" class="form-label">Category Tidbit 2</label>
                            <textarea name="category_tidbit_2" id="category_tidbit_2" class="form-control" 
                                rows="3" placeholder="Enter tidbit content">{{ isset($page) ? $page->category_tidbit_2 : old('category_tidbit_2') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="category_tidbit_3" class="form-label">Category Tidbit 3</label>
                            <textarea name="category_tidbit_3" id="category_tidbit_3" class="form-control" 
                                rows="3" placeholder="Enter tidbit content">{{ isset($page) ? $page->category_tidbit_3 : old('category_tidbit_3') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="footer_subtitle" class="form-label">Footer Subtitle</label>
                            <input type="text" name="footer_subtitle" id="footer_subtitle" class="form-control" 
                                value="{{ isset($page) ? $page->footer_subtitle : old('footer_subtitle') }}"
                                placeholder="Enter footer subtitle">
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="footer_bulletin_board" class="form-label">Footer Bulletin Board</label>
                            <textarea name="footer_bulletin_board" id="footer_bulletin_board" class="form-control" 
                                rows="4" placeholder="Enter footer bulletin board content">{{ isset($page) ? $page->footer_bulletin_board : old('footer_bulletin_board') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="footer_product_image" class="form-label">Footer Product Image</label>
                            <input type="file" name="footer_product_image" id="footer_product_image" class="form-control" accept="image/*">
                            @if(isset($page) && $page->footer_product_image)
                                <img src="{{ Storage::url($page->footer_product_image) }}" class="preview-image" alt="Footer Product Image">
                            @endif
                        </div>
<<<<<<< HEAD
=======
                    
>>>>>>> origin/ready-push-main
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="footer_product_text" class="form-label">Footer Product Text</label>
                            <textarea name="footer_product_text" id="footer_product_text" class="form-control" 
                                rows="4" placeholder="Enter footer product text">{{ isset($page) ? $page->footer_product_text : old('footer_product_text') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            {{ isset($page) ? 'Update' : 'Create' }} Category Page
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
// Enable Bootstrap form validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
</script>
@endsection
