@extends('layouts.main')

@section('title', 'Home')

@section('content')
<!-- Main Content -->
<main class="container">
        <div class="card">
            <div class="card-header text-center bg-primary text-white">
                <h2>Contact us</h2>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <p><i class="bi bi-envelope"></i> info@academyfence.com &nbsp;  &nbsp; <i class="bi bi-telephone"></i> (973) 674-0600 &nbsp;  &nbsp; <i class="bi bi-geo-alt"></i> 119 N Day Street, Orange, NJ</p>
                </div>
    
                <div class="text-center mb-4">
                    <h5>Use Our Quote Sheet</h5>
                    <p>You can fill out this form and upload it below</p>
                    <button class="btn btn-danger">Print Quote Sheet</button>
                </div>
    
                <!-- Contact Form -->
                <form action="/submit-contact" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">Name*</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter your name..." required>
                        </div>
                        <div class="col-md-6">
                            <label for="phone_number" class="form-label">Phone number*</label>
                            <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="Enter your phone number..." required pattern="^\d{10}$" title="Please enter a 10-digit phone number">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email*</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email..." required>
                        </div>
                        <div class="col-md-6">
                            <label for="zip_code" class="form-label">Zip Code*</label>
                            <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="Enter zip code..." required pattern="^\d{5}$" title="Please enter a 5-digit zip code">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description*</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Tell us more about the product..." required></textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="quote_sheet" class="form-label">Upload Quote Sheet Here*</label>
                            <input type="file" class="form-control" id="quote_sheet" name="quote_sheet" required>
                        </div>
                        <div class="col-md-6 d-flex align-items-center">
                            <!-- reCAPTCHA Placeholder -->
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="not_a_robot" required>
                                <label class="form-check-label" for="not_a_robot">I'm not a robot</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                </form>
            </div>
        </div>
</main>
<script>
    function validateForm() {
        const phoneNumber = document.getElementById('phone_number').value;
        const zipCode = document.getElementById('zip_code').value;

        // Validate phone number
        const phonePattern = /^\d{10}$/;
        if (!phonePattern.test(phoneNumber)) {
            alert("Please enter a valid 10-digit phone number.");
            return false;
        }

        // Validate zip code
        const zipPattern = /^\d{5}$/;
        if (!zipPattern.test(zipCode)) {
            alert("Please enter a valid 5-digit zip code.");
            return false;
        }

        return true; // Submit the form if all validations pass
    }
</script>
@endsection
