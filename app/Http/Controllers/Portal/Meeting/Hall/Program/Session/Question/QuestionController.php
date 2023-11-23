<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Program\Session\Question;

use App\Events\Service\Screen\QuestionsEvent;
use App\Http\Controllers\Controller;
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
        $hall = $session->program->hall;
        if(!$question->selected_for_show && $session->questions()->where('selected_for_show', true)->count() >= $session->questions_limit){
            return back()->with('error', 'Soru limitine ulaştınız');
        }
        $question->selected_for_show = !$question->selected_for_show;
        $question->is_deselected = !$question->selected_for_show;
        if (!$question->save()) {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        } else {
            $meeting_hall_screen = $hall->screens()->where('type', 'questions')->first();
            event(new QuestionsEvent($meeting_hall_screen));
            return back();
        }
    }
}
