@props(['cardHeader' => null, 'cardname' => 'default' , 'admin' => 'true'])
<div class="card p-4 mb-4 card-{{ $cardname }}">
    <h4 class="mb-3">{{ $cardHeader }}</h4>
    <div class="row g-3">
        @if($admin == true)
        <div class="col-md-12">
            <label for="addressSelect" class="form-label">Select Address</label>
            <select class="form-select form-select-lg" id="addressSelect" name="selected_address" required>
                <option value="">Choose an address...</option>
                <option value="1">1234 Main St, Newark, New Jersey, 07101</option>
                <option value="2">5678 Oak Ave, Jersey City, New Jersey, 07302</option>
                <option value="3">9101 Maple Rd, Hoboken, New Jersey, 07030</option>
            </select>
            <div class="invalid-feedback">
            Please select a valid address.
            </div>
        </div>
        @endif
        <div class="col-sm-6">
            <label for="firstName" class="form-label">First name</label>
            <input type="text" class="form-control" id="firstName" name="first_name" placeholder="" value="John" required>
            <div class="invalid-feedback">
                Valid first name is required.
            </div>
        </div>

        <div class="col-sm-6">
            <label for="lastName" class="form-label">Last name</label>
            <input type="text" class="form-control" id="lastName" name="last_name" placeholder="" value="Doe" required>
            <div class="invalid-feedback">
                Valid last name is required.
            </div>
        </div>
        <div class="col-lg-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="you@gmail.com" placeholder="you@example.com" require>
            <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
            </div>
        </div>

        <div class="col-lg-6">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="1234567890" placeholder="Phone number" required>
            <div class="invalid-feedback">
                Please enter a valid phone number.
            </div>
        </div>
        <div class="col-12">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="recipient_address" value="1234 Main St" placeholder="1234 Main St" required>
            <div class="invalid-feedback">
                Please enter your shipping address.
            </div>
        </div>

        <div class="col-12">
            <label for="address2" class="form-label">Address 2 <span class="text-muted">(Optional)</span></label>
            <input type="text" class="form-control" id="address2" name="address2" placeholder="Apartment or suite">
        </div>

        <div class="col-md-5">
            <label for="country" class="form-label">City</label>
            <input type="text" class="form-control" id="city1" name="city1" placeholder="Your City" value="Newark" required>
            <div class="invalid-feedback">
                Please select a valid City.
            </div>
        </div>

        <div class="col-md-4">
            <label for="state" class="form-label">State</label>
            <select class="form-select form-select-lg" id="state" name="recipient_state" required="">
                <option value="">Choose...</option>
                <option value="New Jersey">New Jersey</option>
            </select>
            <div class="invalid-feedback">
                Please provide a valid state.
            </div>
        </div>

        <div class="col-md-3">
            <label for="zip" class="form-label">Zip (Get Shipping)</label>
            <input type="text" class="form-control" id="zip" name="recipient_postal" value="" placeholder="Calculate Shipping" required="">
            <div class="invalid-feedback">
                Zip code required.
            </div>
        </div>
        @if($cardname == 'shipping')
        <div class="col-12 mt-4" id="shipping-options">
            
        </div>
        @endif
        @if($cardname == 'shipping')
        <div class="col-12">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="same-as-ship" name="save_info">
                <label class="form-check-label" for="save-info">Save this information for next time</label>
            </div>
        </div>
        @endif
    </div>
</div>