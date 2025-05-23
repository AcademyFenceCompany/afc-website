@extends('layouts.main')

@section('styles')
<style>
  body{
    color: #000;
  }
  section{
    padding: 10rem 0;
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
@endsection

@section('content')
    <x-hero-banner />

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
@endsection