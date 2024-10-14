<?php

namespace App\Http\Controllers\API\Meeting\Survey\Vote;

use App\Http\Controllers\Controller;
use App\Http\Traits\ParticipantLog;
use App\Models\Meeting\Survey\Vote\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VoteController extends Controller
{
    use ParticipantLog;

    /**
     * Store a new vote for the survey.
     *
     * @param Request $request
     * @param int $survey
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, int $survey)
    {
        try {
            // Fetch the survey
            $survey = $request->user()->meeting->surveys()->findOrFail($survey);

            // Parse the options from the request
            $options = explode(',', str_replace(['[', ']'], "", $request->input('options')));

            // Log participant action
            $this->logParticipantAction($request->user(), "vote-survey", __('common.survey') . ': ' . $survey->title);

            // Process each vote
            foreach ($options as $option) {
                $vote = new Vote();
                $vote->option_id = $option;
                $vote->participant_id = $request->user()->id;
                $vote->survey_id = $survey->id;

                // Fetch the associated question for the option
                $question = $survey->options()->findOrFail($option)->question->id;
                $vote->question_id = $question;

                // Save the vote
                $vote->save();
            }

            // Return success response
            return response()->json([
                'data' => null,
                'status' => true,
                'errors' => null
            ], 200);

        } catch (\Throwable $e) {
            Log::error('VoteController Error (store): ' . $e->getMessage());

            // Return error response
            return response()->json([
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }
}
