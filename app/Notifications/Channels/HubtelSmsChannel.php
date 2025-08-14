<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use App\Services\Sms\HubtelSmsSender;

class HubtelSmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toSms')) {
            return;
        }

        $messageData = $notification->toSms($notifiable);

        if (empty($messageData['to']) || empty($messageData['message'])) {
            return;
        }

        try {
            $sender = new HubtelSmsSender();
            $result = $sender->send($messageData['to'], $messageData['message']);

            \Log::debug('HubtelSmsChannel: API result', ['result' => $result]);

            $status = 'failed';
            if (isset($result['response'])) {
                $responseData = json_decode($result['response'], true);
                if (isset($responseData['status']) && $responseData['status'] === 0) {
                    $status = 'sent';
                }
            }

            // Update or create Message record
            \App\Models\Message::create([
                'tenant_id' => $notifiable->tenant_id ?? null,
                'subject' => $notification->subject ?? null,
                'body' => $messageData['message'],
                'channel' => 'sms',
                'recipient' => $messageData['to'],
                'status' => $status,
            ]);
        } catch (\Exception $e) {
            \Log::error('HubtelSmsChannel: Error sending SMS', [
                'error' => $e->getMessage(),
                'recipient' => $messageData['to'],
                'body' => $messageData['message']
            ]);

            \App\Models\Message::create([
                'tenant_id' => $notifiable->tenant_id ?? null,
                'subject' => $notification->subject ?? null,
                'body' => $messageData['message'],
                'channel' => 'sms',
                'recipient' => $messageData['to'],
                'status' => 'failed',
            ]);
        }
    }
}