@extends('layouts.ams')

@section('title', 'Edit Customer')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Edit Customer</h1>

        <!-- Edit Form -->
        <form action="{{ route('customers.update', $customer->customer_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $customer->name }}">
            </div>

            <div class="mb-3">
                <label for="company" class="form-label">Company</label>
                <input type="text" class="form-control" id="company" name="company" value="{{ $customer->company }}">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $customer->email }}">
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $customer->phone }}">
            </div>

            <h3 class="mt-4">Addresses</h3>
            @foreach ($customer->addresses as $address)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="address_1_{{ $address->id }}" class="form-label">Address Line 1</label>
                            <input type="text" class="form-control" id="address_1_{{ $address->id }}"
                                name="addresses[{{ $address->id }}][address_1]" value="{{ $address->address_1 }}">
                        </div>
                        <div class="mb-3">
                            <label for="city_{{ $address->id }}" class="form-label">City</label>
                            <input type="text" class="form-control" id="city_{{ $address->id }}"
                                name="addresses[{{ $address->id }}][city]" value="{{ $address->city }}">
                        </div>
                        <div class="mb-3">
                            <label for="state_{{ $address->id }}" class="form-label">State</label>
                            <input type="text" class="form-control" id="state_{{ $address->id }}"
                                name="addresses[{{ $address->id }}][state]" value="{{ $address->state }}">
                        </div>
                        <div class="mb-3">
                            <label for="zipcode_{{ $address->id }}" class="form-label">Zipcode</label>
                            <input type="text" class="form-control" id="zipcode_{{ $address->id }}"
                                name="addresses[{{ $address->id }}][zipcode]" value="{{ $address->zipcode }}">
                        </div>
                    </div>
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
@endsection
