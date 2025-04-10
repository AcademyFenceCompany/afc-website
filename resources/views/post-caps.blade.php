@extends('layouts.main')

@section('title', $page->title ?? 'Welded Wire')

@section('content')

    <style>
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
            max-width: 250px;
            object-fit: contain;
        }

        .post-cap-content {
            padding: 20px;
        }

        .post-cap-content h5 {
            font-weight: bold;
        }

        .post-cap-content p {
            font-size: 0.95rem;
            color: #555;
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
        <h1 class="page-title text-center py-2 mb-0">POST CAPS</h1>
    </div>
    <div class="text-center py-2 mb-4 border-bottom">
        <p class="mb-0">We carry wood post caps, solar post caps, and vinyl post caps. Post Caps are normally used for a
            number of projects including fence. We carry a wide selection of post caps in differrent materials including
            wood, vinyl and aluminum as well as solar post caps in different colors.</p>
    </div>


    <div class="container my-2">
        <div class="row g-4">
            <!-- Card 1 -->
            <div class="col-md-4">
                <div class="post-cap-card d-flex post-cap-flex p-0">
                    <img src="/resources/images/post_cap.jpg" alt="Vinyl Cap" class="post-cap-image me-1">
                    <div class="post-cap-content">
                        <h5>Vinyl Post Caps</h5>
                        <p>Vinyl PVC Ball Cap, External Flat Cap, New England Cap, Gothic Cap, and Internal Flat Cap.
                            Accessories for 4" x 4", and 5" x 5" Vinyl Fence Posts.</p>
                        <a href="#" class="btn btn-product mt-2">View Product</a>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-md-4">
                <div class="post-cap-card d-flex post-cap-flex p-3">
                    <img src="/resources/images/post_cap.jpg" alt="Wood Cap" class="post-cap-image me-3">
                    <div class="post-cap-content">
                        <h5>Wood Post Caps</h5>
                        <p>Cedar Wood Post attached easily to 4", 5" and 6" posts. Many styles including Pyramid Top, Flat
                            Top and Ball Top.</p>
                        <a href="#" class="btn btn-product mt-2">View Product</a>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-md-4">
                <div class="post-cap-card d-flex post-cap-flex p-3">
                    <img src="/resources/images/post_cap.jpg" alt="Chain Link Cap" class="post-cap-image me-3">
                    <div class="post-cap-content">
                        <h5>Chain Link Post Caps</h5>
                        <p>Aluminum chain link acorn caps are the perfect way to finish a fence project. Comes in sizes
                            ranging from 1-3/8" all the way up to 6-5/8".</p>
                        <a href="#" class="btn btn-product mt-2">View Product</a>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection