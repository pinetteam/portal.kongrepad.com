<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class KeypadEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $hall;
    public $on_vote;

    public function __construct($hall, $on_vote)
    {
        $this->hall = $hall;
        $this->on_vote = $on_vote;
    }

    public function broadcastOn()
    {
        return [
            new Channel('meeting-'.$this->hall->meeting_id),
        ];
    }

    public function broadcastAs()
    {
        return 'keypad';
    }

    public function broadcastWith () {
        return [
            'hall_id' => $this->hall->id,
            'on_vote' => $this->on_vote,
        ];
    }
}
