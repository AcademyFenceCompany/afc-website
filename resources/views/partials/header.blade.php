<header class="bg-white shadow-sm sticky-sm-top sticky-md-top">
    <nav class="top-bar">
        <div class="container d-flex flex-wrap">
            <ul class="nav me-auto">
                <li class="nav-item"><a href="#" class="nav-link px-2 active" aria-current="page">Directions</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2">Customer Service</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2">Contact Us</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2">About Us</a></li>
                @if(isset($height))
                    <li class="nav-item"><a href="#" class="nav-link px-2">{{$height}}</a></li>
                @endif
            </ul>
            <ul class="nav">
            <li class="nav-item nav-link">119 N Day St, Orange, NJ 07050, 973-674-0600</li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="row py-1 border-bottom">
        
        <div class="col-sm-4 col-lg-3 text-center text-sm-start">
            <div class="main-logo">
            <a href="index.html">
                <img src="https://www.academyfence.com/images/logo.png" alt="logo" class="img-fluid">
            </a>
            </div>
            <p class="logo-caption m-0 d-none d-lg-block">The Original Fence Superstore</p>
        </div>
        
        <div class="col-sm-6 offset-sm-2 offset-md-0 col-lg-6 d-flex align-items-center">
            <div class="search-bar w-100 bg-light d-flex p-2 my-2 rounded-4">
                <div class="d-none d-md-block">
                    <select class="form-select border-0 bg-transparent">
                        <option>All Categories</option>
                        <option>Groceries</option>
                        <option>Drinks</option>
                        <option>Chocolates</option>
                    </select>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search all categories">
                    <div class="input-group-append">
                        <button class="btn bg-light" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-8 col-lg-3 d-flex justify-content-end gap-5 align-items-center mt-4 mt-sm-0 justify-content-center justify-content-sm-end">
            <div class="support-box text-end d-none d-xl-block">
                <span class="fs-6 text-muted">For Support?</span>
                <h5 class="mb-0">973-674-0400</h5>
            </div>



            <div class="cart text-end d-none d-lg-block dropdown">
                <button class="border-0 bg-transparent d-flex flex-column gap-2 lh-1 d-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                    <span class="fs-6 text-muted dropdown-toggle">Your Cart</span>
                    <span class="cart-total fs-5 fw-bold">$1290.00</span>
                </button>
                <div class="dropdown">
                
                    <a href="#" class="position-relative text-dark p-2 d-none show" id="cartDropdown" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                        <i class="bi bi-person fs-4"></i>
                    </a>
                        
                    <a href="#" class="position-relative text-dark p-2 show" id="cartDropdown" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                        <i class="bi bi-cart fs-4"></i>
                        <span class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill cart-count">
                            0
                        </span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end p-3 shadow-lg show d-none" style="min-width: 300px; position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 46px);" data-popper-placement="bottom-end">
                        <ul id="mini-cart-items" class="list-unstyled mb-2">
                                    </ul>

                        <p id="empty-cart-message" class=" text-center">Your cart is
                            empty
                        </p>
                        <div class="d-grid gap-2">
                            <a href="http://192.168.0.24/cart" class="btn btn-danger w-100">View Cart</a>
                            <a href="http://192.168.0.24/checkout" class="btn btn-danger w-100">Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div>
    </div>
    <nav class="main-nav">
        <div class="container">
            <div class="row py-2">
            <div class="d-flex  justify-content-center justify-content-sm-between align-items-center">
                <nav class="main-menu d-flex navbar navbar-expand-lg">

                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                    aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">

                    <div class="offcanvas-header justify-content-center">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>

                    <div class="offcanvas-body big-menu">              
                
                    <ul class="navbar-nav justify-content-end menu-list list-unstyled d-flex gap-md-3 mb-0">
                        <li class="nav-item active dropdown">
                            <a class="nav-link dropdown-toggle text-bg-secondary" role="button" data-bs-toggle="dropdown" aria-expanded="false" type="button"
                            data-mdb-toggle="dropdown">Shop By Category</a>
                            <!-- Major Categories First Level menu-->
                            <x-big-menu :majCategories="$majCategories" />
                        </li>
                        <li class="nav-item">
                            <a href="#men" class="nav-link">Wood Fence</a>
                        </li>
                        <li class="nav-item">
                            <a href="#men" class="nav-link">Vinyl Fence</a>
                        </li>
                        <li class="nav-item">
                            <a href="#men" class="nav-link">Chain Link Fence</a>
                        </li>
                        <li class="nav-item">
                            <a href="#men" class="nav-link">Aluminum Fence</a>
                        </li>
                        <li class="nav-item">
                            <a href="#men" class="nav-link">Welded Wire</a>
                        </li>
                        <li class="nav-item">
                            <a href="#men" class="nav-link text-bg-info">Get A Quote</a>
                        </li>
                    </ul>
                    

                    </div>

                </div>

                </nav>
            </div>
            </div>
        </div>
    </nav>
</header>