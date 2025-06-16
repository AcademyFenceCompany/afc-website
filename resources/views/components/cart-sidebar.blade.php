
@props(['cart' => $cart ?? []])
<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart" aria-labelledby="My Cart">
      <div class="offcanvas-header justify-content-center">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <div class="order-md-last">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-primary">Your cart</span>
            <span class="badge bg-primary rounded-pill cart-count">{{$cart['quantity']}}</span>
          </h4>
          <div class="card shopping-cart mb-3" style="border: 2px dashed #ced4da;">
            @dump($cart)
            <ul class="list-group list-group-flush" id="mini-shopping-cart">
                @foreach($cart['items'] as $item)
                <li class="list-group-item d-flex justify-content-between lh-sm">
                <div>
                    <h6 class="my-0">{{$item['name']}}</h6>
                    <small class="text-body-secondary">Quantity: {{$item['quantity']}}</small>
                </div>
                <span class="text-body-secondary">${{$item['price']}}</span>
                </li>
                @endforeach
            </ul>
              <div class="p-3 d-flex justify-content-between">
                <strong>Total (USD)</strong>
                <strong data-mi-total="{{$cart['total']}}" class="mini-cart-subtotal">${{$cart['subtotal']}}</strong>
            </div>
          </div>

          <a href="{{route('cart2.precheckout')}}" class="w-100 btn btn-primary btn-lg" >Continue to checkout</a>
        </div>
      </div>
    </div>