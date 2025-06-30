<div class="card bg-secondary p-4 mb-4">
    <style>
        .ams-cart-item{
            padding: 0.2rem !important;
            background-color: #fff1eb;
        }
    </style>

    <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="">Order Detail Items </span>
          <span class="badge bg-primary rounded-pill cart-count">{{$cart['quantity']}}</span>
        </h4>
    <div class="card-body d-none">
        @foreach($cart['items'] as $item)
        <div class="row d-flex justify-content-between align-items-center cart-item">
            <div class="col-md-1 col-lg-1 col-xl-1">
                <label class="form-label">Item #</label>
               <input type="text" class="form-control line-item"
                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="This top tooltip is themed via CSS variables."
               data-product-id="{{ $item['id'] }}" value="{{ $item['id'] }}">
            </div>
            <div class="col-md-7 col-lg-4">
                <label class="form-label">Product Name</label>
                <input type="text" class="form-control line-item" data-product-id="{{ $item['id'] }}" value="{{ $item['name'] }}">
            </div>
            <div class="col-md-1 col-lg-1">
                <label class="form-label">Color</label>
                <input type="text" class="form-control line-item" data-product-id="{{ $item['id'] }}" value="Black">
            </div>
            <div class="col-md-1 col-lg-1">
                <label class="form-label">Size</label>
                <input type="text" class="form-control line-item" data-product-id="{{ $item['id'] }}" value="48in x 100ft">
            </div>
            <div class="col-md-1 col-lg-1 col-xl-2 d-flex">
                <label class="form-label">Qty</label>
                <input type="number" class="form-control line-item incre-qty" data-product-id="{{ $item['id'] }}" name="quantity" min="1" value="{{ $item['quantity'] }}">
            </div>
            <div class="col-md-1 col-lg-2">
                <label class="form-label">Price</label>
                <input type="text" class="form-control line-item" data-product-id="{{ $item['id'] }}" value="{{ $item['price'] }}">
            </div>
            <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                <a href="#" class="btn btn-outline-secondary remove-from-cart" data-product-id="{{ $item['id'] }}" title="Remove from cart">
                    <i class="bi bi-trash-fill"></i>
                </a>
            </div>
            <hr class="my-4">
        </div>
        @endforeach

    </div>
    <div class="">

        <div class="table-responsive">
            <div class="d-none d-md-block">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Qty</th>
                            <th>Item#</th>
                            <th>Product Name</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Size2</th>
                            <th>Weight(lbs)</th>
                            <th>Unit Price</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{$i = 1}}
                        @foreach($cart['items'] as $item)

                        <tr class="cart-item">
                            <td>{{ $i++ }}</td>
                            <td>
                                <input type="number" class="form-control form-control-sm ams-cart-item incre-qty" name="quantity[]" min="1"  data-product-id="{{$item['id']}}" value="{{ $item['quantity'] }}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm ams-cart-item" name="item_no[]" value="{{ $item['item_no'] }}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm ams-cart-item" name="name[]" value="{{ $item['name'] }}"
                                id="qtyInput" data-bs-toggle="tooltip" data-bs-placement="top" title="2343">

                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm ams-cart-item" name="color[]" value="Black">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm ams-cart-item" name="size[]" value="48in x 100ft">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm ams-cart-item" name="size2[]" value="48in x 100ft">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm ams-cart-item" name="weight[]" value="{{ $item['weight'] }}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm ams-cart-item" name="unit_price[]" value="10.00">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm ams-cart-item" name="price[]" value="{{ $item['price'] }}">
                            </td>
                            <td>
                                <a href="#" class="btn btn-outline-secondary btn-sm remove-from-cart" data-product-id="{{ $item['id'] }}" title="Remove from cart">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Mobile-friendly stacked cards -->
            <div class="d-block d-md-none">
                @foreach($cart['items'] as $index => $item)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body p-2">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold">#{{ $index + 1 }}</span>
                            <a href="#" class="btn btn-outline-secondary btn-sm remove-from-cart" data-product-id="{{ $item['id'] }}" title="Remove from cart">
                                <i class="bi bi-trash-fill"></i>
                            </a>
                        </div>
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="form-label mb-0 small">Qty</label>
                                <input type="number" class="form-control form-control-sm" name="quantity[]" min="1" value="{{ $item['quantity'] }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label mb-0 small">Item#</label>
                                <input type="text" class="form-control form-control-sm" name="item_no[]" value="{{ $item['item_no'] }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label mb-0 small">Product Name</label>
                                <input type="text" class="form-control form-control-sm" name="name[]" value="{{ $item['name'] }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label mb-0 small">Color</label>
                                <input type="text" class="form-control form-control-sm" name="color[]" value="Black">
                            </div>
                            <div class="col-6">
                                <label class="form-label mb-0 small">Size</label>
                                <input type="text" class="form-control form-control-sm" name="size[]" value="48in x 100ft">
                            </div>
                            <div class="col-6">
                                <label class="form-label mb-0 small">Size2</label>
                                <input type="text" class="form-control form-control-sm" name="size2[]" value="48in x 100ft">
                            </div>
                            <div class="col-6">
                                <label class="form-label mb-0 small">Weight</label>
                                <input type="text" class="form-control form-control-sm" name="weight[]" value="{{ $item['weight'] }} lbs" disabled>
                            </div>
                            <div class="col-6">
                                <label class="form-label mb-0 small">Unit Price</label>
                                <input type="text" class="form-control form-control-sm" name="unit_price[]" value="$10.00">
                            </div>
                            <div class="col-6">
                                <label class="form-label mb-0 small">Price</label>
                                <input type="text" class="form-control form-control-sm" name="price[]" value="${{ $item['price'] }}">
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="table-responsive w-100 my-3">
            <figure class="text-center">
                <blockquote class="blockquote">
                    <p>Shipping Quotes</p>
                </blockquote>
                <figcaption class="blockquote-footer">
                    The table below shows shipping quotes that have already been quoted for this order.
                </figcaption>
            </figure>
            <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                    <th scope="col"></th>
                    <th scope="col">Carrier</th>
                    <th scope="col">Weight</th>
                    <th scope="col">Class</th>
                    <th scope="col">Cost</th>
                    <th scope="col">Price</th>
                    <th scope="col">Date</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Quoted By</th>
                    <th scope="col">Ouote #</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input class="form-check-input me-3" type="checkbox" value="1">
                        </td>
                        <td>T-Force</td>
                        <td>50 lbs</td>
                        <td>Class 70</td>
                        <td>$120.00</td>
                        <td>$150.00</td>
                        <td>2024-06-01</td>
                        <td>2</td>
                        <td>John Doe</td>
                        <td>Q123456</td>
                    </tr>
                    <tr>
                        <td>
                            <input class="form-check-input me-3" type="checkbox" value="2">
                        </td>
                        <td>UPS Ground</td>
                        <td>75 lbs</td>
                        <td>Class 85</td>
                        <td>$180.00</td>
                        <td>$210.00</td>
                        <td>2024-06-02</td>
                        <td>1</td>
                        <td>Jane Smith</td>
                        <td>Q654321</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-light border-0 d-flex justify-content-between align-items-center">
        <div class="d-flex flex-wrap w-100 justify-content-between">
            <div>
                <strong>Subtotal:</strong> <span class="text-success mini-cart-subtotal">${{$cart['subtotal']}}</span>
            </div>
            <div>
                <strong>Total Weight:</strong> <span class="text-seondary cart-weight">{{$cart['weight']}} lbs</span>
            </div>
            <div>
                <strong>Items:</strong> <span class="cart-count">{{ $cart['quantity'] }}</span>
            </div>
        </div>
    </div>
</div>
