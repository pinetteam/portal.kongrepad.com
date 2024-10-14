<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Program\Session\Question;

use App\Events\Service\Screen\QuestionsEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Log\Meeting\Hall\Program\Session\Question\Question as QuestionLog; // Log modelini ekle

class QuestionController extends Controller
{
    public function destroy(int $meeting, int $hall, int $program, int $session, int $id)
    {
        $question = $this->getQuestionById($id);

        if ($question->delete()) {
            $question->deleted_by = Auth::user()->id; // Silen kullanıcının ID'sini atayın
            $question->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }

    public function on_screen(int $id)
    {
        $question = $this->getQuestionById($id);
        $session = $this->getSessionByQuestion($question);
        $hall = $session->program->hall;

        if (!$this->canSelectQuestion($question, $session)) {
            return back()->with('error', 'Soru limitine ulaştınız');
        }

        $question->selected_for_show = !$question->selected_for_show; // Durumu tersine çevir
        $this->logQuestionAction($question); // Log işlemini yapın

        if (!$question->save()) {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }

        // Event gönderimi
        $meeting_hall_screen = $hall->screens()->where('type', 'questions')->first();
        event(new QuestionsEvent($meeting_hall_screen));

        return back();
    }

    private function getQuestionById(int $id)
    {
        return Auth::user()->customer->sessionQuestions()->findOrFail($id);
    }

    private function getSessionByQuestion($question)
    {
        return Auth::user()->customer->programSessions()->findOrFail($question->session_id);
    }

    private function canSelectQuestion($question, $session)
    {
        return $question->selected_for_show || $session->questions()->where('selected_for_show', true)->count() < $session->questions_limit;
    }

    private function logQuestionAction($question)
    {
        $question_log = new QuestionLog(); // Log modeline erişim
        $question_log->question_id = $question->id;
        $question_log->created_by = Auth::user()->id;
        $question_log->action = $question->selected_for_show ? 'select' : 'deselect';
        $question_log->save();
    }
}
