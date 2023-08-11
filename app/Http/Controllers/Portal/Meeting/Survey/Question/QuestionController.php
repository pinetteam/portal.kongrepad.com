<?php

namespace App\Http\Controllers\Portal\Meeting\Survey\Question;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Survey\Question\QuestionRequest;
use App\Http\Resources\Portal\Meeting\Survey\Question\QuestionResource;
use App\Models\Meeting\Survey\Question\Question;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function store(QuestionRequest $request)
    {
        if ($request->validated()) {
            $question = new Question();
            $question->survey_id = $request->input('survey_id');
            $question->sort_order = $request->input('sort_order');
            $question->question = $request->input('question');
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
    public function show(string $meeting, string $survey, string $id)
    {
        $question = Auth::user()->customer->surveyQuestions()->findOrFail($id);
        $options = $question->options()->get();
        $statuses = [
            'passive' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'active' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.survey.question.show', compact(['question', 'options', 'statuses']));
    }
    public function edit(string $meeting, string $survey, string $id)
    {
        $question = Auth::user()->customer->surveyQuestions()->findOrFail($id);
        return new QuestionResource($question);
    }
    public function update(QuestionRequest $request, string $meeting, string $survey, string $id)
    {
        if ($request->validated()) {
            $question = Auth::user()->customer->surveyQuestions()->findOrFail($id);
            $question->survey_id = $request->input('survey_id');
            $question->sort_order = $request->input('sort_order');
            $question->question = $request->input('question');
            $question->status = $request->input('status');
            if ($question->save()) {
                $question->updated_by = Auth::user()->id;
                $question->save();
                return back()->with('success', __('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(string $meeting, string $survey, string $id)
    {
        $question = Auth::user()->customer->surveyQuestions()->findOrFail($id);
        if ($question->delete()) {
            $question->deleted_by = Auth::user()->id;
            $question->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
