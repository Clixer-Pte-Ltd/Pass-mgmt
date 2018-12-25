<?php

namespace App\Events;

use App\Models\PassHolder;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class PassHolderTerminated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pass_holder;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(PassHolder $pass_holder)
    {
        $this->pass_holder = $pass_holder;
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
