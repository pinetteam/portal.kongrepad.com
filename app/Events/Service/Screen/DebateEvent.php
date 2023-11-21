<?php

namespace App\Events\Service\Screen;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DebateEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $meeting_hall_screen;
    public $debate;
    public function __construct($meeting_hall_screen, $debate)
    {
        $this->meeting_hall_screen = $meeting_hall_screen;
        $this->debate = $debate;
    }
    public function broadcastOn(): array
    {
        return [
            new Channel('service.screen.debate.'.$this->meeting_hall_screen->code),
        ];
    }
    public function broadcastAs(): string
    {
        return 'debate-event';
    }
    public function broadcastWith () {
        try {
            return [
                'debate' => $this->debate,
            ];
        } catch (\Exception $e) {
            return [
                'debate' => null,
            ];
        }
    }
}
