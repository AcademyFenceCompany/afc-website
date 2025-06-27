@props(['cardHeader' => 'Customer Search', 'cardname' => 'default'])
<div class="card p-4 mb-4">
    <div class="mb-3 align-items-center justify-content-between">
        <h5 class="mb-0">
            <i class="bi bi-truck me-2"></i>
            {{$cardHeader}}
        </h5>
        <span class="text-muted">Use this section to print or email documents for customers and suppliers.</span>
    </div>
    <div class="">
        <div class="row mb-3">
            <div class="col-md-12">
                <!-- Column 1 content -->
                <h6 class="text-success">Customer</h6>
                <div class="btn-group w-100 mb-3" role="group">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle rounded-end-0" type="button" id="documentDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Select Documents
                        </button>
                        <ul class="dropdown-menu p-3" aria-labelledby="documentDropdown" style="width: 200px;">
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="order_sheet" id="orderSheet">
                                    <label class="form-check-label" for="orderSheet">
                                        Order Sheet
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="quote_sheet" id="quoteSheet">
                                    <label class="form-check-label" for="quoteSheet">
                                        Quote Sheet
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="invoice" id="invoice">
                                    <label class="form-check-label" for="invoice">
                                        Invoice
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="packing_slip" id="packingSlip">
                                    <label class="form-check-label" for="packingSlip">
                                        Packing Slip
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="order_inquiry_slip" id="orderInquirySlip">
                                    <label class="form-check-label" for="orderInquirySlip">
                                        Order Inquiry Slip
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="shop_slip" id="shopSlip">
                                    <label class="form-check-label" for="shopSlip">
                                        Shop Slip
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <button class="btn btn-secondary" type="button">
                        <i class="bi bi-printer"></i> Print
                    </button>
                    <button class="btn btn-secondary" type="button">
                        <i class="bi bi-envelope"></i> Email
                    </button>
                </div>
            </div>
            <div class="col-md-12">
                <!-- Column 1 content -->
                <h6 class="text-info">Supplier</h6>
                <div class="mb-3">
                    <select class="form-select" id="companySelect" name="company">
                        <option selected disabled>Choose a company...</option>
                        <option value="acme">Acme Corp</option>
                        <option value="globex">Globex Inc</option>
                        <option value="initech">Initech</option>
                    </select>
                </div>
                <div class="btn-group w-100" role="group">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle rounded-end-0" type="button" id="documentDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Select Documents
                        </button>
                        <ul class="dropdown-menu p-3" aria-labelledby="documentDropdown" style="">
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="order_sheet" id="orderSheet">
                                    <label class="form-check-label" for="orderSheet">
                                        Order Sheet
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="quote_sheet" id="quoteSheet">
                                    <label class="form-check-label" for="quoteSheet">
                                        Quote Sheet
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="invoice" id="invoice">
                                    <label class="form-check-label" for="invoice">
                                        Invoice
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="packing_slip" id="packingSlip">
                                    <label class="form-check-label" for="packingSlip">
                                        Packing Slip
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="order_inquiry_slip" id="orderInquirySlip">
                                    <label class="form-check-label" for="orderInquirySlip">
                                        Order Inquiry Slip
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="shop_slip" id="shopSlip">
                                    <label class="form-check-label" for="shopSlip">
                                        Shop Slip
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <button class="btn btn-secondary" type="button">
                        <i class="bi bi-printer"></i> Print
                    </button>
                    <button class="btn btn-secondary" type="button">
                        <i class="bi bi-envelope"></i> Email
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

