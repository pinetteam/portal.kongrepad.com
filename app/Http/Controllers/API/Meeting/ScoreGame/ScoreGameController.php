<?php

namespace App\Http\Controllers\API\Meeting\ScoreGame;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\ScoreGame\ScoreGameResource;
use App\Http\Traits\ParticipantLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ScoreGameController extends Controller
{
    use ParticipantLog;

    /**
     * Get the score games for the meeting.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            // Get the meeting and score games
            $meeting = $request->user()->meeting;

            // Log participant action
            $this->logParticipantAction($request->user(), "get-score-games", __('common.meeting') . ': ' . $meeting->title);

            // Return the first score game
            return response()->json([
                'data' => new ScoreGameResource($meeting->scoreGames()->first()),
                'status' => true,
                'errors' => null
            ], 200);

        } catch (\Throwable $e) {
            Log::error('ScoreGameController Error (index): ' . $e->getMessage());

            // Return error response
            return response()->json([
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }
}
