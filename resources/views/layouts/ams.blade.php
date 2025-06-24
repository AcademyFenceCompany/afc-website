<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AMS - @yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css') }}" >

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ams.css') }}">
    @yield('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/style.css')}}" >
    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/fqzaaogo06nq3byhp6e1ia5t3r29nvwitty5q04x54v9dgak/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <style>
        @media print {
            .table {
            border-collapse: collapse;
            font-size: 12px;
            }
            table, th, td {
            border: 1px solid black;
            }
            th, td {
                text-align: center;
                vertical-align: middle;
            }
            p {
                font-weight: bold;
                margin-left:20px;
            }
            .table {
                width: 94%;
                margin-left: 3%;
                margin-right: 3%;
            }
            div.bs-table-print {
            text-align: center;
            }
            .d-print-none{
                display:none;
            }
            #product-report-form-filter{
                display:none;
            }
        }
        .content {
            padding:0rem;
            background-color:rgb(255, 255, 255);
        }
        .submenu {
        transition: all 0.3s ease;
        display: none;
        }

        .submenu.show {
        display: block;
        }

        .submenu-toggle:hover {
        background-color: #e9ecef;
        cursor: pointer;
        }

        .rotate-icon {
        transition: transform 0.3s ease;
        }

        .rotate-icon.rotated {
        transform: rotate(180deg);
        }
        .sidebar-container{
            border-right: 1px solid #bebebe;
        }
        .sidebar {
            background-color: #e1d6d2 !important;
            color: #fff;
        }
        .navbar {
            height: 70px;
            border-bottom: 1px solid #bebebe;
            }

            .input-group input:focus {
            box-shadow: none;
            border-color: #86b7fe;
            }

            .dropdown-menu .dropdown-item:hover {
            background-color: #f8f9fa;
            }

        .search-icon {
            position: absolute;
            top: 50%;
            left: 20px;
            transform: translateY(-50%);
            color: #888;
        }
        .search-input{
            padding: auto auto;
        }
        .form-select{
            border: 2px solid #ced4da;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar-container">
        <div class="d-flex flex-column flex-shrink-0 p-3 bg-light sidebar" style="width: 260px;">
            <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none text-dark">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Academy fence Logo" width="" height="32" class="me-2 rounded" style="object-fit:;">
                <span class="fs-5 fw-bold">AMS Home</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto" id="sidebarMenu">
                <!-- Orders -->
                @php
                    // Example: get the count of new orders (replace with your actual logic)
                    $newOrdersCount = session('new_orders_count', 1); // Or fetch from DB
                @endphp
                <li>
                    <a href="#ordersMenu2" class="nav-link text-dark d-flex justify-content-between align-items-center submenu-toggle" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="ordersMenu2">
                        <span>
                            <i class="bi bi-bag me-2"></i> Orders
                            @if($newOrdersCount > 0)
                                <span class="badge bg-danger ms-2">{{ $newOrdersCount }}</span>
                            @endif
                        </span>
                        <i class="bi bi-chevron-down small rotate-icon"></i>
                    </a>
                    <ul class="nav flex-column ms-4 submenu collapse" id="ordersMenu2">
                        <li><a href="{{ route('ams.create-order') }}" class="nav-link text-muted small">Create New Order</a></li>
                        <li><a href="{{ route('ams.activity') }}" class="nav-link text-muted small">Today's Activity</a></li>
                        <li><a href="#" class="nav-link text-muted small">Test Account</a></li>
                    </ul>
                </li>

                <!-- Products Management -->
                <li>
                    <a href="#productsMenu2" class="nav-link text-dark d-flex justify-content-between align-items-center submenu-toggle" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="productsMenu2">
                        <span><i class="bi bi-box-seam me-2"></i> Products Management</span>
                        <i class="bi bi-chevron-down small rotate-icon"></i>
                    </a>
                    <ul class="nav flex-column ms-4 submenu collapse" id="productsMenu2">
                        <li><a href="{{ route('ams.product-query.create') }}" class="nav-link text-muted small">Add Product</a></li>
                        <li><a href="{{ route('ams.product-query.index') }}" class="nav-link text-muted small">View Product</a></li>
                    </ul>
                </li>

                <!-- Category Management -->
                <li>
                    <a href="#categoriesMenu2" class="nav-link text-dark d-flex justify-content-between align-items-center submenu-toggle" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="categoriesMenu2">
                        <span><i class="bi bi-tags me-2"></i> Category Management</span>
                        <i class="bi bi-chevron-down small rotate-icon"></i>
                    </a>
                    <ul class="nav flex-column ms-4 submenu collapse" id="categoriesMenu2">
                        <li><a href="{{ route('ams.mysql-categories.index') }}" class="nav-link text-muted small">View Categories</a></li>
                        <li><a href="{{ route('ams.mysql-categories.create') }}" class="nav-link text-muted small">Add Category</a></li>
                        <li><a href="{{ route('ams.mysql-majorcategories.create') }}" class="nav-link text-muted small">Add Major Category</a></li>
                    </ul>
                </li>

                <!-- Customers -->
                <li>
                    <a href="#customersMenu2" class="nav-link text-dark d-flex justify-content-between align-items-center submenu-toggle" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="customersMenu2">
                        <span><i class="bi bi-people me-2"></i> Customers</span>
                        <i class="bi bi-chevron-down small rotate-icon"></i>
                    </a>
                    <ul class="nav flex-column ms-4 submenu collapse" id="customersMenu2">
                        <li><a href="#" class="nav-link text-muted small">Add Customer</a></li>
                        <li><a href="{{ route('customers.index') }}" class="nav-link text-muted small">View Customers</a></li>
                    </ul>
                </li>

                <!-- Shipping -->
                <li>
                    <a href="#shippingMenu2" class="nav-link text-dark d-flex justify-content-between align-items-center submenu-toggle" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="shippingMenu2">
                        <span><i class="bi bi-truck me-2"></i> Shipping</span>
                        <i class="bi bi-chevron-down small rotate-icon"></i>
                    </a>
                    <ul class="nav flex-column ms-4 submenu collapse" id="shippingMenu2">
                        <li><a href="#" class="nav-link text-muted small">Add Shippers</a></li>
                        <li><a href="#" class="nav-link text-muted small">Add Contacts to Shipper</a></li>
                        <li><a href="#" class="nav-link text-muted small">View Shippers</a></li>
                        <li><a href="#" class="nav-link text-muted small">Delivery Log</a></li>
                        <li><a href="#" class="nav-link text-muted small">Freight Shipping Log</a></li>
                        <li><a href="#" class="nav-link text-muted small">Small Package Log</a></li>
                        <li><a href="{{ route('shipping-markup') }}" class="nav-link text-muted small">Shipping Markup</a></li>
                    </ul>
                </li>

                <!-- Suppliers -->
                <li>
                    <a href="#suppliersMenu2" class="nav-link text-dark d-flex justify-content-between align-items-center submenu-toggle" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="suppliersMenu2">
                        <span><i class="bi bi-building me-2"></i> Suppliers</span>
                        <i class="bi bi-chevron-down small rotate-icon"></i>
                    </a>
                    <ul class="nav flex-column ms-4 submenu collapse" id="suppliersMenu2">
                        <li><a href="#" class="nav-link text-muted small">Add Supplier</a></li>
                        <li><a href="#" class="nav-link text-muted small">Edit Suppliers</a></li>
                        <li><a href="#" class="nav-link text-muted small">View Suppliers</a></li>
                        <li><a href="#" class="nav-link text-muted small">Cost Comparison</a></li>
                    </ul>
                </li>

                <!-- User Management (God only) -->
                @if (auth()->user()->level === 'God')
                <li>
                    <a href="{{ route('user.management') }}"  class="nav-link text-dark d-flex justify-content-between align-items-center submenu-toggle" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="cmsMenu2">
                        <span><i class="bi bi-person-exclamation me-2"></i> User Management </span>
                    </a>
                </li>
                @endif

                <!-- CMS -->
                <li>
                    <a href="#cmsMenu2" class="nav-link text-dark d-flex justify-content-between align-items-center submenu-toggle" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="cmsMenu2">
                        <span><i class="bi bi-pencil-square me-2"></i> CMS</span>
                        <i class="bi bi-chevron-down small rotate-icon"></i>
                    </a>
                    <ul class="nav flex-column ms-4 submenu collapse" id="cmsMenu2">
                        <li><a href="{{ route('ams.cms.pages.index') }}" class="nav-link text-muted small"><i class="bi bi-file-text"></i> Category Pages</a></li>
                        <li><a href="{{ route('ams.cms.pages.create') }}" class="nav-link text-muted small"><i class="bi bi-plus-circle"></i> Add New Page</a></li>
                    </ul>
                </li>

                <!-- Inventory -->
                <li>
                    <a href="#" class="nav-link text-dark"><i class="bi bi-archive me-2"></i> Inventory</a>
                </li>

                <!-- Office Sheets -->
                <li>
                    <a href="#" class="nav-link text-dark"><i class="bi bi-file-earmark-spreadsheet me-2"></i> Office Sheets</a>
                </li>

                <!-- Sales Reports -->
                <li>
                    <a href="#" class="nav-link text-dark"><i class="bi bi-bar-chart me-2"></i> Sales Reports</a>
                </li>

                <!-- Products Report -->
                <li>
                    <a href="{{ route('ams.product-report') }}" class="nav-link text-dark"><i class="bi bi-clipboard-data me-2"></i> Products Report</a>
                </li>

                <!-- Shipping API -->
                <li>
                    <a href="{{ route('ams.getshippingrate') }}" class="nav-link text-dark"><i class="bi bi-cloud-arrow-up me-2"></i> Shipping API</a>
                </li>

                <!-- Install Jobs -->
                <li>
                    <a href="{{ route('ams.install_upload') }}" class="nav-link text-dark"><i class="bi bi-images me-2"></i> Install Jobs</a>
                </li>
            </ul>
            <hr>
            <footer class="text-center mt-4">
                <small class="text-muted d-block">
                    &copy; {{ date('Y') }} Academy Fence Company. All rights reserved.
                </small>
                <small class="text-muted d-none">
                    <i class="bi bi-bootstrap-fill"></i> Powered by AMS
                </small>
            </footer>
        </div>
    </div>
    <!-- Main Content -->
    <div class="content">
        <!-- Navbar fixed-top padding-left 280px -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-lg-top px-4">
            <!-- Search Bar -->
            <form method="post" action="{{ route('ams.global-search') }}" class="d-flex align-items-center col-md-6 me-auto position-relative" role="search">
                <div class="search-container w-100">
                    <input type="text" class="form-control global-search px-5 py-2" name="global-search" placeholder="Search name, email, phone, company, product, item no, order ID, order name..." aria-label="Search" id="global-search-input">
                    <i class="bi bi-search search-icon"></i>
                    <!-- Dropdown menu for search results -->
                    <ul class="dropdown-menu w-100 shadow" id="global-search" style="position: absolute; top: 100%; left: 0; z-index: 1000;">
                        <!-- Products -->
                        <li>
                            <h6 class="dropdown-header text-secondary">Products</h6>
                        </li>
                        <li><a class="dropdown-item" href="#">Product Result 1</a></li>
                        <li><a class="dropdown-item" href="#">Product Result 2</a></li>
                        <!-- Customers -->
                        <li>
                            <h6 class="dropdown-header text-success">Customers</h6>
                        </li>
                        <li><a class="dropdown-item" href="#">Customer Result 1</a></li>
                        <li><a class="dropdown-item" href="#">Customer Result 2</a></li>
                        <!-- Orders -->
                        <li>
                            <h6 class="dropdown-header text-primary">Orders</h6>
                        </li>
                        <li><a class="dropdown-item" href="#">Order Result 1</a></li>
                        <li><a class="dropdown-item" href="#">Order Result 2</a></li>
                    </ul>
                </div>
            </form>

            <!-- Action Buttons -->
            <div class="d-flex align-items-center me-3">
                <a href="#" class="btn btn-outline-secondary me-2"><i class="bi bi-house me-1"></i> Home</a>
                <a href="{{ route('ams.storefront')}}" class="btn btn-danger text-dark mx-2"><i class="bi bi-cart me-1"></i> Store</a>
                <a href="{{ route('ams.create-order')}}" class="btn btn-success text-light position-relative">
                    <i class="bi bi-plus me-1"></i> Create Order
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notify cart-count {{ (session('cart2') && session('cart2.quantity') > 0) ? 'show' : '' }}">
                        {{ session('cart2.quantity', 0) }}
                    </span>
                </a>
            </div>

            <!-- User Dropdown -->
            <div class="dropdown" style="top:0; left:0;">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://img.freepik.com/premium-vector/male-face-avatar-icon-set-flat-design-social-media-profiles_1281173-3806.jpg?semt=ais_hybrid&w=740" alt="user" width="40" height="40" class="rounded-circle me-2">
                <strong class="mx-2">{{auth()->user()->username}}</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm mt-2" aria-labelledby="userMenu">
                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-list-ul me-2"></i> Activity Log</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                </ul>
            </div>
        </nav>
        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mt-3">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set up CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        const APP_URL = "{{ config('app.url') }}";
    </script>

    <script>
        // Global TinyMCE initialization
        document.addEventListener('DOMContentLoaded', function() {
            tinymce.init({
                selector: 'textarea.tinymce',
                height: 300,
                menubar: true,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
                images_upload_url: '/ams/upload-image',
                automatic_uploads: true,
                images_reuse_filename: true,
                relative_urls: false,
                remove_script_host: false,
                convert_urls: true,
                setup: function (editor) {
                    editor.on('change', function () {
                        editor.save();
                    });
                }
            });
        });
            $(document).ready(function() {
                $('.submenu-toggle').on('click', function() {
                    var $submenu = $(this).next('.submenu');
                    var $icon = $(this).find('.rotate-icon');
                    var $currentlyOpen = $('.submenu.show');

                    // Close any other open submenu
                    if ($currentlyOpen.length && !$submenu.is($currentlyOpen)) {
                        $currentlyOpen.removeClass('show');
                        $('.rotate-icon').removeClass('rotated');
                    }

                    // Toggle clicked submenu
                    $submenu.toggleClass('show');
                    $icon.toggleClass('rotated');
                });
            });
    </script>
    <script>
        window.APP_URL = "{{ config('app.url') }}";
        console.log("APP_URL: ", window.APP_URL);
    </script>
    <script src="{{ asset('js/ams.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @yield('scripts')
</body>

</html>
