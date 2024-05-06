<?php

namespace App\Broadcasting;

use Illuminate\Notifications\Notification;

class WhacenterChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toHttp($notifiable);
        $message->send();
    }
}
