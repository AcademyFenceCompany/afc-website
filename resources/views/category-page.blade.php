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

    @if (empty($groupedProducts['groups']))
        <div class="alert alert-info mt-5">
            No products found for this category.
        </div>
    @else
        @foreach ($groupedProducts['groups'] as $group)
            <div class="mt-5">
                <div class="row">
                    <!-- Left Image Column -->
                    <div class="col-md-3">
                        @if ($group['image'])
                            <img style="max-width: 357px;height: 270px;"
                                src="{{ secure_asset(Storage::url($group['image'])) }}" alt="{{ $group['title'] }}"
                                class="img-fluid rounded">
                        @endif
                    </div>

                    <!-- Right Content Column -->
                    <div class="col-md-9">
                        <!-- Group Header -->
                        <div class="bg-danger text-white text-center py-2 rounded">
                            <h4>{{ $group['title'] }}</h4>
                        </div>

                        @if (!empty($group['subgroups']))
                            {{-- Handle nested groups --}}
                            @foreach ($group['subgroups'] as $subgroup)
                                <div class="mt-4">
                                    <div class="bg-secondary text-white text-center py-1 rounded">
                                        <h5>{{ $subgroup['title'] }}</h5>
                                    </div>
                                    @if (!empty($subgroup['products']))
                                        @include('partials.product-table', [
                                            'products' => $subgroup['products'],
                                        ])
                                    @endif
                                    @if (!empty($subgroup['subgroups']))
                                        @foreach ($subgroup['subgroups'] as $nestedGroup)
                                            <div class="mt-3">
                                                <div class="bg-light text-dark text-center py-1 rounded border">
                                                    <h6>{{ $nestedGroup['title'] }}</h6>
                                                </div>
                                                @include('partials.product-table', [
                                                    'products' => $nestedGroup['products'],
                                                ])
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            @endforeach
                        @else
                            {{-- Single level group --}}
                            <div class="mt-4">
                                @include('partials.product-table', ['products' => $group['products']])
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
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
    <script>
        function updateProductDetails(selectElement) {
            const row = selectElement.closest('tr');
            const variants = JSON.parse(selectElement.dataset.variants);
            const selectedColor = selectElement.value;
            const variant = variants[selectedColor];

            // Update item number
            row.querySelector('.item-no').textContent = variant.item_no;

            // Update mesh size
            row.querySelector('.mesh-size').textContent = variant.size2;

            // Update weight
            row.querySelector('.weight').textContent = variant.weight ? variant.weight + ' lbs' : '-';

            // Update add to cart button data attributes
            const addToCartBtn = row.querySelector('.add-to-cart-btn');
            addToCartBtn.dataset.item = variant.item_no;
            addToCartBtn.dataset.size2 = variant.size2;
            addToCartBtn.dataset.weight = variant.weight;
        }

        // Initialize the first selected color for each product
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.color-select').forEach(select => {
                updateProductDetails(select);
            });

            // Handle quantity buttons
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('quantity-decrease') || e.target.classList.contains('quantity-increase')) {
                    const input = e.target.closest('.input-group').querySelector('.quantity-input');
                    let value = parseInt(input.value);

                    if (e.target.classList.contains('quantity-increase')) {
                        value = Math.min(value + 1, 99); // Max 99
                    } else {
                        value = Math.max(value - 1, 1); // Min 1
                    }

                    input.value = value;
                }
            });

            // Handle add to cart
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('add-to-cart-btn')) {
                    e.preventDefault();
                    const button = e.target;
                    const row = button.closest('tr');
                    const quantity = parseInt(row.querySelector('.quantity-input').value) || 1;
                    const price = parseFloat(button.dataset.price);

                    // Create FormData
                    const formData = new FormData();
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                    formData.append('item_no', button.dataset.item || '');
                    formData.append('product_name', button.dataset.productName || '');
                    formData.append('price', price.toString());
                    formData.append('color', row.querySelector('.color-select').value || '');
                    formData.append('size1', button.dataset.size1 || '');
                    formData.append('size2', button.dataset.size2 || '');
                    formData.append('size3', '');
                    formData.append('specialty', '');
                    formData.append('material', '');
                    formData.append('spacing', '');
                    formData.append('coating', '');
                    formData.append('weight', button.dataset.weight || '0');
                    formData.append('family_category', button.dataset.familyCategory || '');
                    formData.append('general_image', '');
                    formData.append('small_image', '');
                    formData.append('large_image', '');
                    formData.append('free_shipping', '0');
                    formData.append('special_shipping', '0');
                    formData.append('amount_per_box', '0');
                    formData.append('quantity', quantity.toString());
                    formData.append('total', (price * quantity).toString());
                    formData.append('description', '');
                    formData.append('subcategory_id', '0');
                    formData.append('shipping_length', button.dataset.shippingLength || '0');
                    formData.append('shipping_width', button.dataset.shippingWidth || '0');
                    formData.append('shipping_height', button.dataset.shippingHeight || '0');
                    formData.append('shipping_class', button.dataset.shippingClass || '');

                    // Add to cart
                    fetch('{{ secure_url(route('cart.add', [], false)) }}', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => Promise.reject(err));
                        }
                        return response.json();
                    })
                    .then(response => {
                        if (response.success) {
                            // Update cart count
                            const cartCountElement = document.getElementById('cart-count');
                            if (cartCountElement) {
                                cartCountElement.textContent = response.cartCount;
                            }

                            // Show success message
                            const toast = document.getElementById('cartToast');
                            if (toast) {
                                toast.querySelector('.toast-body').innerHTML = 'Item added to cart successfully!';
                                const bsToast = new bootstrap.Toast(toast);
                                bsToast.show();
                            }

                            // Update mini cart if it exists
                            const miniCartItems = document.getElementById('mini-cart-items');
                            const emptyCartMessage = document.getElementById('empty-cart-message');
                            
                            if (miniCartItems && emptyCartMessage) {
                                // Clear existing items
                                miniCartItems.innerHTML = '';
                                
                                // Add new items
                                Object.values(response.cart).forEach(item => {
                                    const li = document.createElement('li');
                                    li.className = 'd-flex justify-content-between align-items-start mb-2';
                                    li.innerHTML = `
                                        <div>
                                            <h6 class="mb-0" style="font-size: 14px;">${item.product_name}</h6>
                                            <small class="text-muted">Qty: ${item.quantity}</small>
                                        </div>
                                        <span class="fw-bold" style="font-size: 14px;">$${(item.total).toFixed(2)}</span>
                                    `;
                                    miniCartItems.appendChild(li);
                                    
                                    // Add horizontal line
                                    const hr = document.createElement('hr');
                                    miniCartItems.appendChild(hr);
                                });

                                // Toggle empty cart message
                                emptyCartMessage.classList.toggle('d-none', Object.keys(response.cart).length > 0);
                            }
                        } else {
                            throw new Error(response.message || 'Failed to add item to cart');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Show error message
                        const toast = document.getElementById('cartToast');
                        if (toast) {
                            let errorMessage = 'Error adding item to cart. Please try again.';
                            if (error.errors) {
                                errorMessage = Object.values(error.errors).flat().join('<br>');
                            } else if (error.message) {
                                errorMessage = error.message;
                            }
                            toast.querySelector('.toast-body').innerHTML = errorMessage;
                            const bsToast = new bootstrap.Toast(toast);
                            bsToast.show();
                        }
                    });
                }
            });
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
