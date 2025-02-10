@extends('layouts.ams')

@section('title', 'Categories')

@section('content')

<div class="container">

    <div class="row add_product__title">
        <h2>CATEGORY MANAGEMENT</h2>
    </div>

    <!-- Top Buttons -->
    <div class="row d-flex align-items-center justify-content-between">
        <div class="col-md-4">
            <button class="btn btn-light">
                <i class="fa-light fa-plus"></i> Create New Category
            </button>
        </div>
        <div class="col-md-8 d-flex align-items-center justify-content-end gap-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="selectAll">
                <label class="form-check-label" for="selectAll">Select all</label>
            </div>
            <button class="btn btn-light">Save</button>
            <button class="btn btn-light">
                <i class="fa-solid fa-trash-can"></i> Delete
            </button>
        </div>
    </div>

    <!-- Category List -->
    <div class="card">
        <div class="category-list">
            @foreach ($categories as $category)
                <div class="category-item">
                    <div class="category-header d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-chevron-down toggle-icon" data-bs-toggle="collapse"
                                data-bs-target="#collapse-{{ $loop->index }}"></i>
                            <span data-bs-toggle="collapse"
                                data-bs-target="#collapse-{{ $loop->index }}">{{ $category->family_category_name }}</span>
                            <i class="fa-regular fa-pen-to-square"></i>
                        </div>
                        <div class="category-actions d-flex align-items-center gap-2">
                            <input class="form-check-input" type="checkbox">
                            <button class="btn btn-sm btn-light"><i class="fa-light fa-plus"></i> Add Sub</button>
                            <i class="fa-solid fa-arrows-up-down"></i>
                            <button class="btn btn-sm btn-light"><i class="fa-regular fa-copy"></i> Copy</button>
                            <button class="btn btn-sm btn-light"><i class="fa-solid fa-trash-can"></i> Delete</button>
                        </div>
                    </div>

                    <div class="collapse" id="collapse-{{ $loop->index }}">
                        @if (collect($category->children)->isNotEmpty())
                            <div class="subcategory-list ps-4">
                                @foreach ($category->children as $child)
                                    <div class="subcategory-item">
                                        <div class="subcategory-header d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="fa-solid fa-chevron-down toggle-icon" data-bs-toggle="collapse"
                                                    data-bs-target="#subcollapse-{{ $loop->parent->index }}-{{ $loop->index }}"></i>
                                                <span>{{ $child->family_category_name }}</span>
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </div>
                                            <div class="subcategory-actions d-flex align-items-center gap-2">
                                                <input class="form-check-input" type="checkbox">
                                                <button class="btn btn-sm btn-light"><i class="fa-light fa-plus"></i> Add
                                                    Sub</button>
                                                <i class="fa-solid fa-arrows-up-down"></i>
                                                <button class="btn btn-sm btn-light"><i class="fa-regular fa-copy"></i>
                                                    Copy</button>
                                                <button class="btn btn-sm btn-light"><i class="fa-solid fa-trash-can"></i>
                                                    Delete</button>
                                            </div>
                                        </div>

                                        <div class="collapse ps-4" id="subcollapse-{{ $loop->parent->index }}-{{ $loop->index }}">
                                            @if (collect($child->children)->isNotEmpty())
                                                <div class="sub-subcategory-list ps-4">
                                                    @foreach ($child->children as $subChild)
                                                        <div class="sub-subcategory-item">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <i class="fa-solid fa-chevron-down toggle-icon"
                                                                        data-bs-toggle="collapse"
                                                                        data-bs-target="#subsubcollapse-{{ $loop->parent->parent->index }}-{{ $loop->parent->index }}-{{ $loop->index }}"></i>
                                                                    <span>{{ $subChild->family_category_name }}</span>
                                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                                </div>
                                                                <div class="sub-subcategory-actions d-flex align-items-center gap-2">
                                                                    <input class="form-check-input" type="checkbox">
                                                                    <button class="btn btn-sm btn-light"><i class="fa-light fa-plus"></i>
                                                                        Add
                                                                        Sub</button>
                                                                    <i class="fa-solid fa-arrows-up-down"></i>
                                                                    <button class="btn btn-sm btn-light"><i class="fa-regular fa-copy"></i>
                                                                        Copy</button>
                                                                    <button class="btn btn-sm btn-light"><i
                                                                            class="fa-solid fa-trash-can"></i>
                                                                        Delete</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection