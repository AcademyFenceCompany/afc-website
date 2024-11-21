@section('title', $title)

@section('content')
<main class="container">
    <!-- Page Header -->
    <div class="card">
        <div class="card-header text-center bg-dark text-white py-4">
            <h2>{{ $header }}</h2>
        </div>
        <!-- Contact Information Section -->
    {{-- <div class="text-center mb-4">
        <p>
            <i class="bi bi-envelope"></i> info@academyfence.com &nbsp; | &nbsp; 
            <i class="bi bi-telephone"></i> (973) 674-0600 &nbsp; | &nbsp; 
            <i class="bi bi-geo-alt"></i> 119 N Day Street, Orange, NJ
        </p>
    </div> --}}

    <!-- Navigation Tabs -->
    <div class="text-center mt-4 mb-4">
        <button class="btn btn-outline-dark mx-1">GET A QUOTE</button>
        <button onclick="window.location.href='{{ route('brochures') }}'"  class="btn {{ Route::is('brochures') ? 'btn-warning' : 'btn-outline-dark' }} mx-1">BROCHURES</button>
        <button onclick="window.location.href='{{ route('policy') }}'" 
        class="btn {{ Route::is('policy') ? 'btn-warning' : 'btn-outline-dark' }} mx-1">POLICIES </button>
        <button class="btn btn-outline-dark mx-1">CONTACT US</button>
        <button onclick="window.location.href='{{ route('about') }}'" 
        class="btn {{ Route::is('about') ? 'btn-warning' : 'btn-outline-dark' }} mx-1">ABOUT US</button> 
        <button class="btn btn-outline-dark mx-1">FENCE INSTALL</button>
    </div>