<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Program\Session\Question;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Program\Session\Question\QuestionRequest;
use App\Models\Meeting\Hall\Program\Session\Question\Question;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function destroy(int $meeting, int $hall, int $program, int $session, int $id)
    {
        $question = Auth::user()->customer->sessionQuestions()->findOrFail($id);
        if ($question->delete()) {
            $question->deleted_by = Auth::user()->id;
            $question->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }

   public function on_screen(int $id)
    {
        $question = Auth::user()->customer->sessionQuestions()->findOrFail($id);
        $session = Auth::user()->customer->programSessions()->findOrFail($question->session_id);
        if(!$question->selected_for_show && $session->questions()->where('selected_for_show',1)->count() >= $session->questions_limit){
            return back()->with('error', __('common.you-have-reached-the-question-limit'));
        }
        $question->selected_for_show = !$question->selected_for_show;
        if (!$question->save()) {
            return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
        } else {
            return back();
        }
    }
}
