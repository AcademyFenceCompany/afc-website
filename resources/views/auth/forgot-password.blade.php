@extends('layouts.main')

@section('title', 'Forgot Password')

@section('content')
    <main class="container">
        <div class="card">
            <div class="card-header text-center bg-primary text-white">
                <h2>Forgot Password</h2>
            </div>
            <div class="card-body">
                <p class="text-sm text-muted mb-4 text-center">
                    Forgot your password? No problem. Just let us know your email address, and we will email you a password
                    reset link that will allow you to choose a new one.
                </p>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success text-center">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="email" class="form-label">Email*</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter your email..." value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-danger">Email Password Reset Link</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
