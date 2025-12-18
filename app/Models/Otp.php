<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $fillable = [
        'identifier',
        'otp_hash',
        'expires_at',
        'attempts',
        'verified_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    /**
     * Check if OTP is expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Check if OTP has exceeded max attempts.
     */
    public function hasExceededAttempts(int $maxAttempts = 3): bool
    {
        return $this->attempts >= $maxAttempts;
    }

    /**
     * Increment attempts.
     */
    public function incrementAttempts(): void
    {
        $this->increment('attempts');
    }

    /**
     * Mark as verified.
     */
    public function markAsVerified(): void
    {
        $this->update(['verified_at' => now()]);
    }
}
