<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PassHolderNeedConfirmReturn
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pass_holder;
    public $is_list_pass;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($passHolder, $isListPass)
    {
        $this->pass_holder = $passHolder;
        $this->is_list_pass = $isListPass;
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
