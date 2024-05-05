<?php

namespace App\Broadcasting;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class HttpChannel
{
    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toHttp($notifiable);

        // Send the HTTP request
        Http::post('https://app.whacenter.com/api/send', $data);
    }
}
