<?php

namespace App\Events\Service\Screen;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChairEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $meeting_hall_screen;
    public $participant;
    public function __construct($meeting_hall_screen, $participant)
    {
        $this->meeting_hall_screen = $meeting_hall_screen;
        $this->participant = $participant;
    }
    public function broadcastOn(): array
    {
        return [
            new Channel('service.screen.chair.'.$this->meeting_hall_screen->code),
        ];
    }
    public function broadcastAs(): string
    {
        return 'chair-event';
    }
    public function broadcastWith () {
        try {
            return [
                'chair' => $this->participant,
            ];
        } catch (\Exception $e) {
            return [
                'chair' => null,
            ];
        }
    }
}
