@extends('layouts.main')
@include('layouts.aboutHeader')
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
    @include('layouts.footerproducts')
</main>
@endsection
