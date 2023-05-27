<?php

namespace App\Listeners;

use App\Events\OrderWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Cart;

class EmptyCart
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
     * @param  OrderWasCreated  $event
     * @return void
     */
    public function handle(OrderWasCreated $event)
    {
        //Destroy the Current cart instance
        Cart::destroy();
    }
}
