@extends('layouts.main')

@section('title', $productDetails->product_name)

@section('content')
    <div class="container py-5">
        <!-- Product Details Section -->
        <div class="row g-5 mb-5 align-items-start">
            <!-- Product Image Section -->
            <div class="col-md-4">
                <div class="card shadow-sm text-center">
                    <img src="{{ $productDetails->large_image }}" alt="{{ $productDetails->product_name }}"
                        class="img-fluid p-3">
                </div>
            </div>

            <!-- Product Information Section -->
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <h1 style="font-size: 2rem">{{ $productDetails->product_name }}</h1>
                        <p class="text-success fw-bold">In Stock</p>
                        <p><strong>Item Number:</strong> {{ $productDetails->item_no }}</p>
                        <p><strong>Weight:</strong> {{ $productDetails->weight }} lbs</p>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="material" class="form-label fw-bold">Material:</label>
                                <input type="text" id="material" value="{{ $productDetails->material }}"
                                    class="form-control bg-white mb-2" readonly>
                                <label for="height" class="form-label fw-bold">Height:</label>
                                <select id="height" class="form-select bg-white mb-2">
                                    <option selected>{{ $productDetails->size1 }}</option>
                                </select>
                                <div class="d-flex align-items-center mb-3">
                                    <label for="quantity" class="me-3 fw-bold">Quantity:</label>
                                    <button class="btn btn-outline-secondary btn-sm me-2 quantity-decrease">-</button>
                                    <input type="number" class="quantity-input text-center" value="1" min="1"
                                        data-price="{{ $productDetails->price_per_unit }}" />
                                    <button class="btn btn-outline-secondary btn-sm quantity-increase">+</button>
                                </div>
                                <p><strong>Price:</strong> <span
                                        id="dynamic-price">${{ number_format($productDetails->price_per_unit, 2) }}</span>
                                </p>
                                <button class="btn btn-sm btn-danger text-white ms-2 add-to-cart-btn"
                                    data-item="{{ $productDetails->item_no }}"
                                    data-name="{{ $productDetails->product_name }}"
                                    data-price="{{ $productDetails->price_per_unit }}"
                                    data-color="{{ $productDetails->color }}" data-size="{{ $productDetails->size1 }}"
                                    data-mesh="{{ $productDetails->size2 }} {{ $productDetails->size3 }}">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-white shadow rounded">
                            <h5 class="text-center">About this item</h5>
                            <p>{{ $productDetails->description }}</p>
                        </div>
                        <div class="p-3 bg-white shadow rounded mt-4">
                            <h5 class="text-center">To Place Order - Get Quick Quote/Price</h5>
                            <p>If you know what parts you need - Add items to the cart for total price with shipping.</p>
                            <a href="#" class="btn btn-outline-dark mt-2">Print Quote Sheet</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Associated Products Section -->
        <div class="mt-5">
            <h4 class="bg-danger text-white py-2 px-3 rounded">Associated Products</h4>
            <div class="table-responsive mt-3">
                <table class="table table-bordered text-center">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Item Number</th>
                            <th>Name</th>
                            <th>Size</th>
                            <th>Material</th>
                            <th>Weight</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($associatedProducts as $product)
                            <tr>
                                <td>{{ $product->item_no }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->size1 }}</td>
                                <td>{{ $product->material }}</td>
                                <td>{{ $product->weight }} lbs</td>
                                <td>
                                    <button class="btn btn-outline-secondary btn-sm decrease-qty">-</button>
                                    <input type="number" class="quantity-input text-center" value="1" min="1"
                                        data-price="{{ $product->price_per_unit }}">
                                    <button class="btn btn-outline-secondary btn-sm increase-qty">+</button>
                                </td>
                                <td>
                                    <span>${{ number_format($product->price_per_unit, 2) }}</span>
                                    {{-- <button class="btn btn-danger btn-sm add-to-cart-btn"
                                        data-item="{{ $product->item_no }}" data-name="{{ $product->product_name }}"
                                        data-price="{{ $product->price_per_unit }}">
                                        Add to Cart
                                    </button> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Update price dynamically when quantity changes
        document.querySelectorAll(".quantity-decrease, .quantity-increase").forEach(button => {
            button.addEventListener("click", function() {
                const input = this.closest(".d-flex").querySelector(".quantity-input");
                const priceElement = document.getElementById("dynamic-price");
                const basePrice = parseFloat(input.dataset.price);
                let quantity = parseInt(input.value) || 1;

                if (this.classList.contains("quantity-increase")) {
                    quantity++;
                } else if (this.classList.contains("quantity-decrease") && quantity > 1) {
                    quantity--;
                }

                input.value = quantity;
                priceElement.textContent = `$${(basePrice * quantity).toFixed(2)}`;
            });
        });

        // Handle Add to Cart button click
        document.querySelectorAll(".add-to-cart-btn").forEach(button => {
            button.addEventListener("click", function() {
                const itemNo = this.dataset.item;
                const productName = this.dataset.name;
                const price = this.dataset.price;
                const quantityInput = this.closest(".col-md-6").querySelector(
                ".quantity-input");
                const quantity = parseInt(quantityInput.value);

                fetch("{{ route('cart.add') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            item_no: itemNo,
                            product_name: productName,
                            price,
                            quantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Item added to cart successfully!");
                        } else {
                            alert("Failed to add item to cart.");
                        }
                    })
                    .catch(error => console.error("Error:", error));
            });
        });
    });
</script>
