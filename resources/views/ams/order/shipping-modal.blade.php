<!-- Shipping Options Modal -->
<div class="modal fade" id="shippingModal" tabindex="-1" aria-labelledby="shippingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="shippingModalLabel">Shipping</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="shippingTabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#upsShipping">UPS Shipping</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#freightShipping">Freight Shipping</a>
                    </li>
                </ul>
                
                <div class="tab-content mt-3">
                    <!-- UPS Shipping Tab -->
                    <div class="tab-pane fade show active" id="upsShipping">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Class</th>
                                        <th>Size</th>
                                        <th>Qty per Box</th>
                                        <th>Weight</th>
                                        <th>Cost</th>
                                        <th>Item</th>
                                        <th>Qty in Box</th>
                                        <th>Weight of Box</th>
                                    </tr>
                                </thead>
                                <tbody id="upsShippingTable">
                                    <!-- UPS shipping items will be populated here -->
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Weight</th>
                                        <th>Total Cost</th>
                                        <th>Box Price</th>
                                        <th>Markup</th>
                                        <th>Full Price</th>
                                    </tr>
                                </thead>
                                <tbody id="upsShippingTotals">
                                    <!-- UPS shipping totals will be populated here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Freight Shipping Tab -->
                    <div class="tab-pane fade" id="freightShipping">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Carriers</th>
                                        <th>Weight</th>
                                        <th>Cost</th>
                                        <th>Markup</th>
                                        <th>Price</th>
                                        <th>Destination</th>
                                        <th>Quote Number</th>
                                        <th>Pallet Qty</th>
                                        <th>Pallet Size</th>
                                    </tr>
                                </thead>
                                <tbody id="freightShippingTable">
                                    <!-- Freight shipping items will be populated here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-3">
                    <button type="button" class="btn btn-success btn-sm" id="populateToOrder">Populate to Order</button>
                </div>
            </div>
        </div>
    </div>
</div>
