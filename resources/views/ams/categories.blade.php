@extends('layouts.ams')

@section('title', 'Add Product')

@section('content')
    <ul>
        @foreach ($categories as $category)
            <li>
                {{ $category->family_category_name }}
                @if (!empty($category->children))
                    <ul>
                        @include('categories.partials.nested', ['categories' => $category->children])
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
@endsection
