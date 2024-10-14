<?php

namespace App\Http\Controllers\API\Meeting\Announcement;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Announcement\AnnouncementResource;
use App\Http\Traits\ParticipantLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AnnouncementController extends Controller
{
    use ParticipantLog;

    /**
     * Get the announcements for the user's meeting.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            // Get the meeting from the authenticated user
            $meeting = $request->user()->meeting;

            // Log participant action
            $this->logParticipantAction(
                $request->user(),
                "get-announcements",
                __('common.meeting') . ': ' . $meeting->title
            );

            // Return the announcements
            return response()->json([
                'data' => AnnouncementResource::collection($meeting->announcements()->orderBy('created_at', 'desc')->get()),
                'status' => true,
                'errors' => null
            ], 200);

        } catch (\Throwable $e) {
            // Log the error
            Log::error('AnnouncementController Error: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }
}
