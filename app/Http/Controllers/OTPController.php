<?php

namespace App\Http\Controllers;

use App\Services\OTP\OTPServiceInterface;
use Illuminate\Http\Request;

class OTPController extends Controller
{
    protected $otpService;

    public function __construct(OTPServiceInterface $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Send OTP to a phone number or email.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
        ]);

        $identifier = $request->identifier;
        $otp = $this->otpService->generate($identifier);
        
        $sent = $this->otpService->send($identifier, $otp);

        if ($sent) {
            return response()->json([
                'message' => 'OTP sent successfully.',
                'identifier' => $identifier,
            ]);
        }

        return response()->json([
            'message' => 'Failed to send OTP. Please check your configuration.',
        ], 500);
    }

    /**
     * Verify the provided OTP.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'otp' => 'required|string',
        ]);

        $verified = $this->otpService->verify($request->identifier, $request->otp);

        if ($verified) {
            return response()->json([
                'message' => 'OTP verified successfully.',
            ]);
        }

        return response()->json([
            'message' => 'Invalid or expired OTP.',
        ], 422);
    }
}
