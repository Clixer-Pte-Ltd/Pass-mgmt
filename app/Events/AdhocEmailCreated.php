<?php

namespace App\Events;

use App\Models\BackpackUser;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Models\AdhocEmail;

class AdhocEmailCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $email;

    /**
     * AdhocEmailCreated constructor.
     * @param AdhocEmail $email
     * @param $senderId
     */
    public function __construct(AdhocEmail $email)
    {
        //
        $this->email = $email;
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
