<div class="card mb-3 cart-summary shadow-sm" style="background-color: #fbf7db;">
    <div class="card-header bg-secondary p-3 d-flex align-items-center">
        <h4 class="card-title mb-0 text-dark flex-grow-1">
            <i class="bi bi-receipt-cutoff me-2"></i>Order Summary
        </h4>
        <button type="button" class="btn btn-outline-secondary btn-sm" id="refund-btn" title="Refund">
            <i class="bi bi-arrow-counterclockwise"></i> Refund
        </button>
    </div>
    <div class="card-body">
        <div class="cart-summary-container">
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>
                        <i class="bi bi-box-seam me-1"></i>
                        Item Subtotal (<span class="cart-count">{{$cart['quantity']}}</span>)
                    </span>
                    <span class="text-muted mini-cart-subtotal" data-mi-subtotal="">${{$cart['subtotal']}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>
                        <i class="bi bi-truck me-1"></i>
                        Shipping
                    </span>
                    <span class="text-muted shipping-cost" data-mi-shipping="">${{$cart['shipping_cost']}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>
                        <i class="bi bi-percent me-1"></i>
                        Discount
                    </span>
                    <span class="text-muted" id="discount-amount">${{ $cart['discount'] ?? '0.00' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>
                        <i class="bi bi-cash-coin me-1"></i>
                        Sales Tax
                    </span>
                    <span class="text-muted cart-tax" data-mi-taxes="0" id="tax-amount">${{$cart['tax']}}</span>
                </li>
            </ul>

            <form class="mb-3" id="discount-form">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Discount code" name="discount_code" aria-label="Discount code">
                    <button class="btn btn-outline-success" type="submit">
                        <i class="bi bi-ticket-perforated"></i> Apply
                    </button>
                </div>
            </form>

            <div class="form-check mb-3">
                <input class="form-check-input mt-2 me-3" type="checkbox" value="1" id="taxExempt" name="tax_exempt">
                <label class="form-check-label" for="taxExempt">
                    <i class="bi bi-shield-check me-1"></i>
                    Tax Exempt
                </label>
            </div>

            <div class="border-top py-3">
                <strong>Total (USD)</strong>
                <strong class="cart-total fs-5 text-success" data-mi-total="{{$cart['total']}}">${{$cart['total']}}</strong>
                <input type="number" class="form-control cart-total" name="cart_total" value="{{$cart['total']}}" max="{{$cart['total']}}" min="0" step="0.01" >
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-100 mt-3" id="place-order">
                <i class="bi bi-bag-check me-2"></i>Place Order
            </button>
        </div>
    </div>
</div>
