<div class="card p-4 mb-4">
    <h4 class="mb-3">Payment Method</h4>    
    <div class="row gy-3">
        <div class="col-lg-6">
            <div class="col-md-12">
                <label for="cc-name" class="form-label">Name on card</label>
                <input type="text" class="form-control" id="cc-name" name="cc_name" value="John Newman" placeholder="" required="">
                <small class="text-muted">Full name as displayed on card</small>
                <div class="invalid-feedback">
                    Name on card is required
                </div>
            </div>
            <div class="col-md-12">
                <label for="cc-number" class="form-label">Credit card number</label>
                <input type="text" class="form-control" id="cc-number" name="cc_number" value="4007000000027" placeholder="" required="">
                <div class="invalid-feedback">
                    Credit card number is required
                </div>
            </div>
            <div class="col-lg-12 mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <label for="cc-expiration" class="form-label">Expiration</label>
                        <input type="text" class="form-control" id="cc-expiration" name="cc_expiration" placeholder="MM/YY" value="05/26" required>
                        <div class="invalid-feedback">
                            Expiration date required
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="cc-cvv" class="form-label">CVV</label>
                        <input type="text" class="form-control" id="cc-cvv" name="cc_cvv" value="243" placeholder="" required="">
                        <div class="invalid-feedback">
                            Security code required
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-6">
            <img src="{{asset('assets/images/securecheckout.jpg')}}" alt="Visa" class="shadow-none">
        </div>
    </div>
</div>