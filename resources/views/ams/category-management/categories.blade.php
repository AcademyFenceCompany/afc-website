@extends('layouts.ams')

@section('title', 'Categories')

@section('content')
    <div class="mb-4">
        <a href="{{ route('ams.mysql-categories.index') }}" class="btn btn-primary">
            <i class="bi bi-database"></i> MySQL Categories Management
        </a>
        <p class="text-muted mt-2">Click the button above to manage categories in the academyfence database.</p>
    </div>
    
    <ul class="tree">
        @foreach ($categories as $category)
            <li class="category">
                <!-- Category with children, display the toggle button and recursive children -->
                <h3 class="toggle-btn" onclick="toggleChildren(event)">
                    {{ $category->family_category_name }}
                </h3>
                <ul class="children" style="display: none;"> <!-- Keep children hidden by default -->
                    @foreach ($category->children as $child)
                        @include('ams.category-management.tree', ['category' => $child])
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
@endsection

<script>
    // JavaScript function to toggle children visibility
    function toggleChildren(event) {
        const childrenList = event.target.nextElementSibling;
        if (childrenList) {
            childrenList.style.display = (childrenList.style.display === "none" || childrenList.style.display === "") ?
                "block" : "none";
        }
    }
</script>
