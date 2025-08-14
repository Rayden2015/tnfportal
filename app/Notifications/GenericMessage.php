<?php

namespace App\Notifications;

use App\Models\Message as MessageLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\HubtelSmsChannel;
use App\Services\Sms\HubtelSmsSender;

// class GenericMessage extends Notification implements ShouldQueue
class GenericMessage extends Notification
{
    // use Queueable;

    public function __construct(
        protected string $subject,
        protected string $body,
        protected string $channel
    ) {
    }

    public function via(object $notifiable): array
    {
        if ($this->channel === 'mail') {
            return ['mail'];
        } elseif ($this->channel === 'sms') {
            return [\App\Notifications\Channels\HubtelSmsChannel::class];
        }
        return [];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $recipient = method_exists($notifiable, 'routeNotificationForMail') ? $notifiable->routeNotificationForMail() : ($notifiable->email ?? null);

        MessageLog::create([
            'notifiable_type' => 'mail',
            'notifiable_id' => null,
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
            'notifiable_type' => 'sms',
            'notifiable_id' => null,
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
