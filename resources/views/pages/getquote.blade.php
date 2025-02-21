@extends('layouts.main')

@section('title', 'Get a Quote')

@section('content')
<main class="container">
    <div class="card">
        <div class="card-header text-center bg-primary text-white">
            <h2>Get Quote</h2>
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
                    <!-- <div class="col-md-6 d-flex align-items-center">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="recaptcha" required>
                            <label for="recaptcha" class="form-check-label">I am not a robot</label>
                        </div>
                    </div> -->
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-danger">Submit</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const states = [
        { code: "AL", name: "Alabama" }, { code: "AK", name: "Alaska" }, { code: "AZ", name: "Arizona" },
        { code: "AR", name: "Arkansas" }, { code: "CA", name: "California" }, { code: "CO", name: "Colorado" },
        { code: "CT", name: "Connecticut" }, { code: "DE", name: "Delaware" }, { code: "FL", name: "Florida" },
        { code: "GA", name: "Georgia" }, { code: "HI", name: "Hawaii" }, { code: "ID", name: "Idaho" },
        { code: "IL", name: "Illinois" }, { code: "IN", name: "Indiana" }, { code: "IA", name: "Iowa" },
        { code: "KS", name: "Kansas" }, { code: "KY", name: "Kentucky" }, { code: "LA", name: "Louisiana" },
        { code: "ME", name: "Maine" }, { code: "MD", name: "Maryland" }, { code: "MA", name: "Massachusetts" },
        { code: "MI", name: "Michigan" }, { code: "MN", name: "Minnesota" }, { code: "MS", name: "Mississippi" },
        { code: "MO", name: "Missouri" }, { code: "MT", name: "Montana" }, { code: "NE", name: "Nebraska" },
        { code: "NV", name: "Nevada" }, { code: "NH", name: "New Hampshire" }, { code: "NJ", name: "New Jersey" },
        { code: "NM", name: "New Mexico" }, { code: "NY", name: "New York" }, { code: "NC", name: "North Carolina" },
        { code: "ND", name: "North Dakota" }, { code: "OH", name: "Ohio" }, { code: "OK", name: "Oklahoma" },
        { code: "OR", name: "Oregon" }, { code: "PA", name: "Pennsylvania" }, { code: "RI", name: "Rhode Island" },
        { code: "SC", name: "South Carolina" }, { code: "SD", name: "South Dakota" }, { code: "TN", name: "Tennessee" },
        { code: "TX", name: "Texas" }, { code: "UT", name: "Utah" }, { code: "VT", name: "Vermont" },
        { code: "VA", name: "Virginia" }, { code: "WA", name: "Washington" }, { code: "WV", name: "West Virginia" },
        { code: "WI", name: "Wisconsin" }, { code: "WY", name: "Wyoming" }
    ];

    const stateSelect = document.getElementById("state");
    states.forEach(state => {
        let option = document.createElement("option");
        option.value = state.code;
        option.textContent = state.name;
        stateSelect.appendChild(option);
    });

    const inputField = document.getElementById("stateInput");
    const resultDisplay = document.getElementById("stateName");
    
    inputField.addEventListener("input", function () {
        let userInput = inputField.value.trim().toUpperCase();
        let foundState = states.find(state => state.code === userInput);
        resultDisplay.textContent = foundState ? foundState.name : "State not found";
        
        if (foundState) {
            stateSelect.value = foundState.code;
        }
    });
});

</script>