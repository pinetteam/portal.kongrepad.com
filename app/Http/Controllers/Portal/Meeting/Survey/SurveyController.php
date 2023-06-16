<?php

namespace App\Http\Controllers\Portal\Meeting\Survey;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Survey\SurveyRequest;
use App\Http\Resources\Portal\Meeting\Survey\SurveyResource;
use App\Models\Meeting\Survey\Survey;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function store(SurveyRequest $request, string $meeting_id)
    {
        if ($request->validated()) {
            $survey = new Survey();
            $survey->meeting_id = $request->input('meeting_id');
            $survey->sort_order = $request->input('sort_order');
            $survey->code = $request->input('code');
            $survey->title = $request->input('title');
            $survey->description = $request->input('description');
            $survey->start_at = $request->input('start_at');
            $survey->finish_at = $request->input('finish_at');
            $survey->status = $request->input('status');
            if ($survey->save()) {
                $survey->created_by = Auth::user()->id;
                $survey->save();
                return back()->with('success',__('common.created-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(string $meeting_id, string $id)
    {
        $survey = Auth::user()->customer->surveys()->findOrFail($id);
        $questions = $survey->questions()->get();
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.survey.show', compact(['questions', 'survey', 'statuses']));
    }
    public function edit(string $meeting_id, string $id)
    {
        $survey = Auth::user()->customer->surveys()->findOrFail($id);
        return new SurveyResource($survey);
    }
    public function update(SurveyRequest $request, string $meeting_id, string $id)
    {
        if ($request->validated()) {
            $survey = Auth::user()->customer->surveys()->findOrFail($id);
            $survey->meeting_id = $request->input('meeting_id');
            $survey->sort_order = $request->input('sort_order');
            $survey->code = $request->input('code');
            $survey->title = $request->input('title');
            $survey->description = $request->input('description');
            $survey->start_at = $request->input('start_at');
            $survey->finish_at = $request->input('finish_at');
            $survey->status = $request->input('status');
            if ($survey->save()) {
                $survey->edited_by = Auth::user()->id;
                $survey->save();
                return back()->with('success',__('common.created-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(string $meeting_id, string $id)
    {
        $survey = Auth::user()->customer->surveys()->findOrFail($id);
        if ($survey->delete()) {
            $survey->deleted_by = Auth::user()->id;
            $survey->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }

    public function start_stop(string $meeting_id, string $id)
    {
        $survey = Auth::user()->customer->surveys()->findOrFail($id);
        $survey->on_air = !$survey->on_air;
        if ($survey->save()) {
            if($survey->on_air){
                return back()->with('success',__('common.voting-started'));
            }
            else{
                return back()->with('success',__('common.voting-stopped'));
            }
        } else {
            return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
