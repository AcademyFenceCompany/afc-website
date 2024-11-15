@extends('layouts.main')

@section('title', 'Wood Post Caps')

@section('content')
<main class="container">
    <!-- Wood Post Caps Header Section -->
    <div class="card mb-4">
        <div class="card-header text-center bg-dark text-white">
            <h2>Wood Post Caps</h2>
        </div>
        <div class="card-body">
            <div class="row g-3">
                @for ($i = 0; $i < 12; $i++)
                    <div class="col-6 col-md-3 col-lg-2 text-center">
                        <div class="product-item">
                            <img src="/resources/images/woodpost.png" alt="Copper 5'' Ball" class="img-fluid mb-2">
                            <p class="card-text">Copper 5" Ball</p>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- About Wood Post Caps Section -->
    <div class="card mb-4">
        <div class="card-header text-center bg-dark text-white">
            <h3>About Wood Post Caps</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="/resources/images/woodpostcaps.png" alt="Wood Post Cap" class="img-fluid rounded">
                </div>
                <div class="col-md-8">
                    <h4>Wood Post Caps</h4>
                    <p>100% clear western red cedar wood post caps are high quality and hand crafted. Add the unmistakable mark of distinction to your traditional wood fencing. Being in business, family owned and operated for over 40 years, we are able to promptly deliver premium quality caps at great prices.</p>
                    <button class="btn btn-danger mb-3">Get a Quote</button>
                    
                    <!-- Brochure Buttons -->
                    <div style="margin-top: 8rem;">
                        <h5 style="color:#882905; font-weight:bold;">Brochure</h5>
                        <button class="btn btn-light border mb-2">Wood Post Cap Brochure</button>
                        <button class="btn btn-light border mb-2">Wood Post Cap Order Sheet</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- See All Types of Fence Post Caps Section -->
    <div class="card mb-4">
        <div class="card-header text-center bg-light text-white">
            <h4>See all types of fence post caps</h4>
        </div>
        <div class="card-body">
            <div class="row g-3">
                @foreach(['Solar Post Caps', 'Vinyl Post Caps', 'Glass Post Caps', 'Chain Link Post Caps', 'Copper 5" Ball', 'Copper 5" Ball'] as $postCapType)
                    <div class="col-6 col-md-3 col-lg-2 text-center">
                        <div class="product-item">
                            <img src="/resources/images/woodpost.png" alt="{{ $postCapType }}" class="img-fluid mb-2">
                            <p class="card-text">{{ $postCapType }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</main>
@endsection
