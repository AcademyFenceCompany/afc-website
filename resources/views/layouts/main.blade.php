<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF Token -->
    <!-- Favicon -->
    <link rel="icon" href="{{ url('/resources/images/favicon.ico') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <title>{{ $title ?? 'Academy Fence Company' }}</title>
    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/js/app.js'])
</head>

<body style="font-family: 'Inter', sans-serif;">
    <!-- Header Section -->
    @include('layouts.header')

    {{-- <!-- Optional Page Header -->
    @isset($header)
        <header class="bg-white shadow-sm">
            <div class="container py-3">
                {{ $header }}
            </div>
        </header>
    @endisset --}}

    <!-- Main Content Section -->
    <main class="custom-container my-2">
        {{ $slot ?? '' }}
        @yield('content')

    </main>
    @yield('scripts')

    <!-- Footer Section -->
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                const scrollingInfo = document.getElementById("scrolling-info");
                if (scrollingInfo) scrollingInfo.style.display = "none";
            }, 60000); // 60 seconds
        });
    </script>
    {{-- <script src="{{ asset('js/cart.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/cart-item.js') }}"></script> --}}

</body>

</html>
