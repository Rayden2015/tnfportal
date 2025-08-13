<?php

namespace App\Notifications;

use Illuminate\Notifications\Notifiable;

class AdHocNotifiable
{
    use Notifiable;

    public $email;
    public $phone;

    public function __construct($email = null, $phone = null)
    {
        $this->email = $email;
        $this->phone = $phone;
    }

    public function routeNotificationForMail($notification = null)
    {
        return $this->email;
    }

    public function routeNotificationForSms($notification = null)
    {
        return $this->phone;
    }
}
