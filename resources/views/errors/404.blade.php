@extends('layouts.main')

@section('title', '404 Not Found')

@section('content')
<div class="container my-5 text-center">
    <div class="error-code" style="font-size: 8rem; font-weight: bold;">404</div>
    <div class="error-message" style="font-size: 1.5rem; margin-bottom: 1rem;">
        Oops, the page you're looking for isn't here
    </div>
    <a href="{{ url('/') }}" class="btn btn-danger">Go to Home page</a>
</div>
@endsection