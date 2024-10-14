<?php

namespace App\Http\Controllers\API\Meeting\Survey\Question;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Survey\Question\QuestionResource;
use App\Http\Traits\ParticipantLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    use ParticipantLog;

    /**
     * Get the list of questions for a specific survey.
     *
     * @param Request $request
     * @param int $survey
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, int $survey)
    {
        try {
            // Fetch the survey
            $survey = $request->user()->meeting->surveys()->findOrFail($survey);

            // Log participant action
            $this->logParticipantAction($request->user(), "get-survey-questions", __('common.survey') . ': ' . $survey->title);

            // Return the active questions
            return response()->json([
                'data' => QuestionResource::collection($survey->questions()->where('status', 1)->get()),
                'status' => true,
                'errors' => null
            ], 200);

        } catch (\Throwable $e) {
            Log::error('QuestionController Error (index): ' . $e->getMessage());

            // Return error response
            return response()->json([
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }

    /**
     * Get a specific question from the survey.
     *
     * @param Request $request
     * @param int $survey
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, int $survey, int $id)
    {
        try {
            // Fetch the question for the survey
            $question = $request->user()->meeting->surveys()->findOrFail($survey)->questions()->findOrFail($id);

            // Log participant action
            $this->logParticipantAction($request->user(), "get-survey-question", $question->title);

            // Return the question details
            return response()->json([
                'data' => new QuestionResource($question),
                'status' => true,
                'errors' => null
            ], 200);

        } catch (\Throwable $e) {
            Log::error('QuestionController Error (show): ' . $e->getMessage());

            // Return error response
            return response()->json([
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }
}
