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
            <div class="d-flex">
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
                </div>
                {{-- <div>
                    <a href="{{ url('/cart') }}"
                        class="d-flex align-items-center text-decoration-none text-light ms-3">
                        <i class="bi bi-cart fs-5"></i>
                        <span id="cart-count" class="badge rounded-pill bg-danger ms-2">
                            {{ session('cart') ? count(session('cart')) : 0 }}
                        </span>
                    </a>
                </div> --}}
                <!-- Navbar Mini Cart -->
                <div class="dropdown" style="margin-left: 10px;">
                    <a href="#" class="nav-link position-relative text-light" id="cartDropdown"
                        data-bs-toggle="dropdown">
                        <i class="bi bi-cart fs-4"></i>
                        <span id="cart-count"
                            class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill">
                            {{ session('cart') ? count(session('cart')) : 0 }}
                        </span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end p-3 shadow-lg" style="min-width: 300px;">
                        <h6 class="dropdown-header">Your Cart</h6>
                        <ul id="mini-cart-items" class="list-unstyled mb-2">
                            @foreach (session('cart', []) as $item)
                                <li class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-0">{{ $item['product_name'] }}</h6>
                                        <small class="text-muted">Qty: {{ $item['quantity'] }}</small>
                                    </div>
                                    <span class="fw-bold">${{ number_format($item['total'], 2) }}</span>
                                </li>
                                <hr>
                            @endforeach
                        </ul>

                        <p id="empty-cart-message"
                            class="{{ count(session('cart', [])) > 0 ? 'd-none' : '' }} text-center">Your cart is empty
                        </p>
                        <a href="{{ route('cart.view') }}" class="btn btn-danger w-100">View Cart</a>
                    </div>

                </div>
                {{-- <a href="{{ url('/cart') }}" class="text-light ms-3"><i class="bi bi-cart"></i>Cart</a> --}}
                {{-- <a href="{{ url('/cart') }}" class="text-light ms-3">{{ session('cart') ? count(session('cart')) : 0 }}
                    <i class="bi bi-cart"></i></a> <span id="cart-count" class="badge bg-danger"></span> --}}


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
                    <a href='{{ route('weldedwire') }}' class="nav-link btn nav-btn">WELDED WIRE</a>
                    <a href='{{ route('contact') }}' class="nav-link btn nav-btn">CONTACT US</a>
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
<script>
    // Function to Update Mini Cart
    function updateMiniCart(cart) {
        const miniCartItems = document.getElementById("mini-cart-items");
        const emptyCartMessage = document.getElementById("empty-cart-message");

        // Clear existing mini cart content
        miniCartItems.innerHTML = "";

        if (Object.keys(cart).length > 0) {
            emptyCartMessage.classList.add("d-none");

            // Populate the mini cart
            for (const key in cart) {
                const item = cart[key];
                miniCartItems.innerHTML += `
                <li class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h6 class="mb-0">${item.product_name}</h6>
                        <small class="text-muted">Qty: ${item.quantity}</small>
                    </div>
                    <span class="fw-bold">$${parseFloat(item.total).toFixed(2)}</span>
                </li>`;
            }
        } else {
            emptyCartMessage.classList.remove("d-none");
        }
    }


    // Handle Add to Cart
    document.querySelectorAll(".add-to-cart-btn").forEach((button) => {
        button.addEventListener("click", function() {
            const itemData = {
                item_no: this.getAttribute("data-item"),
                product_name: this.getAttribute("data-name"),
                price: this.getAttribute("data-price"),
                color: this.getAttribute("data-color"),
                size: this.getAttribute("data-size"),
                mesh: this.getAttribute("data-mesh"),
                quantity: this.closest("tr").querySelector(".quantity-input").value,
            };

            fetch("{{ route('cart.add') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    body: JSON.stringify(itemData),
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        updateMiniCart(data.cart); // Update mini cart with new items
                        const cartCountElement = document.getElementById("cart-count");
                        cartCountElement.textContent = data.cartCount; // Update cart count
                        showToast("Item added to cart", "bg-success");
                    }
                })
                .catch((error) => console.error("Error adding item:", error));
        });
    });
</script>
