<div class="card bg-secondary p-4 mb-4">
    <style>
        .line-item{
            padding: 0.2rem !important;
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
        
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Item#</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Color</th>
                    <th scope="col">Size</th>
                    <th scope="col">Size2</th>
                    <th scope="col">Weight</th>
                    <th scope="col">Unit Price</th>
                    <th scope="col">Price</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart['items'] as $item)
                <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>12345</td>
                    <td>{{ \Illuminate\Support\Str::limit($item['name'], 20) }}</td>
                    <td>Black</td>
                    <td>48in x 100ft</td>
                    <td>48in x 100ft</td>
                    <td>{{$item['weight']}} lbs</td>
                    <td>$10.00</td>
                    <td>${{$item['price']}}</td>
                    <td>
                        <a href="#" class="btn btn-outline-secondary remove-from-cart" data-product-id="12345" title="Remove from cart">
                            <i class="bi bi-trash-fill"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-light border-0 d-flex justify-content-between align-items-center">
        <div class="d-flex flex-wrap w-100 justify-content-between">
            <div>
                <strong>Subtotal:</strong> <span class="text-success">${{$cart['subtotal']}}</span>
            </div>
            <div>
                <strong>Total Weight:</strong> <span class="text-seondary">{{$cart['weight']}} lbs</span>
            </div>
            <div>
                <strong>Items:</strong> {{ $cart['quantity'] }}
            </div>
        </div>
    </div>
</div>