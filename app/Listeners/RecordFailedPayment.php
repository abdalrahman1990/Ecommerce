<?php

namespace App\Listeners;

use App\Events\OrderFailed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecordFailedPayment
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
     * @param  OrderFailed  $event
     * @return void
     */
    public function handle(OrderFailed $event)
    {
        //create a failed payment
        $event->order->payment()->create([
            'failed' => true,
        ]);
    }
}
