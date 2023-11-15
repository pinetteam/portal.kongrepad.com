<?php

namespace App\Events\Service\Screen;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SpeakerEvent implements ShouldBroadcast
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
            new Channel('service.screen.speaker.'.$this->meeting_hall_screen->code),
        ];
    }
    public function broadcastAs(): string
    {
        return 'speaker-event';
    }
    public function broadcastWith () {
        try {
            return [
                'speaker' => $this->participant,
            ];
        } catch (\Exception $e) {
            return [
                'speaker' => null,
            ];
        }
    }
}
