<?php

namespace App\Events\Service\Screen;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class KeypadEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $meeting_hall_screen;
    public $keypad;
    public function __construct($meeting_hall_screen, $keypad)
    {
        $this->meeting_hall_screen = $meeting_hall_screen;
        $this->keypad = $keypad;
    }
    public function broadcastOn(): array
    {
        return [
            new Channel('service.screen.keypad.'.$this->meeting_hall_screen->code),
        ];
    }
    public function broadcastAs(): string
    {
        return 'keypad-event';
    }
    public function broadcastWith () {
        try {
            return [
                'keypad' => $this->keypad,
            ];
        } catch (\Exception $e) {
            return [
                'keypad' => null,
            ];
        }
    }
}
