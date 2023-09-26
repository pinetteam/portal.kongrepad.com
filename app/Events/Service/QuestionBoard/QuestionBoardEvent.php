<?php

namespace App\Events\Service\QuestionBoard;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuestionBoardEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $hall;
    public function __construct($hall)
    {
        $this->hall = $hall;
    }
    public function broadcastOn(): array
    {
        return [
            new Channel('service.screen.question-board.' . $this->hall->code),
        ];
    }
    public function broadcastAs(): string
    {
        return 'question-board-event';
    }
    public function broadcastWith () {
        try {
            $session = $this->hall->programSessions()->where('on_air', true)->first();
            if($session && $session->questions) {
                return [
                    'questions' => $session->questions()->where('selected_for_show', false)->with('questioner')->get(),
                    'selected_questions' => $session->questions()->where('selected_for_show', true)->with('questioner')->get(),
                ];
            } else {
                return [
                    'questions' => null,
                    'selected_questions' => null,
                ];
            }
        } catch (\Exception $e) {
            return [
                'questions' => null,
                'selected_questions' => null,
            ];
        }
    }
}
