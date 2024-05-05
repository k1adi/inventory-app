<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Item;
use App\Notifications\ItemCreatedNotification;
use Illuminate\Support\Facades\Http;

class ItemObserver
{
    /**
     * Handle the Item "created" event.
     */
    public function created(Item $item): void
    {
        ActivityLog::create([
            'description' => "Created item - $item->name",
        ]);

        Http::post('https://app.whacenter.com/api/send', [
            'device_id' => env('WHACENTER_DEVICE_ID'),
            'number' => env('WHACENTER_RECEIVER'),
            'message' => 'RIZKI - Test sending message from observer with created item ' . $item->name
        ]);

        $item->notify(new ItemCreatedNotification($item));
    }

    /**
     * Handle the Item "updated" event.
     */
    public function updated(Item $item): void
    {
        //
    }

    /**
     * Handle the Item "deleted" event.
     */
    public function deleted(Item $item): void
    {
        //
    }

    /**
     * Handle the Item "restored" event.
     */
    public function restored(Item $item): void
    {
        //
    }

    /**
     * Handle the Item "force deleted" event.
     */
    public function forceDeleted(Item $item): void
    {
        //
    }
}
