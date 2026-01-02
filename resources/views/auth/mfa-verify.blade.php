<x-guest-layout>
    <div class="auth-header">
        <i class="bi bi-shield-lock" style="font-size: 3rem;"></i>
        <h2 class="mt-3">Two-Factor Authentication</h2>
        <p>Enter the OTP code sent to your {{ session('mfa_channel') === 'sms' ? 'phone number' : 'email' }}</p>
    </div>

    <div class="auth-body">
        <form method="POST" action="{{ route('mfa.verify') }}">
            @csrf

            <!-- Info Alert -->
            <div class="alert alert-info d-flex align-items-center" role="alert">
                <i class="bi bi-info-circle me-2"></i>
                <div>
                    Check your {{ session('mfa_channel') === 'sms' ? 'phone number' : 'email' }} for a 6-digit verification code
                </div>
            </div>

            <!-- OTP Input -->
            <div class="mb-4">
                <label for="otp" class="form-label">
                    <i class="bi bi-key-fill"></i> Verification Code
                </label>
                <input type="text" 
                       class="form-control form-control-lg text-center @error('otp') is-invalid @enderror" 
                       id="otp" 
                       name="otp" 
                       required 
                       autofocus 
                       maxlength="6" 
                       placeholder="000000"
                       style="letter-spacing: 1em; font-size: 2rem; font-weight: 700;">
                @error('otp')
                    <div class="invalid-feedback text-center">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-shield-check"></i> Verify Code
                </button>
            </div>

            <!-- Back to Login -->
            <div class="text-center">
                <a href="{{ route('login') }}" class="auth-link small">
                    <i class="bi bi-arrow-left"></i> Back to login
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
