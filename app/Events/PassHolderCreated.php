<?php

namespace App\Events;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class PassHolderCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $model;
    public $zones;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($model, $zones)
    {
        //
        $this->model = $model;
        $this->zones = $zones;
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
