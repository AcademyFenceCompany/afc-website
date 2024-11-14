<header>
    @include('layouts.ticker') 
    <!-- Top Bar: Full Width, Black Background -->
    <div class="container-fluid bg-black text-light py-2">
        <div class="container d-flex justify-content-between align-items-center">
            <button class="inst-btn btn btn-outline-light"><i class="bi bi-pencil-square"></i>Request Installation Quote</button>
            <div>
                <a href="#" class="text-light"><i class="bi bi-person-circle"></i>Login</a>
                <a href="#" class="text-light ms-3"><i class="bi bi-cart"></i>Cart</a>
            </div>
        </div>
    </div>

    <!-- Main Header Container: Full Width, Light Background -->
    <div class="container-fluid bg-light-custom py-3">
        <div class="container">
            <!-- Second Bar: Logo, Search, Address, Phone, Get a Quote Button -->
            <div class="d-flex justify-content-center align-items-center mb-3">
                <div class="d-flex align-items-center">
                    <a href={{url('/')}}> <img src="{{ url('/resources/images/logo.png') }}" alt="Academy Fence Company" class="me-3"> </a> 
                </div>
                <div class="d-flex align-items-center justify-content-center flex-grow-1">
                    <div class="search-section d-flex">
                        <input type="text" class="form-control search-input me-2" placeholder="Search for...">
                        <button class="btn btn-dark">Search</button>
                    </div>
                    <div class="d-none d-md-flex align-items-center ms-4">
                        <span class="me-2"><i class="bi bi-geo-alt"></i> 119 N Day Street, Orange, NJ</span>
                        <span><i class="bi bi-telephone"></i> (973) 674-0600</span>
                    </div>
                </div>
                <button class="quote-btn btn btn-danger ms-3">GET A QUOTE</button>
            </div>

            <!-- Third Bar: Tagline and Navigation Menu -->
            <div class="tagline-box text-center my-2">
                <h3 class="tagline">The Original Fence Superstore</h3>
            </div>
            <nav class="nav justify-content-center mb-3">
                <a href="#" class="nav-link btn nav-btn">WOOD FENCE</a>
                <a href="#" class="nav-link btn nav-btn">VINYL FENCE</a>
                <a href="#" class="nav-link btn nav-btn">CHAIN LINK</a>
                <a href="#" class="nav-link btn nav-btn">ALUMINUM FENCE</a>
                <a href="#" class="nav-link btn nav-btn">WELDED WIRE</a>
                <div class="dropdown">
                    <a href="#" class="nav-link btn nav-btn dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-list"></i> Menu
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Option 1</a></li>
                        <li><a class="dropdown-item" href="#">Option 2</a></li>
                        <li><a class="dropdown-item" href="#">Option 3</a></li>
                    </ul>
                </div>
            </nav>
            <!-- Fourth Bar: Breadcrumb and NJ Fence Installation Guide -->
            <div class="d-flex justify-content-between align-items-center mt-2">
                <!-- breadcrumbs component -->
                <x-breadcrumbs />
                <div class="dropdown">
                    <a href="#" class="quote-btn btn btn-danger dropdown-toggle" data-bs-toggle="dropdown">
                         NJ Fence INSTALLATION Guide
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Option 1</a></li>
                        <li><a class="dropdown-item" href="#">Option 2</a></li>
                        <li><a class="dropdown-item" href="#">Option 3</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
