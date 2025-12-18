<x-app-layout>
    <x-slot name="header">
        <h2 class="h3 mb-0">{{ __('MFA Settings') }}</h2>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('mfa.settings.update') }}">
                            @csrf

                            <!-- Enable MFA -->
                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="mfa_enabled" name="mfa_enabled" value="1" {{ old('mfa_enabled', auth()->user()->mfa_enabled) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="mfa_enabled">
                                        <strong>{{ __('Enable Two-Factor Authentication') }}</strong>
                                    </label>
                                </div>
                                <small class="text-muted">Add an extra layer of security to your account by requiring an OTP code during login.</small>
                            </div>

                            <div id="mfa-options" style="display: {{ old('mfa_enabled', auth()->user()->mfa_enabled) ? 'block' : 'none' }};">
                                <!-- MFA Channel -->
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Verification Method') }}</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="mfa_channel" id="mfa_email" value="email" {{ old('mfa_channel', auth()->user()->mfa_channel) === 'email' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="mfa_email">
                                            <i class="bi bi-envelope"></i> Email ({{ auth()->user()->email }})
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="mfa_channel" id="mfa_sms" value="sms" {{ old('mfa_channel', auth()->user()->mfa_channel) === 'sms' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="mfa_sms">
                                            <i class="bi bi-phone"></i> SMS
                                        </label>
                                    </div>
                                    @error('mfa_channel')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Phone Number (shown when SMS is selected) -->
                                <div class="mb-3" id="phone-number-field" style="display: {{ old('mfa_channel', auth()->user()->mfa_channel) === 'sms' ? 'block' : 'none' }};">
                                    <label for="phone_number" class="form-label">{{ __('Phone Number') }}</label>
                                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number', auth()->user()->phone_number) }}" placeholder="+1234567890">
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Enter your phone number with country code (e.g., +1234567890)</small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                    {{ __('Cancel') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save Settings') }}
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('mfa_enabled').addEventListener('change', function() {
            document.getElementById('mfa-options').style.display = this.checked ? 'block' : 'none';
        });

        document.querySelectorAll('input[name="mfa_channel"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                document.getElementById('phone-number-field').style.display = this.value === 'sms' ? 'block' : 'none';
            });
        });
    </script>
</x-app-layout>
