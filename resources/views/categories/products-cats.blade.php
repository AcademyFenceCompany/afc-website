@extends('layouts.main')

@section('title', 'Fence Post Caps')

@section('content')
<main class="container">
    <!-- Fence Post Caps Header Section -->
    <div class="card mb-4">
        <div class="card-header text-center bg-danger text-white">
            <h2>Fence Post Caps</h2>
        </div>
        <div class="card-body text-center">
            <p>
                We carry wood post caps, solar post caps, and vinyl post caps. Post Caps are normally used for a number of projects including fencing.
                We carry a wide selection of post caps in different materials including wood, vinyl, and aluminum, as well as solar post caps in different colors.
            </p>
        </div>
    </div>

    <!-- Post Caps List Section -->
    <div class="row g-4">
        @foreach([
            ['title' => 'Vinyl Post Caps', 'description' => 'Vinyl PVC Ball Cap, External Flat Cap, New England Cap, Gothic Cap, and Internal Flat Caps. Accessories for 4" x 4", and 5" x 5" Vinyl Fence Posts.', 'image' => '/resources/images/post-caps.png'],
            ['title' => 'Wood Post Caps', 'description' => 'Cedar Wood Post attached easily to 4", 5" and 6" posts. Many styles including Pyramid Top, Flat top and Ball Top.', 'image' => '/resources/images/post-caps.png'],
            ['title' => 'Chain Link Post Caps', 'description' => 'Aluminum chain link acorn caps are the perfect way to finish a fence project. Come in sizes ranging from 1-3/8" all the way up to 8-5/8".', 'image' => '/resources/images/post-caps.png'],
            ['title' => 'Wood Post Caps', 'description' => 'Cedar Wood Post attached easily to 4", 5" and 6" posts. Many styles including Pyramid Top, Flat top and Ball Top.', 'image' => '/resources/images/post-caps.png']
        ] as $postCap)
        <div class="col-12 col-md-6 col-lg-4 d-flex">
            <div class="card product-card shadow-sm p-3 d-flex flex-row align-items-center w-100">
                <!-- Image Section -->
                <div class="product-image me-3">
                    <img src="{{ $postCap['image'] }}" alt="{{ $postCap['title'] }}" class="img-fluid rounded" style="max-width: 150px;">
                </div>
                <!-- Content Section -->
                <div class="product-details">
                    <h5 class="fw-bold">{{ $postCap['title'] }}</h5>
                    <p class="text-muted">{{ $postCap['description'] }}</p>
                    <a href="#" class="btn btn-danger text-white">View Product</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</main>
@endsection
