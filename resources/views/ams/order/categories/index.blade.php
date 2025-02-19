@extends('layouts.ams')

@section('title', 'Product Categories')

@section('content')
<div class="container-fluid py-2">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Select Category</h5>
                    <div class="row row-cols-1 row-cols-md-4 g-4">
                        @foreach($categories as $category)
                            <div class="col">
                                <a href="{{ route('ams.orders.category.show', $category->family_category_id) }}" 
                                   class="card h-100 text-decoration-none">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">{{ $category->family_category_name }}</h5>
                                        @if($category->children_count > 0)
                                            <p class="card-text text-muted">
                                                {{ $category->children_count }} subcategories
                                            </p>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.card:hover {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    transform: translateY(-2px);
    transition: all 0.2s ease-in-out;
}
</style>
@endsection
