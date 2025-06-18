@props(['cardHeader' => 'Customer Search', 'cardname' => 'default'])
<div class="card mb-4">
    <div class="card-header">
        <h4>{{$cardHeader}}</h4>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <!-- Column 1 content -->
                <h6>Origin</h6>
                <ul class="list-group" style="border:2px solid green;">
                    <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" name="order-origin" value="" id="firstCheckboxStretched">
                        <label class="form-check-label stretched-link" for="firstCheckboxStretched">AFC Stock</label>
                    </li>
                    <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="" id="secondCheckboxStretched">
                        <label class="form-check-label stretched-link" for="secondCheckboxStretched">AFC Make</label>
                    </li>
                    <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="" id="thirdCheckboxStretched">
                        <label class="form-check-label stretched-link" for="thirdCheckboxStretched">AFC Acquire</label>
                    </li>
                    <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="" id="thirdCheckboxStretched">
                        <label class="form-check-label stretched-link" for="thirdCheckboxStretched">Drop Ship</label>
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <!-- Column 1 content -->
                <h6>Shipping Method</h6>
                <ul class="list-group" style="border:2px solid #8484ff;">
                    <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="" id="firstCheckboxStretched">
                        <label class="form-check-label stretched-link" for="firstCheckboxStretched">Small Package</label>
                    </li>
                    <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="" id="secondCheckboxStretched">
                        <label class="form-check-label stretched-link" for="secondCheckboxStretched">Frieght</label>
                    </li>
                    <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="" id="thirdCheckboxStretched">
                        <label class="form-check-label stretched-link" for="thirdCheckboxStretched">Delivery AFC</label>
                    </li>
                    <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="" id="thirdCheckboxStretched">
                        <label class="form-check-label stretched-link" for="thirdCheckboxStretched">Pickup AFC </label>
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <!-- Column 1 content -->
                <h6>Supplier</h6>
                <div class="mb-3">
                    <label for="companySelect" class="form-label">Select Supplier</label>
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

