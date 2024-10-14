<?php

namespace App\Events\Service\QuestionBoard;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Meeting\Hall\Hall;
use Illuminate\Support\Facades\Log;

class QuestionBoardEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The hall instance.
     *
     * @var Hall
     */
    public Hall $hall;

    /**
     * Create a new event instance.
     *
     * @param Hall $hall
     */
    public function __construct(Hall $hall)
    {
        $this->hall = $hall;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('service.screen.question-board.' . $this->hall->code),
        ];
    }

    /**
     * Get the event name for broadcasting.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'question-board-event';
    }

    /**
     * Get the data to broadcast with.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        try {
            $session = $this->hall->programSessions()->where('on_air', true)->first();
            if ($session && $session->questions) {
                return [
                    'questions' => $session->questions->toArray(),
                    'selected_questions' => $session->selectedQuestions ? $session->selectedQuestions->toArray() : null,
                ];
            } else {
                return [
                    'questions' => null,
                    'selected_questions' => null,
                ];
            }
        } catch (\Exception $e) {
            Log::error('QuestionBoardEvent Error: ' . $e->getMessage());
            return [
                'questions' => null,
                'selected_questions' => null,
            ];
        }
    }
}
