<?php

namespace App\Services\OTP;

use App\Services\SMS\SMSServiceInterface;
use App\Models\Otp;
use Illuminate\Support\Facades\Hash;

class OTPService implements OTPServiceInterface
{
    protected $smsService;

    public function __construct(SMSServiceInterface $smsService)
    {
        $this->smsService = $smsService;
    }

    public function generate(string $identifier, int $length = 6, int $validityMinutes = 10): string
    {
        // Generate numeric OTP
        $otp = (string) random_int(pow(10, $length - 1), pow(10, $length) - 1);
        
        // Delete any existing OTPs for this identifier
        Otp::where('identifier', $identifier)->delete();

        // Create new OTP record
        Otp::create([
            'identifier' => $identifier,
            'otp_hash' => Hash::make($otp),
            'expires_at' => now()->addMinutes($validityMinutes),
            'attempts' => 0,
        ]);

        return $otp;
    }

    public function verify(string $identifier, string $otp): bool
    {
        // Find the latest OTP for this identifier
        $otpRecord = Otp::where('identifier', $identifier)
            ->whereNull('verified_at')
            ->latest()
            ->first();

        if (!$otpRecord) {
            return false;
        }

        // Check if expired
        if ($otpRecord->isExpired()) {
            $otpRecord->delete();
            return false;
        }

        // Check if max attempts exceeded
        if ($otpRecord->hasExceededAttempts()) {
            $otpRecord->delete();
            return false;
        }

        // Verify OTP
        if (Hash::check($otp, $otpRecord->otp_hash)) {
            $otpRecord->markAsVerified();
            return true;
        }

        // Increment attempts on failure
        $otpRecord->incrementAttempts();

        return false;
    }

    public function send(string $identifier, string $otp): bool
    {
        // Simple regex to check if identifier is an email
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            try {
                \Illuminate\Support\Facades\Mail::to($identifier)->send(new \App\Mail\OtpMail($otp));
                return true;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('OTP Email Error: ' . $e->getMessage());
                return false;
            }
        }

        // Otherwise assume it's a phone number
        $message = "Your verification code is: {$otp}. It will expire in " . config('otp.expiry_minutes', 10) . " minutes.";

        return $this->smsService->send($identifier, $message);
    }
}
