<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mfa_enabled',
        'mfa_channel',
        'phone_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'mfa_enabled' => 'boolean',
        ];
    }

    /**
     * Check if user has permission in a specific portal.
     */
    public function hasPermissionToInPortal(string $permission, string $portal): bool
    {
        // Check direct permissions
        $hasDirect = $this->permissions()
            ->where('name', $permission)
            ->where('portal', $portal)
            ->exists();

        if ($hasDirect) {
            return true;
        }

        // Check via roles
        return $this->roles()
            ->where('portal', $portal)
            ->whereHas('permissions', function ($q) use ($permission, $portal) {
                $q->where('name', $permission)->where('portal', $portal);
            })->exists();
    }
}
