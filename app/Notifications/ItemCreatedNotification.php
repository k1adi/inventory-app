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
        return [HttpChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toHttp($notifiable)
    {
        return [
            'device_id' => env('WHACENTER_DEVICE_ID'),
            'number' => env('WHACENTER_RECEIVER'),
            'message' => "Hello, RIZKI.\n".
                         "Test sending message from notification\n" .
                         "created item " . $this->item->name . "\n" .
                         "with code " . $this->item->code . 
                         "and qty : " . $this->item->qty . "\n" .
                         "-------------------------------------\n" .
                         "Do not reply this message!\n".
                         "this message was sent without service"
        ];
    }
}
