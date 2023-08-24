<?php

namespace App\Events\Service\Screen;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuestionsEvent implements ShouldBroadcast
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
            new Channel('service.screen.questions.'.$this->meeting_hall_screen->code),
        ];
    }
    public function broadcastAs(): string
    {
        return 'questions-event';
    }
    public function broadcastWith () {
        try {
            $session = $this->meeting_hall_screen->hall->programs()->where('is_started', true)->first()->sessions->where('on_air', true)->first();
            return [
                'meeting_hall_screen' => $this->meeting_hall_screen,
                'questions' => $session->questions()->where('selected_for_show', true)->with('questioner')->get(),
            ];
        } catch (\Exception $e) {
            return [
                'meeting_hall_screen' => $this->meeting_hall_screen,
                'questions' => null,
            ];
        }
    }}
