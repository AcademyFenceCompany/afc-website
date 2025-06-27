@extends('layouts.main2')

@section('content')
    
    @include('partials.header')
    <x-cart-sidebar :cart="$cart"/>
    <div class="container">
      <div class="row d-none">
        <div class="col-md-12">
            @if(session('success'))
            <h1 class="text-center my-3 text-success">Thank You!</h1>
            <h1 class="text-center my-3 text-success">{{ session('success') }}</h1>
            <p class="text-center">Your order has been successfully placed. We will contact you shortly with the details.</p>
            @endif
            @if(session('error'))
            <h1 class="text-center my-3 text-danger">{{ session('error') }}</h1>
            <p class="text-center">There was an issue with your order. Please try again or contact support.</p>
            
            @endif
        </div>
      </div>
      <div class="row py-5 justify-content-center">
        <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
            <h1 class="my-3 text-success display-4">Thank You for Your Order!</h1>
            <p class="lead mb-4">
            We appreciate your business. Your order has been received and is being processed.<br>
            You will receive an email with your tracking number once your order has been shipped.
            <br>
            <hr class="my-4">
            Feel assured that we will do our utmost to have your order ready for you as soon as possible. We've been proudly supplying happy customers since the 1960s, and your satisfaction is our top priority.
            </p>
            <hr>
            <div class="alert alert-info mt-4" role="alert">
            <strong>Pickup Information:</strong><br>
            Please pick up your order during our business hours:<br>
            <b>Monday to Friday, 7:30 AM – 4:30 PM</b>.<br>
            If you have any questions or need to arrange a different pickup time, please contact our support team.
            </div>
            <p class="mt-4">
            Thank you for choosing us! We look forward to serving you again.
            </p>
            </div>
        </div>
        </div>
      </div>
    </div>
    
@endsection