<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Database\Eloquent\Collection;

class CompanyExpired
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $companies;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Collection $companies)
    {
        $this->companies = $companies;
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
