<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AMS - @yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/ams.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ams__products.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shippers.css') }}">
    <link rel="stylesheet" href="{{ asset('css/inventory.css') }}">
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
            <a href="{{ route('ams.activity') }}" class="menu-item">Today's Activity</a>
            <a href="#" class="menu-item">Test Account</a>
        </div>

        <!-- Products -->
        <a class="menu-item" data-bs-toggle="collapse" href="#productsMenu" role="button" aria-expanded="false"
            aria-controls="productsMenu">
            Products <i class="bi bi-caret-down-fill"></i>
        </a>
        <div class="collapse submenu" id="productsMenu">
            <a href="{{ route('ams.products.add') }}" class="menu-item">Add Product</a>
            <a href="{{ route('products.index') }}" class="menu-item">View Products</a>
            <a href="{{ route('categories.display') }}" class="menu-item">Category Management</a>
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
            <a href="{{ route('shippers.view', ['page' => 'add_shippers']) }}" class="menu-item" class="menu-item">Add
                Shippers</a>
            <a href="{{ route('shippers.view', ['page' => 'add_shippers_contacts']) }}" class="menu-item">Add Contacts
                to Shipper</a>
            <a href="{{ route('shippers.view', ['page' => 'index_shippers']) }}" class="menu-item">View Shippers</a>
            <a href="{{ route('shippers.view', ['page' => 'delivery_status']) }}" class="menu-item">Delivery Status</a>
            <a href="{{ route('shippers.view', ['page' => 'shipping_markup']) }}" class="menu-item">Shipping Markup</a>
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

        <!-- Inventory -->
        <a href="{{ route('inventory', ['page' => 'inventory_index']) }}" class="menu-item">Inventory</a>


        <!-- Office Sheets -->
        <a class="menu-item" data-bs-toggle="collapse" href="#officeSheets" role="button" aria-expanded="false"
            aria-controls="suppliersMenu">
            Office Sheets<i class="bi bi-caret-down-fill">
            </i>
        </a>
        <div class="collapse submenu" id="officeSheets">
            <a href="resources/office_sheets/Time_Sheet-template.pdf" target="_blank" class="menu-item">Time Sheet
                Template</a>
            <a href="resources/office_sheets/Freight_Log.xls" target="_blank" class="menu-item">Freight Log</a>
            <a href="resources/office_sheets/Proposal.pdf" target="_blank" class="menu-item">Proposal</a>
            <a href="resources/office_sheets/Proposal_Cl.pdf" target="_blank" class="menu-item">Proposal Cl</a>
            <a href="resources/office_sheets/Proposal_Non_Cl.pdf" target="_blank" class="menu-item">Proposal Cl
                w/email</a>
            <a href="resources/office_sheets/chainlinkassemblydiagram.pdf" target="_blank" class="menu-item">Chain Link
                Assembly Diagram</a>
            <a href="resources/office_sheets/work_order-updated_07-19-2019.pdf" target="_blank" class="menu-item">Work
                Order</a>
            <a href="resources/office_sheets/lead-current.pdf" target="_blank" class="menu-item">Lead Sheet</a>
            <a href="resources/office_sheets/yard-sale.pdf" target="_blank" class="menu-item">Blank Yard Sale</a>
            <a href="resources/office_sheets/Yard Sale Chain Link Sales Sheet.pdf" target="_blank"
                class="menu-item">Yard Sale</a>
            <a href="resources/office_sheets/woodfencinggeneralorderform.pdf" target="_blank" class="menu-item">Wood
                Fencing Order Sheet</a>
            <a href="resources/office_sheets/customerquotefaxsheet.pdf" target="_blank" class="menu-item">Quote
                Sheet</a>
            <a href="resources/office_sheets/Procalls sheet.pdf" target="_blank" class="menu-item">Pro Call Sheet</a>
            <a href="resources/office_sheets/woodfencinggeneralorderform.pdf" target="_blank" class="menu-item">Fencing
                Order Sheet</a>
            <a href="resources/office_sheets/returnsheet.pdf" target="_blank" class="menu-item">Return Sheet</a>
        </div>

        <a href="#" class="menu-item">Sales Reports</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Header Section -->
        <div class="header">
            <h2>Academy Fence Management System</h2>
            <div class="header-buttons">
                <p class="text-center">Welcome {{ auth()->user()->username }}</p>
                <a href="{{ route('customers.index') }}" class="btn btn-primary">New Order</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Log Out</button>
                </form>
            </div>
        </div>
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/user-management.js') }}"></script>
    <script src="{{ asset('js/ams.js') }}"></script>

</body>

</html>