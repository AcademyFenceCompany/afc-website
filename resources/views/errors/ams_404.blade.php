@extends('layouts.ams')

@section('title', 'Activity')

@section('content')

<div class="container my-5 text-center">
    <div class="error-code" style="font-size: 8rem; font-weight: bold;">404</div>
    <div class="error-message" style="font-size: 1.5rem; margin-bottom: 1rem;">
        Oops, the page you're looking for isn't here
    </div>
    <a href={{ url('/ams/dashboard') }} class="btn btn-danger" style="background-color: #4E4C67; color: #FFF; border: none; padding: 10px 15px; text-decoration: none; display: inline-block; border-radius: 5px;">
    Go to AMS Home
</a>

</div>

@endsection