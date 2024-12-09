@extends('layouts.main')

@section('title', 'Wood Fence Products')

@section('content')
    <main class="container">
        <!-- Header Section -->
        <div class="card mb-4">
            <div class="card-header text-center text-white">
                <h2>Wood Fence</h2>
            </div>
            <div class="card-body text-center">
                <p>
                    Academy Wood Fence - Cedar Fencing Leaders in Wood Fencing for Over 40 Years.
                </p>
            </div>
        </div>

        <!-- Product List Section -->
        <div class="row g-4">
            @foreach ([
            [
                'title' => 'Space Picket',
                'description' => "Academy's Spaced Picket Fence is made from cedar wood with stainless steel nailed 2' or 3' slats.",
                'image' => '/resources/images/spacepicket.png',
                'sizes' => ['2-1/2', '2-3/4'],
            ],
            [
                'title' => 'Solid Board',
                'description' => "Academy's handcrafted decorative solid board fencing comes in 1\"x4\" slats and white cedar boards.",
                'image' => '/resources/images/PICTURE (2).png',
            ],
            [
                'title' => 'Shadow Box/Board',
                'description' => 'Shadow Box/Board provides alternating slats for unique styling.',
                'image' => '/resources/images/image 78.png',
                'sizes' => ['2-1/2', '2-3/4'],
            ],
            [
                'title' => 'Loose Wood Fence Boards',
                'description' => 'Individual boards for homeowners or contractors to customize their fencing style.',
                'image' => '/resources/images/image 79.png',
            ],
            [
                'title' => 'Wood Fence Gate',
                'description' => 'Wood Gate Latches, Hinges, and Accessories for fencing gates.',
                'image' => '/resources/images/PICTURE (3).png',
            ],
            [
                'title' => 'Tongue & Groove Fence',
                'description' => "High-quality 1\"x4\" white cedar tongue and groove boards.",
                'image' => '/resources/images/PICTURE (4).png',
            ],
            [
                'title' => 'Stockade Fence',
                'description' => 'Durable cedar stockade fencing for enhanced privacy and security.',
                'image' => '/resources/images/PICTURE (5).png',
            ],
            [
                'title' => 'Post & Rail',
                'description' => 'Rustic Split Rail Cedar fence for landscaping.',
                'image' => '/resources/images/PICTURE (6).png',
            ],
            [
                'title' => 'Wood Post Caps',
                'description' => 'Cedar Wood Post Caps in Pyramid Top, Flat Top, and Ball Top styles.',
                'image' => '/resources/images/PICTURE (7).png',
            ],
        ] as $product)
                <div class="col-12 col-md-6 col-lg-4 d-flex align-items-stretch">
                    <div class="card product-card shadow-sm p-3 w-100">
                        <div class="d-flex h-100">
                            <!-- Image Section -->
                            <div class="product-image me-3">
                                <img src="{{ $product['image'] }}" alt="{{ $product['title'] }}" class="img-fluid rounded"
                                    style="max-height: 150px; max-width: 150px;">
                            </div>
                            <!-- Content Section -->
                            <div class="product-details d-flex flex-column justify-content-between flex-grow-1">
                                <div>
                                    <h5 class="fw-bold">{{ $product['title'] }}</h5>
                                    <p class="text-muted">{{ $product['description'] }}</p>
                                </div>
                                <!-- Check if sizes are defined -->
                                <div class="mt-3">
                                    @if (isset($product['sizes']))
                                        @foreach ($product['sizes'] as $size)
                                            <a href="#" class="btn btn-danger text-white me-2">{{ $size }}</a>
                                        @endforeach
                                    @else
                                        <a href="#" class="btn btn-danger text-white">View Product</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>



        <!-- About Section -->
        <div class="card mt-5 shadow-sm">
            <div class="card-header text-white">
                <h2 class="text-center">Academy Wood Fence - Cedar Fencing</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <img src="/resources/images/woodfenceabt.png" alt="Cedar Fencing" class="img-fluid rounded">
                    </div>
                    <div class="col-md-8">
                        <p>
                            Academy Fence offers many different types of wood fencing including spaced picket wood fencing,
                            solid board wood fencing, board on board, and post and rail wood fencing for purchase or
                            install. Academy Fence designs, manufactures, wholesales, and professionally installs
                            top-quality custom decorative and privacy wood fencing and picket.
                        </p>
                        <p>
                            We use top-grade 100% white cedar for vertical boards and horizontal rails. Cedar wood has been
                            used and proven locally as the best wood for fencing for many generations. It is naturally
                            resistant to rotting and decay and therefore requires no chemical treatment, making it
                            environmentally friendly.
                        </p>
                        <a href="#" class="btn btn-danger">Get a Quote</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
