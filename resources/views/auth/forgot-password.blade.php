<x-guest-layout>
    <div class="auth-header">
        <i class="bi bi-question-circle" style="font-size: 3rem;"></i>
        <h2 class="mt-3">Forgot Password?</h2>
        <p>No problem! We'll send you a reset link</p>
    </div>

    <div class="auth-body">
        <!-- Info Text -->
        <div class="alert alert-info d-flex align-items-start" role="alert">
            <i class="bi bi-info-circle me-2 mt-1"></i>
            <div>
                <small>Enter your email address and we'll send you a link to reset your password.</small>
            </div>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="form-label">
                    <i class="bi bi-envelope"></i> Email Address
                </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-at"></i></span>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" 
                           required autofocus 
                           placeholder="Enter your email">
                </div>
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-send"></i> Send Reset Link
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
