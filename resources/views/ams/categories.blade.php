@extends('layouts.ams')

@section('title', 'Add Product')

@section('content')
    <ul class="tree">
        @foreach ($categories as $category)
            <li class="category">
                <span class="toggle-btn" onclick="toggleChildren(event)">{{ $category->family_category_name }}</span>

                @if (count($category->children) > 0)
                    <ul class="children">
                        @foreach ($category->children as $child)
                            @include('ams.tree', ['category' => $child])
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>

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




@endsection
