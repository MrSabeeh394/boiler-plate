<?php

namespace App\Services\SMS;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class TwilioService implements SMSServiceInterface
{
    protected $sid;
    protected $token;
    protected $from;

    public function __construct()
    {
        $this->sid = config('services.twilio.sid');
        $this->token = config('services.twilio.token');
        $this->from = config('services.twilio.from');
    }

    /**
     * Send an SMS message using Twilio.
     *
     * @param  string  $to
     * @param  string  $message
     * @return bool
     */
    public function send(string $to, string $message): bool
    {
        try {
            if (empty($this->sid) || empty($this->token)) {
                Log::error('Twilio credentials not configured.');
                return false;
            }

            $client = new Client($this->sid, $this->token);
            $client->messages->create($to, [
                'from' => $this->from,
                'body' => $message,
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Twilio SMS Error: ' . $e->getMessage());
            return false;
        }
    }
}
