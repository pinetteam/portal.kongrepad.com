<?php

namespace App\Events\Service\Screen;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DocumentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $meeting_hall_screen;
    public $document;
    public function __construct($meeting_hall_screen, $document)
    {
        $this->meeting_hall_screen = $meeting_hall_screen;
        $this->document = $document;
    }
    public function broadcastOn(): array
    {
        return [
            new Channel('service.screen.document.'.$this->meeting_hall_screen->code),
        ];
    }
    public function broadcastAs(): string
    {
        return 'document-event';
    }
    public function broadcastWith () {
        try {
            return [
                'document' => $this->document,
            ];
        } catch (\Exception $e) {
            return [
                'document' => null,
            ];
        }
    }
}
