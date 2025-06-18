@props(['admin' => true])
@if(!$admin)
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
            <img src="{{asset('assets/images/securecheckout.jpg')}}" alt="Visa" class="shadow-none w-100">
        </div>
    </div>
</div>
@else
<div class="card p-4 mb-4">
    <h4 class="mb-3">Payment Method</h4>    
    <div class="row gy-3">
        <div class="col-lg-6">
            <div class="col-md-12 mb-3">
                 <label for="cc-name" class="form-label">Select Payment Method</label>
                <select class="form-select form-select" id="payment-method">
                    <option value="">Select Payment</option>
                    <option value="cash">Cash</option>
                    <option value="check">Check</option>
                    <option value="paypal">PayPal</option>
                    <option value="account_card">Account Card</option>
                    <option value="office_card">Office Card</option>
                </select>
            </div>
            <div class="col-md-12">
                 <label for="cc-name" class="form-label">Select Account Card</label>
                <select class="form-select form-select" id="payment-method">
                    <option value="">Cards on account</option>
                    @php
                        // Example cards array. Replace with your actual data source.
                        $cards = [
                            ['id' => 1, 'number' => '4007000000027'],
                            ['id' => 2, 'number' => '4111111111111111'],
                            ['id' => 3, 'number' => '5555555555554444'],
                        ];
                    @endphp
                    @foreach($cards as $card)
                        @php
                            $masked = str_repeat('*', strlen($card['number']) - 4) . substr($card['number'], -4);
                        @endphp
                        <option value="{{ $card['id'] }}">{{ $masked }}</option>
                    @endforeach
                </select>
            </div>

        </div>

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
    </div>
</div>
@endif