<?php

namespace App\Listeners;

use App\Events\ProductQuantityUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\notifications;
use App\Models\User;

class SendStockQuantityNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ProductQuantityUpdated  $event
     * @return void
     */
    public function handle(ProductQuantityUpdated $event)
    {
        if ($event->product->product_quantity < 5) {
            // Get all user IDs to notify
            $userIds = User::pluck('id')->toArray();
            $createdBy = $event->product->created_by;


            // Include the creator in the list of recipients
            if (!in_array($createdBy, $userIds)) {
                $userIds[] = $createdBy;
            }

            // Create the notifications for each recipient
            foreach ($userIds as $userId) {
                Notifications::create([
                    'user_id' => $userId,
                    'product_id' => $event->product->id,
                    'message' => "Product {$event->product->product_name} is running low on quantity!",

                    'is_read' => false,
                    'created_at' => Carbon::now(),
                ]);
            }
        }
    }
}
