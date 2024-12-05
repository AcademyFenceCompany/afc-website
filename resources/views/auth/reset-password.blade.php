@extends('layouts.main')

@section('title', 'Reset Password')

@section('content')
    <main class="container">
        <div class="card">
            <div class="card-header text-center bg-primary text-white">
                <h2>Reset Password</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="email" class="form-label">Email*</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email', $request->email) }}" required autofocus>
                            @if ($errors->has('email'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password*</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            @if ($errors->has('password'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirm Password*</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" required>
                            @if ($errors->has('password_confirmation'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('password_confirmation') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-danger">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
