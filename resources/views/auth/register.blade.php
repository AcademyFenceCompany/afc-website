@extends('layouts.main')

@section('title', 'Register')

@section('content')
    <main class="container">
        <div class="card">
            <div class="card-header text-center bg-primary text-white">
                <h2>Register</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="name" class="form-label">Name*</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter your name..." value="{{ old('name') }}" required autofocus>
                            @if ($errors->has('name'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="email" class="form-label">Email*</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter your email..." value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="phone" class="form-label">Phone*</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                placeholder="Enter your phone number..." value="{{ old('phone') }}" required>
                            @if ($errors->has('phone'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('phone') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Street Address -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="street_address" class="form-label">Street Address*</label>
                            <input type="text" class="form-control" id="street_address" name="street_address"
                                placeholder="Enter your street address..." value="{{ old('street_address') }}" required>
                            @if ($errors->has('street_address'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('street_address') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- City, State, Zip -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="city" class="form-label">City*</label>
                            <input type="text" class="form-control" id="city" name="city"
                                placeholder="Enter your city..." value="{{ old('city') }}" required>
                            @if ($errors->has('city'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('city') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label for="state" class="form-label">State*</label>
                            <input type="text" class="form-control" id="state" name="state"
                                placeholder="Enter your state..." value="{{ old('state') }}" required>
                            @if ($errors->has('state'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('state') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label for="zip" class="form-label">Zip*</label>
                            <input type="text" class="form-control" id="zip" name="zip"
                                placeholder="Enter your zip code..." value="{{ old('zip') }}" required>
                            @if ($errors->has('zip'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('zip') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="password" class="form-label">Password*</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Enter your password..." required>
                            @if ($errors->has('password'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="password_confirmation" class="form-label">Confirm Password*</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Confirm your password..." required>
                            @if ($errors->has('password_confirmation'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('password_confirmation') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Already Registered -->
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-sm text-primary">
                            Already registered?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-danger">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
