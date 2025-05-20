@extends('layouts.main')

@section('title', 'Solar Posts Caps')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .page-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .main-header {
            background-color: var(--secondary-color);
            color: white;
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .cap-box {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            height: 100%;
        }

        .cap-box:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }

        .cap-box.active {
            border-color: #8B4513;
            box-shadow: 0 0 10px rgba(139, 69, 19, 0.3);
        }

        .cap-box img {
            max-width: 100%;
            height: 100px;
            margin-bottom: 10px;
        }

        .cap-box h5 {
            font-size: 14px;
            margin-bottom: 0;
        }

        .product-table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }

        .product-table th,
        .product-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .product-table th {
            background-color: #8B4513;
            color: white;
        }

        .product-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .btn-add {
            background-color: #8B4513;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .btn-add:hover {
            background-color: #6B3100;
        }

        .product-image {
            max-height: 200px;
            max-width: 100%;
            object-fit: contain;
        }

        .note-box {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #8B4513;
        }

        .product-header {
            background-color: #6C757D;
            color: white;
            padding: 10px;
            text-align: center;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .table th {
            background-color: #f8f9fa;
        }

        .quantity-input {
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-4">

        <div class="row">
            <div class="col-12">
                <div class="main-header">
                    <h4 class="mb-0" id="cap-title">Pyramid Wood Post Caps</h4>
                </div>
            </div>
        </div>


        <!-- Cap Types Grid - All in one row with 5 columns -->
        <div class="row">
            @php
                $parentCodeToSlug = [
                    'AFCWPCP' => 'standard-pyramid',
                    'AFCWPCF' => 'standard-flat',
                    'AFCWPCPD' => 'ball-top',
                    'AFCWPCPC' => 'ball-only',
                    'AFCWPCFD' => 'dentil-flat',
                    'AFCWPCFC' => 'copper-flat',
                    'AFCWPCB3' => '3-ball',
                    'AFCWPCBD3' => '3-ball-dentil',
                    'AFCWPCB5' => '5-ball',
                    'AFCWPCBC5' => '5-ball-copper',
                ];

                $allParentCodes = array_keys($parentCodeToSlug);
            @endphp

            @foreach ($allParentCodes as $parentCode)
                @if (isset($representativeProducts[$parentCode]))
                    <div class="col-md-2 col-sm-4 col-6 mb-3">
                        <div class="cap-box {{ isset($selectedParent) && $selectedParent == $parentCode ? 'active' : '' }}"
                            data-parent="{{ $parentCode }}">
                            @php
                                $product = $representativeProducts[$parentCode];
                                $imagePath = $product->img_large ? url('storage/products/' . $product->img_large) : url('storage/products/default.png');
                            @endphp
                            <img src="{{ $imagePath }}" alt="{{ $parentGroups[$parentCode] ?? 'Wood Post Cap' }}">
                            <h5>{{ $parentGroups[$parentCode] ?? 'Wood Post Cap' }}</h5>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Note Box -->
        <div class="note-box mt-4">
            Note: Measure your post for Actual Post Size before ordering.
        </div>

        <!-- Product Tables - One for each parent type, initially hidden -->
        <div id="product-sections">
            @foreach ($productsByParent as $parentCode => $products)
                @if(count($products) > 0)
                    <div class="product-section" id="products-{{ $parentCode }}" style="display: none;">
                        <div class="product-header">
                            <h5 class="mb-0">{{ strtoupper($parentGroups[$parentCode] ?? 'WOOD POST CAPS') }}</h5>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Item Number</th>
                                    <th>Name</th>
                                    <th>Nominal Post Size</th>
                                    <th>Cap Opening</th>
                                    <th>Fits to Post Size</th>
                                    <th>Color</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->item_no }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->size }}</td>
                                        <td>{{ $product->size2 }}</td>
                                        <td>{{ $product->size3 }}</td>
                                        <td>{{ $product->color ?? 'Pressure Treated' }}</td>
                                        <td class="text-center">
                                            <div class="input-group input-group-sm" style="width: 100px; margin: 0 auto;">
                                                <button class="btn btn-outline-secondary quantity-minus" type="button">-</button>
                                                <input type="text" class="form-control text-center quantity-input" value="1">
                                                <button class="btn btn-outline-secondary quantity-plus" type="button">+</button>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div>
                                                $<span class="product-price"
                                                    data-base-price="{{ $product->price }}">{{ number_format($product->price, 2) }}</span>
                                            </div>
                                        </td>
                                        <td> <button class="btn btn-danger btn-sm btn-add-cart add-to-cart-btn" 
                                            data-id="{{ $product->id }}"
                                            data-item_no="{{ $product->item_no }}" 
                                            data-product_name="{{ $product->product_name }}"
                                            data-price="{{ $product->price }}"
                                            data-color="{{ $product->color ?? '' }}"
                                            data-size="{{ $product->size ?? '' }}"
                                            data-size_in="{{ $product->size_in ?? '' }}"
                                            data-size_wt="{{ $product->size_wt ?? '' }}"
                                            data-size_ht="{{ $product->size_ht ?? '' }}"
                                            data-weight_lbs="{{ $product->weight_lbs ?? '' }}"
                                            data-img_small="{{ $product->img_small ?? '' }}"
                                            data-img_large="{{ $product->img_large ?? '' }}"
                                            data-display_size_2="{{ $product->display_size_2 ?? '' }}"
                                            data-size2="{{ $product->size2 ?? '' }}"
                                            data-size3="{{ $product->size3 ?? '' }}"
                                            data-material="{{ $product->material ?? '' }}"
                                            data-spacing="{{ $product->spacing ?? '' }}"
                                            data-coating="{{ $product->coating ?? '' }}"
                                            data-style="{{ $product->style ?? '' }}"
                                            data-speciality="{{ $product->speciality ?? '' }}"
                                            data-free_shipping="{{ $product->free_shipping ?? '0' }}"
                                            data-special_shipping="{{ $product->special_shipping ?? '0' }}"
                                            data-amount_per_box="{{ $product->amount_per_box ?? '1' }}"
                                            data-class="{{ $product->class ?? '' }}"
                                            data-categories_id="{{ $product->categories_id ?? '' }}"
                                            data-ship_length="{{ $product->ship_length ?? '' }}"
                                            data-ship_width="{{ $product->ship_width ?? '' }}"
                                            data-ship_height="{{ $product->ship_height ?? '' }}"
                                            data-shipping_method="{{ $product->shipping_method ?? '' }}">
                                            Add
                                    </button>
                                    </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('js/mini-cart.js') }}"></script> --}}
    <script>
        $(document).ready(function () {
            // Handle cap box clicks
            $('.cap-box').click(function () {
                $('.cap-box').removeClass('active');
                $(this).addClass('active');

                var parentCode = $(this).data('parent');
                var parentName = $(this).find('h5').text();

                $('#cap-title').text(parentName + ' Wood Post Caps');
                $('#breadcrumb-style').text(parentName);
                $('.product-section').hide();
                $('#products-' + parentCode).show();

                $('html, body').animate({
                    scrollTop: $('.note-box').offset().top - 20
                }, 500);

                if (history.pushState) {
                    const parentCodeToSlug = {
                        'AFCWPCP': 'standard-pyramid',
                        'AFCWPCPD': 'ball-top',
                        'AFCWPCPC': 'copper-pyramid',
                        'AFCWPCF': 'standard-flat',
                        'AFCWPCFD': 'dentil-flat',
                        'AFCWPCFC': 'copper-flat',
                        'AFCWPCB3': '3-ball',
                        'AFCWPCBD3': '3-ball-dentil',
                        'AFCWPCB5': '5-ball',
                        'AFCWPCBC5': '5-ball-copper'
                    };

                    const slug = parentCodeToSlug[parentCode] || parentCode;
                    const currentPath = window.location.pathname;
                    const pathSegments = currentPath.split('/').filter(Boolean);

                    if (Object.keys(parentCodeToSlug).includes(pathSegments[pathSegments.length - 1]) ||
                        Object.values(parentCodeToSlug).includes(pathSegments[pathSegments.length - 1])) {
                        pathSegments[pathSegments.length - 1] = slug;
                    } else {
                        pathSegments.push(slug);
                    }

                    const newUrl = window.location.origin + '/' + pathSegments.join('/');
                    window.history.pushState({ path: newUrl }, '', newUrl);
                }
            });

            // Recalculate price based on quantity
            function updatePrice($input) {
                var $row = $input.closest('tr');
                var basePrice = parseFloat($row.find('.product-price').data('base-price'));
                var quantity = parseInt($input.val()) || 1;
                var total = (basePrice * quantity).toFixed(2);
                $row.find('.product-price').text(total);
            }

            // Quantity plus
            $(document).on('click', '.quantity-plus', function () {
                var $input = $(this).closest('.input-group').find('.quantity-input');
                var value = parseInt($input.val()) || 1;
                $input.val(value + 1);
                updatePrice($input);
            });

            // Quantity minus
            $(document).on('click', '.quantity-minus', function () {
                var $input = $(this).closest('.input-group').find('.quantity-input');
                var value = parseInt($input.val()) || 1;
                if (value > 1) {
                    $input.val(value - 1);
                    updatePrice($input);
                }
            });

            // Quantity input manual change
            $(document).on('input', '.quantity-input', function () {
                updatePrice($(this));
            });

            // Trigger selected parent cap on load
            @if(isset($selectedParent))
                $('.cap-box[data-parent="{{ $selectedParent }}"]').click();
            @else
                                    if ($('.cap-box').length > 0) {
                $('.cap-box').first().click();
            }
            @endif
                });
    </script>

@endsection