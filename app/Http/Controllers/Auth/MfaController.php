<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OTP\OTPServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MfaController extends Controller
{
    public function __construct(
        protected OTPServiceInterface $otpService
    ) {}

    /**
     * Show MFA verification form.
     */
    public function show(): View
    {
        if (!session()->has('mfa_user_id')) {
            abort(403, 'Invalid MFA session.');
        }

        return view('auth.mfa-verify');
    }

    /**
     * Verify MFA OTP and complete login.
     */
    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $userId = session('mfa_user_id');
        $remember = session('mfa_remember', false);

        if (!$userId) {
            return redirect()->route('login')->withErrors(['otp' => 'Invalid MFA session.']);
        }

        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('login')->withErrors(['otp' => 'User not found.']);
        }

        $identifier = $user->mfa_channel === 'sms' ? $user->phone_number : $user->email;

        if ($this->otpService->verify($identifier, $request->otp)) {
            // Clear MFA session data
            session()->forget(['mfa_user_id', 'mfa_remember']);

            // Log the user in
            Auth::login($user, $remember);

            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['otp' => 'Invalid or expired OTP. Please try again.']);
    }

    /**
     * Show MFA settings page.
     */
    public function settings(): View
    {
        return view('auth.mfa-settings');
    }

    /**
     * Update MFA settings.
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        $request->validate([
            'mfa_enabled' => ['required', 'boolean'],
            'mfa_channel' => ['required_if:mfa_enabled,true', 'in:email,sms'],
            'phone_number' => ['required_if:mfa_channel,sms', 'nullable', 'string'],
        ]);

        $user = Auth::user();

        $user->update([
            'mfa_enabled' => $request->boolean('mfa_enabled'),
            'mfa_channel' => $request->mfa_enabled ? $request->mfa_channel : null,
            'phone_number' => $request->mfa_channel === 'sms' ? $request->phone_number : $user->phone_number,
        ]);

        return back()->with('success', 'MFA settings updated successfully.');
    }
}
