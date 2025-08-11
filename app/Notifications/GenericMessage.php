<?php

namespace App\Notifications;

use App\Models\Message as MessageLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GenericMessage extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected string $subject,
        protected string $body,
    ) {
    }

    public function via(object $notifiable): array
    {
        $channels = [];
        if (method_exists($notifiable, 'routeNotificationForMail') || isset($notifiable->email)) {
            $channels[] = 'mail';
        }
        if (method_exists($notifiable, 'routeNotificationForSms') || isset($notifiable->phone)) {
            $channels[] = 'sms';
        }
        return $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        $recipient = method_exists($notifiable, 'routeNotificationForMail') ? $notifiable->routeNotificationForMail() : ($notifiable->email ?? null);

        MessageLog::create([
            'channel' => 'mail',
            'recipient' => $recipient,
            'subject' => $this->subject,
            'body' => $this->body,
            'status' => 'queued',
        ]);

        return (new MailMessage)
            ->subject($this->subject)
            ->line($this->body);
    }

    public function toSms(object $notifiable): array
    {
        $recipient = method_exists($notifiable, 'routeNotificationForSms') ? $notifiable->routeNotificationForSms() : ($notifiable->phone ?? null);

        MessageLog::create([
            'channel' => 'sms',
            'recipient' => $recipient,
            'subject' => $this->subject,
            'body' => $this->body,
            'status' => 'queued',
        ]);

        return [
            'to' => $recipient,
            'message' => $this->body,
        ];
    }
}


