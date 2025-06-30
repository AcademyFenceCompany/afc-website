{{-- Frontend Shipping options list --}}
@props(['admin' => false, 'cart' => $cart ?? [], 'upsrates' => 0, 'tForceRates' => 0, 'rlCarriersRates' => 0, 'rlCarriersRatesAll' => []])

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
            <span class="badge text-bg-primary text-dark rounded-pill ship-module-price">{{$rlCarriersRates}}</span>
        </li>
        @endif
    </ul>
</div>
@else
{{-- Admin Shipping options list --}}
<div class="card bg-light mb-3 border-0" style="border: 1px solid #cecece;">
    <div class="card-header bg-warning text-dark py-2">
        <h5 class="card-title">Shipping Options</h5>
        <p class="card-text">Select a shipping method for your order.</p>
    </div>
    <div class="px-3 py-3">
        <div class="d-flex justify-content-between align-items-center">
            <p class="badge rounded-pill text-bg-success p-3"><i class="bi bi-truck me-3"></i><strong>Origin: </strong>{{ $formData['sender_state'] }}, {{$formData['sender_postal']}}</p>
            <p class="badge rounded-pill text-bg-danger p-3"> <i class="bi bi-geo-alt-fill me-3"></i><strong>Destination: </strong>{{ $formData['recipient_state'] }}, {{ $formData['recipient_postal'] }}</p>
        </div>

        <figure class="text-center">
            <blockquote class="blockquote">
                <p>Items in the shipment.</p>
            </blockquote>
            <figcaption class="blockquote-footer">
                This shipment contains items that will be shipped together.
            </figcaption>
        </figure>
    </div>
    <div style="border: 2px dashed rgb(133, 103, 103); background-color: #FFF;" class="p-3 mb-4">
        <div class="ms-2 mb-3 d-flex me-auto justify-content-between align-items-start">
            <div class="d-flex align-items-center">
                <img src="https://upload.wikimedia.org/wikipedia/commons/e/e9/Ups_logo.png?20230812203117 alt="Small Package Icon" style="width:50px; height:50px; margin-right:10px;">
                <div>
                    <div class="fw-bold">Small Package</div>
                    Estimated delivery by <span class="text-muted">Monday, Oct 30</span>
                </div>
            </div>
        </div>
        <!-- Table for small package items -->
        <div class="table-responsive w-100">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                    <th scope="col">Item #</th>
                    <th scope="col">Package(LxWxH)</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Weight/box</th>
                    <th scope="col">Box Charge</th>
                    <th scope="col">UPS Cost</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart['items'] as $item)
                    <tr>
                        <td>{{ $item['item_no'] }}</td>
                        <td>{{ $item['length'] }}x{{$item['width'] }}x{{$item['height']}}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ $item['weight'] }} lbs</td>
                        <td>--</td>
                        <td>--</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Total summary for small package -->
        <div class="table-responsive w-100">
            <table class="table table-success" style="border:2px solid Green;">
                <thead>
                    <tr>
                    <th scope="col">Total Weight</th>
                    <th scope="col">Total Cost</th>
                    <th scope="col">Total Box Charge</th>
                    <th scope="col">Markup</th>
                    <th scope="col">Shipping Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">{{$cart['weight']}} lbs</th>
                    <td>--</td>
                    <td>--</td>
                    <td>--</td>
                    <td><span class="badge text-bg-primary rounded-pill fs-6">${{$upsrates}}</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="w-100 mb-3">
            <ul class="list-group">
                @foreach($upsallrates as $upsrate)
                <li class="list-group-item d-flex align-items-center">
                    <input class="form-check-input me-3" type="checkbox" value="" id="firstCheckbox">
                    @php
                        // UPS service code descriptions
                        $upsServiceDescriptions = [
                            '01' => 'UPS Next Day Air',
                            '02' => 'UPS 2nd Day Air',
                            '03' => 'UPS Ground',
                            '12' => 'UPS 3 Day Select',
                            '13' => 'UPS Next Day Air Saver',
                            '14' => 'UPS Next Day Air Early',
                            '59' => 'UPS 2nd Day Air AM',
                            '07' => 'UPS Worldwide Express',
                            '08' => 'UPS Worldwide Expedited',
                            '11' => 'UPS Standard',
                            '54' => 'UPS Worldwide Express Plus',
                            '65' => 'UPS Saver',
                            // Add more as needed
                        ];
                        $serviceCode = $upsrate['service_code'] ?? '';
                        $serviceDesc = $upsServiceDescriptions[$serviceCode] ?? 'UPS Service';
                    @endphp
                    <label class="form-check-label me-auto" for="firstCheckbox">{{ $serviceDesc }}</label>
                    <span class="badge text-bg-primary rounded-pill">${{$upsrate['total_cost']}}</span>
                </li>
                @endforeach
            </ul>
        </div>


    </div>
    <ul class="list-group" style="border: 2px solid #4d4d4d; background-color: #FFF;">
        <li class="list-group-item bg-transparent">
            <div class="ms-2 mb-3 d-flex me-auto justify-content-between align-items-start">
                <div class="d-flex align-items-center">
                    <img src="https://d1yjjnpx0p53s8.cloudfront.net/styles/logo-thumbnail/s3/022023/tforce-preview.png?fRv6FSKuOn2gLoSsibSd3YdmHrW3e2pS&itok=Nq4QxgRB" alt="Freight Icon" style="width:50px; height:50px; margin-right:10px;">
                    <div>
                        <div class="fw-bold">Freight</div>
                        Estimated delivery by <span class="text-muted">Monday, Oct 30</span>
                    </div>
                </div>
            </div>
            <div class="table-responsive w-100">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col"></th>
                        <th scope="col">Carrier</th>
                        <th scope="col">Ouote #</th>
                        <th scope="col">Weight</th>
                        <th scope="col">Pallet <br> Qty</th>
                        <th scope="col">Pallet <br> Size</th>
                        <th scope="col">Pallet <br> Charge</th>
                        <th scope="col">Cost</th>
                        <th scope="col">Markup</th>
                        <th scope="col">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input class="form-check-input me-3" type="checkbox" value=""></td>
                            <td>TForce Freight</td>
                            <td>525 lbs</td>
                            <td>Q123456</td>
                            <td>2</td>
                            <td>48x48x60</td>
                            <td>$34</td>
                            <td>$234.33</td>
                            <td>$25</td>
                            <td><span class="badge text-bg-primary rounded-pill fs-6">${{$tForceRates}}</span></td>
                        </tr>
                        <tr>
                            <td><input class="form-check-input me-3" type="checkbox" value=""></td>
                            <td>R&L Carriers</td>
                            <td>525 lbs</td>
                            <td>Q123457</td>
                            <td>2</td>
                            <td>48x48x60</td>
                            <td>$34</td>
                            <td>$234.33</td>
                            <td>$25</td>
                            <td><span class="badge text-bg-primary rounded-pill fs-6">{{$rlCarriersRates}}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </li>
    </ul>
</div>
@endif
