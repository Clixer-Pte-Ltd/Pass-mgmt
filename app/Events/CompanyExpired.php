<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Database\Eloquent\Collection;

class CompanyExpired
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $companies;
    public $type;

    /**
     * Create a new event instance.
     *
     * @param Collection $companies
     * @param $type
     */
    public function __construct(Collection $companies, $type)
    {
        $this->companies = $companies;
        $this->type = $type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
