<?php

namespace App\Http\Controllers\API\Meeting\Survey;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Survey\SurveyResource;
use App\Http\Traits\ParticipantLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SurveyController extends Controller
{
    use ParticipantLog;

    /**
     * Get the list of surveys for the meeting.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            // Get the meeting and surveys
            $meeting = $request->user()->meeting;

            // Log participant action
            $this->logParticipantAction($request->user(), "get-surveys", __('common.meeting') . ': ' . $meeting->title);

            // Return surveys
            return response()->json([
                'data' => SurveyResource::collection($meeting->surveys()->get())->additional(['some_id' => 1]),
                'status' => true,
                'errors' => null
            ], 200);

        } catch (\Throwable $e) {
            Log::error('SurveyController Error (index): ' . $e->getMessage());

            // Return error response
            return response()->json([
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }

    /**
     * Get a specific survey by its ID.
     *
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, string $id)
    {
        try {
            // Fetch the survey
            $survey = $request->user()->meeting->surveys()->findOrFail($id);

            // Log participant action
            $this->logParticipantAction($request->user(), "get-survey", $survey->title);

            // Return survey details
            return response()->json([
                'data' => new SurveyResource($survey),
                'status' => true,
                'errors' => null
            ], 200);

        } catch (\Throwable $e) {
            Log::error('SurveyController Error (show): ' . $e->getMessage());

            // Return error response
            return response()->json([
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }
}
