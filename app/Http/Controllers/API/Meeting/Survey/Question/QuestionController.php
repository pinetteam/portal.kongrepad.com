<?php

namespace App\Http\Controllers\API\Meeting\Survey\Question;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Survey\Question\QuestionRequest;
use App\Http\Resources\Portal\Meeting\Survey\Question\QuestionResource;
use App\Models\Meeting\Survey\Question\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index(Request $request, string $meeting_id, string $survey_id){
        return $request->user()->meeting->surveys()->where('meeting_surveys.id',$survey_id)->first()->questions()->get();
    }
}
