<?php

namespace App\Listeners;

use App\Events\OrderWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Product;

class UpdateStock
{
    /**
     * update the products quantity.
     *
     * @param  OrderWasCreated  $event
     * @return void
     */
    public function handle(OrderWasCreated $event)
    {
        foreach($event->products as $item){
            //increment and decrement are eloquent methods.
            $item->model->decrement('quantity',$item->qty);
        }
    }
}
