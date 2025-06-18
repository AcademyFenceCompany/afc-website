{{-- Frontend Shipping options list --}}
@props(['admin' => true, 'cart' => $cart ?? [], 'upsrates' => 0, 'tForceRates' => 0, 'rlCarriersRates' => 0])

{{-- Check if the user is an admin --}}
@if(!$admin)
<div class="card bg-light mb-3">  
    <ul class="list-group list-group-flush ">

        <li class="list-group-item d-flex bg-primary justify-content-between align-items-start ship-module">
            <input class="form-check-input me-1 mt-2" type="radio" name="shipmethod" value="pickup" checked>
            <div class="ms-2 me-auto">
                <div class="fw-bold">Pick Up</div>
                Pick up at our warehouse in <span class="text-muted">Orange, NJ</span>
            </div>
            <span class="badge text-bg-secondary rounded-pill">FREE</span>
        </li>
        @if(isset($upsrates) && $upsrates != 0)
            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-start ship-module" data-shipping-cost="ups">
                <input class="form-check-input me-1 mt-2" type="radio" name="shipmethod" value="ups">
                <div class="ms-2 me-auto">
                    <div class="fw-bold">UPS Ground</div>
                    Estimated delivery by <span class="text-muted">{{ \Carbon\Carbon::now()->addDays(5)->format('l, M d') }}</span>
                </div>
                <span class="badge text-bg-primary text-dark rounded-pill">${{$upsrates}}</span>
                
            </li>   
        @endif
        @if(isset($tForceRates) && $tForceRates != 0)
            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-start ship-module" data-shipping-cost="tforce">
                <input class="form-check-input me-1 mt-2" type="radio" name="shipmethod" value="tforce">
                <div class="ms-2 me-auto">
                    <div class="fw-bold">TForce Freight (Standard LTL) </div>
                    Estimated delivery by <span class="text-muted">{{ \Carbon\Carbon::now()->addDays(5)->format('l, M d') }}</span>
                </div>
                
                <span class="badge text-bg-primary text-dark rounded-pill">${{ $tForceRates }}</span>
            </li>
        @endif
        @if(isset($rlCarriersRates) && $rlCarriersRates != 0)
        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-start ship-module" data-shipping-cost="rl_carriers">
            <input class="form-check-input me-1 mt-2" type="radio" name="shipmethod" value="rl_carriers">
            <div class="ms-2 me-auto">
            <div class="fw-bold">R&L Carriers (Standard Service) </div>
                Estimated delivery by <span class="text-muted">{{ \Carbon\Carbon::now()->addDays(5)->format('l, M d') }}</span>
            </div>
            <span class="badge text-bg-primary text-dark rounded-pill ship-module-price">${{$rlCarriersRates}}</span>
        </li>
        @endif
    </ul>
</div>
@else
{{-- Admin Shipping options list --}}
<div class="card bg-light mb-3" style="border: 1px solid #cecece;">
    <div class="card-header bg-primary text-dark py-2">
        <h5 class="card-title">Shipping Options</h5>
        <p class="card-text">Select a shipping method for your order.</p>
    </div>
    <div class="px-3 py-3">
        <div class="d-flex justify-content-between align-items-center">
            <p class="badge rounded-pill text-bg-success p-3"><i class="bi bi-truck me-3"></i><strong>Origin: </strong>NJ, 07050</p>
            <p class="badge rounded-pill text-bg-danger p-3"> <i class="bi bi-geo-alt-fill me-3"></i><strong>Destination: </strong>{{$formData['recipient_state']}}, {{$formData['recipient_postal']}}</p>
        </div>

        <figure class="text-center">
            <blockquote class="blockquote">
                <p>Items in the shipment. 2</p>
            </blockquote>
            <figcaption class="blockquote-footer">
                This shipment contains items that will be shipped together.
            </figcaption>
        </figure>

        <div class="table-responsive w-100">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                    <th scope="col">Item #</th>
                    <th scope="col">Size(LxWxH)</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Weight/box</th>
                    <th scope="col">Price/Box</th>
                    <th scope="col">Cost</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart['items'] as $item)
                    <tr>
                        <td>{{$item['id']}}</td>
                        <td>{{ $item['length'] }}x{{ $item['width'] }}x{{ $item['height'] }}</td>
                        <td>{{$item['quantity']}}</td>
                        <td>{{$item['weight']}} lbs</td>
                        <td>$5.00</td>
                        <td>$343.00</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="table-responsive w-100">
            <table class="table table-success" style="border:2px solid Green;">
                <thead>
                    <tr>
                    <th scope="col">Total Weight</th>
                    <th scope="col">Total Cost</th>
                    <th scope="col">Total Price/Box</th>
                    <th scope="col">Markup</th>
                    <th scope="col">Shipping Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">{{$cart['weight']}} lbs</th>
                    <td>$234.33</td>
                    <td>$25</td>
                    <td>$234.34</td>
                    <td>$1243.34</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <ul class="list-group list-group-flush ">
        {{-- @dump($cart, $shippingmethod, $upsallrates, $upsrates, $tForceRates, $rlCarriersRates) --}}
        @if($cart['weight'] < 150)
        <li class="list-group-item bg-transparent">
            <div class="ms-2 mb-3 d-flex me-auto justify-content-between align-items-start">
                <div>
                    <div class="fw-bold">Small Package</div>Estimated delivery by <span class="text-muted">{{ \Carbon\Carbon::now()->addDays(5)->format('l, M d') }}</span>
                </div>
            </div>
            <div class="w-100 mb-3">
                <ul class="list-group">
                    
                    <li class="list-group-item d-flex align-items-center">
                        <input class="form-check-input me-3" type="checkbox" value="" id="firstCheckbox">
                        <label class="form-check-label me-auto" for="firstCheckbox">USPS Small Package</label>
                        <span class="badge text-bg-primary rounded-pill text-dark">${{$upsrates}}</span>
                    </li>
                </ul>
            </div>
        </li>
        @else
        <li class="list-group-item bg-transparent">
            <div class="ms-2 mb-3 d-flex me-auto justify-content-between align-items-start">
                <div>
                    <div class="fw-bold">Freight</div>Estimated delivery by <span class="text-muted">{{ \Carbon\Carbon::now()->addDays(5)->format('l, M d') }}</span>
                </div>
            </div>
            <div class="w-100 mb-3">
                <ul class="list-group">
                    <li class="list-group-item d-flex align-items-center">
                        <input class="form-check-input me-3" type="checkbox" value="" id="firstCheckbox">
                        <label class="form-check-label me-auto" for="firstCheckbox">TForce Freight (Standard LTL)</label>
                        <span class="badge text-bg-primary rounded-pill text-dark">${{$tForceRates}}</span>
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <input class="form-check-input me-3" type="checkbox" value="" id="firstCheckbox">
                        <label class="form-check-label me-auto" for="firstCheckbox">R&amp;L Carriers (Standard Service) </label>
                        <span class="badge text-bg-primary rounded-pill text-dark">{{$rlCarriersRates}}</span>
                    </li>
                </ul>
            </div>
        </li>
        @endif
    </ul>
</div>
@endif
