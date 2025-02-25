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
                <img src="{{ secure_asset(Storage::url($page->product_image)) }}" alt="{{ $page->title }} Image"
                    class="img-fluid rounded shadow-sm">
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
                        <img src="{{ secure_asset(Storage::url($group['image'])) }}" alt="{{ $style }}"
                            class="img-fluid rounded">
                    @endif
                </div>

                <!-- Right Content Column -->
                <div class="col-md-9">
                    <!-- Style Header -->
                    <div class="bg-danger text-white text-center py-2 rounded">
                        <h4>{{ $style }} PVT Slats</h4>
                    </div>

                    <div class="mt-4">
                        <p class="text-danger">Note: call ahead for local pickup!</p>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th>Item Number</th>
                                        <th>Height</th>
                                        <th>Mesh Size</th>
                                        <th>Weight</th>
                                        <th>Price</th>
                                        <th>Choose A Color</th>
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
                                            <td class="item-no">{{ $firstVariant['item_no'] }}</td>
                                            <td>{{ $product->size1 }}'</td>
                                            <td class="mesh-size">{{ $firstVariant['size2'] }}</td>
                                            <td class="weight">{{ $firstVariant['weight'] ?? '-' }} lbs</td>
                                            <td>${{ number_format($product->price_per_unit, 2) }}</td>
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
                                            <td>
                                                <div class="input-group" style="width: 120px;">
                                                    <button class="btn btn-outline-secondary" type="button">-</button>
                                                    <input type="text" class="form-control text-center" value="1">
                                                    <button class="btn btn-outline-secondary" type="button">+</button>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-danger add-to-cart"
                                                    data-product-id="{{ $product->product_id }}">
                                                    Add
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
            // Initialize add to cart functionality
            const addToCartButtons = document.querySelectorAll('.add-to-cart');
            addToCartButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.dataset.productId;
                    addToCart(productId, 1); // Add 1 quantity by default
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle quantity increment/decrement
            document.querySelectorAll('.input-group .btn').forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.closest('.input-group').querySelector('input');
                    let value = parseInt(input.value);

                    if (this.textContent === '+') {
                        value++;
                    } else {
                        value = value > 1 ? value - 1 : 1;
                    }

                    input.value = value;
                });
            });

            // Handle color selection
            document.querySelectorAll('.color-select').forEach(select => {
                select.addEventListener('change', function() {
                    const row = this.closest('tr');
                    const selectedColor = this.value;

                    // Get variants data from the select element
                    const variants = JSON.parse(this.getAttribute('data-variants'));
                    const selectedVariant = variants[selectedColor];

                    console.log('Selected color:', selectedColor);
                    console.log('Selected variant:', selectedVariant);

                    if (selectedVariant) {
                        // Update product details in the row
                        row.querySelector('.item-no').textContent = selectedVariant.item_no || '';
                        row.querySelector('.mesh-size').textContent = selectedVariant.size2 || '';
                        row.querySelector('.weight').textContent = (selectedVariant.weight || '-') +
                            ' lbs';
                    }
                });
            });
        });
    </script>
@endsection
