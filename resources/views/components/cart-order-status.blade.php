<div class="card p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="">
            <i class="bi me-2 bi-truck"></i>
            Order Status
        </h5>
        <span class="text-muted"><strong>Created On:</strong> {{ date('Y-m-d') }}</span>

    </div>
    <hr class="my-3">
    <div class="">
        <form>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="date2" class="form-label">Ouote: Colin</label>
                    <div class="input-group">
                        <input type="text" class="form-control order-date" id="date2" name="date2" value="2024-06-15" readonly>
                        <button type="button" class="btn btn-secondary add-date">
                            <i class="bi bi-calendar-date"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="date3" class="form-label">Sold</label>
                    <div class="input-group">
                        <input type="text" class="form-control order-date" id="date2" name="date2" value="" readonly>
                        <button type="button" class="btn btn-success add-date">
                            <i class="bi bi-calendar-date"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="date4" class="form-label">Customer Confirm</label>
                    <div class="input-group">
                        <input type="text" class="form-control order-date" id="date2" name="date2" value="" readonly>
                        <button type="button" class="btn btn-warning add-date">
                            <i class="bi bi-calendar-date"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="date5" class="form-label">Shipped Confirmed</label>
                    <div class="input-group">
                        <input type="text" class="form-control order-date" id="date2" name="date2" value="" readonly>
                        <button type="button" class="btn btn-danger add-date">
                            <i class="bi bi-calendar-date"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
