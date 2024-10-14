<?php

namespace App\Http\Controllers\API\Meeting\Participant;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Participant\ParticipantResource;
use App\Http\Traits\ParticipantLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ParticipantController extends Controller
{
    use ParticipantLog;

    /**
     * Get the details of the authenticated participant.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            // Get the authenticated participant
            $participant = $request->user();

            // Log participant action
            $this->logParticipantAction($participant, "get-participant", $participant->full_name);

            // Return participant details
            return response()->json([
                'data' => new ParticipantResource($participant),
                'status' => true,
                'errors' => null
            ], 200);

        } catch (\Throwable $e) {
            // Log the error
            Log::error('ParticipantController Error: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }
}
