<section>
    <header>
        <h3 class="text-primary mb-3">Profile Information</h3>
        <p>Update your account's profile information and email address.</p>
    </header>

    <form method="POST" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}"
                required>
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" class="form-control"
                value="{{ old('email', $user->email) }}" required>
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="additional_phone" class="form-label">Additional Phone</label>
            <input id="additional_phone" name="additional_phone" type="text" class="form-control"
                value="{{ old('additional_phone', $user->additional_phone) }}">
        </div>

        <div class="mb-3">
            <label for="billing_email" class="form-label">Billing Email</label>
            <input id="billing_email" name="billing_email" type="email" class="form-control"
                value="{{ old('billing_email', $user->billing_email) }}">
        </div>

        <div class="mb-3">
            <label for="delivery_address" class="form-label">Delivery Address</label>
            <textarea id="delivery_address" name="delivery_address" class="form-control">{{ old('delivery_address', $user->delivery_address) }}</textarea>
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <p class="text-muted">
                Your email address is unverified.
                <button form="send-verification" class="btn btn-link">Resend Verification Email</button>
            </p>
        @endif

        <div>
            <button type="submit" class="btn btn-danger">Save</button>
            @if (session('status') === 'profile-updated')
                <span class="text-success ms-3">Profile updated successfully.</span>
            @endif
        </div>
    </form>
</section>
