<?php

namespace App\Events\Service\Debate;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Meeting\Hall\Hall;

class DebateEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The hall instance.
     *
     * @var Hall
     */
    public Hall $hall;

    /**
     * Indicates if voting is active.
     *
     * @var bool
     */
    public bool $on_vote;

    /**
     * Create a new event instance.
     *
     * @param Hall $hall
     * @param bool $on_vote
     */
    public function __construct(Hall $hall, bool $on_vote)
    {
        $this->hall = $hall;
        $this->on_vote = $on_vote;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('meeting-' . $this->hall->meeting_id),
        ];
    }

    /**
     * Get the event name for broadcasting.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'debate';
    }

    /**
     * Get the data to broadcast with.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'hall_id' => $this->hall->id,
            'on_vote' => $this->on_vote,
        ];
    }
}
