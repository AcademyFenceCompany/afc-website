@extends('layouts.main')

@section('title', 'Wood Post Caps')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        body {
            background-color: var(--bg-color);
        }

        .main-header {
            background-color: var(--secondary-color);
            color: white;
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
        }

        .cap-box {
            border: 3px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
        }

        .cap-box:hover {
            border-color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .cap-box.active {
            border-color: var(--primary-color);
            background-color: rgba(0, 85, 128, 0.05);
        }

        .cap-box img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
            max-height: 80px;
            object-fit: contain;
        }

        .cap-box h5 {
            font-size: 0.9rem;
            margin: 0;
            color: #333;
        }
        .quantity-input {
            width: 15px !important;
            text-align: center;
            margin:4px;
        }

        @media (max-width: 767px) {
            .cap-box img {
                max-height: 60px;
            }
            .cap-box h5 {
                font-size: 0.8rem;
            }
        }

        .note-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-left: 5px solid var(--primary-color);
            padding: 15px;
            margin-bottom: 20px;
            font-style: italic;
            color: #495057;
        }

        .product-section {
            margin-top: 20px;
            margin-bottom: 40px;
        }

        .product-header {
            background-color: var(--gray-color);
            color: white;
            padding: 10px;
            text-align: center;
            margin-bottom: 20px;
            border-radius: 3px;
        }

        .responsive-table {
            width: 100%;
            overflow-x: auto;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .product-table th, .product-table td {
            padding: 1px;
            border: 1px solid #dee2e6;
            text-align: center;
        }

        .product-table th {
            background-color: #f8f9fa;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        @media (max-width: 767px) {
            .product-table th, .product-table td {
                padding: 5px;
                font-size: 0.85rem;
            }
            
            .input-group-sm {
                width: 100% !important;
            }
            
            .btn-add-cart {
                padding: 0.2rem 0.5rem !important;
                font-size: 0.75rem !important;
            }
        }
        
        /* For extra small screens */
        @media (max-width: 575px) {
            .product-table {
                display: block;
            }
            
            .product-table thead {
                display: none;
            }
            
            .product-table tbody, 
            .product-table tr {
                display: block;
            }
            
            .product-table tr {
                margin-bottom: 15px;
                border: 1px solid #dee2e6;
            }
            
            .product-table td {
                display: block;
                text-align: right;
                border: none;
                border-bottom: 1px solid #f0f0f0;
                position: relative;
                padding-left: 50%;
            }
            
            .product-table td:before {
                content: attr(data-label);
                position: absolute;
                left: 8px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                text-align: left;
                font-weight: bold;
            }
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
                    'AFCWPCPD' => 'dentil-pyramid',
                    'AFCWPCPC' => 'copper-pyramid',
                    'AFCWPCF' => 'standard-flat',
                    'AFCWPCFD' => 'dentil-flat',
                    'AFCWPCFC' => 'copper-flat',
                    'AFCWPCB3' => '3-ball',
                    'AFCWPCBD3' => '3-ball-dentil',
                    'AFCWPCB5' => '5-ball',
                    'AFCWPCBC5' => '5-ball-copper'
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
                        <div class="product-header" style="background-color: #6c757d;">
                            <h5 class="mb-0">{{ strtoupper($parentGroups[$parentCode] ?? 'WOOD POST CAPS') }}</h5>
                        </div>

                        <div class="responsive-table">
                            <table class="product-table">
                                <thead>
                                <tr>
                                    <th>Item No</th>
                                    <th>Product Name</th>
                                    <th>Nominal Size</th>
                                    <th>Cap Opening</th>
                                    <th>Fits Post Size</th>
                                    <th>Color</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td data-label="Item No">{{ $product->item_no }}</td>
                                        <td data-label="Product Name">{{ $product->product_name }}</td>
                                        <td data-label="Size">{{ $product->size }}</td>
                                        <td data-label="Fits to Post Size">{{ $product->size2 }}</td>
                                        <td data-label="Post Size">{{ $product->size3 }}</td>
                                        <td data-label="Color">{{ $product->color ?? 'Pressure Treated' }}</td>
                                        <td class="text-center" data-label="Quantity">
                                            <div class="input-group input-group-sm" style="width: 100px; margin: 0 auto;">
                                                <div class="input-group-prepend">
                                                    <button class="btn minus-btn" type="button">-</button>
                                                </div>
                                                <input type="text" class="form-control text-center quantity-input" value="1"
                                                    min="1" data-price="{{ $product->price }}"
                                                    style="text-align: center;">
                                                <div class="input-group-append">
                                                    <button class="btn plus-btn" type="button">+</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center" data-label="Price">
                                            <div class="price-display">
                                                $<span class="product-price"
                                                    data-base-price="{{ $product->price }}">{{ number_format($product->price, 2) }}</span>
                                            </div>
                                        </td>
                                        <td data-label=""> <button class="btn btn-danger btn-sm btn-add-cart add-to-cart-btn" 
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
                        'AFCWPCPD': 'dentil-pyramid',
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

            // Add to cart AJAX
            // $(document).on('click', '.add-to-cart-btn', function () {
            //     var $button = $(this);
            //     var $row = $button.closest('tr');
            //     var itemNo = $button.data('item');
            //     var name = $button.data('name');
            //     var price = $button.data('price');
            //     var quantity = $row.find('.quantity-input').val();

            //     $.ajax({
            //         url: '{{ route("cart.add") }}',
            //         method: 'POST',
            //         data: {
            //             _token: '{{ csrf_token() }}',
            //             item_no: itemNo,
            //             product_name: name,
            //             price: price,
            //             quantity: quantity
            //         },
            //         success: function (response) {
            //             if (response.success) {
            //                 toastr.success(name + ' added to cart!');

            //                 // ✅ Update cart count badge
            //                 if ($('.cart-count').length > 0) {
            //                     $('.cart-count').text(response.cartCount);
            //                 }

            //                 // ✅ Dynamically update mini cart if data is present and function exists
            //                 if (typeof updateMiniCart === 'function' && response.cart) {
            //                     updateMiniCart(response.cart);
            //                 }
            //             } else {
            //                 toastr.error('Error adding item to cart');
            //             }
            //         },
            //         error: function (xhr) {
            //             toastr.error('Error adding item to cart');
            //             console.error(xhr.responseText);
            //         }
            //     });
            // });


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