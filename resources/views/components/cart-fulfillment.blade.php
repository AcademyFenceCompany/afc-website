@props(['cardHeader' => 'Customer Search', 'cardname' => 'default'])
<div class="card p-4 mb-4">
    <div class="mb-3 d-flex align-items-center justify-content-between">
        <h5 class="mb-0">
            <i class="bi bi-truck me-2"></i>
            {{$cardHeader}}
        </h5>
    </div>
    <div class="">
        <div class="row mb-3">
            <div class="col-md-4">
                <!-- Column 1 content -->
                <h6>Origin</h6>
                <ul class="list-group" style="border:2px solid green;">
                    <li class="list-group-item">
                        <input class="form-check-input me-1" type="radio" name="order-origin" value="afcStock" id="afcStockRadio" checked>
                        <label class="form-check-label stretched-link" for="afcStockRadio">AFC Stock</label>
                    </li>
                    <li class="list-group-item">
                        <input class="form-check-input me-1" type="radio" name="order-origin" value="afcMake" id="afcMakeRadio">
                        <label class="form-check-label stretched-link" for="afcMakeRadio">AFC Make</label>
                    </li>
                    <li class="list-group-item">
                        <input class="form-check-input me-1" type="radio" name="order-origin" value="afcAcquire" id="afcAcquireRadio">
                        <label class="form-check-label stretched-link" for="afcAcquireRadio">AFC Acquire</label>
                    </li>
                    <li class="list-group-item">
                        <input class="form-check-input me-1" type="radio" name="order-origin" value="dropShip" id="dropShipRadio">
                        <label class="form-check-label stretched-link" for="dropShipRadio">Drop Ship</label>
                    </li>
                </ul>
                </div>
                <div class="col-md-4">
                    <!-- Column 1 content -->
                    <h6>Shipping Method</h6>
                    <ul class="list-group" style="border:2px solid #8484ff;">
                        <li class="list-group-item">
                            <input class="form-check-input me-1" type="radio" name="shipping-method" value="smallPackage" id="smallPackageRadio" checked>
                            <label class="form-check-label stretched-link" for="smallPackageRadio">Small Package</label>
                        </li>
                        <li class="list-group-item">
                            <input class="form-check-input me-1" type="radio" name="shipping-method" value="freight" id="freightRadio">
                            <label class="form-check-label stretched-link" for="freightRadio">Freight</label>
                        </li>
                        <li class="list-group-item">
                            <input class="form-check-input me-1" type="radio" name="shipping-method" value="deliveryAfc" id="deliveryAfcRadio">
                            <label class="form-check-label stretched-link" for="deliveryAfcRadio">Delivery AFC</label>
                        </li>
                        <li class="list-group-item">
                            <input class="form-check-input me-1" type="radio" name="shipping-method" value="pickupAfc" id="pickupAfcRadio">
                            <label class="form-check-label stretched-link" for="pickupAfcRadio">Pickup AFC</label>
                        </li>
                    </ul>
            </div>
            <div class="col-md-4">
                <!-- Column 1 content -->
                <h6>Supplier</h6>
                <div class="mb-3">
                    <select class="form-select" id="companySelect" name="company">
                        <option selected disabled>Choose a company...</option>
                        <option value="acme">Acme Corp</option>
                        <option value="globex">Globex Inc</option>
                        <option value="initech">Initech</option>
                        <option value="umbrella">Umbrella Co</option>
                    </select>
                </div>
            </div>
        </div>

    </div>
</div>

