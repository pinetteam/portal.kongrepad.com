<?php

namespace App\Http\Controllers\API\Meeting\Survey\Question\Option;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index(Request $request, string $meeting_id, string $survey_id, string $question_id){
        return $request->user()->meeting->surveys()->where('meeting_surveys.id',$survey_id)->first()->questions()->where('meeting_survey_questions.id', $question_id)->first()->options()->get();
    }
}
