@extends('layouts.main')

@section('title', 'Welded Wire')

@section('content')
    <!-- Header Section -->
    <div class="bg-black text-white text-center py-3 rounded">
        <h1 class="mb-0">Welded Wire</h1>
    </div>
    <div class="text-center mt-2">
        <p>Specializing in Vinyl Coated Mesh, Hex Netting/Chicken Wire, Hardware Cloth. When comparing welded wire
            prices from different companies, one of the most important factors of Strength and Quality can be determined
            by comparing the specifications and weight of the roll.</p>
        <p class="text-danger fw-bold">CALL AHEAD FOR LOCAL PICKUP!</p>
    </div>

    <!-- Content Section -->
    <div class="row mt-4 align-items-center">
        <!-- Left Column -->
        <div class="col-md-4">
            <div class="bg-warning text-dark p-4 rounded">
                <h4 class="fw-bold text-center">The Original online Fence Superstore</h4>
                <p class="mb-0 text-center"><em>Family owned operated since 1968</em></p>
                <h5 class="mt-3 text-center">Welded Wire Manufacturer</h5>
                <ul class="mt-3">
                    <li>Widest variety of mesh size and gauges</li>
                    <li>Direct Ship from our warehouse</li>
                    <li>Our manufacture specifications:
                        <ul>
                            <li>Full gauge steel core</li>
                            <li>Hot dip galvanized</li>
                            <li>Then quality PVC coated</li>
                        </ul>
                    </li>
                    <li>Pick up available in NJ</li>
                </ul>
            </div>
        </div>

        <!-- Center Image -->
        <div class="col-md-4 text-center">
            <img src='/resources/images/Vinyl-coated-fence-category 1.png' alt="Welded Wire Rolls"
                class="img-fluid rounded shadow-lg">
        </div>

        <!-- Right Column -->
        <div class="col-md-4">
            <h4>Academy Welded Wire Fence Manufacturing</h4>
            <p class="text-danger fw-bold">In stock warehouse - Quick Shipping!</p>
            <p>As a welded wire fence manufacturing company, we provide a very wide selection of mesh sizes, gauges,
                heights, roll lengths, weights, and colors. We retail and discount wholesale from our US-based stock
                warehouse inventories and quick ship large and small orders by single roll, pallet (freight), and
                truckload quantities. Specializing in black and green vinyl PVC coated and hot-dipped galvanized welded
                wire mesh fence products, chicken wire, poultry hex netting, and hardware cloth.
            </p>
            <a href="#" class="btn btn-danger text-white">WELDED WIRE SAMPLE</a>

            <!-- Brochures Section -->
            <div class="mt-4">
                <h5>Brochures</h5>
                <a href="#" class="btn btn-secondary btn-sm me-2"><i class="bi bi-file-earmark-text"></i> Welded
                    Wire Brochure</a>
                <a href="#" class="btn btn-secondary btn-sm"><i class="bi bi-printer"></i> Print Order Sheet</a>
            </div>
        </div>
    </div>

    <!-- Product Grid Section -->
    <div class="bg-light mt-5 py-4">
        <div class="custom-container">
            <div class="bg-black text-white text-center py-3 rounded">
                <h1 class="mb-0">Welded Wire Mesh Sizes</h1>
            </div>
            <div class="row justify-content-center g-4 mt-3">
                @foreach ($general_ww_mesh_size_imgs as $mesh_size)
                    <div class="col-6 col-md-4 col-lg-2 d-flex justify-content-center">
                        <div class="card text-center shadow-sm h-100" style="width: 150px;border: none;">
                            <div class="card-header bg-danger text-white fw-bold py-2">
                                <h6>{{ $mesh_size->size2 }}</h6>
                            </div>
                            <div class="card-body p-2">
                                <img src="{{ $mesh_size->image ?? '/resources/images/4x4.jpg' }}" alt="Wire Image"
                                    style="height:140px; " class="img-fluid mb-3 rounded">
                                <div class="d-grid gap-2">


                                    <!-- Galvanized Button -->
                                    <a class="btn btn-outline-dark btn-sm fw-bold"
                                        href="{{ route('meshsize.products', ['meshSize' => urlencode($mesh_size->size2), 'coating' => 'Galvanized']) }}">
                                        Galvanized
                                    </a>

                                    <!-- Vinyl Coated Button -->
                                    <a href="{{ route('meshsize.products', ['meshSize' => urlencode($mesh_size->size2), 'coating' => 'Vinyl PVC']) }}"
                                        class="btn btn-outline-dark btn-sm fw-bold" style="font-size: 12px;">Vinyl PVC</a>

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
            <div class="bg-black text-white text-center py-3 rounded">
                <h5 class="mb-0">Hardware Cloth Wire</h5>
            </div>
            <div class="row mt-3">
                <div class="col-4">
                    <img src="/resources/images/image 91.png" alt="Hardware Cloth" class="img-fluid mb-3 rounded shadow-sm">
                </div>
                <div class="col-8 prd-sm-text">
                    <p>Our 1/2in Hardware Cloth is a welded steel wire mesh. It’s zinc coating provides maximum
                        protection
                        and extra durability. Hardware cloth has an unlimited number of applications around the home,
                        business, or farm.</p>

                </div>
                <div>
                    <h5>Brochures</h5>
                    <a href="#" class="btn btn-secondary btn-sm me-2">Welded Wire Brochure</a>
                    <a href="#" class="btn btn-secondary btn-sm">Print Order Sheet</a>
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
                    <p>A snow fence is a structure, similar to a sand fence, that forces drifting snow to accumulate in
                        a
                        desired place.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards Row -->
    <div class="row mt-4">
        <!-- Hardware Cloth Wire Cards -->
        <div class="col-lg-5">
            <div class="row justify-content-center">
                @foreach (["1/2\"", "1/4\"", "1/8\""] as $size)
                    <div class="col-4 mb-3 d-flex justify-content-center">
                        <div class="card text-center shadow-sm h-100" style="width: 150px; border: none;">
                            <div class="card-header bg-danger text-white fw-bold py-2 prd-sm-text">
                                {{ $size }}
                            </div>
                            <div class="card-body p-2">
                                <img src="/resources/images/4x4.jpg" alt="{{ $size }}"
                                    class="img-fluid mb-3 rounded">
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
                                <img src="/resources/images/4x4.jpg" alt="{{ $size }}"
                                    class="img-fluid mb-3 rounded">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-dark btn-sm fw-bold"
                                        style="font-size: 12px;">Galvanized</button>
                                    <button class="btn btn-outline-secondary btn-sm fw-bold"
                                        style="font-size: 12px;">Vinyl Coated</button>
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
                            <a href="#" class="btn btn-secondary btn-sm me-2"><i
                                    class="bi bi-file-earmark-text"></i> Welded Wire Brochure</a>
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
                                <img src="/resources/images/4x4.jpg" alt="{{ $size }}"
                                    class="img-fluid rounded mb-3">
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
                            <a href="#" class="btn btn-secondary btn-sm me-2"><i
                                    class="bi bi-file-earmark-text"></i> Welded Wire Brochure</a>
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
                                <img src="/resources/images/4x4.jpg" alt="{{ $size }}"
                                    class="img-fluid rounded mb-3">
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
