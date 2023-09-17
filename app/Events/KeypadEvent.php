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

    public function __construct($hall)
    {
        $this->hall = $hall;
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
        ];
    }
}
