<?php

namespace App\Services\Notification;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationService implements NotificationServiceInterface
{
    public function send($user, string $message, array $channels = ['email'])
    {
        foreach ($channels as $channel) {
            switch ($channel) {
                case 'email':
                    $this->sendEmail($user, $message);
                    break;
                case 'sms':
                    $this->sendSms($user, $message);
                    break;
                case 'whatsapp':
                    $this->sendWhatsApp($user, $message);
                    break;
                case 'pusher':
                    $this->sendPusher($user, $message);
                    break;
                default:
                    Log::warning("Notification channel [$channel] not supported.");
            }
        }
    }

    protected function sendEmail($user, $message)
    {
        // Send actual email
        Mail::raw($message, function ($msg) use ($user) {
            $msg->to($user->email)->subject('Notification from ' . config('app.name'));
        });
        
        Log::info("Sent Email to {$user->email}");
    }

    protected function sendSms($user, $message)
    {
        // Mock Implementation - Replace with actual SMS provider (Twilio, etc.)
        // Example: $this->twilioClient->messages->create($user->phone_number, ['from' => config('services.twilio.from'), 'body' => $message]);
        Log::info("Sent SMS to {$user->phone_number}: $message");
    }

    protected function sendWhatsApp($user, $message)
    {
        // Mock Implementation - Replace with actual WhatsApp API
        // Example: Use Twilio WhatsApp API or WhatsApp Business API
        Log::info("Sent WhatsApp to {$user->phone_number}: $message");
    }

    protected function sendPusher($user, $message)
    {
        // Mock Implementation - Replace with actual Pusher/Broadcasting
        // Example: broadcast(new NotificationEvent($user, $message));
        Log::info("Sent Pusher event to user {$user->id}: $message");
    }
}
