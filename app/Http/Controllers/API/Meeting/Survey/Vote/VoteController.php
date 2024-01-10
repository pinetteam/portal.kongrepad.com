<?php

namespace App\Http\Controllers\API\Meeting\Survey\Vote;

use App\Http\Controllers\Controller;
use App\Models\Meeting\Survey\Vote\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function store(Request $request, int $survey){

        $survey = $request->user()->meeting->surveys()->findOrFail($survey);
        $options = explode(',', str_replace(['[',"]"],"",$request->input('options')));
        $log = new \App\Models\Log\Meeting\Participant\Participant();
        $log->participant_id = $request->user()->id;
        $log->action = "vote-survey";
        $log->save();
        foreach ($options as $option){
            $vote = new Vote();
            $vote->option_id = $option;
            $vote->participant_id = $request->user()->id;
            $vote->survey_id = $survey->id;
            $question = $survey->options()->findOrFail($option)->question->id;
            $vote->question_id = $question;
            try{
                $vote->save();
            } catch (\Throwable $e){
                return [
                    'data' => null,
                    'status' => false,
                    'errors' => [$e->getMessage()]
                ];
            }
        }
        return [
            'data' => null,
            'status' => true,
            'errors' => null
        ];
    }
}

