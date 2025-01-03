<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMS - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/ams.css') }}">
    <style>
        body {
            display: flex;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #C1BFD8;
        }

        .sidebar {
            width: 250px;
            background-color: #4E4C67;
            color: white;
            display: flex;
            flex-direction: column;
            padding: 1rem;
        }

        .sidebar h3 {
            text-align: center;
            margin-bottom: 2rem;
            font-size: 1.25rem;
        }

        .menu-item {
            padding: 10px;
            margin-bottom: 10px;
            background-color: #6C6B88;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .menu-item:hover {
            background-color: #5A5975;
        }

        .content {
            flex: 1;
            padding: 1rem;
            background-color: #F5F5F5;
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #8E8BA8;
            color: white;
            padding: 1rem;
            border-radius: 5px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .table th,
        .table td {
            border: 1px solid #DDD;
            padding: 10px;
            text-align: left;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3>AMS Home</h3>
        <a href="{{ route('ams.activity') }}" class="menu-item">Activity</a>
        <a href="#" class="menu-item">Orders</a>
        <a href="#" class="menu-item">Products</a>
        <a href="#" class="menu-item">Customers</a>
        <a href="#" class="menu-item">Shipping</a>
        <a href="#" class="menu-item">Suppliers</a>
        <a href="#" class="menu-item">User Management</a>
        <a href="#" class="menu-item">Inventory</a>
        <a href="#" class="menu-item">Office Sheets</a>
        <a href="#" class="menu-item">Sales Reports</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        @yield('content')
    </div>
</body>

</html>
