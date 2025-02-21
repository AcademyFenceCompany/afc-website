@extends('layouts.main')

@section('title', 'Academy Fence Installation')

@section('content')
<main class="container">
    <div class="card">
        <div class="card-header text-center bg-primary text-white">
            <h2>Academy Fence Installation</h2>
        </div>    
        <!-- Quote Form Section -->
        <div class="card shadow-sm p-4 mb-5">
            <h2 class="text-center">Use Our Quote Sheet</h2>
            <p class="text-center text-muted">You can fill this form and upload it below</p>
            <div class="text-center mb-4">
                <a href="resources/office_sheets/customerquotefaxsheet.pdf" target="_blank" class="btn btn-danger">Print Quote Sheet</a>
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
    <!-- Header Section -->
    <div class="text-center mb-4">
        <h2 class="fw-bold text-uppercase" style="background-color: #000; color: #fff; padding: 15px; border-radius: 5px;">
            Examples of Our Installations Are Below
        </h2>
        <p class="text-muted mt-2">
            Fence Installation And Repairs Throughout New Jersey. We Specialize In At-Home Installation, Serving All Of New Jersey Including Essex, Hudson, Morris, Union, Bergen, Middlesex, And Passaic Counties. South And Central - Manasquan / Wall And Surrounding Areas.
        </p>
    </div>

    <!-- Grid Section -->
    <div class="row g-4">
        @foreach([1, 2, 3, 4, 5, 6] as $example)
        <div class="col-12 col-md-4">
            <div class="d-flex align-items-center shadow-sm border-0" style="background-color: #fff; border-radius: 8px; overflow: hidden;">
                <!-- Image Section -->
                <img src="/resources/images/PICTURE.png" alt="Fence Image" style="width: 40%; height: auto; object-fit: cover;">

                <!-- Content Section -->
                <div class="p-3" style="width: 60%;">
                    <h5 class="fw-bold mb-2" style="color: #5a5a5a;">Type of Fence</h5>
                    <p class="mb-2 text-muted">Location<br>How much time did it take</p>
                    <a href="#" class="btn btn-danger" style="border-radius: 5px;">Get A Quote</a>
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
    </div>
</main>
@endsection