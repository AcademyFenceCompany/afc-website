<!-- resources/views/layouts/header.blade.php -->
<header class="header bg-dark text-light py-3">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="{{ asset('path/to/logo.png') }}" alt="Academy Fence Logo" class="me-3">
                <button class="btn btn-outline-light me-3">Request Installation Quote</button>
            </div>
            <div class="d-flex flex-grow-1 justify-content-center align-items-center">
                <input type="text" class="form-control search-input me-2" placeholder="Search for...">
                <button class="btn btn-dark">Search</button>
                <div class="d-none d-md-flex align-items-center ms-4">
                    <span class="me-2"><i class="bi bi-geo-alt"></i> 119 N Day Street, Orange, NJ</span>
                    <span><i class="bi bi-telephone"></i> (973) 674-0600</span>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <button class="btn btn-danger ms-3">GET A QUOTE</button>
                <div class="ms-3">
                    <a href="#" class="text-light">Log in</a>
                    <a href="#" class="text-light ms-2"><i class="bi bi-cart"></i></a>
                </div>
            </div>
        </div>
        <nav class="nav mt-3 justify-content-center">
            <a href="#" class="nav-link btn btn-warning">WOOD FENCE</a>
            <a href="#" class="nav-link btn btn-warning">VINYL FENCE</a>
            <a href="#" class="nav-link btn btn-warning">CHAIN LINK</a>
            <a href="#" class="nav-link btn btn-warning">ALUMINUM FENCE</a>
            <a href="#" class="nav-link btn btn-warning">WELDED WIRE</a>
            <div class="dropdown">
                <a href="#" class="nav-link text-dark btn btn-warning dropdown-toggle" data-bs-toggle="dropdown">Menu</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Option 1</a></li>
                    <li><a class="dropdown-item" href="#">Option 2</a></li>
                    <li><a class="dropdown-item" href="#">Option 3</a></li>
                </ul>
            </div>
            <a href="#" class="btn btn-danger ms-2">NJ Fence INSTALLATION Guide</a>
        </nav>
    </div>
</header>
