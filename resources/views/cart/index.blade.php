@extends('layouts.main')

@section('title', 'My Shopping Cart')

@section('content')
    <main class="container py-5">
        <h1 class="text-center mb-3">My Shopping Cart</h1>
        <p class="text-center text-danger">Because of current conditions, prices are subject to change without prior notice.
        </p>

        <table class="table table-bordered">
            <thead class="bg-light text-start">
                <tr>
                    <th class="text-start">Product Info</th>
                    <th class="text-start">Quantity</th>
                    <th class="text-start">Price per Item</th>
                    <th class="text-start">Price</th>
                </tr>
            </thead>
            <tbody>
                @forelse (session('cart', []) as $item)
                    <tr>
                        <td class="text-start">
                            <h6 class="mb-0">{{ $item['product_name'] }}
                                <i class="bi bi-trash text-danger ms-2 delete-btn" style="cursor: pointer;"
                                    data-item="{{ $item['item_no'] }}"></i>
                            </h6>
                            <small class="text-muted">Item # - {{ $item['item_no'] }}</small><br>
                            <small class="text-muted">Size: {{ $item['size'] ?? 'N/A' }}</small><br>
                            <small class="text-muted">Size 2: {{ $item['size2'] ?? 'N/A' }}</small><br>
                            <small class="text-muted">Size 3: {{ $item['size3'] ?? 'N/A' }}</small><br>
                            <small class="text-muted">Color: {{ $item['color'] ?? 'N/A' }}</small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <button class="btn btn-outline-secondary btn-sm quantity-decrease">-</button>
                                <input type="number" value="{{ $item['quantity'] }}"
                                    class="form-control mx-2 text-center quantity-input" style="width: 60px;"
                                    min="1">
                                <button class="btn btn-outline-secondary btn-sm quantity-increase">+</button>
                            </div>
                        </td>
                        <td class="price-per-item text-start">${{ number_format($item['price'], 2) }}</td>
                        <td class="total-price text-start">${{ number_format($item['total'], 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Your cart is empty.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-between mt-3">
            <div class="d-flex align-items-center gap-3">
                <button id="clear-cart" class="btn btn-outline-danger"
                    {{ session('cart') && count(session('cart')) > 0 ? '' : 'disabled' }}>
                    <i class="bi bi-trash"></i> Clear Cart
                </button>
            </div>
            <h4>Subtotal: <span class="fw-bold text-danger" id="subtotal">$0.00</span></h4>
            <button id="checkout-button" class="btn btn-danger"
                onclick="window.location.href='{{ route('checkout.index') }}'"
                {{ session('cart') && count(session('cart')) > 0 ? '' : 'disabled' }}>
                Proceed to Checkout
            </button>
        </div>
        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to remove this item from your cart?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clear Cart Confirmation Modal -->
        <div class="modal fade" id="clearCartModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Clear Cart</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to remove all items from your cart?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmClearCart">Clear All</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('scripts')
    <script src="{{ asset('js/cart-index.js') }}"></script>
@endsection
<!-- Bootstrap Toast Notification -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
    <div id="cart-toast" class="toast align-items-center text-white bg-success border-0" role="alert"
        aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div id="cart-toast-message" class="toast-body">
                Item removed from cart
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</div>
