<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\Meeting\Hall\Hall;

class QuestionBoardController extends Controller
{
    public function index(string $code)
    {
        $hall = Hall::where('code', $code)->first();
        $session = $hall->programSessions()->where('meeting_hall_program_sessions.on_air', 1)->first();
        $questions = $session ? $session->questions()->where('selected_for_show', false)->get() : null;
        $selected_questions = $session ? $session->questions()->where('selected_for_show', true)->get() : null;
        return view('service.question-board.index', compact(['hall', 'session', 'questions', 'selected_questions']));
    }
}
