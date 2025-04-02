@extends('layouts.ams')

@section('title', 'AFC Category Management')

@section('styles')
<style>
    .category-tree {
        margin-left: 0;
        padding-left: 0;
        font-size: 0.875rem;
    }
    
    .category-tree ul {
        list-style-type: none;
        padding-left: 20px;
        margin-top: 0;
        margin-bottom: 0;
    }
    
    .category-tree li {
        margin: 4px 0;
        position: relative;
    }
    
    .category-tree .major-category {
        font-weight: 500;
        font-size: 0.9rem;
        margin-bottom: 4px;
        padding: 6px 10px;
        background-color: #f8f9fa;
        border-left: 3px solid #007bff;
        display: flex;
        align-items: center;
    }
    
    .category-tree .sub-category {
        padding: 4px 8px;
        margin: 2px 0;
        border-left: 2px solid #28a745;
        background-color: #fff;
        display: flex;
        align-items: center;
        font-size: 0.85rem;
    }
    
    .toggle-icon {
        cursor: pointer;
        margin-right: 6px;
        font-size: 0.8rem;
    }
    
    .category-actions {
        margin-left: 10px;
        white-space: nowrap;
    }
    
    .category-actions .btn {
        padding: 0.2rem 0.4rem;
        font-size: 0.75rem;
        border: none;
    }
    
    .category-actions .btn i {
        font-size: 0.7rem;
    }
    
    .badge {
        font-size: 0.7rem;
        padding: 0.2em 0.5em;
        margin-left: 5px;
    }
    
    .major-category .category-actions {
        margin-left: auto;
    }
    
    .category-name {
        flex: 1;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <div>
            <a href="{{ route('ams.mysql-categories.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Add New Category
            </a>
            <a href="{{ route('ams.mysql-majorcategories.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Major Category
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($majorCategories->isEmpty())
                <div class="alert alert-info">No categories found in the system.</div>
            @else
                <div class="category-tree">
                    <ul>
                        @foreach($majorCategories as $majorCategory)
                            <li>
                                <div class="major-category">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-caret-right-fill toggle-icon" onclick="toggleSubcategories(this)"></i>
                                        <span class="category-name">{{ $majorCategory->cat_name }}</span>
                                        @if(!$majorCategory->enabled)
                                            <span class="badge bg-secondary ms-2"></span>
                                        @endif
                                        <div class="category-actions">
                                            <a href="{{ route('ams.mysql-majorcategories.edit', $majorCategory->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i> 
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <ul style="display: none;">
                                    @foreach($categories as $category)
                                        @if($category->majorcategories_id == $majorCategory->id)
                                            <li>
                                                <div class="sub-category d-flex align-items-center" style="justify-content: flex-start;">
                                                    <a href="{{ route('ams.mysql-categories.edit', $category->id) }}" class="text-decoration-none text-dark flex-grow-0 me-2">
                                                        {{ $category->cat_name }}
                                                        @if(!$category->web_enabled)
                                                            <span class="badge bg-secondary ms-1"></span>
                                                        @endif
                                                    </a>
                                                    <div class="category-actions" style="margin-left: 0;">
                                                        <a href="{{ route('ams.mysql-categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary">
                                                            <i class="bi bi-pencil"></i> 
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleSubcategories(icon) {
        const categoryItem = icon.closest('li');
        const subcategoryList = categoryItem.querySelector('ul');
        
        if (subcategoryList.style.display === 'none' || subcategoryList.style.display === '') {
            subcategoryList.style.display = 'block';
            icon.classList.remove('bi-caret-right-fill');
            icon.classList.add('bi-caret-down-fill');
        } else {
            subcategoryList.style.display = 'none';
            icon.classList.remove('bi-caret-down-fill');
            icon.classList.add('bi-caret-right-fill');
        }
    }
</script>
@endsection
