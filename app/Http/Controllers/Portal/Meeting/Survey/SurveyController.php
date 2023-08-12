<?php

namespace App\Http\Controllers\Portal\Meeting\Survey;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Survey\SurveyRequest;
use App\Http\Resources\Portal\Meeting\Survey\SurveyResource;
use App\Models\Customer\Setting\Variable\Variable;
use App\Models\Meeting\Survey\Survey;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function index(int $meeting)
    {

        $surveys = Auth::user()->customer->surveys()->where('meeting_id', $meeting)->paginate(20);
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $statuses = [
            'passive' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'active' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];

        return view('portal.meeting.survey.index', compact(['surveys', 'meeting', 'statuses']));
    }
    public function store(SurveyRequest $request, int $meeting)
    {
        if ($request->validated()) {
            $survey = new Survey();
            $survey->meeting_id = $meeting;
            $survey->sort_order = $request->input('sort_order');
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
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(int $meeting, int $id)
    {
        $survey = Auth::user()->customer->surveys()->where('meeting_id', $meeting)->findOrFail($id);
        $questions = $survey->questions()->get();
        $questionCount= $questions->count();
        $statuses = [
            'passive' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'active' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.survey.show', compact(['questions', 'survey', 'questionCount', 'statuses']));
    }
    public function edit(string $meeting, string $id)
    {
        $survey = Auth::user()->customer->surveys()->where('meeting_id', $meeting)->findOrFail($id);
        return new SurveyResource($survey);
    }
    public function update(SurveyRequest $request, int $meeting, int $id)
    {
        if ($request->validated()) {
            $survey = Auth::user()->customer->surveys()->where('meeting_id', $meeting)->findOrFail($id);
            $survey->meeting_id = $meeting;
            $survey->sort_order = $request->input('sort_order');
            $survey->title = $request->input('title');
            $survey->description = $request->input('description');
            $survey->start_at = $request->input('start_at');
            $survey->finish_at = $request->input('finish_at');
            $survey->status = $request->input('status');
            if ($survey->save()) {
                $survey->updated_by = Auth::user()->id;
                $survey->save();
                return back()->with('success',__('common.created-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(int $meeting, int $id)
    {
        $survey = Auth::user()->customer->surveys()->where('meeting_id', $meeting)->findOrFail($id);
        if ($survey->delete()) {
            $survey->deleted_by = Auth::user()->id;
            $survey->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }

    public function start_stop(string $meeting, string $id)
    {
        $survey = Auth::user()->customer->surveys()->findOrFail($id);
        $survey->on_vote = !$survey->on_vote;
        if ($survey->save()) {
            if($survey->on_vote){
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
