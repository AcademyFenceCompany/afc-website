@extends('layouts.main')

@section('title', 'Shopping Cart')

@section('content')
    <main class="container text-center my-5">
        <!-- Page Header -->
        <div class="">
            <div>
                <h2>My Shopping Cart</h2>
            </div>
            <div class="card-body">
                <p class="text-danger fw-bold">Because of current conditions, prices are subject to change without prior
                    notice.</p>
            </div>
        </div>

        <!-- Empty Cart Message -->
        <div class="my-2">
            <h4 class="text-muted mb-3 text-danger">Your cart is empty</h4>
            <a href="/" class="btn btn-danger text-white" style="background-color: var(--secondary-color);">
                Keep shopping
            </a>
        </div>
    </main>
@endsection
