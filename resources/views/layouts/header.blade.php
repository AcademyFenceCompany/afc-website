<header>
    @include('layouts.ticker')

    <!-- Top Bar -->
    <div class="container-fluid bg-black text-light py-2">
        <div class="custom-container d-flex justify-content-between align-items-center">
            <button class="inst-btn btn btn-outline-light">
                <i class="bi bi-pencil-square"></i>Request Installation Quote
            </button>
            <div>
                <a href={{ url('/customerservice') }} class="text-light">
                    <i class="bi bi-headset"></i>Customer Service
                </a>
            </div>
            <div>
                @auth
                    <a href="#" class="text-light dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                Profile
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                @else
                    <a href={{ url('/login') }} class="text-light">
                        <i class="bi bi-person-circle"></i>Login
                    </a>
                @endauth
                <a href="#" class="text-light ms-3"><i class="bi bi-cart"></i>Cart</a>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="container-fluid bg-light-custom py-3">
        <div class="custom-container">
            <!-- Logo and Search -->
            <div class="d-flex justify-content-center align-items-center mb-3">
                <div class="d-flex align-items-center">
                    <a href={{ url('/') }}>
                        <img src="{{ url('/resources/images/logo.png') }}" alt="Academy Fence Company" class="me-3">
                    </a>
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

            <!-- Navigation Menu -->
            <div class="container-fluid">
                <div class="tagline-box text-center my-2">
                    <h3 class="tagline">The Original Fence Superstore</h3>
                </div>
                <nav class="nav mb-3">
                    <a href="#" class="nav-link btn nav-btn">WOOD FENCE</a>
                    <a href="#" class="nav-link btn nav-btn">VINYL FENCE</a>
                    <a href="#" class="nav-link btn nav-btn">CHAIN LINK</a>
                    <a href="#" class="nav-link btn nav-btn">ALUMINUM FENCE</a>
                    <a href="#" class="nav-link btn nav-btn">WELDED WIRE</a>
                    <a href="#" class="nav-link btn nav-btn">CONTACT US</a>
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
            </div>
            <!-- Breadcrumb and NJ Fence Installation Guide -->
            <div class="d-flex justify-content-between align-items-center mt-2">
                <!-- Breadcrumb -->
                <div class="breadcrumb">
                    <x-breadcrumbs />
                </div>
                <div class="dropdown njfig-btn">
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
