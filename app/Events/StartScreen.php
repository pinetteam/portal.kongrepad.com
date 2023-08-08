<?php

namespace App\Events;

use App\Models\Meeting\Participant\Participant;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StartScreen implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $participant;

    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return [
            new Channel('screen-channel'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'my-event';
    }
}
