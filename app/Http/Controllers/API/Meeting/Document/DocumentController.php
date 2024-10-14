<?php

namespace App\Http\Controllers\API\Meeting\Document;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Document\DocumentResource;
use App\Http\Traits\ParticipantLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DocumentController extends Controller
{
    use ParticipantLog;

    /**
     * Get the documents for the user's meeting.
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
                "get-documents",
                __('common.meeting') . ': ' . $meeting->title
            );

            // Fetch and return documents
            return response()->json([
                'data' => DocumentResource::collection($meeting->documents()->orderBy('created_at', 'desc')->get()),
                'status' => true,
                'errors' => null
            ], 200);

        } catch (\Throwable $e) {
            // Log the error
            Log::error('DocumentController Error: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }
}
