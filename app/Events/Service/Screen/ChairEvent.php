<?php

namespace App\Events\Service\Screen;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChairEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $meeting_hall_screen;
    public function __construct($meeting_hall_screen)
    {
        $this->meeting_hall_screen = $meeting_hall_screen;
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
            $program = $this->meeting_hall_screen->hall->programs()->where('is_started', true)->first();
            return [
                'meeting_hall_screen' => $this->meeting_hall_screen,
                'chair' => $program->programChairs()->get()[$this->meeting_hall_screen->id%3]->chair,
            ];
        } catch (\Exception $e) {
            return [
                'meeting_hall_screen' => $this->meeting_hall_screen,
                'chair' => null,
            ];
        }
    }
}
