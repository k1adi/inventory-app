<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Item;
use App\Notifications\ItemCreatedNotification;
use App\Notifications\WhacenterNotification;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class ItemObserver
{
    /**
     * Handle the Item "created" event.
     */
    public function created(Item $item): void
    {
        ActivityLog::create([
            'description' => "Created item - $item->name with code - $item->code",
        ]);
        // Send notification without service
        $item->notify(new ItemCreatedNotification($item));
        // Send notification with service
        FacadesNotification::send($item, new WhacenterNotification($item));
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
