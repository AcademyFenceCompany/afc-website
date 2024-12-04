@extends('layouts.main')

@section('title', 'Academy Fence Installation')

@section('content')
<main class="container py-5">
    <!-- Header Section -->
    <h1 class="text-center mb-3">Academy Fence Installation</h1>
    <div class="text-center mb-4">
        <p><i class="bi bi-envelope"></i> info@academyfence.com</p>
        <p><i class="bi bi-telephone-fill"></i> (973) 674-0600</p>
        <p><i class="bi bi-geo-alt-fill"></i> 119 N Day Street, Orange, NJ</p>
    </div>

    <!-- Quote Form Section -->
    <div class="card shadow-sm p-4 mb-5">
        <h2 class="text-center">Use Our Quote Sheet</h2>
        <p class="text-center text-muted">You can fill this form and upload it below</p>
        <div class="text-center mb-4">
            <a href="#" class="btn btn-danger">Print Quote Sheet</a>
        </div>

        <form action="#" method="POST" enctype="multipart/form-data">
            <div class="row g-4">
                <div class="col-md-6">
                    <label for="first_name" class="form-label">First Name*</label>
                    <input type="text" id="first_name" name="first_name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="last_name" class="form-label">Last Name*</label>
                    <input type="text" id="last_name" name="last_name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="company_name" class="form-label">Company Name</label>
                    <input type="text" id="company_name" name="company_name" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email*</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="phone_number" class="form-label">Phone Number*</label>
                    <input type="tel" id="phone_number" name="phone_number" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="street_address" class="form-label">Street Address*</label>
                    <input type="text" id="street_address" name="street_address" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="city" class="form-label">Town/City*</label>
                    <input type="text" id="city" name="city" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="zip_code" class="form-label">Zip Code*</label>
                    <input type="text" id="zip_code" name="zip_code" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="state" class="form-label">State*</label>
                    <select id="state" name="state" class="form-select" required>
                        <option value="" disabled selected>Select your state</option>
                        <!-- Add states here -->
                    </select>
                </div>
                <div class="col-12">
                    <label for="description" class="form-label">Description*</label>
                    <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
                </div>
                <div class="col-md-6">
                    <label for="quote_file" class="form-label">Upload Quote Sheet Here*</label>
                    <input type="file" id="quote_file" name="quote_file" class="form-control" required>
                </div>
                <div class="col-md-6 d-flex align-items-center">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="recaptcha" required>
                        <label for="recaptcha" class="form-check-label">I am not a robot</label>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-danger">Submit</button>
            </div>
        </form>
    </div>

    <!-- Examples of Installations Section -->
    <section class="container py-5">
        <h2 class="text-center text-uppercase mb-3">Examples of Our Installations Are Below</h2>
        <p class="text-center text-muted">
            Fence Installation And Repairs Throughout New Jersey. We Specialize In At-Home Installation, Serving All Of New Jersey Including Essex, Hudson, Morris, Union, Bergen, Middlesex, And Passaic Counties. South And Central - Manasquan / Wall And Surrounding Areas.
        </p>

        <div class="row g-4">
            @foreach([1, 2, 3, 4, 5, 6] as $example)
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm">
                    <img src="/resources/images/fence-example.jpg" class="card-img-top" alt="Type of Fence">
                    <div class="card-body text-center">
                        <h5 class="card-title">Type of Fence</h5>
                        <p class="card-text text-muted">Location<br>Type: Fence Style & Size</p>
                        <a href="#" class="btn btn-danger">Get A Quote</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Reviews Section -->
    <section class="container py-5">
        <h2 class="text-center mb-4">Our Reviews</h2>

        <div class="row g-4">
            @foreach([1, 2, 3, 4] as $review)
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">Madeline</h5>
                        <div class="d-flex justify-content-center mb-2">
                            <span class="text-warning">&#9733; &#9733; &#9733; &#9733; &#9734;</span>
                        </div>
                        <p class="card-text text-muted">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </p>
                        <small class="text-muted">1 Month Ago</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <a href="#" class="btn btn-danger">Write Review</a>
        </div>
    </section>
</main>
@endsection