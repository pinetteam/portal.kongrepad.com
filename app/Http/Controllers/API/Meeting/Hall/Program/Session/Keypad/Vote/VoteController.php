<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program\Session\Keypad\Vote;

use App\Http\Controllers\Controller;
use App\Http\Traits\ParticipantLog;
use App\Models\Meeting\Hall\Program\Session\Keypad\Vote\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VoteController extends Controller
{
    use ParticipantLog;

    /**
     * Store the participant's vote for a keypad session.
     *
     * @param Request $request
     * @param int $keypad
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, int $keypad)
    {
        // Get the keypad instance
        $keypadInstance = $request->user()->meeting->keypads()->where('id', $keypad)->first();

        // Check if the user has already voted
        if ($keypadInstance->votes()->where('participant_id', $request->user()->id)->exists()) {
            return response()->json([
                'data' => null,
                'status' => false,
                'errors' => ["You have already voted in this keypad session!"]
            ], 400); // Bad Request
        }

        // Check if the voting session is still active
        if ($keypadInstance->on_vote == 0) {
            return response()->json([
                'data' => null,
                'status' => false,
                'errors' => ["This keypad voting session has ended!"]
            ], 400); // Bad Request
        }

        // Create a new vote
        $vote = new Vote();
        $vote->option_id = $request->input('option');
        $vote->participant_id = $request->user()->id;
        $vote->keypad_id = $keypad;

        try {
            // Save the vote
            $vote->save();

            // Log the participant's action
            $this->logParticipantAction(
                $request->user(),
                "send-keypad-vote",
                $keypadInstance->title
            );

            // Return success response
            return response()->json([
                'data' => null,
                'status' => true,
                'errors' => null
            ], 200);

        } catch (\Throwable $e) {
            // Log the error
            Log::error('Keypad VoteController Error: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'data' => null,
                'status' => false,
                'errors' => ['An error occurred while saving your vote. Please try again.']
            ], 500); // Internal Server Error
        }
    }
}
