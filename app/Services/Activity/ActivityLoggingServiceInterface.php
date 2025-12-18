<?php

namespace App\Services\Activity;

use Illuminate\Database\Eloquent\Model;

interface ActivityLoggingServiceInterface
{
    /**
     * Log an activity.
     *
     * @param  string  $action
     * @param  Model|null  $subject
     * @param  array|null  $originalValues
     * @param  array|null  $newValues
     * @return void
     */
    public function log(string $action, ?Model $subject = null, ?array $originalValues = null, ?array $newValues = null);
}
