@extends('layouts.main')

@section('title', $page->title ?? 'Post Caps')

@section('content')

    <style>
        p {
            font-size: 14px;
        }
        .border-bottom {
            font-size: 12px;
        }

        .post-cap-card {
            border: 1px solid #eee;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            height: 100%;
        }

        .post-cap-image {
            max-width: 170px;
            object-fit: contain;
            height: 150px;
        }

        .post-cap-content {
            padding: 2px;
        }

        .post-cap-content h5 {
            font-weight: bold;
        }

        .post-cap-content p {
            font-size: 0.95rem;
            color: #555;
        }
        .post-cap-content a {
            color: #8B2E14;
            text-decoration: none;
        }
        .btn-product {
            background-color: #8B2E14;
            color: white;
            font-weight: bold;
        }

        .btn-product:hover {
            background-color: #722511;
        }

        @media (max-width: 768px) {
            .post-cap-flex {
                flex-direction: column !important;
                text-align: center;
            }

            .post-cap-image {
                margin: 0 auto;
            }
        }
    </style>

    <!-- Header Section -->
    <div class="rounded bg-brown">
        <h1 class="page-title text-center py-2 mb-0">Fence Post Caps</h1>
    </div>
    <div class="text-center py-2 mb-4 border-bottom">
        <p class="mb-0">We carry wood post caps, solar post caps, and vinyl post caps. Post Caps are normally used for a number of projects including fence. We carry a wide selection of post caps in differrent materials including wood, 
            vinyl and aluminum as well as solar post caps in different colors.</p>
    </div>


    <div class="container my-2">
        <div class="row g-4">
            <!-- Card 1 -->
            <div class="col-md-4">
                <div class="post-cap-card d-flex post-cap-flex p-3">
                    <a href="{{ route('woodpostcaps.index') }}"><img src="/resources/images/woodpost.png" alt="Wood Cap" class="post-cap-image me-3"></a>
                    <div class="post-cap-content">
                        <h5> <a href="{{ route('woodpostcaps.index') }}" rel="noopener noreferrer">Wood Post Caps</a></h5>
                        <p>Cedar Wood Post attached easily to 4", 5" and 6" posts. Many styles including Pyramid Top, Flat
                            Top and Ball Top.</p>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-md-4">
                <div class="post-cap-card d-flex post-cap-flex p-3">
                    <img src="/resources/images/solarpost.jpg" alt="Chain Link Cap" class="post-cap-image me-3">
                    <div class="post-cap-content">
                        <h5>Solar Post Caps</h5>
                        <p>Will fit over any standard vinyl or wood post. Allowes up to 10 hours of light per night. Made from UV Stable, 100% prime PVC (vinyl) guaranteed not to fade, rust or yellow.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection