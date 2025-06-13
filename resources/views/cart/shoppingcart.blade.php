@extends('layouts.main2')
@section('styles')
<style>
      body{
        color: #000;
      }
      .form-control, .form-select{
        border: 2px solid #ced4da;
        padding: 0.8rem 0.75rem
      }
      .form-check-input{
        --bs-form-check-bg: #c4c4c4;
      }
      section{
          padding: 10rem 0;
          /* border-top: 2px solid rgb(126, 126, 126);
          border-bottom: 2px solid rgb(126, 126, 126); */
      }
      header .nav-link {
          background-color: transparent;
      }
      .feature-icon-small {
        width: 3rem;
        height: 3rem;
      }
      .shipping-availability{
        background-color: #e8d7d3;
      }
      .card{
        border: 2px dashed #ced4da;
        box-shadow:none;
      }
    </style>
@endsection
@section('content')
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
      <defs>
        <symbol xmlns="http://www.w3.org/2000/svg" id="link" viewBox="0 0 24 24">
          <path fill="currentColor" d="M12 19a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm5 0a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm0-4a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm-5 0a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm7-12h-1V2a1 1 0 0 0-2 0v1H8V2a1 1 0 0 0-2 0v1H5a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3Zm1 17a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-9h16Zm0-11H4V6a1 1 0 0 1 1-1h1v1a1 1 0 0 0 2 0V5h8v1a1 1 0 0 0 2 0V5h1a1 1 0 0 1 1 1ZM7 15a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm0 4a1 1 0 1 0-1-1a1 1 0 0 0 1 1Z"/>
        </symbol>
        <symbol xmlns="http://www.w3.org/2000/svg" id="arrow-right" viewBox="0 0 24 24">
          <path fill="currentColor" d="M17.92 11.62a1 1 0 0 0-.21-.33l-5-5a1 1 0 0 0-1.42 1.42l3.3 3.29H7a1 1 0 0 0 0 2h7.59l-3.3 3.29a1 1 0 0 0 0 1.42a1 1 0 0 0 1.42 0l5-5a1 1 0 0 0 .21-.33a1 1 0 0 0 0-.76Z"/>
        </symbol>
        <symbol xmlns="http://www.w3.org/2000/svg" id="category" viewBox="0 0 24 24">
          <path fill="currentColor" d="M19 5.5h-6.28l-.32-1a3 3 0 0 0-2.84-2H5a3 3 0 0 0-3 3v13a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-10a3 3 0 0 0-3-3Zm1 13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-13a1 1 0 0 1 1-1h4.56a1 1 0 0 1 .95.68l.54 1.64a1 1 0 0 0 .95.68h7a1 1 0 0 1 1 1Z"/>
        </symbol>
        <symbol xmlns="http://www.w3.org/2000/svg" id="calendar" viewBox="0 0 24 24">
          <path fill="currentColor" d="M19 4h-2V3a1 1 0 0 0-2 0v1H9V3a1 1 0 0 0-2 0v1H5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3Zm1 15a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-7h16Zm0-9H4V7a1 1 0 0 1 1-1h2v1a1 1 0 0 0 2 0V6h6v1a1 1 0 0 0 2 0V6h2a1 1 0 0 1 1 1Z"/>
        </symbol>
        <symbol xmlns="http://www.w3.org/2000/svg" id="heart" viewBox="0 0 24 24">
          <path fill="currentColor" d="M20.16 4.61A6.27 6.27 0 0 0 12 4a6.27 6.27 0 0 0-8.16 9.48l7.45 7.45a1 1 0 0 0 1.42 0l7.45-7.45a6.27 6.27 0 0 0 0-8.87Zm-1.41 7.46L12 18.81l-6.75-6.74a4.28 4.28 0 0 1 3-7.3a4.25 4.25 0 0 1 3 1.25a1 1 0 0 0 1.42 0a4.27 4.27 0 0 1 6 6.05Z"/>
        </symbol>
        <symbol xmlns="http://www.w3.org/2000/svg" id="plus" viewBox="0 0 24 24">
          <path fill="currentColor" d="M19 11h-6V5a1 1 0 0 0-2 0v6H5a1 1 0 0 0 0 2h6v6a1 1 0 0 0 2 0v-6h6a1 1 0 0 0 0-2Z"/>
        </symbol>
        <symbol xmlns="http://www.w3.org/2000/svg" id="minus" viewBox="0 0 24 24">
          <path fill="currentColor" d="M19 11H5a1 1 0 0 0 0 2h14a1 1 0 0 0 0-2Z"/>
        </symbol>
        <symbol xmlns="http://www.w3.org/2000/svg" id="cart" viewBox="0 0 24 24">
          <path fill="currentColor" d="M8.5 19a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 8.5 19ZM19 16H7a1 1 0 0 1 0-2h8.491a3.013 3.013 0 0 0 2.885-2.176l1.585-5.55A1 1 0 0 0 19 5H6.74a3.007 3.007 0 0 0-2.82-2H3a1 1 0 0 0 0 2h.921a1.005 1.005 0 0 1 .962.725l.155.545v.005l1.641 5.742A3 3 0 0 0 7 18h12a1 1 0 0 0 0-2Zm-1.326-9l-1.22 4.274a1.005 1.005 0 0 1-.963.726H8.754l-.255-.892L7.326 7ZM16.5 19a1.5 1.5 0 1 0 1.5 1.5a1.5 1.5 0 0 0-1.5-1.5Z"/>
        </symbol>
        <symbol xmlns="http://www.w3.org/2000/svg" id="check" viewBox="0 0 24 24">
          <path fill="currentColor" d="M18.71 7.21a1 1 0 0 0-1.42 0l-7.45 7.46l-3.13-3.14A1 1 0 1 0 5.29 13l3.84 3.84a1 1 0 0 0 1.42 0l8.16-8.16a1 1 0 0 0 0-1.47Z"/>
        </symbol>
        <symbol xmlns="http://www.w3.org/2000/svg" id="trash" viewBox="0 0 24 24">
          <path fill="currentColor" d="M10 18a1 1 0 0 0 1-1v-6a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1ZM20 6h-4V5a3 3 0 0 0-3-3h-2a3 3 0 0 0-3 3v1H4a1 1 0 0 0 0 2h1v11a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8h1a1 1 0 0 0 0-2ZM10 5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v1h-4Zm7 14a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V8h10Zm-3-1a1 1 0 0 0 1-1v-6a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1Z"/>
        </symbol>
        <symbol xmlns="http://www.w3.org/2000/svg" id="star-outline" viewBox="0 0 15 15">
          <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M7.5 9.804L5.337 11l.413-2.533L4 6.674l2.418-.37L7.5 4l1.082 2.304l2.418.37l-1.75 1.793L9.663 11L7.5 9.804Z"/>
        </symbol>
        <symbol xmlns="http://www.w3.org/2000/svg" id="star-solid" viewBox="0 0 15 15">
          <path fill="currentColor" d="M7.953 3.788a.5.5 0 0 0-.906 0L6.08 5.85l-2.154.33a.5.5 0 0 0-.283.843l1.574 1.613l-.373 2.284a.5.5 0 0 0 .736.518l1.92-1.063l1.921 1.063a.5.5 0 0 0 .736-.519l-.373-2.283l1.574-1.613a.5.5 0 0 0-.283-.844L8.921 5.85l-.968-2.062Z"/>
        </symbol>
        <symbol xmlns="http://www.w3.org/2000/svg" id="search" viewBox="0 0 24 24">
          <path fill="currentColor" d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z"/>
        </symbol>
        <symbol xmlns="http://www.w3.org/2000/svg" id="user" viewBox="0 0 24 24">
          <path fill="currentColor" d="M15.71 12.71a6 6 0 1 0-7.42 0a10 10 0 0 0-6.22 8.18a1 1 0 0 0 2 .22a8 8 0 0 1 15.9 0a1 1 0 0 0 1 .89h.11a1 1 0 0 0 .88-1.1a10 10 0 0 0-6.25-8.19ZM12 12a4 4 0 1 1 4-4a4 4 0 0 1-4 4Z"/>
        </symbol>
        <symbol xmlns="http://www.w3.org/2000/svg" id="close" viewBox="0 0 15 15">
          <path fill="currentColor" d="M7.953 3.788a.5.5 0 0 0-.906 0L6.08 5.85l-2.154.33a.5.5 0 0 0-.283.843l1.574 1.613l-.373 2.284a.5.5 0 0 0 .736.518l1.92-1.063l1.921 1.063a.5.5 0 0 0 .736-.519l-.373-2.283l1.574-1.613a.5.5 0 0 0-.283-.844L8.921 5.85l-.968-2.062Z"/>
        </symbol>
      </defs>
    </svg>

    <div class="preloader-wrapper">
      <div class="preloader">
      </div>
    </div>

    <x-cart-sidebar :cart="$cart" />
    
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasSearch" aria-labelledby="Search">
      <div class="offcanvas-header justify-content-center">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <div class="order-md-last">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-primary">Search</span>
          </h4>
          <form role="search" action="index.html" method="get" class="d-flex mt-3 gap-0">
            <input class="form-control rounded-start rounded-0 bg-light" type="email" placeholder="What are you looking for?" aria-label="What are you looking for?">
            <button class="btn btn-dark rounded-end rounded-0" type="submit">Search</button>
          </form>
        </div>
      </div>
    </div>

    @include('partials.header')
        <main class="container">
            <div class="py-4">
                <h2>
                    <svg class="me-2" width="32" height="32" style="color:rgba(167, 40, 40, 0.9);">
                    <use xlink:href="#cart"></use>
                    </svg>
                Shopping Cart
                </h2>
                <p class="lead text-muted">Review your cart items and proceed to checkout.</p>
            </div>
            <form class="needs-validation" method="POST" action="{{ route('shipping2.getShippingRates') }}" novalidate>
              @csrf
              <div class="row g-5">
                <div class="col-md-5 col-lg-4 order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Order Summary</span>
                    <span class="badge bg-primary rounded-pill cart-count">{{$cart['quantity']}}</span>
                    </h4>
                    <div class="card mb-3 cart-summary">
                      <div class="cart-summary-container">
                          <ul class="list-group-item px-3 pt-4">
                              <li class="list-group-item py-1 d-flex justify-content-between">
                                  <span>Item Subtotal (<span class="cart-count">{{$cart['quantity']}}</span>)</span>
                                  <span class="text-muted mini-cart-subtotal" data-mi-subtotal="">${{$cart['subtotal']}}</span>
                              </li>
                              <li class="list-group-item py-1 d-flex justify-content-between">
                                  <span>Shipping</span>
                                  <span class="text-muted cart-sumry-shipcost" data-mi-shipping="">--</span>
                              </li>
                              <li class="list-group-item py-1 d-flex justify-content-between">
                                  <span>Sales Tax</span>
                                  <span class="text-muted cart-tax" data-mi-taxes="0" >${{$cart['tax']}}</span>

                              </li>
                          </ul>
                          <div class="p-3 d-flex justify-content-between border-top">
                              <strong>Total (USD)</strong>
                              <strong data-mi-total="{{$cart['total']}}" class="cart-total">${{$cart['total']}}</strong>
                          </div>
                      </div>
                      <a href="{{route('cart2.checkout2')}}" class="btn btn-primary btn-lg m-3 mt-0" id="place-order">
                          Proceed to Checkout
                          <i class="bi bi-arrow-right-circle-fill"></i>
                        </a>
                    </div>
                    <div class="card bg-light mb-3" style="border:none;">
                      <img src="https://fencesnj.com/assets/images/nationwidemap.png" class="card-img-top shadow-none" alt="...">
                    </div>
                    
                </div>
                <div class="col-md-7 col-lg-8">
                    
                    @foreach($cart['items'] as $item)
                    <div class="row mb-4 d-flex justify-content-between align-items-center cart-item">
                        <div class="col-md-2 col-lg-2">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg"
                            class="img-fluid rounded-3" alt="Cotton T-shirt">
                        </div>
                        <div class="col-md-5 col-lg-5">
                            <h6 class="text-muted">Item #: {{$item['id']}}</h6>
                            <h6 class="mb-0">{{$item['name']}}</h6>
                        </div>
                        <div class="col-md-2 col-lg-1 col-xl-2 d-flex">
                            <input type="number" class="form-control incre-qty" data-product-id="{{$item['id']}}" name="quantity" min="1" value="{{$item['quantity']}}">
                        </div>
                        <div class="col-md-2 col-lg-2">
                            <h4 class="mb-0 text-success">${{$item['price']}}</h4>
                        </div>
                        <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                            <a href="#" class="btn btn-outline-secondary remove-from-cart" data-product-id="{{$item['id']}}" title="Remove from cart">
                                <i class="bi bi-trash-fill"></i>
                            </a>
                        </div>
                        <hr class="my-4">
                    </div>
                    
                    @endforeach
                    <div class="row py-4">
                        <div class="col-sm-6 mb-sm-0">
                            <div class="card bg-light" style="border-style:solid;">
                                <div class="card-body">
                                    <i class="bi bi-truck me-2"></i>
                                    <h5 class="card-title d-inline">No Returns</h5>
                                    <p>We do not accept returns. Please review your order carefully before completing your purchase.</p>
                                    <a href="#" class="btn btn-secondary">Learn more</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card bg-light" style="border-style:solid;">
                                <div class="card-body">
                                    <i class="bi bi-telephone-fill me-2"></i>
                                    <h5 class="card-title d-inline">Shopping Assistance</h5>
                                    <p>Have questions before you check out? We're here to help!</p>
                                    <a href="#" class="btn btn-secondary">Email</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </form>
        </main>
@section('content') 