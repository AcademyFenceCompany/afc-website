@dump($groupedProducts);
@extends('layouts.main')

@section('title', $page->title)

@section('content')
    <!-- Header Section -->
    <div class="bg-black text-white text-center py-3 rounded">
        <h1 class="mb-0">{{ $page->title }}</h1>
    </div>
    <div class="mt-2">
        <p class="text-center">{!! $page->subtitle !!}</p>
    </div>

    <!-- Main Section -->
    <div class="row mt-4 align-items-center">
        <!-- Left Column -->
        <div class="col-md-4">
            <div class="bg-warning text-dark p-4 rounded shadow-sm">
                <h4 class="fw-bold">The Original online Fence Superstore</h4>
                <p class="mb-0"><em>Family owned operated since 1968</em></p>
                <div>{!! $page->bulletin_board !!}</div>

                <!-- Category Tidbits -->
                <div class="mt-3">
                    @if ($page->category_tidbit_1)
                        <div class="mb-3">{!! $page->category_tidbit_1 !!}</div>
                    @endif
                    @if ($page->category_tidbit_2)
                        <div class="mb-3">{!! $page->category_tidbit_2 !!}</div>
                    @endif
                    @if ($page->category_tidbit_3)
                        <div class="mb-3">{!! $page->category_tidbit_3 !!}</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Center Image -->
        <div class="col-md-4 text-center">
            @if ($page->product_image)
                <img style="max-width: 357px;height: 270px;" src="{{ secure_asset(Storage::url($page->product_image)) }}"
                    alt="{{ $page->title }} Image" class="img-fluid rounded shadow-sm">
            @endif
        </div>

        <!-- Right Column -->
        <div class="col-md-4">
            @if ($page->product_text)
                <div class="product-text">
                    {!! $page->product_text !!}
                </div>
            @endif
        </div>
    </div>

    <!-- Products Section -->
    @php
        if (isset($subcategories)) {
            Log::info('View Subcategories:', [
                'count' => $subcategories->count(),
                'names' => $subcategories->pluck('family_category_name'),
            ]);
        }
        if (isset($products)) {
            Log::info('View Products:', [
                'count' => $products->count(),
            ]);
        }
    @endphp

    @foreach ($groupedProducts as $style => $group)
        <div class="mt-5">
            <div class="row">
                <!-- Left Image Column -->
                <div class="col-md-3">
                    @if ($group['image'])
                        <img style="max-width: 357px;height: 270px;" src="{{ secure_asset(Storage::url($group['image'])) }}"
                            alt="{{ $style }}" class="img-fluid rounded">
                    @endif
                </div>

                <!-- Right Content Column -->
                <div class="col-md-9">
                    <!-- Style Header -->
                    <div class="bg-danger text-white text-center py-2 rounded">
                        <h4>{{ $style }}</h4>
                    </div>

                    <div class="mt-4">
                        <!-- Products Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Height</th>
                                        <th>Color</th>
                                        <th>Mesh Size</th>
                                        <th>Weight</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($group['products'] as $product)
                                        @php
                                            $firstVariant = $product->color_variants->first();
                                        @endphp
                                        <tr data-product-row="{{ $product->product_id }}">
                                            <td>{{ $product->size1 }}'</td>
                                            <td>
                                                @php
                                                    $variantsJson = json_encode($product->color_variants);
                                                @endphp
                                                <select class="form-select color-select"
                                                    data-variants='{{ $variantsJson }}'>
                                                    @foreach ($product->available_colors as $color)
                                                        <option value="{{ $color }}">{{ $color }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="mesh-size">{{ $firstVariant['size2'] }}</td>
                                            <td class="weight">{{ $firstVariant['weight'] ?? '-' }} lbs</td>
                                            <td class="price">${{ number_format($product->price_per_unit, 2) }}</td>
                                            <td>
                                                <div class="input-group" style="width: 120px;">
                                                    <button class="btn btn-outline-secondary quantity-decrease"
                                                        type="button">-</button>
                                                    <input type="text" class="form-control text-center quantity-input"
                                                        value="1" data-price="{{ $product->price_per_unit }}">
                                                    <button class="btn btn-outline-secondary quantity-increase"
                                                        type="button">+</button>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-danger add-to-cart-btn"
                                                    data-item="{{ $firstVariant['item_no'] }}"
                                                    data-price="{{ $product->price_per_unit }}"
                                                    data-size1="{{ $product->size1 }}"
                                                    data-size2="{{ $firstVariant['size2'] }}"
                                                    data-weight="{{ $firstVariant['weight'] }}"
                                                    data-family_category="{{ $product->family_category_id }}">
                                                    Add to Cart
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @if ($groupedProducts->isEmpty())
        <div class="alert alert-info mt-5">
            No products found for this category.
        </div>
    @endif

    <!-- Footer Section -->
    @if ($page->footer_subtitle || $page->footer_bulletin_board || $page->footer_product_image || $page->footer_product_text)
        <div class="mt-5">
            @if ($page->footer_subtitle)
                <div class="text-center mb-4">
                    <h3>{!! $page->footer_subtitle !!}</h3>
                </div>
            @endif

            @if ($page->footer_bulletin_board)
                <div class="alert alert-danger text-center">
                    {!! $page->footer_bulletin_board !!}
                </div>
            @endif

            <div class="row align-items-center">
                @if ($page->footer_product_image)
                    <div class="col-md-6 text-center">
                        <img src="{{ secure_asset(Storage::url($page->footer_product_image)) }}" alt="Footer Product Image"
                            class="img-fluid rounded shadow-sm">
                    </div>
                @endif

                @if ($page->footer_product_text)
                    <div class="col-md-{{ $page->footer_product_image ? '6' : '12' }}">
                        <div class="footer-product-text">
                            {!! $page->footer_product_text !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    <script src="{{ secure_asset('js/mini-cart.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle quantity buttons
            const quantityButtons = document.querySelectorAll('.quantity-decrease, .quantity-increase');
            quantityButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.closest('.input-group').querySelector('input');
                    let value = parseInt(input.value);

                    if (this.classList.contains('quantity-increase')) {
                        value = Math.min(value + 1, 99); // Max 99
                    } else {
                        value = Math.max(value - 1, 1); // Min 1
                    }

                    input.value = value;
                    updatePrice(input);
                });
            });

            // Handle color selection
            const colorSelects = document.querySelectorAll('.color-select');
            colorSelects.forEach(select => {
                select.addEventListener('change', function() {
                    const row = this.closest('tr');
                    const selectedColor = this.value;
                    const variants = JSON.parse(this.getAttribute('data-variants'));
                    const selectedVariant = variants[selectedColor];

                    if (selectedVariant) {
                        row.querySelector('.item-no').textContent = selectedVariant.item_no || '';
                        row.querySelector('.mesh-size').textContent = selectedVariant.size2 || '';
                        row.querySelector('.weight').textContent = (selectedVariant.weight || '-') +
                            ' lbs';
                    }
                });
            });

            // Handle add to cart
            const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
            addToCartButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const quantity = parseInt(row.querySelector('.quantity-input').value);
                    const color = row.querySelector('.color-select').value;
                    const variants = JSON.parse(row.querySelector('.color-select').getAttribute(
                        'data-variants'));
                    const selectedVariant = variants[color];
                    const size = row.querySelector('td:nth-child(1)').textContent.trim();

                    const itemData = {
                        item_no: selectedVariant.item_no,
                        product_name: row.closest('.mt-5').querySelector('h4').textContent
                            .trim(),
                        price: parseFloat(row.querySelector('.price').textContent.replace('$',
                            '')),
                        color: color,
                        size1: size,
                        size2: selectedVariant.size2 || '',
                        size3: '',
                        specialty: '',
                        material: '',
                        spacing: '',
                        coating: '',
                        weight: selectedVariant.weight || 0,
                        family_category: '',
                        general_image: '',
                        small_image: '',
                        large_image: '',
                        free_shipping: false,
                        special_shipping: false,
                        amount_per_box: null,
                        quantity: quantity,
                        description: '',
                        subcategory_id: null,
                        shipping_length: null,
                        shipping_width: null,
                        shipping_height: null,
                        shipping_class: ''
                    };

                    fetch('/cart/add', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(itemData)
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(err => Promise.reject(err));
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Update the mini cart
                                if (typeof updateMiniCart === 'function') {
                                    updateMiniCart(data.cart);
                                }

                                // Show success toast
                                const toastEl = document.getElementById('cartToast');
                                toastEl.querySelector('.toast-header').classList.remove(
                                    'bg-danger');
                                toastEl.querySelector('.toast-header').classList.add(
                                    'bg-success');
                                toastEl.querySelector('.toast-body').textContent =
                                    'Item added to cart successfully!';
                                const toast = new bootstrap.Toast(toastEl);
                                toast.show();
                            } else {
                                throw new Error(data.message || 'Failed to add item to cart');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Show error toast
                            const toastEl = document.getElementById('cartToast');
                            toastEl.querySelector('.toast-header').classList.remove(
                                'bg-success');
                            toastEl.querySelector('.toast-header').classList.add('bg-danger');
                            toastEl.querySelector('.toast-body').textContent = error.message ||
                                'Failed to add item to cart. Please try again.';
                            const toast = new bootstrap.Toast(toastEl);
                            toast.show();
                        });
                });
            });

            // Function to update price based on quantity
            function updatePrice(input) {
                const basePrice = parseFloat(input.dataset.price);
                const quantity = parseInt(input.value);
                const priceElement = input.closest('tr').querySelector('.dynamic-price');
                if (priceElement) {
                    const total = (basePrice * quantity).toFixed(2);
                    priceElement.textContent = '$' + total;
                }
            }
        });
    </script>
@endsection

<!-- Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="cartToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <strong class="me-auto">Success</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Item added to cart successfully!
        </div>
    </div>
</div>
