@extends('layouts.main')

@section('title', 'About Us')

@section('content')
<main class="container">
    <!-- Page Header -->
    <div class="card">
        <div class="card-header text-center bg-dark text-white py-4">
            <h2>About Us</h2>
        </div>
        <!-- Contact Information Section -->
    {{-- <div class="text-center mb-4">
        <p>
            <i class="bi bi-envelope"></i> info@academyfence.com &nbsp; | &nbsp; 
            <i class="bi bi-telephone"></i> (973) 674-0600 &nbsp; | &nbsp; 
            <i class="bi bi-geo-alt"></i> 119 N Day Street, Orange, NJ
        </p>
    </div> --}}

    <!-- Navigation Tabs -->
    <div class="text-center mt-4 mb-4">
        <button class="btn btn-outline-dark mx-1">GET A QUOTE</button>
        <button class="btn btn-outline-dark mx-1">BROCHURES</button>
        <button class="btn btn-outline-dark mx-1">POLICIES</button>
        <button class="btn btn-outline-dark mx-1">CONTACT US</button>
        <button class="btn btn-warning mx-1">ABOUT US</button>
        <button class="btn btn-outline-dark mx-1">FENCE INSTALL</button>
    </div>

    <!-- About Section -->
    <div class="card mb-4 shadow-sm">
        <div class="row align-items-center p-4 about-sec">
            <div class="col-md-6">
                <img src="/resources/images/about.png" alt="About Us" class="img-fluid rounded shadow-sm">
            </div>
            <div class="col-md-6">
                <h3 class="fw-bold">About us</h3>
                <p>
                    <strong class="text-danger">ACADEMY FENCE COMPANY</strong><br>
                    Established in the 1960’s, we offer a complete line of all types of fencing and railing. Our installers and designers are some of the best in the business, uniquely skilled in the industry. Whether it’s for aluminum, chain link, wood, or welded wire fencing, you can be assured that we offer only the best in quality and standards.
                </p>
                <button class="btn btn-danger mb-3">Contact Us</button>
                <div>
                    <a href="#" class="text-dark mx-2"><i class="bi bi-facebook fs-4"></i></a>
                    <a href="#" class="text-dark mx-2"><i class="bi bi-instagram fs-4"></i></a>
                    <a href="#" class="text-dark mx-2"><i class="bi bi-twitter fs-4"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="row box-sec-full g-4 text-center mb-5">
        @foreach([
            ['icon' => 'bi-journal-text', 'title' => 'OUR HISTORY', 'text' => 'Knowledgeable and Courteous. Established in the 1960’s, Academy Fence Company is a family-owned, industry leader. We provide expert fencing and backyard product inspiration.', 'image' => '/resources/images/history.png'],
            ['icon' => 'bi-box', 'title' => 'WHAT WE OFFER', 'text' => 'Knowledgeable and Courteous. Established in the 1960’s, Academy Fence Company is a family-owned, industry leader. We provide expert fencing and backyard product inspiration.','image' => '/resources/images/offer.png'],
            ['icon' => 'bi-journal-text', 'title' => 'OUR HISTORY', 'text' => 'Knowledgeable and Courteous. Established in the 1960’s, Academy Fence Company is a family-owned, industry leader. We provide expert fencing and backyard product inspiration.','image' => '/resources/images/history.png'],
            ['icon' => 'bi-box', 'title' => 'WHAT WE OFFER', 'text' => 'Knowledgeable and Courteous. Established in the 1960’s, Academy Fence Company is a family-owned, industry leader. We provide expert fencing and backyard product inspiration.','image' => '/resources/images/offer.png']
        ] as $feature)
        <div class="col-md-6 col-lg-3 p-4">
            <div class="card box-sec shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <img src="{{ $feature['image'] }}" alt="{{ $feature['title'] }}" style="max-width: 20%;" class="me-3">
                    <h5 class="fw-bold mb-0">{{ $feature['title'] }}</h5>
                </div>
                <p class="mt-3">{{ $feature['text'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Product Section -->
    <div class="mt-2 p-4">
        <h4 class="text-dark mb-4">SHOP FOR PRODUCT</h4>
        <div class="row g-4">
            @foreach(range(1, 4) as $product)
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card product-card shadow-sm text-center p-3">
                    <img src="/resources/images/woodpost.png" alt="Wood Post Caps" class="img-fluid mb-3">
                    <h5 class="text-danger fw-bold">Wood Post Caps</h5>
                    <a href="#" class="btn btn-danger text-white">View Product</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    </div>

    
</main>
@endsection
