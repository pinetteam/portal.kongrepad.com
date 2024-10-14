<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\ParticipantLog;
use App\Models\Meeting\Participant\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    use ParticipantLog;

    /**
     * Authenticate participant and return token.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function participant(Request $request)
    {
        // Validate the input
        $request->validate([
            'username' => 'required|string',
        ]);

        // Fetch participant by username
        $participant = Participant::where('username', $request->username)->first();

        // If participant does not exist
        if (!$participant) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.'
            ], 401); // Unauthorized status code
        }

        // Create API token
        $participant_token = $participant->createToken('api-token')->plainTextToken;

        // Update participant details
        $participant->gdpr_consent = true;
        $participant->enrolled = true;
        $participant->save();

        // Log participant login
        $this->logParticipantAction($participant, "login", $participant->full_name);

        // Return token with success status
        return response()->json(['token' => $participant_token], 200);
    }
}
