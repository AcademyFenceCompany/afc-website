<header>
    <!-- Top Bar -->
    <div class="container-fluid bg-black text-light py-2">
        <div class="custom-container d-flex justify-content-between align-items-center flex-wrap">
            <button class="inst-btn btn btn-outline-light btn-sm my-1">
                <i class="bi bi-pencil-square"></i><span class="d-none d-sm-inline"> Request Installation Quote</span>
            </button>
            <div class="my-1">
                <a href={{ url('/customerservice') }} class="text-light">
                    <i class="bi bi-headset"></i><span class="d-none d-sm-inline"> Customer Service</span>
                </a>
            </div>
            <div class="d-flex my-1">
                <div>
                    {{-- @auth
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
                    @endauth --}}
                </div>
                <!-- Navbar Mini Cart -->
                @include('layouts.partials.mini-cart')
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="container-fluid bg-light-custom py-3">
        <div class="custom-container">
            <!-- Logo and Search -->
            <div class="row align-items-center mb-3">
                <div class="col-12 col-md-3 text-center text-md-start mb-3 mb-md-0">
                    <a href={{ url('/') }}>
                        <img src="{{ url('/resources/images/logo.png') }}" alt="Academy Fence Company" class="img-fluid" style="max-height: 80px;">
                    </a>
                    <p class="mb-0 logoline">The Original Fence Superstore</p>
                </div>
                <div class="col-12 col-md-9 mb-3 mb-md-0">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <div class="search-section d-flex me-md-3" style="max-width: 250px;">
                            <input type="text" class="form-control search-input me-2" placeholder="Search...">
                            <button class="btn btn-dark btn-sm">Search</button>
                        </div>
                        <div class="d-flex flex-column flex-md-row align-items-md-center mt-2 mt-md-0">
                            <div class="me-md-3 text-nowrap mb-1 mb-md-0">
                                <i class="bi bi-geo-alt"></i> <span class="fw-bold">Headquarters:</span> 119 N Day Street, Orange, NJ, 07050
                            </div>
                            <div class="text-nowrap">
                                <i class="bi bi-telephone"></i> (973) 674-0600
                            </div>
                        </div>
                        <div class="d-none d-md-block text-md-end">
                            <button class="quote-btn btn btn-danger">GET A QUOTE</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3 text-center text-md-end d-md-none">
                    <button class="quote-btn btn btn-danger">GET A QUOTE</button>
                </div>
            </div>

            <!-- Navigation Menu -->
            <div class="container-fluid">
                <div class="tagline-box text-center my-2">
                    <h3 class="tagline">The Original Fence Superstore</h3>
                </div>
                
                <!-- Mobile Menu Toggle Button -->
                <button class="btn nav-btn d-md-none w-100 mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNavMenu" aria-expanded="false" aria-controls="mobileNavMenu">
                    <i class="bi bi-list"></i> Menu
                </button>
                
                <!-- Desktop Navigation -->
                <nav class="nav mb-3 d-none d-md-flex flex-wrap">
                    <a href='{{ route('woodfence') }}' class="nav-link btn nav-btn">WOOD FENCE</a>
                    <a href="#" class="nav-link btn nav-btn">VINYL FENCE</a>
                    <a href="#" class="nav-link btn nav-btn">CHAIN LINK</a>
                    <a href="#" class="nav-link btn nav-btn">ALUMINUM FENCE</a>
                    <a href='{{ route('weldedwire') }}' class="nav-link btn nav-btn">WELDED WIRE</a>
                    @foreach(\App\Models\CategoryPage::with('category')->where('menu_type', 'main_menu')->orderBy('menu_order')->get() as $page)
                        <a href='{{ route('category.show', ['slug' => $page->slug]) }}' class="nav-link btn nav-btn">{{ strtoupper($page->title ?: $page->category->family_category_name) }}</a>
                    @endforeach
                    <a href='{{ route('contact') }}' class="nav-link btn nav-btn">CONTACT US</a>
                    <div class="dropdown">
                        <a href="#" class="nav-link btn nav-btn dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-list"></i> Quick Menu
                        </a>
                        <ul class="dropdown-menu">
                            @foreach(\App\Models\CategoryPage::with('category')->where('menu_type', 'quick_menu')->orderBy('menu_order')->get() as $page)
                                <li>
                                    <a class="dropdown-item" href="{{ route('category.show', ['slug' => $page->slug]) }}">
                                        {{ $page->title ?: $page->category->family_category_name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </nav>
                
                <!-- Mobile Navigation -->
                <div class="collapse mb-3" id="mobileNavMenu">
                    <div class="d-flex flex-column">
                        <a href='{{ route('woodfence') }}' class="nav-link btn nav-btn mb-2">WOOD FENCE</a>
                        <a href="#" class="nav-link btn nav-btn mb-2">VINYL FENCE</a>
                        <a href="#" class="nav-link btn nav-btn mb-2">CHAIN LINK</a>
                        <a href="#" class="nav-link btn nav-btn mb-2">ALUMINUM FENCE</a>
                        <a href='{{ route('weldedwire') }}' class="nav-link btn nav-btn mb-2">WELDED WIRE</a>
                        @foreach(\App\Models\CategoryPage::with('category')->where('menu_type', 'main_menu')->orderBy('menu_order')->get() as $page)
                            <a href='{{ route('category.show', ['slug' => $page->slug]) }}' class="nav-link btn nav-btn mb-2">{{ strtoupper($page->title ?: $page->category->family_category_name) }}</a>
                        @endforeach
                        <a href='{{ route('contact') }}' class="nav-link btn nav-btn mb-2">CONTACT US</a>
                        
                        <div class="dropdown">
                            <a href="#" class="nav-link btn nav-btn dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="bi bi-list"></i> Quick Menu
                            </a>
                            <ul class="dropdown-menu">
                                @foreach(\App\Models\CategoryPage::with('category')->where('menu_type', 'quick_menu')->orderBy('menu_order')->get() as $page)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('category.show', ['slug' => $page->slug]) }}">
                                            {{ $page->title ?: $page->category->family_category_name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Breadcrumb and NJ Fence Installation Guide -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-2">
                <!-- Breadcrumb -->
                <div class="breadcrumb mb-2 mb-md-0">
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
