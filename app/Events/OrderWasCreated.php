<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Order;
use App\Product;

class OrderWasCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $transaction_id;
    public $products;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Order $order,$products,$transaction_id)
    {
        $this->order = $order;
        $this->transaction_id = $transaction_id;
        $this->products = $products;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
