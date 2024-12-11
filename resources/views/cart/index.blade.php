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
                            <small class="text-muted">{{ $item['mesh'] ?? 'N/A' }}</small><br>
                            <small class="text-muted">{{ $item['size'] ?? 'N/A' }}</small><br>
                            <small class="text-muted">{{ $item['color'] ?? 'N/A' }}</small>
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
            <h4>Subtotal: <span class="fw-bold text-danger" id="subtotal">$0.00</span></h4>
            <button onclick="window.location.href='{{ route('checkout.index') }}'" class="btn btn-danger">
                Proceed to Checkout
            </button>


        </div>
    </main>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const subtotalElement = document.getElementById('subtotal');

        const updateCartTotal = () => {
            let subtotal = 0;

            document.querySelectorAll('tbody tr').forEach(row => {
                const pricePerItemText = row.querySelector('.price-per-item').textContent.trim();
                const price = parseFloat(pricePerItemText.replace('$', ''));
                const quantityInput = row.querySelector('.quantity-input');
                const quantity = parseInt(quantityInput.value);

                if (!isNaN(price) && !isNaN(quantity)) {
                    const totalPrice = price * quantity;
                    row.querySelector('.total-price').textContent = `$${totalPrice.toFixed(2)}`;
                    subtotal += totalPrice;
                }
            });

            subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
        };

        // Handle Quantity Increase
        document.querySelectorAll('.quantity-increase').forEach(button => {
            button.addEventListener('click', function() {
                const quantityInput = this.previousElementSibling;
                quantityInput.value = parseInt(quantityInput.value) + 1;
                updateCartTotal();
            });
        });

        // Handle Quantity Decrease
        document.querySelectorAll('.quantity-decrease').forEach(button => {
            button.addEventListener('click', function() {
                const quantityInput = this.nextElementSibling;
                if (parseInt(quantityInput.value) > 1) {
                    quantityInput.value = parseInt(quantityInput.value) - 1;
                    updateCartTotal();
                }
            });
        });

        // Delete Item Functionality
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const itemNo = this.getAttribute('data-item');
                fetch("{{ route('cart.removeItem') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            item_no: itemNo
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.closest('tr').remove(); // Remove the row
                            updateCartTotal(); // Update total
                            alert('Item removed successfully!');
                        } else {
                            alert('Failed to remove item.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });

        // Initial subtotal calculation
        updateCartTotal();
    });
</script>
