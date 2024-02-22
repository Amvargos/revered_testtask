<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;


class ChangeTraficLightEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    /**
     * Create a new event instance.
     *
     * @return void
     */

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function broadcastAs()
    {
        return 'traficLights.change';
    }
    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return new Channel('traficLights.notification');
    }

    public function broadcastWith()
    {
        return ['data' => $this->data];
    }
}
