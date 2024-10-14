<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program\Debate\Vote;

use App\Http\Controllers\Controller;
use App\Http\Traits\ParticipantLog;
use App\Models\Meeting\Hall\Program\Debate\Vote\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VoteController extends Controller
{
    use ParticipantLog;

    /**
     * Store the participant's vote for a debate.
     *
     * @param Request $request
     * @param int $debate
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, int $debate)
    {
        // Get the debate the user is voting on
        $debateInstance = $request->user()->meeting->debates()->where('id', $debate)->first();

        // Check if the user has already voted in this debate
        if ($debateInstance->votes()->where('participant_id', $request->user()->id)->exists()) {
            return response()->json([
                'data' => null,
                'status' => false,
                'errors' => ["You have already voted in this debate!"]
            ], 400); // Bad Request
        }

        // Create a new vote
        $vote = new Vote();
        $vote->team_id = $request->input('team');
        $vote->participant_id = $request->user()->id;
        $vote->debate_id = $debate;

        try {
            // Save the vote
            $vote->save();

            // Log the participant's action
            $this->logParticipantAction(
                $request->user(),
                "send-debate-vote",
                $debateInstance->title
            );

            // Return success response
            return response()->json([
                'data' => null,
                'status' => true,
                'errors' => null
            ], 200);

        } catch (\Throwable $e) {
            // Log the error
            Log::error('VoteController Error: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'data' => null,
                'status' => false,
                'errors' => ['An error occurred while saving your vote. Please try again.']
            ], 500); // Internal Server Error
        }
    }
}
