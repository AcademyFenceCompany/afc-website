{{-- Frontend Shipping options list --}}
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

{{-- Backend Shipping options list --}}
<div class="card bg-light mb-3">
    <div class="card-header bg-primary text-dark py-2">
        <h5 class="card-title">Shipping Options</h5>
        <p class="card-text">Select a shipping method for your order.</p>
    </div>
    <div class="px-3 py-2">
        <h5 class="card-title">Items in shipment</h5>
        <div class="table-responsive w-100">
            <table class="table table-striped table-success" style="border:2px solid Green;">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Item #</th>
                    <th scope="col">Size</th>
                    <th scope="col">Qty/Box</th>
                    <th scope="col">Weight/box</th>
                    <th scope="col">Cost</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>WW441110048BK</td>
                        <td>16x49x16</td>
                        <td>1</td>
                        <td>105.00lbs</td>
                        <td>$343.00</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>WW441110048BK</td>
                        <td>16x49x16</td>
                        <td>1</td>
                        <td>105.00lbs</td>
                        <td>$343.00</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>WW441110048BK</td>
                        <td>16x49x16</td>
                        <td>1</td>
                        <td>105.00lbs</td>
                        <td>$343.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table-responsive w-100">
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">Total Weight</th>
                    <th scope="col">Total Cost</th>
                    <th scope="col">Price/Box</th>
                    <th scope="col">Markup</th>
                    <th scope="col">Full Price</th>
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
            <div class="ms-2 d-flex me-auto justify-content-between align-items-start">
                <div>
                    <div class="fw-bold">UPS Ground</div>Estimated delivery by <span class="text-muted">Monday, Oct 30</span>
                </div>
                <span class="badge text-bg-secondary rounded-pill">$343</span>
            </div>
           
            
        </li>
        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-start">
            <div class="ms-2 me-auto">
            <div class="fw-bold">TForce Freight (Standard LTL) </div>
            Estimated delivery by <span class="text-muted">Monday, Oct 30</span>
            </div>
            <span class="badge text-bg-primary rounded-pill">14</span>
        </li>
        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-start">
            <div class="ms-2 me-auto">
            <div class="fw-bold">R&amp;L Carriers (Standard Service) </div>
            Estimated delivery by <span class="text-muted">Monday, Oct 30</span>
            </div>
            <span class="badge text-bg-primary rounded-pill">14</span>
        </li>
    </ul>
</div>