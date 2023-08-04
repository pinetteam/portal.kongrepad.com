<?php

namespace App\Http\Controllers\API\Meeting\Survey\Question;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Request $request, string $meeting_id, string $survey_id){
        return $request->user()->meeting->surveys()->where('meeting_surveys.id',$survey_id)->first()->questions()->get();
    }
}
