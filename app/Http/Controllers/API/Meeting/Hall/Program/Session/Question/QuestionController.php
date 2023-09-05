<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program\Session\Question;

use App\Http\Controllers\Controller;
use App\Models\Meeting\Hall\Program\Session\Question\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(Request $request, int $hall)
    {
        $meeting_hall = $request->user()->meeting->halls()->findOrFail($hall);
        $session = $meeting_hall->programSessions()->where('is_started', 1)->first();
        $question = new Question();
        $question->session_id = $session->id;
        $question->questioner_id = $request->user()->id;
        $question->is_hidden_name = $request->input('is_hidden_name');
        $question->question = $request->input('question');
        try{
            return [
                'data' => $question->save(),
                'status' => true,
                'errors' => null
            ];
        } catch (\Throwable $e){

            return [
                'data' => null,
                'status' => false,
                'errors' => "error"
            ];
        }
    }
}
