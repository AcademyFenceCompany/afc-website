@extends('layouts.ams')

@section('title', 'Categories')

@section('content')

<div class="container">
    <div class="row add_product__title">
        <h2>CATEGORY MANAGEMENT</h2>
    </div>

    <!-- Top Buttons -->
    <div class="row d-flex align-items-center justify-content-between mb-3">

   

        <div class="col-md-4">
        <a href="{{ route('categories.create') }}" class="btn btn-light">
   <i class="fa-solid fa-plus"></i> Add New Category
</a>
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
    <div class="card ">
        <div class="category-list">
            @foreach ($categories as $category)
                <div class="category-item">
                    <div class="category-header d-flex align-items-center justify-content-between p-2 {{ $loop->index % 2 == 0 ? 'bg-light' :  'bg-white' }}">
                        <div class="d-flex align-items-center gap-2">
                            @if(collect($category->children)->isNotEmpty())
                                <i class="fa-solid fa-chevron-down toggle-icon" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-{{ $loop->index }}"></i>
                            @endif
                            <span class="category-name" @if(collect($category->children)->isNotEmpty()) data-bs-toggle="collapse"
                            data-bs-target="#collapse-{{ $loop->index }}" @endif>
                                {{ $category->family_category_name }}
                            </span>
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

                    @if(collect($category->children)->isNotEmpty())
                        <div class="collapse" id="collapse-{{ $loop->index }}">
                            <div class="subcategory-list ps-4">
                                @foreach ($category->children as $child)
                                    <div class="subcategory-item">
                                        <div class="subcategory-header d-flex align-items-center justify-content-between {{ $loop->index % 2 == 0 ? 'bg-light' :  'bg-white' }}">
                                            <div class="d-flex align-items-center gap-2">
                                                @if(collect($child->children)->isNotEmpty())
                                                    <i class="fa-solid fa-chevron-down toggle-icon" data-bs-toggle="collapse"
                                                        data-bs-target="#subcollapse-{{ $loop->parent->index }}-{{ $loop->index }}"></i>
                                                @endif
                                                <span @if(collect($child->children)->isNotEmpty()) data-bs-toggle="collapse"
                                                    data-bs-target="#subcollapse-{{ $loop->parent->index }}-{{ $loop->index }}"
                                                @endif>
                                                    {{ $child->family_category_name }}
                                                </span>
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

                                        @if(collect($child->children)->isNotEmpty())
                                            <div class="collapse ps-4" id="subcollapse-{{ $loop->parent->index }}-{{ $loop->index }}">
                                                <div class="sub-subcategory-list ps-4">
                                                    @foreach ($child->children as $subChild)
                                                        <div class="sub-subcategory-item">
                                                            <div class="d-flex align-items-center justify-content-between {{ $loop->index % 2 == 0 ? 'bg-light' :  'bg-white' }}">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    @if(collect($subChild->children)->isNotEmpty())
                                                                        <i class="fa-solid fa-chevron-down toggle-icon"
                                                                            data-bs-toggle="collapse"
                                                                            data-bs-target="#subsubcollapse-{{ $loop->parent->parent->index }}-{{ $loop->parent->index }}-{{ $loop->index }}"></i>
                                                                    @endif
                                                                    <span @if(collect($subChild->children)->isNotEmpty())
                                                                        data-bs-toggle="collapse"
                                                                        data-bs-target="#subsubcollapse-{{ $loop->parent->parent->index }}-{{ $loop->parent->index }}-{{ $loop->index }}"
                                                                    @endif>
                                                                        {{ $subChild->family_category_name }}
                                                                    </span>
                                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                                </div>
                                                                <div class="category-actions d-flex align-items-center gap-2">
                                                                    <input class="form-check-input" type="checkbox">
                                                                    <button class="btn btn-sm btn-light"><i class="fa-light fa-plus"></i>
                                                                        Add Sub</button>
                                                                    <i class="fa-solid fa-arrows-up-down"></i>
                                                                    <button class="btn btn-sm btn-light"><i class="fa-regular fa-copy"></i>
                                                                        Copy</button>
                                                                    <button class="btn btn-sm btn-light"><i
                                                                            class="fa-solid fa-trash-can"></i> Delete</button>
                                                                </div>
                                                            </div>

                                                            @if(collect($subChild->children)->isNotEmpty())
                                                                <div class="collapse ps-4"
                                                                    id="subsubcollapse-{{ $loop->parent->parent->index }}-{{ $loop->parent->index }}-{{ $loop->index }}">
                                                                    <div class="sub-sub-subcategory-list ps-4">
                                                                        @foreach ($subChild->children as $deepestChild)
                                                                            <div class="sub-sub-subcategory-item">
                                                                                <div class="d-flex align-items-center justify-content-between {{ $loop->index % 2 == 0 ? 'bg-light' :  'bg-white' }}">
                                                                                    <div class="d-flex align-items-center gap-2">
                                                                                        <span>{{ $deepestChild->family_category_name }}</span>
                                                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                                                    </div>
                                                                                    <div class="category-actions d-flex align-items-center gap-2">
                                                                                        <input class="form-check-input" type="checkbox">
                                                                                        <button class="btn btn-sm btn-light"><i
                                                                                                class="fa-light fa-plus"></i> Add Sub</button>
                                                                                        <i class="fa-solid fa-arrows-up-down"></i>
                                                                                        <button class="btn btn-sm btn-light"><i
                                                                                                class="fa-regular fa-copy"></i> Copy</button>
                                                                                        <button class="btn btn-sm btn-light"><i
                                                                                                class="fa-solid fa-trash-can"></i> Delete</button>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection