<div class="dropdown" style="margin-left: 10px;">
    <a href="#" class="nav-link position-relative text-light" id="cartDropdown" data-bs-toggle="dropdown">
        <i class="bi bi-cart fs-4"></i>
        <span id="cart-count" class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill">
            {{ session('cart') ? count(session('cart')) : 0 }}
        </span>
    </a>

    <div class="dropdown-menu dropdown-menu-end p-3 shadow-lg" style="min-width: 270px;">
        <ul id="mini-cart-items" class="list-unstyled mb-2">
            @foreach (session('cart', []) as $item)
                <li class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h6 class="mb-0" style="font-size: 14px;">{{ $item['product_name'] }}</h6>
                        <small class="text-muted">Qty: {{ $item['quantity'] }}</small>
                    </div>
                    <span class="fw-bold" style="font-size: 14px;">${{ number_format($item['total'], 2) }}</span>
                </li>
                <hr>
            @endforeach
        </ul>

        <p id="empty-cart-message" class="{{ count(session('cart', [])) > 0 ? 'd-none' : '' }} text-center">Your cart is
            empty
        </p>
        <div class="d-grid gap-2">
            <a href="{{ route('cart.view') }}" class="btn btn-danger w-100">View Cart</a>
            <a href="{{ route('checkout.index') }}" class="btn btn-danger w-100">Checkout</a>
        </div>
    </div>
</div>
