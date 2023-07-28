<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program\Session\Question;

use App\Http\Controllers\Controller;
use App\Models\Meeting\Hall\Program\Session\Question\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(Request $request, string $meeting_hall_id)
    {

        $meeting_hall = $request->user()->meeting->halls()->findOrFail($meeting_hall_id);
        $session = $meeting_hall->programSessions()->where('is_started',1)->first();
        $question = new Question();
        $question->session_id = $session->id;
        $question->owner_id = $request->user()->id;
        $question->title = $request->title;
        $question->status = 1;
        if ($question->save()) {
            $question->created_by = $request->user()->id;
            $question->save();
            return json_encode(array("success"=> "success"));
        } else {
            return json_encode(array("error"=> "error"));
        }

    }
}
