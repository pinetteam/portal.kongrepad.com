<?php

namespace App\Http\Controllers\Portal\Report\Question;

use App\Http\Controllers\Controller;
use App\Models\Meeting\Participant\Participant;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index()
    {
        $participants = Auth::user()->customer->participants()->get();
        $participants = $participants->sortByDesc(function ($participant){
            return $participant->sessionQuestions()->where([['is_hidden_name', 0], ['selected_for_show', 1]])->count();
        });
        return view('portal.report.question.index', compact(['participants']));
    }
}
