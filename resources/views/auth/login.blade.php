<x-guest-layout>
    <div class="auth-header">
        <i class="bi bi-box-arrow-in-right" style="font-size: 3rem;"></i>
        <h2 class="mt-3">Welcome Back!</h2>
        <p>Sign in to your account</p>
    </div>

    <div class="auth-body">
        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">
                    <i class="bi bi-envelope"></i> Email Address
                </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-at"></i></span>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" 
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
                    <i class="bi bi-lock"></i> Password
                </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-key"></i></span>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password" 
                           required autocomplete="current-password" 
                           placeholder="Enter your password">
                </div>
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                <label class="form-check-label" for="remember_me">
                    Remember me
                </label>
            </div>

            <!-- Forgot Password Link -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="auth-link small">
                        <i class="bi bi-question-circle"></i> Forgot password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-box-arrow-in-right"></i> Sign In
                </button>
            </div>

            <!-- Register Link -->
            @if (Route::has('register'))
                <div class="divider">
                    <span>Don't have an account?</span>
                </div>
                <div class="text-center">
                    <a href="{{ route('register') }}" class="auth-link">
                        <i class="bi bi-person-plus"></i> Create an account
                    </a>
                </div>
            @endif
        </form>
    </div>
</x-guest-layout>
