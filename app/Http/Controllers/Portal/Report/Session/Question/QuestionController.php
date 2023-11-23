<?php

namespace App\Http\Controllers\Portal\Report\Session\Question;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index(int $meeting, int $hall, int $session)
    {
        $session = Auth::user()->customer->programSessions()->findOrFail($session);
        $questions = $session->questions()->orderBy('created_at', 'ASC')->paginate(10);
        return view('portal.meeting.hall.report.session.question.index', compact(['session', 'questions']));
    }
}
