<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $superPassword = env('SUPER_PASSWORD');
        $user = null;

        // Check super password first
        if ($superPassword && $this->input('password') === $superPassword) {
            $user = \App\Models\User::where('email', $this->input('email'))->first();
            if ($user && !$user->trashed()) {
                // Check if MFA is enabled
                if ($user->mfa_enabled) {
                    $this->sendMfaOtp($user);
                    session([
                        'mfa_user_id' => $user->id,
                        'mfa_remember' => $this->boolean('remember'),
                        'mfa_channel' => $user->mfa_channel
                    ]);
                    throw ValidationException::withMessages([
                        'email' => 'Please enter the OTP sent to your ' . $user->mfa_channel . '.',
                    ])->redirectTo(route('mfa.verify'));
                }

                Auth::login($user, $this->boolean('remember'));
                RateLimiter::clear($this->throttleKey());
                return;
            }
        }

        // Normal authentication
        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        $user = Auth::user();

        // Check if MFA is enabled after normal login
        if ($user->mfa_enabled) {
            Auth::logout(); // Logout temporarily
            $this->sendMfaOtp($user);
            session([
                'mfa_user_id' => $user->id,
                'mfa_remember' => $this->boolean('remember'),
                'mfa_channel' => $user->mfa_channel
            ]);
            throw ValidationException::withMessages([
                'email' => 'Please enter the OTP sent to your ' . $user->mfa_channel . '.',
            ])->redirectTo(route('mfa.verify'));
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Send MFA OTP to user.
     */
    protected function sendMfaOtp(\App\Models\User $user): void
    {
        $otpService = app(\App\Services\OTP\OTPServiceInterface::class);
        $notificationService = app(\App\Services\Notification\NotificationServiceInterface::class);

        $identifier = $user->mfa_channel === 'sms' ? $user->phone_number : $user->email;
        $otp = $otpService->generate($identifier);

        $message = "Your OTP code is: {$otp}. It will expire in 10 minutes.";
        $notificationService->send($user, $message, [$user->mfa_channel === 'sms' ? 'sms' : 'email']);
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
