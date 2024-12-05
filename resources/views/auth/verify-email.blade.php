@extends('layouts.main')

@section('title', 'Email Verification')

@section('content')
    <main class="container">
        <div class="card">
            <div class="card-header text-center bg-primary text-white">
                <h2>Email Verification</h2>
            </div>
            <div class="card-body">
                <p class="text-muted text-center mb-4">
                    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </p>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success text-center">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <!-- Resend Verification Email -->
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            {{ __('Resend Verification Email') }}
                        </button>
                    </form>

                    <!-- Log Out -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-secondary">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
