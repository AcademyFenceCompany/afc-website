@extends('layouts.main')

@section('title', 'Login')

@section('content')
    <main class="container">
        <div class="card">
            <div class="card-header text-center bg-primary text-white">
                <h2>Login</h2>
            </div>
            <div class="card-body">
                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success mb-4" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="email" class="form-label">Email*</label>
                            <input type="email" id="email" name="email" class="form-control"
                                placeholder="Enter your email..." value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="password" class="form-label">Password*</label>
                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="Enter your password..." required>
                            @if ($errors->has('password'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                            <label for="remember_me" class="form-check-label">Remember me</label>
                        </div>
                    </div>

                    <div class="text-center">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-primary">
                                Forgot your password?
                            </a>
                        @endif
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-danger">Log in</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
