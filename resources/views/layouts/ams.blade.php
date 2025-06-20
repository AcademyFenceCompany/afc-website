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
            left: 15px;
            transform: translateY(-50%);
            color: #888;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar d-none">
        <h3>AMS Home</h3>

        <!-- Orders -->
        <a class="menu-item" data-bs-toggle="collapse" href="#ordersMenu" role="button" aria-expanded="false"
            aria-controls="ordersMenu">
            Orders <i class="bi bi-caret-down-fill"></i>
        </a>
        <div class="collapse submenu" id="ordersMenu">
            <a href="{{ route('ams.create-order') }}" class="menu-item">Create New Order</a>
            <a href="{{ route('ams.activity') }}" class="menu-item">Today's Activity</a>
            <a href="#" class="menu-item">Test Account</a>
        </div>

        <!-- Products -->
        <a class="menu-item" data-bs-toggle="collapse" href="#productsMenu" role="button" aria-expanded="false"
            aria-controls="productsMenu">
            Products Management <i class="bi bi-caret-down-fill"></i>
        </a>
        <div class="collapse submenu" id="productsMenu">
            <a href="{{ route('ams.product-query.create') }}" class="menu-item">Add Product</a>
            <a href="{{ route('ams.product-query.index') }}" class="menu-item">View Product</a>
        </div>

        <!-- Categories -->
        <a class="menu-item" data-bs-toggle="collapse" href="#categoriesMenu" role="button" aria-expanded="false"
        aria-controls="categoriesMenu">
        Category Management <i class="bi bi-caret-down-fill"></i>
        </a>
        <div class="collapse submenu" id="categoriesMenu">
            <a href="{{ route('ams.mysql-categories.index') }}" class="menu-item">View Categories</a>
            <a href="{{ route('ams.mysql-categories.create') }}" class="menu-item">Add Category</a>
            <a href="{{ route('ams.mysql-majorcategories.create') }}" class="menu-item">Add Major Category</a>
        </div>
        <!-- Customers -->
        <a class="menu-item" data-bs-toggle="collapse" href="#customersMenu" role="button" aria-expanded="false"
            aria-controls="customersMenu">
            Customers <i class="bi bi-caret-down-fill"></i>
        </a>
        <div class="collapse submenu" id="customersMenu">
            <a href="#" class="menu-item">Add Customer</a>
            <a href="{{ route('customers.index') }}" class="menu-item">View Customers</a>
        </div>

        <!-- Shipping -->
        <a class="menu-item" data-bs-toggle="collapse" href="#shippingMenu" role="button" aria-expanded="false"
            aria-controls="shippingMenu">
            Shipping <i class="bi bi-caret-down-fill"></i>
        </a>
        <div class="collapse submenu" id="shippingMenu">
            <a href="#" class="menu-item">Add Shippers</a>
            <a href="#" class="menu-item">Add Contacts to Shipper</a>
            <a href="#" class="menu-item">View Shippers</a>
            <a href="#" class="menu-item">Delivery Log</a>
            <a href="#" class="menu-item">Freight Shipping Log</a>
            <a href="#" class="menu-item">Small Package Log</a>
            <a href="{{ route('shipping-markup') }}" class="menu-item">Shipping Markup</a>
        </div>

        <!-- Suppliers -->
        <a class="menu-item" data-bs-toggle="collapse" href="#suppliersMenu" role="button" aria-expanded="false"
            aria-controls="suppliersMenu">
            Suppliers <i class="bi bi-caret-down-fill"></i>
        </a>
        <div class="collapse submenu" id="suppliersMenu">
            <a href="#" class="menu-item">Add Supplier</a>
            <a href="#" class="menu-item">Edit Suppliers</a>
            <a href="#" class="menu-item">View Suppliers</a>
            <a href="#" class="menu-item">Cost Comparison</a>
        </div>

        <!-- Additional Menus -->
        @if (auth()->user()->level === 'God')
            <a href="{{ route('user.management') }}"
                class="menu-item {{ request()->routeIs('user.management') ? 'active' : '' }}">
                <i class="fas fa-users-cog"></i>
                <span>User Management</span>
            </a>
        @endif

        <!-- CMS Menu -->
        <a class="menu-item" data-bs-toggle="collapse" href="#cmsMenu" role="button" aria-expanded="false"
            aria-controls="cmsMenu">
            <i class="bi bi-pencil-square"></i>
            <span>CMS</span>
            <i class="bi bi-caret-down-fill"></i>
        </a>
        <div class="collapse submenu" id="cmsMenu">
            <a href="{{ route('ams.cms.pages.index') }}" class="menu-item">
                <i class="bi bi-file-text"></i> Category Pages
            </a>
            <a href="{{ route('ams.cms.pages.create') }}" class="menu-item">
                <i class="bi bi-plus-circle"></i> Add New Page
            </a>
        </div>

        <a href="#" class="menu-item">Inventory</a>
        <a href="#" class="menu-item">Office Sheets</a>
        <a href="#" class="menu-item">Sales Reports</a>
        <a href="{{ route('ams.product-report') }}" class="menu-item">Products Report</a>
        <a href="{{ route('ams.getshippingrate') }}" class="menu-item">Shipping API</a>
        <a href="{{ route('ams.install_upload') }}" class="menu-item">Install Jobs Gallery</a>

    </div>
    <div class="sidebar-container">
        <div class="d-flex flex-column flex-shrink-0 p-3 bg-light sidebar" style="width: 260px;">
            <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none text-dark">
            <i class="fas fa-cubes me-2"></i><span class="fs-5">AMS Home</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto" id="sidebarMenu">
                <!-- Orders -->
                <li>
                    <a href="#ordersMenu2" class="nav-link text-dark d-flex justify-content-between align-items-center submenu-toggle" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="ordersMenu2">
                        <span><i class="bi bi-bag me-2"></i> Orders</span>
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
                    <a href="{{ route('user.management') }}" class="nav-link text-dark">
                        <i class="fas fa-users-cog me-2"></i> User Management
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
        </div>
    </div>
    <!-- Main Content -->
    <div class="content">
        <div class="header d-none">
            <h2>@yield('title')</h2>
            <div class="header-buttons">
                <a href="{{ route('ams.orders.create') }}" class="btn btn-primary me-2">
                    <i class="bi bi-plus-circle"></i> Create New Order
                </a>
                <a href="" class="btn btn-outline-light">
                    <i class="bi bi-house-fill"></i> Home
                </a>
                <a href="{{ route('logout') }}" class="btn btn-outline-light">
                    <i class="bi bi-box-arrow-right"></i> Log Out
                </a>
            </div>
        </div>
        <!-- Navbar fixed-top padding-left 280px -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4">
            <!-- Search Bar -->
            <form class="d-flex align-items-center col-md-6 me-auto" role="search">
                <div class="search-container w-100">
                    <input type="text" class="form-control search-input" placeholder="Search...">
                    <i class="bi bi-search search-icon"></i>
                </div>
            </form>

            <!-- Action Buttons -->
            <div class="d-flex align-items-center me-3">
                <a href="#" class="btn btn-outline-secondary me-2"><i class="fas fa-house me-1"></i> Home</a>
                <a href="#" class="btn btn-success text-light"><i class="fas fa-plus me-1"></i> Create Order</a>
            </div>

            <!-- User Dropdown -->
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://img.freepik.com/premium-vector/male-face-avatar-icon-set-flat-design-social-media-profiles_1281173-3806.jpg?semt=ais_hybrid&w=740" alt="user" width="40" height="40" class="rounded-circle me-2">
                <strong class="mx-2">{{auth()->user()->username}}</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm mt-2" aria-labelledby="userMenu">
                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-list-ul me-2"></i> Activity Log</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
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
