<?php

namespace App\Http\Controllers\API\Meeting;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\MeetingResource;
use App\Http\Traits\ParticipantLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MeetingController extends Controller
{
    use ParticipantLog;

    /**
     * Get the current meeting for the user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            // Get the user's meeting
            $meeting = $request->user()->meeting;

            // Log participant action
            $this->logParticipantAction($request->user(), "get-meeting", $meeting->title);

            // Return the meeting details
            return response()->json([
                'data' => new MeetingResource($meeting),
                'status' => true,
                'errors' => null
            ], 200);

        } catch (\Throwable $e) {
            Log::error('MeetingController Error (index): ' . $e->getMessage());

            // Return error response
            return response()->json([
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }
}
