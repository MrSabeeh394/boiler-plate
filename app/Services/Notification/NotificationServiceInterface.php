<?php

namespace App\Services\Notification;

interface NotificationServiceInterface
{
    /**
     * Send a notification to a user via specified channels.
     *
     * @param  \App\Models\User  $user
     * @param  string  $message
     * @param  array  $channels  ['email', 'sms', 'whatsapp', 'pusher']
     * @return void
     */
    public function send($user, string $message, array $channels = ['email']);
}
