@extends('layouts.main')

@section('title', 'Checkout')

@section('content')
    <main class="container my-5">
        <h2 class="text-center mb-4">Checkout</h2>

        <div class="row">
            <div class="col-lg-8">
                <form id="checkout-form">
                    @csrf

                    <h5 class="mb-3">Shipper Information</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="shipper-address" class="form-label">Shipper Address</label>
                            <input type="text" id="shipper-address" name="shipper_address" class="form-control"
                                placeholder="Enter shipper address" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="shipper-city" class="form-label">Shipper City</label>
                            <input type="text" id="shipper-city" name="shipper_city" class="form-control"
                                placeholder="Enter shipper city" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="shipper-state" class="form-label">Shipper State</label>
                            <input type="text" id="shipper-state" name="shipper_state" class="form-control"
                                placeholder="Enter shipper state" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="shipper-postal" class="form-label">Shipper ZIP Code</label>
                            <input type="text" id="origin-zip" name="shipper_postal" class="form-control"
                                placeholder="Enter shipper ZIP code" required>
                        </div>
                    </div>

                    <h5 class="mb-3">Recipient Information</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="recipient-address" class="form-label">Recipient Address</label>
                            <input type="text" id="recipient-address" name="recipient_address" class="form-control"
                                placeholder="Enter recipient address" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="recipient-city" class="form-label">Recipient City</label>
                            <input type="text" id="recipient-city" name="recipient_city" class="form-control"
                                placeholder="Enter recipient city" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="recipient-state" class="form-label">Recipient State</label>
                            <input type="text" id="recipient-state" name="recipient_state" class="form-control"
                                placeholder="Enter recipient state" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="recipient-postal" class="form-label">Recipient ZIP Code</label>
                            <input type="text" id="destination-zip" name="recipient_postal" class="form-control"
                                placeholder="Enter recipient ZIP code" required>
                        </div>
                    </div>

                    <h5 class="mb-3">Package Information</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="weight" class="form-label">Weight (lbs)</label>
                            <input type="number" id="weight" name="weight" class="form-control"
                                placeholder="Enter package weight" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="length" class="form-label">Length (inches)</label>
                            <input type="number" id="length" name="length" class="form-control" placeholder="Length"
                                required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="width" class="form-label">Width (inches)</label>
                            <input type="number" id="width" name="width" class="form-control" placeholder="Width"
                                required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="height" class="form-label">Height (inches)</label>
                            <input type="number" id="height" name="height" class="form-control"
                                placeholder="Height" required>
                        </div>
                    </div>

                    <button type="button" id="calculate-shipping" class="btn btn-primary">Calculate Shipping</button>
                </form>

                <div id="shipping-options" class="mt-4">
                    <h5 class="mb-3">Available Shipping Rates</h5>
                    <div id="shipping-rates" class="border p-3"></div>
                </div>
            </div>

            <div class="col-lg-4">
                <h5>Your Order</h5>
                <div class="border p-3">
                    @foreach ($cart as $item)
                        <div class="d-flex justify-content-between">
                            <span>{{ $item['product_name'] }} × {{ $item['quantity'] }}</span>
                            <span>${{ number_format($item['total'], 2) }}</span>
                        </div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span>Subtotal</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Tax</span>
                        <span>${{ number_format($tax, 2) }}</span>
                    </div>
                    <div id="shipping-cost" class="d-flex justify-content-between d-none">
                        <span>Shipping</span>
                        <span>$0.00</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong id="total-amount"
                            data-total="{{ $total }}">${{ number_format($total, 2) }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        window.appConfig = {
            csrfToken: "{{ csrf_token() }}",
            calculateShippingUrl: "/shipping-rates",
        };
    </script>
    <script src="{{ secure_asset('js/checkout.js') }}"></script>
@endsection
