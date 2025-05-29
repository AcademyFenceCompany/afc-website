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
    </style>


</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3>AMS Home</h3>

        <!-- Orders -->
        <a class="menu-item" data-bs-toggle="collapse" href="#ordersMenu" role="button" aria-expanded="false"
            aria-controls="ordersMenu">
            Orders <i class="bi bi-caret-down-fill"></i>
        </a>
        <div class="collapse submenu" id="ordersMenu">
            <a href="{{ route('ams.orders.create') }}" class="menu-item">Create New Order</a>
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

    <!-- Main Content -->
    <div class="content">
        <div class="header">
            <h2>@yield('title')</h2>
            <div class="header-buttons">
                <a href="{{ route('ams.orders.create') }}" class="btn btn-primary me-2">
                    <i class="bi bi-plus-circle"></i> Create New Order
                </a>
                <a href="{{ route('ams.home') }}" class="btn btn-outline-light">
                    <i class="bi bi-house-fill"></i> Home
                </a>
                <a href="{{ route('logout') }}" class="btn btn-outline-light">
                    <i class="bi bi-box-arrow-right"></i> Log Out
                </a>
            </div>
        </div>

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
    </script>
    <script>
        window.APP_URL = "{{ config('app.url') }}";
        console.log("APP_URL: ", window.APP_URL);
    </script>
    <script src="{{ asset('js/ams.js') }}"></script>
    @yield('scripts')
</body>

</html>
