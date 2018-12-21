<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class PassHolderExpired
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pass_holders;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Collection $pass_holders)
    {
        $this->pass_holders = $pass_holders;
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
