<x-guest-layout>
    <div class="auth-header">
        <i class="bi bi-key" style="font-size: 3rem;"></i>
        <h2 class="mt-3">Reset Password</h2>
        <p>Create a new password for your account</p>
    </div>

    <div class="auth-body">
        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">
                    <i class="bi bi-envelope"></i> Email Address
                </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-at"></i></span>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" 
                           value="{{ old('email', $request->email) }}" 
                           required autofocus autocomplete="username" 
                           placeholder="Enter your email">
                </div>
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">
                    <i class="bi bi-lock"></i> New Password
                </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-key"></i></span>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password" 
                           required autocomplete="new-password" 
                           placeholder="Enter new password">
                </div>
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
                <small class="text-muted">Minimum 8 characters</small>
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="form-label">
                    <i class="bi bi-lock-fill"></i> Confirm Password
                </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                           id="password_confirmation" name="password_confirmation" 
                           required autocomplete="new-password" 
                           placeholder="Confirm new password">
                </div>
                @error('password_confirmation')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-circle"></i> Reset Password
                </button>
            </div>

            <!-- Back to Login -->
            <div class="text-center">
                <a href="{{ route('login') }}" class="auth-link">
                    <i class="bi bi-arrow-left"></i> Back to login
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
