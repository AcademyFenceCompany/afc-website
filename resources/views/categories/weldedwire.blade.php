@extends('layouts.main')

@section('title', 'Welded Wire')

@section('content')


    <style>
        .bg-brown {
            background-color: #8B4513 !important;
        }

        .page-title {
            font-size: 24px !important;
            color: #fff !important;
            font-weight: bold !important;
            padding: 10px 0 !important;
        }

        .page-description {
            font-size: 14px !important;
            font-weight: 500 !important;
            line-height: 1.5 !important;
            margin-bottom: 1rem !important;
        }

        /* Custom button styles */
        .btn.btn-brown {
            background-color: #8B4513 !important;
            color: white !important;
            border-color: #8B4513 !important;
        }

        .btn.btn-brown:hover {
            background-color: #6B3100 !important;
            color: white !important;
        }

        .border-bottom {
            font-size: 12px;
        }

        /* Custom 4-column layout */
        .col-lg-3 {
            width: 25% !important;
        }

        .mesh-size__title {
            font-size: 13px;
            margin: 0;
        }

        .cards {
            width: 190px;
        }

        .gal:hover {
            background-color: #b5b7bb;
            border-color: #b5b7bb;
        }

        @media (max-width: 992px) {
            .col-lg-3 {
                width: 33.333% !important;
            }
        }

        @media (max-width: 768px) {
            .col-lg-3 {
                width: 50% !important;
            }
        }

        @media (max-width: 576px) {
            .col-lg-3 {
                width: 100% !important;
            }
        }

        .about-image {
            width: 180px !important;
            height: 180px !important;
            object-fit: cover !important;
        }

        .bg-light-yellow {
            background-color: #FFFFD4 !important;
        }

        .small-font {
            font-size: 12px !important;
        }

        .product-image {
            width: 250px !important;
            height: 250px !important;
            object-fit: cover !important;
        }

        .btn-small-text {
            font-size: 0.7rem !important;
        }
    </style>


    <!-- Header Section -->
    <div class="rounded bg-brown">
        <h1 class="page-title text-center py-2 mb-0">WELDED WIRE</h1>
    </div>
    <div class="text-center py-2 mb-4 border-bottom">
        <p class="mb-0">Specializing in Vinyl Coated Mesh, Hex Netting/Chicken Wire, Hardware Cloth. When comparing welded
            wire
            prices from different companies, one of the most important factors of Strength and Quality can be determined
            by comparing the specifications and weight of the roll.</p>
    </div>

    <!-- Info Section -->
    <div class="row g-4 mb-3">
        <!-- Left Section - About -->
        <div class="col-md-6 wf-about">
            <div class="d-flex">
                <img src="/resources/images/Vinyl-coated-fence-category 1.png" alt="Welded Wire Rolls"
                    class="me-4 rounded about-image">

                <div>
                    <h4 class="mb-2">Welded Wire Manufacturer</h4>
                    <p class="page-description mb-2">
                        We manufacture and supply a wide range of welded wire fence products, offering various mesh sizes,
                        gauges, heights, colors, and roll lengths. From our US-based warehouses, we retail and wholesale
                        single rolls to truckloads. We specialize in black and green vinyl-coated, galvanized welded wire,
                        chicken wire, poultry netting, and hardware cloth.
                    </p>
                    <p class="text-danger fw-bold">CALL AHEAD FOR LOCAL PICKUP!</p>
                </div>
            </div>
        </div>

        <!-- Middle Section - Brochures -->
        <div class="col-md-2 text-center">
            <h5 class="text-brown mb-2">Brochures</h5>
            <div class="d-flex flex-column gap-2">
                <button class="btn btn-light border w-100 text-center">
                    Welded Wire Brochure
                </button>
                <button class="btn btn-light border w-100 text-center">
                    Welded Wire Sample
                </button>
                <button class="btn btn-brown w-100" style="background-color: #8B4513 !important; color: white !important;">
                    Get a Quote
                </button>
            </div>
        </div>

        <!-- Right Section - Manufacturer Info -->
        <div class="col-md-4">
            <div class="p-3 rounded bg-light-yellow">
                <h6 class="text-center mb-1"><strong>The Original online Fence Superstore</strong></h6>
                <p class="text-center small mb-1 fst-italic">Family owned operated since 1968</p>
                <ul class="list-unstyled mb-0 small-font">
                    <li>Our manufacture specifications:
                        <ul>
                            <li>Full gauge steel core</li>
                            <li>Hot dip galvanized</li>
                            <li>Then quality PVC coated</li>
                        </ul>
                    </li>
                    <li>• Widest variety of mesh size and gauges</li>
                    <li>• Direct Ship from our warehouse</li>
                    <li>• Pick up available in NJ</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Product Grid Section -->
    <div class="bg-light py-0">
        <div class="custom-container">
            <div class="bg-black text-white text-center py-2 rounded">
                <h3 class="mb-0">Welded Wire Mesh Sizes</h3>
            </div>
            <div class="row justify-content-center g-2 mt-2">
                @foreach ($general_ww_mesh_size_imgs as $mesh_size)
                    <div class="col-8 col-md-2 d-flex justify-content-center cards">
                        <div class="col card text-center shadow-sm h-100" style="width: 150px; border: none;">
                            <div class="card-header bg-danger text-white fw-bold py-1">
                                <h6 class="mesh-size__title">{{ $mesh_size->size2 }}</h6>
                            </div>
                            <div class="card-body p-2">
                                <img src="{{ $mesh_size->image ?? '/resources/images/4x4.jpg' }}" alt="Wire Image"
                                    style="height:120px; " class="img-fluid mb-1 rounded">
                                <div class="d-grid gap-1">

                                    <div class="d-flex justify-content-center gap-2">
                                        <!-- Vinyl Coated Button -->
                                        <a href="{{ route('meshsize.products', ['meshSize' => urlencode($mesh_size->size2), 'coating' => 'Vinyl PVC']) }}"
                                            class="btn btn-outline-dark btn-sm fw-bold"
                                            style="font-size: 12px; padding: 5px 20px;">
                                            Vinyl
                                        </a>

                                        <!-- Galvanized Button -->
                                        <a href="{{ route('meshsize.products', ['meshSize' => urlencode($mesh_size->size2), 'coating' => 'Galvanized']) }}"
                                            class="btn btn-outline-dark btn-sm fw-bold gal"
                                            style="font-size: 12px; padding: 5px 20px;">
                                            Galv
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Main Row -->
    <div class="row mt-4">
        <!-- Hardware Cloth Wire -->
        <div class="col-lg-4 mb-4">
            <div class="bg-black text-white text-center py-1 rounded">
                <h5 class="mb-0">Hardware Cloth Wire</h5>
            </div>

            <!-- Hardware Cloth Wire Cards -->
            <div class="col-12 mt-2">
                <div class="row justify-content-center">
                    @foreach (["1/2\"", "1/4\"", "1/8\""] as $size)
                        <div class="col-4 mb-1 d-flex justify-content-center">
                            <div class="card text-center shadow-sm h-100" style="width:120px; border: none;">
                                <div class="card-header bg-danger text-white fw-bold py-1 prd-sm-text">
                                    {{ $size }}
                                </div>
                                <div class="card-body p-2">
                                    <img src="/resources/images/4x4.jpg" alt="{{ $size }}" class="img-fluid mb-3 rounded">
                                    <div class="d-grid gap-2">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button class="btn btn-outline-dark btn-sm fw-bold"
                                                style="font-size: 12px; padding: 5px 10px;">Vinyl</button>

                                            <button class="btn btn-outline-dark btn-sm fw-bold gal"
                                                style="font-size: 12px; padding: 5px 10px;">Galv</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-4">
                    <img src="/resources/images/image 91.png" alt="Hardware Cloth" class="img-fluid mb-3 rounded shadow-sm">
                </div>
                <div class="col-8 prd-sm-text">
                    <h6>Brochures</h6>
                    <div class="d-flex gap-1 flex-wrap mb-1">
                        <a href="#" class="btn btn-light btn-sm border">WWF Brochure</a>
                        <a href="#" class="btn btn-light btn-sm border">Order Sheet</a>
                    </div>
                    <p>Our 1/2in Hardware Cloth is a welded steel wire mesh. It’s zinc coating provides maximum
                        protection
                        and extra durability. Hardware cloth has an unlimited number of applications around the home,
                        business, or farm.</p>
                </div>
                <div>
                </div>
            </div>
        </div>

        <!-- Chicken Wire -->
        <div class="col-lg-4 mb-4">
            <div class="bg-black text-white text-center py-3 rounded">
                <h5 class="mb-0">Chicken Wire</h5>
            </div>
            <div class="row mt-3">
                <div class="col-4">
                    <img src="/resources/images/image 94.png" alt="Chicken Wire" class="img-fluid mb-3 rounded shadow-sm">
                </div>
                <div class="col-8 prd-sm-text">
                    <p>Vinyl Coated Hex Netting (aka chicken wire) is a cost-effective means of building wire cages,
                        enclosures, traps, etc. Our protective vinyl PVC coating makes PVC wire last many years longer
                        than
                        an uncoated wire.</p>
                </div>
            </div>
        </div>

        <!-- Silt Fence -->
        <div class="col-lg-2 mb-4">
            <div class="bg-black text-white text-center py-3 rounded">
                <h5 class="mb-0">Silt Fence</h5>
            </div>
            <div class="row mt-3">
                <div class="col-12 prd-sm-text">
                    <p>Erosion control fencing, Silt Fence, is made of vinyl fabric with posts pre-attached at 10 ft
                        intervals.</p>
                </div>
            </div>
        </div>

        <!-- Snow Fence -->
        <div class="col-lg-2 mb-4">
            <div class="bg-black text-white text-center py-3 rounded">
                <h5 class="mb-0">Snow Fence</h5>
            </div>
            <div class="row mt-3">
                <div class="col-12 prd-sm-text">
                    <p>A snow fence is a structure, similar to a sand fence, that forces drifting snow to accumulate in a
                        desired place.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards Row -->
    <div class="row mt-4">


        <!-- Chicken Wire Cards -->
        <div class="col-lg-3">
            <div class="row justify-content-center">
                @foreach (["1\" Hex", "2\" Hex"] as $size)
                    <div class="col-6 mb-3 d-flex justify-content-center">
                        <div class="card text-center shadow-sm h-100" style="width: 150px; border: none;">
                            <div class="card-header bg-danger text-white fw-bold py-2 prd-sm-text">
                                {{ $size }}
                            </div>
                            <div class="card-body p-2">
                                <img src="/resources/images/4x4.jpg" alt="{{ $size }}" class="img-fluid mb-3 rounded">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-dark btn-sm fw-bold"
                                        style="font-size: 12px;">Galvanized</button>
                                    <button class="btn btn-outline-secondary btn-sm fw-bold" style="font-size: 12px;">Vinyl
                                        Coated</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Silt Fence Cards -->
        <div class="col-lg-2">
            <div class="row justify-content-center">
                <div class="col-12 mb-3 d-flex justify-content-center">
                    <div class="card text-center shadow-sm h-100" style="width: 150px; border: none;">
                        <div class="card-header bg-danger text-white fw-bold py-2 prd-sm-text">Silt & Wired Back</div>
                        <div class="card-body p-2">
                            <img src="/resources/images/4x4.jpg" alt="Silt Fence" class="img-fluid mb-3 rounded">
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-dark btn-sm fw-bold"
                                    style="font-size: 12px;">Galvanized</button>
                                <button class="btn btn-outline-secondary btn-sm fw-bold" style="font-size: 12px;">Vinyl
                                    Coated</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Snow Fence Cards -->
        <div class="col-lg-2">
            <div class="row justify-content-center">
                <div class="col-12 mb-3 d-flex justify-content-center">
                    <div class="card text-center shadow-sm h-100" style="width: 150px; border: none;">
                        <div class="card-header bg-danger text-white fw-bold py-2 prd-sm-text">Various Sizes</div>
                        <div class="card-body p-2">
                            <img src="/resources/images/4x4.jpg" alt="Silt Fence" class="img-fluid mb-3 rounded">
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-dark btn-sm fw-bold" style="font-size: 12px;">Natural
                                    Wood</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Deer Fence and Gate Kits for Welded Wire Section -->
    <div class="row g-4 mt-5">
        <!-- Deer Fence -->
        <div class="col-12 col-lg-6">
            <div class="bg-black text-white text-center py-3 rounded">
                <h2>Deer Fence</h2>
            </div>
            <div class="p-4 bg-light rounded shadow-sm mt-3">
                <div class="row align-items-center">
                    <!-- Image -->
                    <div class="col-md-4">
                        <div class="text-center">
                            <img src="/resources/images/image 96.png" alt="Deer Fence" class="img-fluid rounded"
                                style="max-height: 200px;">
                        </div>
                    </div>
                    <!-- Content -->
                    <div class="col-md-8">
                        <h5 class="fw-bold">Academy Deer Fence</h5>
                        <p class="prd-sm-text">Long Lasting, Galvanized Steel Core Wire, then black vinyl PVC coated. Deer
                            fence 8 foot 2 x 4
                            black, deer fence 1 1/2 x 4 black, deer fence graduated fixed knot. We offer cost-effective ways
                            to provide protection from deer damage.</p>
                        <div class="mt-3">
                            <h6>Brochures</h6>
                            <a href="#" class="btn btn-secondary btn-sm me-2"><i class="bi bi-file-earmark-text"></i> Welded
                                Wire Brochure</a>
                            <a href="#" class="btn btn-secondary btn-sm"><i class="bi bi-printer"></i> Print Order
                                Sheet</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Grid for Deer Fence -->
            <div class="row g-4 mt-4">
                @foreach (["2\" x 4\"", "1 1/2\" x 4\"", "1\" Hex", 'Fixed knot'] as $size)
                    <div class="col-6 col-md-3">
                        <div class="card text-center shadow-sm h-100">
                            <div class="card-header bg-danger text-white fw-bold py-2">
                                {{ $size }}
                            </div>
                            <div class="card-body p-3">
                                <img src="/resources/images/4x4.jpg" alt="{{ $size }}" class="img-fluid rounded mb-3">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-dark btn-sm fw-bold">Galvanized</button>
                                    <button class="btn btn-outline-secondary btn-sm fw-bold">Vinyl Coated</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Gate Kits for Welded Wire -->
        <div class="col-12 col-lg-6">
            <div class="bg-black text-white text-center py-3 rounded">
                <h2>Gate Kits for Welded Wire</h2>
            </div>
            <div class="p-4 bg-light rounded shadow-sm mt-3">
                <div class="row align-items-center">
                    <!-- Image -->
                    <div class="col-md-4">
                        <div class="text-center">
                            <img src="/resources/images/image 95.png" alt="Gate Kits" class="img-fluid rounded"
                                style="max-height: 200px;">
                        </div>
                    </div>
                    <!-- Content -->
                    <div class="col-md-8">
                        <h5 class="fw-bold">Gate Kits for Welded Wire</h5>
                        <p class="prd-sm-text">Academy Fence offers gate frame kits which include welded pipe gate frame(s)
                            and all necessary
                            hardware to attach your wire to the gate frame.We offer cost-effective ways to provide
                            protection from deer damage. We offer cost-effective ways to provide
                            protection damage.</p>
                        <div class="mt-3">
                            <h6>Brochures</h6>
                            <a href="#" class="btn btn-secondary btn-sm me-2"><i class="bi bi-file-earmark-text"></i> Welded
                                Wire Brochure</a>
                            <a href="#" class="btn btn-secondary btn-sm"><i class="bi bi-printer"></i> Print Order
                                Sheet</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Grid for Gate Kits -->
            <div class="row g-4 mt-4">
                @foreach (['4ft Wide', '5ft Wide', '6ft Wide'] as $size)
                    <div class="col-6 col-md-4">
                        <div class="card text-center shadow-sm h-100">
                            <div class="card-header bg-danger text-white fw-bold py-2">
                                {{ $size }}
                            </div>
                            <div class="card-body p-3">
                                <img src="/resources/images/4x4.jpg" alt="{{ $size }}" class="img-fluid rounded mb-3">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-dark btn-sm fw-bold">Galvanized</button>
                                    <button class="btn btn-outline-secondary btn-sm fw-bold">Vinyl Coated</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Game & Horse, Knock In Posts, Fence Pen Kits Section -->
    <div class="row g-4 mt-5">
        <!-- Game & Horse -->
        <div class="col-lg-4">
            <div class="bg-black text-white text-center py-3 rounded">
                <h5>Game & Horse</h5>
            </div>
            <div class="p-4 bg-light rounded shadow-sm mt-3">
                <div class="row align-items-center">
                    <!-- Image -->
                    <div class="col-md-5 text-center">
                        <div class="card-header bg-danger text-white fw-bold py-2">
                            Various Sizes
                        </div>
                        <img src="/resources/images/Group 294 (1).png" alt="Game & Horse" class="img-fluid rounded"
                            style="max-height: 150px;">
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-dark btn-sm fw-bold">Galvanized</button>
                            <button class="btn btn-outline-secondary btn-sm fw-bold">Vinyl Coated</button>
                        </div>
                    </div>
                    <!-- Content -->
                    <div class="col-md-7">
                        <div class="card shadow-sm h-100">
                            <div class="card-body prd-sm-text">
                                <p>Field & Game Fence manufactured by SolidLock with Fixed Knot mesh. Offers the benefits of
                                    high
                                    tensile fencing over traditional soft products used over the last century.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Knock In Posts -->
        <div class="col-lg-4">
            <div class="bg-black text-white text-center py-3 rounded">
                <h5>Knock In Posts</h5>
            </div>
            <div class="p-4 bg-light rounded shadow-sm mt-3">
                <div class="row align-items-center">
                    <!-- Image -->
                    <div class="col-md-5 text-center">
                        <div class="card-header bg-danger text-white fw-bold py-2">
                            U-Channel
                        </div>
                        <img src="/resources/images/Group 294 (2).png" alt="Knock In Posts" class="img-fluid rounded"
                            style="max-height: 150px;">
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-dark btn-sm fw-bold">Green</button>
                            <button class="btn btn-outline-secondary btn-sm fw-bold">Black</button>
                        </div>
                    </div>
                    <!-- Content -->
                    <div class="col-md-7">
                        <div class="card text-center shadow-sm h-100">

                            <div class="card-body">
                                <p>Heavy Knock-In U</p>
                                <ul class="text-start prd-sm-text">
                                    <li>Easy to Install</li>
                                    <li>Weather Proof</li>
                                    <li>Attractive Durable</li>
                                    <li>Rust-Resistant</li>
                                    <li>Black and Green</li>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fence Pen Kits -->
        <div class="col-lg-4">
            <div class="bg-black text-white text-center py-3 rounded">
                <h5>Fence Pen Kits</h5>
            </div>
            <div class="p-4 bg-light rounded shadow-sm mt-3">
                <div class="row align-items-center">
                    <!-- Image -->
                    <div class="col-md-5 text-center">
                        <div class="card-header bg-danger text-white fw-bold py-2">
                            Various Sizes
                        </div>
                        <img src="/resources/images/Group 294 (3).png" alt="Fence Pen Kits" class="img-fluid rounded"
                            style="max-height: 150px;">
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-dark btn-sm fw-bold">Vinyl Coated</button>
                            <button class="btn btn-outline-secondary btn-sm fw-bold">Galvanized</button>
                        </div>
                    </div>
                    <!-- Content -->
                    <div class="col-md-7">
                        <div class="card shadow-sm h-100">
                            <div class="card-body prd-sm-text">
                                <p>A quick ship fence pen kit will enable you to build a welded wire fence enclosure with an
                                    all-inclusive fence pen kit.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection