{{-- Frontend Shipping options list 
<div class="card bg-light mb-3 d-none">
    <ul class="list-group list-group-flush ">

        <li class="list-group-item d-flex bg-primary justify-content-between align-items-start">
            <input class="form-check-input me-1" type="radio" name="shipmethod" value="pickup" checked>
            <div class="ms-2 me-auto">
                <div class="fw-bold">Pick Up</div>
                Pick up at our warehouse in <span class="text-muted">Orange, NJ</span>
            </div>
            <span class="badge text-bg-secondary rounded-pill">FREE</span>
        </li>
        @if(isset($upsrates['total_cost']))
            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="fw-bold">UPS Ground</div>
                    Estimated delivery by <span class="text-muted">{{ \Carbon\Carbon::now()->addDays(5)->format('l, M d') }}</span>
                </div>
                
                <span class="badge text-bg-secondary rounded-pill">${{ $upsrates['total_cost'] }}</span>
                
            </li>
        @endif
        @if(!isset($tForceRates['error']))
            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-start">
                <input class="form-check-input me-1" type="radio" name="shipmethod" value="freight">
                <div class="ms-2 me-auto">
                    <div class="fw-bold">TForce Freight (Standard LTL) </div>
                    Estimated delivery by <span class="text-muted">{{ \Carbon\Carbon::now()->addDays($tForceRates['detail'][0]['timeInTransit']['timeInTransit'])->format('l, M d') }}</span>
                </div>
                
                <span class="badge text-bg-primary rounded-pill">${{ $tForceRates['detail'][0]['shipmentCharges']['total']['value'] }}</span>
            </li>
        @endif
        @if(!isset($rlCarriersRates['error']))
        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-start">
            <input class="form-check-input me-1" type="radio" name="shipmethod" value="freight">
            <div class="ms-2 me-auto">
            <div class="fw-bold">R&L Carriers (Standard Service) </div>
                Estimated delivery by <span class="text-muted">{{ \Carbon\Carbon::now()->addDays(5)->format('l, M d') }}</span>
            </div>
            <span class="badge text-bg-primary rounded-pill">{{$rlCarriersRates['d']['Result']['ServiceLevels'][0]['NetCharge']}}</span>
        </li>
        @endif
    </ul>
</div>
--}}
{{-- Backend Shipping options list --}}
<div class="card bg-light mb-3">
    <div class="card-header bg-primary text-dark py-2">
        <h5 class="card-title">Shipping Options</h5>
        <p class="card-text">Select a shipping method for your order.</p>
    </div>
    <div class="px-3 py-3">
        <div class="d-flex justify-content-between align-items-center">
            <p class="badge rounded-pill text-bg-success p-3"><i class="bi bi-truck me-3"></i><strong>Origin: </strong>NJ, 07102</p>
            <p class="badge rounded-pill text-bg-danger p-3"> <i class="bi bi-geo-alt-fill me-3"></i><strong>Destination: </strong>NJ, 07102</p>
        </div>
        

        <figure class="text-center">
            <blockquote class="blockquote">
                <p>Items in the shipment.</p>
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
                    <tr>
                        <td>WW441110048BK</td>
                        <td>16x49x16</td>
                        <td>1</td>
                        <td>105.00 lbs</td>
                        <td>$5.00</td>
                        <td>$343.00</td>
                    </tr>
                    <tr>
                        <td>WW441110048BK</td>
                        <td>16x49x16</td>
                        <td>1</td>
                        <td>105.00 lbs</td>
                        <td>$5.00</td>
                        <td>$343.00</td>
                    </tr>
                    <tr>
                        <td>WW441110048BK</td>
                        <td>16x49x16</td>
                        <td>1</td>
                        <td>105.00 lbs</td>
                        <td>$5.00</td>
                        <td>$343.00</td>
                    </tr>
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
                    <th scope="row">525 lbs</th>
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
        <li class="list-group-item bg-transparent">
            <div class="ms-2 mb-3 d-flex me-auto justify-content-between align-items-start">
                <div>
                    <div class="fw-bold">Small Package</div>Estimated delivery by <span class="text-muted">Monday, Oct 30</span>
                </div>
            </div>
            <div class="w-100 mb-3">
                <ul class="list-group">
                    <li class="list-group-item d-flex align-items-center">
                        <input class="form-check-input me-3" type="checkbox" value="" id="firstCheckbox">
                        <label class="form-check-label me-auto" for="firstCheckbox">USPS Small Package</label>
                        <span class="badge text-bg-primary rounded-pill">$423</span>
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <input class="form-check-input me-3" type="checkbox" value="" id="firstCheckbox">
                        <label class="form-check-label me-auto" for="firstCheckbox">UPS Ground</label>
                        <span class="badge text-bg-primary rounded-pill">$423</span>
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <input class="form-check-input me-3" type="checkbox" value="" id="firstCheckbox">
                        <label class="form-check-label me-auto" for="firstCheckbox">UPS Standard</label>
                        <span class="badge text-bg-primary rounded-pill">$43</span>
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <input class="form-check-input me-3" type="checkbox" value="" id="firstCheckbox">
                        <label class="form-check-label me-auto" for="firstCheckbox">UPS Worldwide Express Freight</label>
                        <span class="badge text-bg-primary rounded-pill">$532</span>
                    </li> 
                    <li class="list-group-item d-flex align-items-center">
                        <input class="form-check-input me-3" type="checkbox" value="" id="firstCheckbox">
                        <label class="form-check-label me-auto" for="firstCheckbox">UPS Next Day Air</label>
                        <span class="badge text-bg-primary rounded-pill">$432</span>
                    </li>
                </ul>
            </div>
            
        </li>
        <li class="list-group-item bg-transparent">
            <div class="ms-2 mb-3 d-flex me-auto justify-content-between align-items-start">
                <div>
                    <div class="fw-bold">Freight</div>Estimated delivery by <span class="text-muted">Monday, Oct 30</span>
                </div>
            </div>
            <div class="w-100 mb-3">
                <ul class="list-group">
                    <li class="list-group-item d-flex align-items-center">
                        <input class="form-check-input me-3" type="checkbox" value="" id="firstCheckbox">
                        <label class="form-check-label me-auto" for="firstCheckbox">TForce Freight (Standard LTL)</label>
                        <span class="badge text-bg-primary rounded-pill">$423</span>
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <input class="form-check-input me-3" type="checkbox" value="" id="firstCheckbox">
                        <label class="form-check-label me-auto" for="firstCheckbox">R&amp;L Carriers (Standard Service) </label>
                        <span class="badge text-bg-primary rounded-pill">$43</span>
                    </li>
                </ul>
            </div>
            
        </li>
    </ul>
</div>