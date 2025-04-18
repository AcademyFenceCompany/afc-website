{{-- @dd($page); --}}
@extends('layouts.main')

@section('title', $page->title)

@section('content')
    <!-- Header Section -->
    <div class="rounded bg-brown">
        <h1 class="page-title text-center py-2 mb-0">{{ $page->title }}</h1>
    </div>
    <div class="text-center py-2 mb-4 border-bottom">
        <p class="mb-0">{!! $page->subtitle !!}</p>
    </div>

   <!-- Main Section (Styled Like Info Section) -->
<div class="row g-4 mb-3">
    <!-- Left Section - Superstore Info -->
    <div class="col-md-6 wf-about">
        <div class="d-flex">
            @if ($page->img_large)
                <img src="{{ Storage::url($page->img_large) }}"
                    alt="{{ $page->title }} Image"
                    class="me-4 rounded about-image"
                    style="max-width: 200px; height: auto;">
            @endif
            <div>
                <div class="small-font">
                    {!! $page->product_text !!}
                </div>
                

                <!-- Category Tidbits -->
                <div class="small">
                    @if ($page->category_tidbit_1)
                        <div class="mb-2">{!! $page->category_tidbit_1 !!}</div>
                    @endif
                    @if ($page->category_tidbit_2)
                        <div class="mb-2">{!! $page->category_tidbit_2 !!}</div>
                    @endif
                    @if ($page->category_tidbit_3)
                        <div class="mb-2">{!! $page->category_tidbit_3 !!}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Middle Section - Optional Buttons (Replace if needed) -->
    <div class="col-md-2 text-center">
        <h5 class="text-brown mb-2">Options</h5>
        <div class="d-flex flex-column gap-2">
            <button class="btn btn-light border w-100 text-center">Contact Us</button>
            <button class="btn btn-light border w-100 text-center">More Info</button>
            <button class="btn btn-brown w-100" style="background-color: #8B4513 !important; color: white !important;">
                Get a Quote
            </button>
        </div>
    </div>

    <!-- Right Section - Product Text -->
    <div class="col-md-4">
        @if ($page->product_text)
            <div class="p-3 rounded bg-light-yellow">
            <h6 class="mb-2 fw-bold">The Original Online Fence Superstore</h6>
                <p class="mb-2 fst-italic">Family owned & operated since 1968</p>
                <div class="page-description mb-2">{!! $page->bulletin_board !!}</div>
            </div>
        @endif
    </div>
