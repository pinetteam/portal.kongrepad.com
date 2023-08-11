<?php

namespace App\Http\Controllers\Portal\Meeting\Survey\Question\Option;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Survey\Question\Option\OptionRequest;
use App\Http\Resources\Portal\Meeting\Survey\Question\Option\OptionResource;
use App\Models\Meeting\Survey\Question\Option\Option;
use Illuminate\Support\Facades\Auth;

class OptionController extends Controller
{
    public function store(OptionRequest $request)
    {

        if ($request->validated()) {
            $option = new Option();
            $option->survey_id = $request->input('survey_id');
            $option->question_id = $request->input('question_id');
            $option->option = $request->input('option');
            $option->sort_order = $request->input('sort_order');
            $option->status= $request->input('status');
            if ($option->save()) {
                $option->created_by = Auth::user()->id;
                $option->save();
                return back()->with('success',__('common.created-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function edit(string $meeting_id, string $survey_id, string $question_id, string $id)
    {
        $option = Auth::user()->customer->surveyOptions()->findOrFail($id);
        return new OptionResource($option);
    }
    public function update(OptionRequest $request, string $meeting_id, string $survey_id, string $question_id, string $id)
    {
        if ($request->validated()) {
            $option = Auth::user()->customer->surveyOptions()->findOrFail($id);
            $option->question_id = $request->input('question_id');
            $option->sort_order = $request->input('sort_order');
            $option->status= $request->input('status');
            $option->option = $request->input('option');
            if ($option->save()) {
                $option->updated_by = Auth::user()->id;
                $option->save();
                return back()->with('success',__('common.created-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(string $meeting_id, string $survey_id, string $question_id, string $id)
    {
        $option = Auth::user()->customer->surveyOptions()->findOrFail($id);
        if ($option->delete()) {
            $option->deleted_by = Auth::user()->id;
            $option->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
