<?php

namespace App\Services\OTP;

interface OTPServiceInterface
{
    /**
     * Generate and store an OTP for the given identifier.
     *
     * @param  string  $identifier  Unique key (e.g. email or phone)
     * @param  int  $length
     * @param  int  $validityMinutes
     * @return string  The raw OTP (to be sent via notification)
     */
    public function generate(string $identifier, int $length = 6, int $validityMinutes = 10): string;

    /**
     * Verify the provided OTP.
     *
     * @param  string  $identifier
     * @param  string  $otp
     * @return bool
     */
    public function verify(string $identifier, string $otp): bool;
    /**
     * Send the OTP to the user.
     *
     * @param  string  $identifier
     * @param  string  $otp
     * @return bool
     */
    public function send(string $identifier, string $otp): bool;
}
