@extends('layouts.main')

@section('title', 'Profile')

@section('content')
    <main class="container">
        <div class="card mb-4">
            <div class="card-header text-center bg-primary text-white">
                <h2>Profile</h2>
            </div>
            <div class="card-body">
                <!-- Update Profile Information -->
                <div class="mb-4">
                    @include('profile.partials.update-profile-information-form')
                </div>
                <!-- Update Password -->
                <div class="mb-4">
                    @include('profile.partials.update-password-form')
                </div>
                <!-- Delete User Account -->
                <div>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </main>
@endsection
