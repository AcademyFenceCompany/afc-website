
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
          <div class="card mb-3">
            <ul class="list-group mb-3" style="border-color:rgb(187, 187, 187);">
                @dump($cart)
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
        </div>
          <a href="{{route('cart2.checkout2')}}" class="w-100 btn btn-primary btn-lg" >Continue to checkout</a>
        </div>
      </div>
    </div>