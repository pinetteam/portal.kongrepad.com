<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Program\Session\Question;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Program\Session\Question\QuestionRequest;
use App\Http\Resources\Portal\Meeting\Hall\Program\Session\Question\QuestionResource;
use App\Models\Meeting\Hall\Program\Session\Question\Question;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function store(QuestionRequest $request)
    {
        if ($request->validated()) {
            $question = new Question();
            $question->session_id = $request->input('session_id');
            $question->owner_id = $request->input('owner_id');
            $question->sort_order = $request->input('sort_order');
            $question->title = $request->input('title');
            $question->status = $request->input('status');
            if ($question->save()) {
                $question->created_by = Auth::user()->id;
                $question->save();
                return back()->with('success',__('common.created-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(string $id)
    {
        $question = Auth::user()->customer->sessionQuestions()->findOrFail($id);
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.survey.question.show', compact(['question', 'statuses']));
    }
    public function edit(string $id)
    {
        $question = Auth::user()->customer->sessionQuestions()->findOrFail($id);
        return new QuestionResource($question);
    }
    public function update(QuestionRequest $request, string $id)
    {
        if ($request->validated()) {
            $question = Auth::user()->customer->sessionQuestions()->findOrFail($id);
            $question->session_id = $request->input('session_id');
            $question->owner_id = $request->input('owner_id');
            $question->sort_order = $request->input('sort_order');
            $question->title = $request->input('title');
            $question->status = $request->input('status');
            if ($question->save()) {
                $question->updated_by = Auth::user()->id;
                $question->save();
                return back()->with('success',__('common.created-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(string $id)
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

    public function on_screen(string $id)
    {
        $question = Auth::user()->customer->sessionQuestions()->findOrFail($id);
        $session = Auth::user()->customer->programSessions()->findOrFail($question->session_id);
        if(!$question->on_screen && $session->questions()->where('on_screen',1)->count() >= $session->question_limit){
            return back()->with('error', __('common.you-have-reached-the-question-limit'));
        }
        $question->on_screen = !$question->on_screen;
        if (!$question->save()) {
            return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
        } else {
            return back();
        }
    }
}
