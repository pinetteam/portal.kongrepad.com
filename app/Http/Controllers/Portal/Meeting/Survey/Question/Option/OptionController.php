<?php

namespace App\Http\Controllers\Portal\Meeting\Survey\Question\Option;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Survey\Question\Option\OptionRequest;
use App\Http\Resources\Portal\Meeting\Survey\Question\Option\OptionResource;
use App\Models\Meeting\Survey\Question\Option\Option;
use Illuminate\Support\Facades\Auth;

class OptionController extends Controller
{
    public function store(OptionRequest $request, int $meeting, int $survey, int $question)
    {
        if ($request->validated()) {
            $option = new Option();
            $option->sort_order = $request->input('sort_order');
            $option->question_id = $question;
            $option->option = $request->input('option');
            $option->status= $request->input('status');
            if ($option->save()) {
                $option->created_by = Auth::user()->id;
                $option->save();
                return back()->with('success',__('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function edit(int $meeting, int $survey, int $question, int $id)
    {
        $question = Auth::user()->customer->surveyQuestions()->findOrFail($question);
        $option = $question->options()->findOrFail($id);
        return new OptionResource($option);
    }
    public function update(OptionRequest $request, int $meeting, int $survey, int $question, int $id)
    {
        if ($request->validated()) {
            $option = Auth::user()->customer->surveyOptions()->findOrFail($id);
            $option->sort_order = $request->input('sort_order');
            $option->question_id = $request->input('question_id');
            $option->status= $request->input('status');
            $option->option = $request->input('option');
            if ($option->save()) {
                $option->updated_by = Auth::user()->id;
                $option->save();
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(int $meeting, int $survey, int $question, int $id)
    {
        $question = Auth::user()->customer->surveyQuestions()->findOrFail($question);
        $option = $question->options()->findOrFail($id);
        if ($option->delete()) {
            $option->deleted_by = Auth::user()->id;
            $option->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