</div>


    <!-- Products Section -->
    @if (empty($groupedProducts['groups']) && empty($meshSize_products) && empty($mainTableProducts))
        <div class="alert alert-info mt-5">
            No products found for this category.
        </div>
    @else
        @if ($isRazorWire ?? false)
            <!-- Razor Wire Products -->
            <div class="mt-4">
                <h2 class="text-center mb-4">18" Razor Wire Pricing</h2>

                <!-- Main Product Table -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-danger text-white">
                            <tr>
                                <th>Item No.</th>
                                <th>Description</th>
                                <th>Weight</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mainTableProducts as $product)
                                <tr>
                                    <td>{{ $product->item_no }}</td>
                                    <td>{{ $product->size1 }}</td>
                                    <td>{{ $product->weight }} lbs</td>
                                    <td>${{ number_format($product->price_per_unit, 2) }}</td>
                                    <td>
                                        <input type="number" class="form-control quantity-input" min="1"
                                            max="{{ $quantityLimits[$product->product_id] }}" value="1"
                                            data-product-id="{{ $product->product_id }}"
                                            onchange="validateQuantity(this, {{ $quantityLimits[$product->product_id] }})">
                                    </td>
                                    <td>
                                        <button class="btn btn-danger add-to-cart-btn"
                                            data-product-id="{{ $product->product_id }}"
                                            data-price="{{ $product->price_per_unit }}"
                                            data-item="{{ $product->item_no }}"
                                            data-product-name="{{ $product->product_name }}"
                                            data-size1="{{ $product->size1 }}" data-weight="{{ $product->weight }}"
                                            data-family-category="{{ $mainCategory->family_category_id }}">
                                            Add to Cart
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
                                    <img src="{{ Storage::url($page->footer_product_image) }}" alt="Footer Product Image"
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
                <!-- Other Products -->
                @if ($otherProducts->count() > 0)
                    <h3 class="text-center mt-5 mb-4">Other Available Products</h3>
                    <div class="row">
                        @foreach ($otherProducts as $product)
                            <div class="col-md-3 mb-4">
                                <div class="card h-100">
                                    <div class="card-header bg-danger text-white">
                                        <p class="mb-0">{{ $product->product_name }}</p>
                                    </div>
                                    <div class="card-body">
                                        <img style="max-width: 150px;height: 125px;"
                                            src="{{ Storage::url($product->large_image) }}"
                                            alt="{{ $product->product_name }}" class="img-fluid rounded shadow-sm">
                                        <p class="card-text">
                                            <strong>Item No:</strong> {{ $product->item_no }}<br>
                                            <strong>Weight:</strong> {{ $product->weight }} lbs<br>
                                            <strong>Price:</strong> ${{ number_format($product->price_per_unit, 2) }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <input type="number" class="form-control quantity-input" style="width: 100px"
                                                min="1" value="1" data-product-id="{{ $product->product_id }}">
                                            <button class="btn btn-danger add-to-cart-btn"
                                                data-item="{{ $product->item_no }}"
                                                data-price="{{ $product->price_per_unit }}"
                                                data-product-name="{{ $product->product_name }}"
                                                data-size1="{{ $product->size1 }}" data-weight="{{ $product->weight }}"
                                                data-family-category="{{ $mainCategory->family_category_id }}">
                                                Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @elseif ($isWeldedWire)
            <!-- Welded Wire Products by Gauge -->
            @foreach ($meshSize_products->groupBy('size3') as $gauge => $products)
                <!-- Gauge Section -->
                <div class="mt-5">
                    <div class="bg-danger text-white text-center py-2 rounded">
                        <h4>{{ $gauge }} Gauge</h4>
                    </div>
                    <div class="row mt-3">
                        <!-- Left Image -->
                        <div class="col-md-3 text-center">
                            <div class="card shadow-sm">
                                <div class="card-header bg-danger text-white fw-bold py-2">
                                    {{ $products->first()->size2 ?? 'Mesh Size' }},
                                    {{ $gauge ?? 'Gauge' }}
                                </div>
                                <div class="card-body">
                                    <img src="{{ $products->first()->large_image ? Storage::url($products->first()->large_image) : asset('images/default.png') }}"
                                        alt="{{ $products->first()->product_name }}" class="img-fluid rounded">
                                </div>
                            </div>
                        </div>

                        <!-- Right Content -->
                        <div class="col-md-9">
                            <p class="text-danger"><strong>Note:</strong> call ahead for local pickup!</p>
                            @include('partials.product-table', [
                                'products' => $products,
                            ])
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <!-- Regular Products -->
            @foreach ($groupedProducts['groups'] as $group)
                <div class="mt-5">
                    <div class="row">
                        <!-- Left Image Column -->
                        <div class="col-md-3">
                            @if ($group['image'])
                                <img style="max-width: 357px;height: 270px;" src="{{ Storage::url($group['image']) }}"
                                    alt="{{ $group['title'] }}" class="img-fluid rounded">
                            @endif
                        </div>

                        <!-- Right Content Column -->
                        <div class="col-md-9">
                            <!-- Group Header -->
                            <div class="bg-danger text-white text-center py-2 rounded">
                                <h4>{{ $group['title'] }}</h4>
                            </div>

                            @if (!empty($group['subgroups']))
                                <!-- Navigation Buttons -->
                                <div class="mt-3 text-center">
                                    @foreach ($group['subgroups'] as $index => $subgroup)
                                        <button class="btn btn-outline-primary mb-2 me-2 specialty-btn"
                                            data-target="specialty-{{ $loop->parent->index }}-{{ $index }}">
                                            {{ $subgroup['title'] }}
                                        </button>
                                    @endforeach
                                </div>

                                <!-- Specialty Groups -->
                                @foreach ($group['subgroups'] as $index => $subgroup)
                                    <div class="specialty-group mt-4"
                                        id="specialty-{{ $loop->parent->index }}-{{ $index }}"
                                        style="{{ $loop->first ? '' : 'display: none;' }}">
                                        @include('partials.product-table', [
                                            'products' => $subgroup['products'],
                                        ])
                                    </div>
                                @endforeach
                            @else
                                @include('partials.product-table', ['products' => $group['products']])
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
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
                        <img src="{{ Storage::url($page->footer_product_image) }}" alt="Footer Product Image"
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle specialty button clicks
            const specialtyBtns = document.querySelectorAll('.specialty-btn');
            specialtyBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const parentGroup = this.closest('.mt-5');
                    const allGroups = parentGroup.querySelectorAll('.specialty-group');
                    const allBtns = parentGroup.querySelectorAll('.specialty-btn');

                    // Hide all groups
                    allGroups.forEach(group => group.style.display = 'none');
                    // Show target group
                    document.getElementById(targetId).style.display = 'block';
                    // Update button states
                    allBtns.forEach(btn => btn.classList.remove('btn-primary', 'text-white'));
                    this.classList.add('btn-primary', 'text-white');
                });
            });

            // Handle quantity buttons
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('quantity-decrease') || e.target.classList.contains(
                        'quantity-increase')) {
                    const input = e.target.closest('.input-group').querySelector('.quantity-input');
                    let value = parseInt(input.value) || 1;

                    if (e.target.classList.contains('quantity-increase')) {
                        value = Math.min(value + 1, 99); // Max 99
                    } else {
                        value = Math.max(value - 1, 1); // Min 1
                    }

                    input.value = value;
                }
            });

            // Initialize cart functionality
            initializeCart();
        });

        function updateProductDetails(selectElement) {
            const row = selectElement.closest('tr');
            const variants = JSON.parse(selectElement.dataset.variants);
            const selectedColor = selectElement.value;
            const variant = variants[selectedColor];

            // Update item number
            row.querySelector('.item-no').textContent = variant.item_no;

            // Update mesh size
            const meshSize = row.querySelector('.mesh-size');
            if (meshSize) {
                meshSize.textContent = variant.size2;
            }

            // Update weight
            const weight = row.querySelector('.weight');
            if (weight) {
                weight.textContent = variant.weight ? variant.weight + ' lbs' : '-';
            }

            // Update add to cart button data attributes
            const addToCartBtn = row.querySelector('.add-to-cart-btn');
            if (addToCartBtn) {
                addToCartBtn.dataset.item = variant.item_no;
                addToCartBtn.dataset.size2 = variant.size2;
                addToCartBtn.dataset.weight = variant.weight;
            }
        }

        function initializeCart() {
            const cartIcon = document.getElementById('cart-icon');
            const miniCart = document.getElementById('mini-cart');

            if (cartIcon && miniCart) {
                // Toggle mini cart on icon click
                cartIcon.addEventListener('click', function(e) {
                    e.preventDefault();
                    miniCart.classList.toggle('show');
                });

                // Close mini cart when clicking outside
                document.addEventListener('click', function(e) {
                    if (miniCart && !miniCart.contains(e.target) && e.target !== cartIcon) {
                        miniCart.classList.remove('show');
                    }
                });
            }

            // Initialize color selects
            document.querySelectorAll('.color-select').forEach(select => {
                updateProductDetails(select);
            });

            // Add to cart functionality
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('add-to-cart-btn')) {
                    e.preventDefault();
                    const button = e.target;
                    const container = button.closest('tr') || button.closest('.card-body');
                    const quantity = parseInt(container.querySelector('.quantity-input').value) || 1;
                    const price = parseFloat(button.dataset.price);

                    // Create FormData
                    const formData = new FormData();
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                    formData.append('item_no', button.dataset.item || '');
                    formData.append('product_name', button.dataset.productName || '');
                    formData.append('price', price.toString());
                    formData.append('quantity', quantity.toString());
                    formData.append('size1', button.dataset.size1 || '');
                    formData.append('weight', button.dataset.weight || '0');
                    formData.append('family_category', button.dataset.familyCategory || '');

                    // Add color if color select exists
                    const colorSelect = container.querySelector('.color-select');
                    if (colorSelect) {
                        formData.append('color', colorSelect.value);
                    }

                    // Add other fields if they exist
                    if (button.dataset.size2) formData.append('size2', button.dataset.size2);
                    if (button.dataset.size3) formData.append('size3', button.dataset.size3);
                    if (button.dataset.specialty) formData.append('specialty', button.dataset.specialty);
                    if (button.dataset.material) formData.append('material', button.dataset.material);
                    if (button.dataset.spacing) formData.append('spacing', button.dataset.spacing);
                    if (button.dataset.coating) formData.append('coating', button.dataset.coating);
                    if (button.dataset.shippingLength) formData.append('shipping_length', button.dataset
                        .shippingLength);
                    if (button.dataset.shippingWidth) formData.append('shipping_width', button.dataset
                        .shippingWidth);
                    if (button.dataset.shippingHeight) formData.append('shipping_height', button.dataset
                        .shippingHeight);
                    if (button.dataset.shippingClass) formData.append('shipping_class', button.dataset
                        .shippingClass);

                    // Send request to add to cart
                    fetch('/cart/add', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show success message
                                const toast = new bootstrap.Toast(document.getElementById('cartToast'));
                                document.querySelector('#cartToast .toast-body').textContent =
                                    'Item added to cart successfully!';
                                toast.show();

                                // Update cart UI
                                updateCartUI(data);
                            } else {
                                alert(data.message || 'Failed to add item to cart');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while adding to cart');
                        });
                }
            });
        }

        function updateCartUI(response) {
            const cartCount = document.getElementById('cart-count');
            const cartItemsList = document.getElementById('cart-items');
            const cartTotal = document.getElementById('cart-total');
            const emptyCartMessage = document.getElementById('empty-cart-message');

            if (response.cart) {
                // Update cart count
                if (cartCount) {
                    cartCount.textContent = response.cartCount;
                    cartCount.style.display = response.cartCount > 0 ? 'inline' : 'none';
                }

                // Update cart items
                if (cartItemsList) {
                    cartItemsList.innerHTML = Object.values(response.cart).map(item => `
                        <li class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-0" style="font-size: 14px;">${item.product_name}</h6>
                                <small class="text-muted">Qty: ${item.quantity}</small>
                            </div>
                            <span class="fw-bold" style="font-size: 14px;">$${(item.total).toFixed(2)}</span>
                        </li>
                        <hr>
                    `).join('');
                }

                // Update cart total
                if (cartTotal && response.total) {
                    cartTotal.textContent = `$${response.total}`;
                }

                // Toggle empty cart message
                if (emptyCartMessage) {
                    emptyCartMessage.classList.toggle('d-none', Object.keys(response.cart).length > 0);
                }
            }
        }
    </script>

    @push('scripts')
        <script>
            function validateQuantity(input, maxLimit) {
                const value = parseInt(input.value);
                if (value > maxLimit) {
                    input.value = maxLimit;
                    alert('Maximum quantity for this product is ' + maxLimit);
                }
            }
        </script>
    @endpush

    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="cartToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">
                <strong class="me-auto">Cart Update</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="toast-body"></div>
        </div>
    </div>
@endsection
