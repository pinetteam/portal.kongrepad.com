<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program\Session\Question;

use App\Events\Service\QuestionBoard\QuestionBoardEvent;
use App\Http\Controllers\Controller;
use App\Http\Traits\ParticipantLog;
use App\Models\Meeting\Hall\Program\Session\Question\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    use ParticipantLog;

    /**
     * Store a question for the current session.
     *
     * @param Request $request
     * @param int $hall
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, int $hall)
    {
        // Fetch the meeting hall
        $meeting_hall = $request->user()->meeting->halls()->findOrFail($hall);

        // Check if the user is an attendee
        if ($request->user()->type != 'attendee') {
            return response()->json([
                'data' => null,
                'status' => false,
                'errors' => ["You do not have permission to ask a question."]
            ], 403); // Forbidden
        }

        // Get the active session
        $session = $meeting_hall->programSessions()->where('on_air', 1)->firstOrFail();

        // Create a new question
        $question = new Question();
        $question->session_id = $session->id;
        $question->questioner_id = $request->user()->id;
        $question->is_hidden_name = $request->input('is_hidden_name');
        $question->question = $request->input('question');

        try {
            // Log participant action
            $this->logParticipantAction($request->user(), "ask-question", __('common.session') . ': ' . $session->title);

            // Save the question and trigger the event
            $question->save();
            event(new QuestionBoardEvent($meeting_hall));

            // Return success response
            return response()->json([
                'data' => true,
                'status' => true,
                'errors' => null
            ], 200);

        } catch (\Throwable $e) {
            // Log the error
            Log::error('QuestionController Error: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ], 500); // Internal Server Error
        }
    }
}
