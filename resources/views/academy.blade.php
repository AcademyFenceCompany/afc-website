<!DOCTYPE html>
<html lang="en">
  <head>
    <title>AcademyFence - HTML Website Template</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendor.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css') }}" >
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css" >
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @yield('styles')
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet"> -->
    <style>
      body{
        color: #000;
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
    </style>
  </head>
  <body>

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
    <x-cart-sidebar :cart="$cart"/>
    
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
    
    <x-hero-banner :cart="$cart"/>

    <section class="landing-features d-none">
      <div class="container px-4 py-5">
        <div class="row row-cols-1 row-cols-md-2 align-items-md-center g-5 py-5">
          <div class="col d-flex flex-column align-items-start gap-2">
            <h2 class="fw-bold text-body-emphasis">Discover the Best Fencing Solutions for Your Property</h2>
            <p class="text-body-secondary">At Academy Fence Company, we specialize in providing top-quality fencing solutions tailored to meet your needs. Whether you're looking for privacy, security, or aesthetic appeal, our expert team is here to help you find the perfect fence for your property. Explore our wide range of materials and styles to enhance your outdoor space today.</p>
            <a href="#" class="btn btn-primary btn-lg px-3 py-2">Get Started</a>
          </div>

          <div class="col">
            <div class="row row-cols-1 row-cols-sm-2 g-4">
              <div class="col d-flex flex-column gap-2">
                <div class="feature-icon-small d-inline-flex align-items-center justify-content-center text-bg-secondary bg-gradient fs-4 rounded-3">
                    <i class="bi bi-cart4"></i>
                </div>
                <h4 class="fw-semibold mb-0 text-body-emphasis">In Stock Products</h4>
                <p class="text-body-secondary">Paragraph of text beneath the heading to explain the heading.</p>
              </div>

              <div class="col d-flex flex-column gap-2">
                <div class="feature-icon-small d-inline-flex align-items-center justify-content-center text-bg-secondary bg-gradient fs-4 rounded-3">
                  <i class="bi bi-truck"></i>
                </div>
                <h4 class="fw-semibold mb-0 text-body-emphasis">Shipping</h4>
                <p class="text-body-secondary">Paragraph of text beneath the heading to explain the heading.</p>
              </div>

              <div class="col d-flex flex-column gap-2">
                <div class="feature-icon-small d-inline-flex align-items-center justify-content-center text-bg-secondary bg-gradient fs-4 rounded-3">
                  <i class="bi bi-headset"></i>
                </div>
                <h4 class="fw-semibold mb-0 text-body-emphasis">Customer Service</h4>
                <p class="text-body-secondary">Paragraph of text beneath the heading to explain the heading.</p>
              </div>

              <div class="col d-flex flex-column gap-2">
                <div class="feature-icon-small d-inline-flex align-items-center justify-content-center text-bg-secondary bg-gradient fs-4 rounded-3">
                  <i class="bi bi-wrench-adjustable"></i>
                </div>
                <h4 class="fw-semibold mb-0 text-body-emphasis">Contractors</h4>
                <p class="text-body-secondary">Paragraph of text beneath the heading to explain the heading.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <x-landing-3-sections />

    <x-card-categories />

    <section class="d-none">
      <div class="container">
        <div class="row">
        <div class="col-4">
            <div class="card mb-3 border-0">
              <div class="row">
                <div class="col-md-2 text-dark">
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M21.5 15a3 3 0 0 0-1.9-2.78l1.87-7a1 1 0 0 0-.18-.87A1 1 0 0 0 20.5 4H6.8l-.33-1.26A1 1 0 0 0 5.5 2h-2v2h1.23l2.48 9.26a1 1 0 0 0 1 .74H18.5a1 1 0 0 1 0 2h-13a1 1 0 0 0 0 2h1.18a3 3 0 1 0 5.64 0h2.36a3 3 0 1 0 5.82 1a2.94 2.94 0 0 0-.4-1.47A3 3 0 0 0 21.5 15Zm-3.91-3H9L7.34 6H19.2ZM9.5 20a1 1 0 1 1 1-1a1 1 0 0 1-1 1Zm8 0a1 1 0 1 1 1-1a1 1 0 0 1-1 1Z"/></svg>
                </div>
                <div class="col-md-10">
                  <div class="card-body p-0">
                    <h5>Free delivery</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                  </div>
                </div>
              </div>
              </div>
          </div>
          <div class="col-4">
            <div class="card mb-3 border-0">
              <div class="row">
                <div class="col-md-2 text-dark">
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M19.63 3.65a1 1 0 0 0-.84-.2a8 8 0 0 1-6.22-1.27a1 1 0 0 0-1.14 0a8 8 0 0 1-6.22 1.27a1 1 0 0 0-.84.2a1 1 0 0 0-.37.78v7.45a9 9 0 0 0 3.77 7.33l3.65 2.6a1 1 0 0 0 1.16 0l3.65-2.6A9 9 0 0 0 20 11.88V4.43a1 1 0 0 0-.37-.78ZM18 11.88a7 7 0 0 1-2.93 5.7L12 19.77l-3.07-2.19A7 7 0 0 1 6 11.88v-6.3a10 10 0 0 0 6-1.39a10 10 0 0 0 6 1.39Zm-4.46-2.29l-2.69 2.7l-.89-.9a1 1 0 0 0-1.42 1.42l1.6 1.6a1 1 0 0 0 1.42 0L15 11a1 1 0 0 0-1.42-1.42Z"/></svg>
                </div>
                <div class="col-md-10">
                  <div class="card-body p-0">
                    <h5>100% secure payment</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                  </div>
                </div>
              </div>
              </div>
          </div>
          <div class="col-4">
            <div class="card mb-3 border-0">
              <div class="row">
                <div class="col-md-2 text-dark">
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M22 5H2a1 1 0 0 0-1 1v4a3 3 0 0 0 2 2.82V22a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-9.18A3 3 0 0 0 23 10V6a1 1 0 0 0-1-1Zm-7 2h2v3a1 1 0 0 1-2 0Zm-4 0h2v3a1 1 0 0 1-2 0ZM7 7h2v3a1 1 0 0 1-2 0Zm-3 4a1 1 0 0 1-1-1V7h2v3a1 1 0 0 1-1 1Zm10 10h-4v-2a2 2 0 0 1 4 0Zm5 0h-3v-2a4 4 0 0 0-8 0v2H5v-8.18a3.17 3.17 0 0 0 1-.6a3 3 0 0 0 4 0a3 3 0 0 0 4 0a3 3 0 0 0 4 0a3.17 3.17 0 0 0 1 .6Zm2-11a1 1 0 0 1-2 0V7h2ZM4.3 3H20a1 1 0 0 0 0-2H4.3a1 1 0 0 0 0 2Z"/></svg>
                </div>
                <div class="col-md-10">
                  <div class="card-body p-0">
                    <h5>Quality guarantee</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                  </div>
                </div>
              </div>
              </div>
          </div>
        </div>
      </div>

    </section>

    <section class="py-3 d-none" style="background-image: url('images/background-pattern.jpg');background-repeat: no-repeat;background-size: cover;">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="banner-blocks">          
              <div class="banner-ad large bg-info block-1">

                <div class="swiper main-swiper sw-bg">
                  <div class="swiper-wrapper">
                    
                    <div class="swiper-slide">
                      <div class="row banner-content p-5">
                        <div class="content-wrapper col-md-7">
                          <div class="categories my-3">Orange, New Jersey</div>
                          <h3 class="display-4 text-white">Welcome to Academy Fence Company</h3>
                          <p class="text-white">Academy Fence Company Established in the 1960's we offer a complete line of all types of fencing and railing.</p>
                          <a href="#" class="btn btn-primary btn-lg text-uppercase fs-6 rounded-1 px-4 py-3 mt-3">Shop Now</a>
                        </div>
                      </div>
                    </div>
                    
                    <div class="swiper-slide">
                      <div class="row banner-content p-5">
                        <div class="content-wrapper col-md-7">
                          <div class="categories mb-3 pb-3">100% natural</div>
                          <h3 class="banner-title">Fresh Smoothie & Summer Juice</h3>
                          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Dignissim massa diam elementum.</p>
                          <a href="#" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">Shop Collection</a>
                        </div>
                        <div class="img-wrapper col-md-5">
                          <img src="images/product-thumb-1.png" class="img-fluid">
                        </div>
                      </div>
                    </div>
                    
                    <div class="swiper-slide">
                      <div class="row banner-content p-5">
                        <div class="content-wrapper col-md-7">
                          <div class="categories mb-3 pb-3">100% natural</div>
                          <h3 class="banner-title">Heinz Tomato Ketchup</h3>
                          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Dignissim massa diam elementum.</p>
                          <a href="#" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">Shop Collection</a>
                        </div>
                        <div class="img-wrapper col-md-5">
                          <img src="images/product-thumb-2.png" class="img-fluid">
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="swiper-pagination"></div>

                </div>
              </div>
              
              <div class="banner-ad bg-success-subtle block-2" style="background:url('images/ad-image-1.png') no-repeat;background-position: right bottom">
                <div class="row banner-content p-5">

                  <div class="content-wrapper col-md-7">
                    <div class="categories sale mb-3 pb-3">20% off</div>
                    <h3 class="banner-title">Fence Installations and Repair</h3>
                    <a href="#" class="d-flex align-items-center nav-link">Go to Section <svg width="24" height="24"><use xlink:href="#arrow-right"></use></svg></a>
                  </div>

                </div>
              </div>

              <div class="banner-ad bg-danger block-3" style="background:url('images/ad-image-2.png') no-repeat;background-position: right bottom">
                <div class="row banner-content p-5">

                  <div class="content-wrapper col-md-7">
                    <div class="categories sale mb-3 pb-3">15% off</div>
                    <h3 class="item-title">Aluminum Fence</h3>
                    <a href="#" class="d-flex align-items-center nav-link">Shop Collection <svg width="24" height="24"><use xlink:href="#arrow-right"></use></svg></a>
                  </div>

                </div>
              </div>

            </div>
            <!-- / Banner Blocks -->
              
          </div>
        </div>
      </div>
    </section>


    <section class="product-desc ">
        <div class="container mt-5">
            <div class="row">
                <!-- Product Images -->
                <div class="col-md-6 mb-4 g-col-6 px-5">
                    <img src="https://mobileimages.lowes.com/productimages/ec62c039-d9c3-48db-89af-19699cc5b472/42237287.jpg" alt="Product" class="img-fluid rounded mb-3 product-image img-thumbnail" id="mainImage">
                    <div class="row ">
                        <div class="col-3">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/2048px-No_image_available.svg.png" class="img-thumbnail" alt="Thumbnail 1">
                        </div>
                        <div class="col-3">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/2048px-No_image_available.svg.png" class="img-thumbnail" alt="Thumbnail 1">
                        </div>                        
                        <div class="col-3">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/2048px-No_image_available.svg.png" class="img-thumbnail" alt="Thumbnail 1">
                        </div>
                        <div class="col-3">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/2048px-No_image_available.svg.png" class="img-thumbnail" alt="Thumbnail 1">
                        </div>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="col-md-6 g-col-6 px-3">
                    <h2 class="mb-3">Spaced Picket Section 2 1/2 in-SOT - Slant Ear</h2>
                    <p class="text-muted mb-4">Item No: WH1000XM4</p>
                    <div class="mb-3">
                        <span class="h4 me-2">$349.99</span>
                        <span class="text-muted"><s>$399.99</s></span>
                    </div>
                    <div class="mb-3">
                        <i class="bi bi-star-fill text-primary"></i>
                        <i class="bi bi-star-fill text-primary"></i>
                        <i class="bi bi-star-fill text-primary"></i>
                        <i class="bi bi-star-fill text-primary"></i>
                        <i class="bi bi-star-fill text-primary"></i>
                        <span class="ms-2">4.5 (120 reviews)</span>
                    </div>
                    <p class="mb-4">Experience premium sound quality and industry-leading noise cancellation with these wireless
                        headphones. Perfect for music lovers and frequent travelers.</p>
                    <div class="mb-4">
                        <h5>Color:</h5>
                        <div class="btn-group" role="group" aria-label="Color selection">
                            <input type="radio" class="btn-check" name="color" id="black" autocomplete="off" checked>
                            <label class="btn btn-outline-dark" for="black">Black</label>
                            <input type="radio" class="btn-check" name="color" id="silver" autocomplete="off">
                            <label class="btn btn-outline-secondary" for="silver">Silver</label>
                            <input type="radio" class="btn-check" name="color" id="blue" autocomplete="off">
                            <label class="btn btn-outline-primary" for="blue">Blue</label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="quantity" class="form-label">Quantity:</label>
                        <input type="number" class="form-control main-qty incre-qty" id="quantity" data-product-id="43765" value="1" min="1" style="width: 80px;">
                    </div>
                    <div class="d-sm-flex flex-sm-row gap-4">
                        <button class="btn btn-primary btn-lg flex-sm-fill add-to-cart" data-product-id="43765">
                            <i class="bi bi-cart-plus"></i> Add to Cart
                        </button>
                        <button class="btn btn-outline-secondary btn-lg flex-sm-fill">
                            <i class="bi bi-envelope-paper"></i> Get a Quote
                        </button>
                    </div>
                    <div class="mt-4">
                        <h5>Key Features:</h5>
                        <ul>
                            <li>Industry-leading noise cancellation</li>
                            <li>30-hour battery life</li>
                            <li>Touch sensor controls</li>
                            <li>Speak-to-chat technology</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="product-desc-customization d-none">
        <div class="container mt-5">
            <div class="row">
                <!-- Product Images -->
                <div class="col-md-6 mb-4 g-col-6 px-5">
                    <img src="{{ asset('assets/images/defaultfenceSG.png') }}" alt="Product" class="img-fluid rounded mb-3 product-image img-thumbnail" id="mainImage">
                    <div class="row ">
                        <div class="col-3">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/2048px-No_image_available.svg.png" class="img-thumbnail" alt="Thumbnail 1">
                        </div>
                        <div class="col-3">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/2048px-No_image_available.svg.png" class="img-thumbnail" alt="Thumbnail 1">
                        </div>                        
                        <div class="col-3">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/2048px-No_image_available.svg.png" class="img-thumbnail" alt="Thumbnail 1">
                        </div>
                        <div class="col-3">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/2048px-No_image_available.svg.png" class="img-thumbnail" alt="Thumbnail 1">
                        </div>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="col-md-6 g-col-6 px-3">
                    <h2 class="mb-3">Academy System 1, 4ft Complete</h2>
                    <p class="text-muted mb-4">Item No: WH1000XM4</p>
                    <div class="mb-3">
                        <span class="h4 me-2" style="color:rgb(129, 143, 8);">$349.99</span>
                        <span class="text-muted"><s>$399.99</s></span>
                    </div>

                    <p class="mb-4">Our complete fence systems include all necessary hardware for your fence installation. We simply need to know three things; 1) your total linear footage (price per foot), 2) the number of terminal posts, 3) and the number of access gates.
                    All parts are included in the price that are necessary to erect the fence except for concrete. For example the price per foot includes the chain link mesh fabric, the top rail, line posts,
                     and loop caps. Alternatively you have the option to select individual parts from our complete line of posts, rail, pipe, fittings, hardware, hinges, latches, accessories and gates; all in stock and ready to pick up or to ship.</p>
                    <div class="mb-4">
                        <h5>Color:</h5>
                        <div class="btn-group" role="group" aria-label="Color selection">
                            <input type="radio" class="btn-check" name="color" id="black" autocomplete="off" checked>
                            <label class="btn btn-outline-dark" for="black">Black</label>
                            <input type="radio" class="btn-check" name="color" id="Green" autocomplete="off">
                            <label class="btn btn-outline-secondary" for="Green">Green</label>
                            <input type="radio" class="btn-check" name="color" id="Blue" autocomplete="off">
                            <label class="btn btn-outline-danger" for="blue">Brown</label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="quantity" class="form-label">Quantity:</label>
                        <input type="number" class="form-control main-qty" id="quantity" value="1" min="1" style="width: 80px;">
                    </div>
                    <div class="d-sm-flex flex-sm-row gap-4">
                        <button class="btn btn-primary btn-lg flex-sm-fill">
                            <i class="bi bi-cart-plus"></i> Add to Cart
                        </button>
                        <button class="btn btn-outline-secondary btn-lg flex-sm-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top">
                            <i class="bi bi-envelope-paper"></i> Get a Quote
                        </button>
                    </div>
                    <div class="mt-4">
                        <h5>Customize Your Order</h5>
                        <table class="table table-responsive">
                          <tbody>
                            <tr>
                              <td>Add Foot of Fencing @ <strong>$19.77</strong> each</td>
                              <td>
                                <input min="1" type="number" id="quantity" name="quantity" width="4rem" style="width:4rem !important" pattern="[0-9]*" value="0" required=""
                                data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Tooltip on left">
                              </td>
                              <td>
                                <button class="btn add-to-cart btn-primary float-right" data-item="PSFL72" data-qty="1" data-name="Flat Top Wood Fence Post" data-price="12.00">
                                    Update Cart
                                </button>
                              </td>
                            </tr>
                            <tr>
                              <td>Add Single Walk Gate 3ft @ <strong>$19.77</strong> each</td>
                              <td>
                                <input min="1" type="number" id="quantity" name="quantity" width="4rem" style="width:4rem !important" pattern="[0-9]*" value="0" required="">
                              </td>
                              <td>
                                <button class="btn add-to-cart btn-primary float-right" data-item="PSFL72" data-qty="1" data-name="Flat Top Wood Fence Post" data-price="12.00">
                                    Update Cart
                                </button>
                              </td>
                            </tr>
                            <tr>
                              <td>Add 2x6 Terminal Posts  @ <strong>$19.77</strong> each</td>
                              <td>
                                <input min="1" type="number" id="quantity" name="quantity" width="4rem" style="width:4rem !important" pattern="[0-9]*" value="0" required="">
                              </td>
                              <td>
                                <button class="btn add-to-cart btn-primary float-right" data-item="PSFL72" data-qty="1" data-name="Flat Top Wood Fence Post" data-price="12.00">
                                    Update Cart
                                </button>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <h5>Kit Includes:</h5>
                        <ul>
                            <li>(42) 2-1/2" Black Steel Tension Band Item# 10406B</li>
                            <li>(23) 1-3/8" Black Fork Latch Hanger Item# 10873B</li>
                            <li>(42) 2-1/2" Black Steel Tension Band Item# 10406B</li>
                            <li>(23) 1-3/8" Black Fork Latch Hanger Item# 10873B</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- <x-fencesyscustom/> -->
    <!-- <x-chainlink-byparts /> -->

    <section class="sub-category py-5 d-none">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title mb-4">Straight On Top</h2>
                </div>
                
                @php
                  for ($i = 0; $i < 4; $i++) {
                      echo'
                      <div class="col-lg-3 col-sm-12">
                          <div class="card mb-4">
                              <img src="https://www.academyfence.com/images/wood/sketch2/SE_SOT_SKETCH_SM.jpg" class="card-img-top py-3" alt="...">
                              <div class="card-body">
                                  <h5 class="card-title">Slant Ear</h5>
                                  <p class="card-text p-1 m-0"><strong>Section Top Style:</strong> Straight</p>
                                  <p class="card-text p-1 m-0"><strong>Heights:</strong> 3ft, 42in, 4ft, 5ft, 6ft, 7ft, 8ft</p>
                                  <p class="card-text p-1 m-0">Picket Style: Slant Ear</p>
                                  <p class="card-text p-1 m-0">Spacing: 2-1/2in</p>
                                  <a href="#" class="btn btn-primary d-none">Go somewhere</a>
                              </div>
                          </div>
                      </div>';
                  }
                @endphp

            </div>
            <div class="row mt-5">
                <div class="col-12">
                    <h2 class="section-title mb-4">Concave</h2>
                </div>
                <?php 
                for ($i = 0; $i < 3; $i++) {
                    echo'
                    <div class="col-lg-4 col-sm-12">
                        <div class="card">
                            <img src="https://www.academyfence.com/images/wood/sketch2/FT_CC_SKETCH_SM.jpg" class="card-img-top py-3" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Slant Ear</h5>
                                <p class="card-text p-1 m-0"><strong>Section Top Style:</strong> Straight</p>
                                <p class="card-text p-1 m-0"><strong>Heights:</strong> 3ft, 42in, 4ft, 5ft, 6ft, 7ft, 8ft</p>
                                <p class="card-text p-1 m-0"><strong>Picket Style:</strong> Slant Ear</p>
                                <p class="card-text p-1 m-0"><strong>Spacing:</strong> 2-1/2in</p>
                                <a href="#" class="btn btn-primary d-none">Go somewhere</a>
                            </div>
                        </div>
                    </div>';
                }

                ?>
            </div>
        </div>
    </section>

    <section class="category-listing py-5 d-none">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-12">
                    <x-sidebar-filter />
                </div>
                <div class="col-lg-9 col-sm-12">
                    <div class="row">
                    <?php
                        for ($i = 0; $i < 3; $i++) {
                            // Example of a product card
                            echo'
                            <div class="col-lg-4 col-sm-12 mb-4">
                                <div class="card">
                                    <img src="https://mobileimages.lowes.com/productimages/ec62c039-d9c3-48db-89af-19699cc5b472/42237287.jpg" class="card-img-top" alt="Product Image">
                                    <div class="card-body">
                                        <h5 class="card-title">Welded Wire</h5>
                                        <p class="card-text">Short product description goes here.</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="h5 mb-0">$99.99</span>
                                            <div>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-half text-warning"></i>
                                                <small class="text-muted">(4.5)</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-between bg-light">
                                        <button class="btn btn-primary btn-sm">Add to Cart</button>
                                        <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-heart"></i></button>
                                    </div>
                                </div>
                            </div>';
                        }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="necessary-products container d-none">
        <div class="text-center py-3 rounded mb-4 bg-secondary-subtle d-none">
            <h3 class="mb-0">MOST POPULAR CHOICES</h3>
        </div>
        <div class="table-responsive mt-3">
            <table class="table product-table">
                <thead>
                    <tr>
                        <th>Item Number</th>
                        <th>Name</th>
                        <th>Size</th>
                        <th>Color</th>
                        <th>Quantity</th>
                        <th>Price / Add to Cart</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                        <td>PSFL72</td>
                        <td>Flat Top Wood Fence Post</td>
                        <td>4in x 4in x 6ft</td>
                        <td>Pressure Treated</td>
                        <td>
                            <div class="input-group product-qty">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
                                    <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                </button>
                            </span>
                            <input type="text" id="quantity" name="quantity" class="form-control border input-number mx-3 w-25" value="1">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
                                    <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                </button>
                            </span>
                        </div>
                        </td>
                        <td>
                            <span class="px-2 me-3">$12.00</span>
                            <button class="btn add-to-cart btn-primary float-right" data-item="PSFL72" data-qty="1" data-name="Flat Top Wood Fence Post" data-price="12.00">
                                Add to Cart
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>PSFL72</td>
                        <td>Flat Top Wood Fence Post</td>
                        <td>4in x 4in x 6ft</td>
                        <td>Pressure Treated</td>
                        <td>
                            <div class="input-group product-qty">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
                                    <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                </button>
                            </span>
                            <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1" style="width: 1rem;">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
                                    <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                </button>
                            </span>
                        </div>
                        </td>
                        <td>
                            <span class="px-2">$12.00</span>
                            <button class="btn add-to-cart btn-sm btn-primary" data-item="PSFL72" data-qty="1" data-name="Flat Top Wood Fence Post" data-price="12.00">
                                Add to Cart
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>  
        <h2 class="section-title">Solid Board</h2>
        <div class="table-responsive mt-3">
            <table class="table product-table align-middle">
                <thead>
                    <tr>
                        <th>Item Number</th>
                        <th>Name</th>
                        <th>Size</th>
                        <th>Color</th>
                        <th>Quantity</th>
                        <th>Price / Add to Cart</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                        <td>PSFL72</td>
                        <td>Flat Top Wood Fence Post</td>
                        <td>4in x 4in x 6ft</td>
                        <td>Pressure Treated</td>
                        <td>
                            <div class="input-group product-qty">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
                                    <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                </button>
                            </span>
                            <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1" style="width: 1rem;">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
                                    <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                </button>
                            </span>
                        </div>
                        </td>
                        <td>
                            <span class="px-2">$12.00</span>
                            <button class="btn add-to-cart btn-sm btn-primary" data-item="PSFL72" data-name="Flat Top Wood Fence Post" data-price="12.00">
                                Add to Cart
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>PSFL72</td>
                        <td>Flat Top Wood Fence Post</td>
                        <td>4in x 4in x 6ft</td>
                        <td>Pressure Treated</td>
                        <td>
                            <div class="input-group product-qty">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
                                    <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                </button>
                            </span>
                            <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1" style="width: 1rem;">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
                                    <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                </button>
                            </span>
                        </div>
                        </td>
                        <td>
                            <span class="px-2">$12.00</span>
                            <button class="btn add-to-cart btn-sm btn-primary" data-item="PSFL72" data-name="Flat Top Wood Fence Post" data-price="12.00">
                                Add to Cart
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div> 
    </section>

    <section class="py-5 overflow-hidden">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-header d-flex flex-wrap justify-content-between mb-5">
              <h2 class="section-title">NJ/NY Metro Area Pick-up Center</h2>
              <div class="d-flex align-items-center">
                <a href="#" class="btn-link text-decoration-none">View All Categories →</a>
                <div class="swiper-buttons">
                  <button class="swiper-prev category-carousel-prev btn btn-yellow">❮</button>
                  <button class="swiper-next category-carousel-next btn btn-yellow">❯</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-5 shipping-availability"> 
      <div class="container">
        <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
          <div class="col-10 col-sm-8 col-lg-6">
            <img src="{{asset('assets/images/installationmap.png')}}" class="d-block mx-lg-auto img-fluid rounded" alt="Installation Map" width="700" height="500" loading="lazy">
          </div>
          <div class="col-lg-6">
            <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3">Shipping availability.</h1>
            <p class="lead">We offer reliable and efficient shipping services to ensure your fencing materials arrive on time and in excellent condition. Whether you're ordering for a residential or commercial project, our team is committed to providing seamless delivery solutions tailored to your needs. Contact us for more details on shipping options and timelines.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="py-5">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="bootstrap-tabs product-tabs">
              <div class="tabs-header d-flex justify-content-between border-bottom my-5">
                <h3>Fencing</h3>
                <nav>
                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a href="#" class="nav-link text-uppercase fs-6 active" id="nav-all-tab" data-bs-toggle="tab" data-bs-target="#nav-all">All</a>
                    <a href="#" class="nav-link text-uppercase fs-6" id="nav-fruits-tab" data-bs-toggle="tab" data-bs-target="#nav-fruits">Privacy Slats</a>
                    <a href="#" class="nav-link text-uppercase fs-6" id="nav-juices-tab" data-bs-toggle="tab" data-bs-target="#nav-juices">Deer Fence</a>
                  </div>
                </nav>
              </div>
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
                  <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                    <!-- Product items would be loaded here -->
                  </div>
                </div>
                <div class="tab-pane fade" id="nav-fruits" role="tabpanel" aria-labelledby="nav-fruits-tab">
                  <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                    <!-- Privacy slats products would be loaded here -->
                  </div>
                </div>
                <div class="tab-pane fade" id="nav-juices" role="tabpanel" aria-labelledby="nav-juices-tab">
                  <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                    <!-- Deer fence products would be loaded here -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-5">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="banner-ad bg-danger mb-3" style="background: url('images/ad-image-3.png');background-repeat: no-repeat;background-position: right bottom;">
              <div class="banner-content p-5">
                <div class="categories sale mb-3 pb-3">15% off</div>
                <h3 class="banner-title">Aluminum Fence In Stock</h3>
                <p>Heron Longspur Siskin Starling</p>
                <a href="#" class="btn btn-dark text-uppercase">Shop Now</a>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="banner-ad" style="background-color: #a8b2b3;background-repeat: no-repeat;background-position: right bottom; background-size: contain;color: #000;">
              <div class="banner-content p-5">
                <div class="categories text-primary fs-3 fw-bold">10% Off Shipping and Handling</div>
                <h3 class="banner-title">Welded Wire</h3>
                <p>Solar Post caps</p>
                <a href="#" class="btn btn-dark text-uppercase">Shop Now</a>
              </div>
            </div>
          </div>   
        </div>
      </div>
    </section>

    <section id="latest-blog" class="py-5">
      <div class="container">
        <div class="row">
          <div class="section-header d-flex align-items-center justify-content-between my-5">
            <h2 class="section-title">Our Recent Blog</h2>
            <div class="btn-wrap align-right">
              <a href="#" class="d-flex align-items-center nav-link">Read All Articles <svg width="24" height="24"><use xlink:href="#arrow-right"></use></svg></a>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <article class="post-item card shadow-sm p-3" style="border: 1px solid #7d7d7d">
              <div class="image-holder zoom-effect">
                <a href="#">
                  <img src="https://www.academyfence.com/codes-and-permits/wp-content/uploads/2017/12/6-foot-board-on-board-and-4-foot-starling-aluminum-fence-Madison-NJ-Morris-County-3.jpg" alt="post" class="card-img-top">
                </a>
              </div>
              <div class="card-body">
                <div class="post-meta d-flex text-uppercase gap-3 my-2 align-items-center">
                  <div class="meta-date"><svg width="16" height="16"><use xlink:href="#calendar"></use></svg>22 Aug 2021</div>
                  <div class="meta-categories"><svg width="16" height="16"><use xlink:href="#category"></use></svg>tips & tricks</div>
                </div>
                <div class="post-header">
                  <h3 class="post-title">
                    <a href="#" class="text-decoration-none">Top 10 casual look ideas to dress up your kids</a>
                  </h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipi elit. Aliquet eleifend viverra enim tincidunt donec quam. A in arcu, hendrerit neque dolor morbi...</p>
                </div>
              </div>
            </article>
          </div>
          <div class="col-md-4">
            <article class="post-item card shadow-sm p-3" style="border: 1px solid #7d7d7d">
              <div class="image-holder zoom-effect">
                <a href="#">
                  <img src="https://www.academyfence.com/codes-and-permits/wp-content/uploads/2017/12/Jerith-Bronze-Aluminum-Fence-and-Gate.jpg" alt="post" class="card-img-top">
                </a>
              </div>
              <div class="card-body">
                <div class="post-meta d-flex text-uppercase gap-3 my-2 align-items-center">
                  <div class="meta-date"><svg width="16" height="16"><use xlink:href="#calendar"></use></svg>25 Aug 2021</div>
                  <div class="meta-categories"><svg width="16" height="16"><use xlink:href="#category"></use></svg>trending</div>
                </div>
                <div class="post-header">
                  <h3 class="post-title">
                    <a href="#" class="text-decoration-none">Latest trends of wearing street wears supremely</a>
                  </h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipi elit. Aliquet eleifend viverra enim tincidunt donec quam. A in arcu, hendrerit neque dolor morbi...</p>
                </div>
              </div>
            </article>
          </div>
          <div class="col-md-4">
            <article class="post-item card shadow-sm p-3" style="border: 1px solid #7d7d7d">
              <div class="image-holder zoom-effect">
                <a href="#">
                  <img src="https://www.academyfence.com/codes-and-permits/wp-content/uploads/2017/11/Pool-Code-Aluminum-Backyard-Fence.jpg" alt="post" class="card-img-top">
                </a>
              </div>
              <div class="card-body">
                <div class="post-meta d-flex text-uppercase gap-3 my-2 align-items-center">
                  <div class="meta-date"><svg width="16" height="16"><use xlink:href="#calendar"></use></svg>28 Aug 2021</div>
                  <div class="meta-categories"><svg width="16" height="16"><use xlink:href="#category"></use></svg>inspiration</div>
                </div>
                <div class="post-header">
                  <h3 class="post-title">
                    <a href="#" class="text-decoration-none">10 Different Types of comfortable clothes ideas for women</a>
                  </h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipi elit. Aliquet eleifend viverra enim tincidunt donec quam. A in arcu, hendrerit neque dolor morbi...</p>
                </div>
              </div>
            </article>
          </div>
        </div>
      </div>
    </section>
</html>