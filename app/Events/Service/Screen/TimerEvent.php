<?php

namespace App\Events\Service\Screen;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TimerEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $meeting_hall_screen;
    public $time;
    public $action;
    public function __construct($meeting_hall_screen, $time, $action)
    {
        $this->meeting_hall_screen = $meeting_hall_screen;
        $this->time = $time;
        $this->action = $action;
    }
    public function broadcastOn(): array
    {
        return [
            new Channel('service.screen.timer.'.$this->meeting_hall_screen->code),
        ];
    }
    public function broadcastAs(): string
    {
        return 'timer-event';
    }
    public function broadcastWith () {
        try {
            return [
                'time' => $this->time,
                'action' => $this->action,
            ];
        } catch (\Exception $e) {
            return [
                'time' => null,
                'action' => null,
            ];
        }
    }
}
