<?php

namespace App\Services\Activity;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLoggingService implements ActivityLoggingServiceInterface
{
    public function log(string $action, ?Model $subject = null, ?array $originalValues = null, ?array $newValues = null)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject ? $subject->getKey() : null,
            'original_values' => $originalValues ? json_encode($originalValues) : null,
            'new_values' => $newValues ? json_encode($newValues) : null,
            'ip_address' => Request::ip(),
        ]);
    }
}
