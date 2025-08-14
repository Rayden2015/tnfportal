<?php

namespace App\Notifications\Channels;

use App\Services\Sms\HubtelSmsSender;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    public function __construct(private HubtelSmsSender $smsSender)
    {
    }

    public function send(object $notifiable, Notification $notification): void
    {
        if (!method_exists($notification, 'toSms')) {
            return;
        }

        $message = $notification->toSms($notifiable);
        $to = $message['to'] ?? null;
        $text = $message['message'] ?? null;

        if (!$to || !$text) {
            return;
        }

        $this->smsSender->send($to, $text);
    }
}


