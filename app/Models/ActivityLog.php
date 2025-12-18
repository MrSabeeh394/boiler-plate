<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'subject_type',
        'subject_id',
        'original_values',
        'new_values',
        'ip_address',
    ];

    protected $casts = [
        'original_values' => 'array',
        'new_values' => 'array',
    ];
}
