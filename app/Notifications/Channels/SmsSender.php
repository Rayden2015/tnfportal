<?php

namespace App\Services\Sms;

use App\Models\Message;
use Illuminate\Support\Facades\Log;

class SmsSender
{
    public function __construct(
        private ?string $provider = null,
    ) {
    }

    public function send(string $to, string $text): void
    {
        try {
            // TODO: integrate with Twilio/Nexmo/etc. For now we log as sent.
            Log::info('SMS send', ['to' => $to, 'text' => $text]);

            Message::create([
                'channel' => 'sms',
                'recipient' => $to,
                'subject' => null,
                'body' => $text,
                'status' => 'sent',
                'sent_at' => now(),
            ]);
        } catch (\Throwable $e) {
            Message::create([
                'channel' => 'sms',
                'recipient' => $to,
                'subject' => null,
                'body' => $text,
                'status' => 'failed',
                'error' => $e->getMessage(),
            ]);
        }
    }
}


