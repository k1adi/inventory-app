<?php

namespace App\Notifications;

use App\Broadcasting\HttpChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ItemCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $item;

    /**
     * Create a new notification instance.
     */
    public function __construct($item)
    {
        $this->item = $item;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return [\App\Broadcasting\HttpChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toHttp($notifiable)
    {
        return [
            'device_id' => env('WHACENTER_DEVICE_ID'),
            'number' => env('WHACENTER_RECEIVER'),
            'message' => 'RIZKI - Test sending message from notification with created item | ' . $this->item->name
        ];
    }
}
