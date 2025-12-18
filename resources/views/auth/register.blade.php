<x-guest-layout>
    <div class="auth-header">
        <i class="bi bi-person-plus" style="font-size: 3rem;"></i>
        <h2 class="mt-3">Create Account</h2>
        <p>Join us today!</p>
    </div>

    <div class="auth-body">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">
                    <i class="bi bi-person"></i> Full Name
                </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" 
                           required autofocus autocomplete="name" 
                           placeholder="Enter your full name">
                </div>
                @error('name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">
                    <i class="bi bi-envelope"></i> Email Address
                </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-at"></i></span>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" 
                           required autocomplete="username" 
                           placeholder="Enter your email">
                </div>
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">
                    <i class="bi bi-lock"></i> Password
                </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-key"></i></span>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password" 
                           required autocomplete="new-password" 
                           placeholder="Create a password">
                </div>
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
                <small class="text-muted">Minimum 8 characters</small>
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">
                    <i class="bi bi-lock-fill"></i> Confirm Password
                </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                           id="password_confirmation" name="password_confirmation" 
                           required autocomplete="new-password" 
                           placeholder="Confirm your password">
                </div>
                @error('password_confirmation')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-person-plus"></i> Create Account
                </button>
            </div>

            <!-- Login Link -->
            <div class="divider">
                <span>Already have an account?</span>
            </div>
            <div class="text-center">
                <a href="{{ route('login') }}" class="auth-link">
                    <i class="bi bi-box-arrow-in-right"></i> Sign in instead
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
