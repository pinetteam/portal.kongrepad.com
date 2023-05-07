<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Stage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Stage\StageRequest;
use App\Http\Resources\Portal\Meeting\Hall\Stage\StageResource;
use App\Models\Meeting\Hall\Stage\Stage;
use Illuminate\Support\Facades\Auth;

class StageController extends Controller
{
    public function index()
    {
        $meeting_halls = Auth::user()->customer->meetingHalls()->get();
        $stages = Auth::user()->customer->stages()->where('stages.status', 1)->paginate(20);
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.stage.index', compact(['stages', 'statuses', 'meeting_halls']));
    }
    public function store(StageRequest $request)
    {
        if ($request->validated()) {
            $stage = new Stage();
            $stage->meeting_hall_id = $request->input('meeting_hall_id');
            $stage->title = $request->input('title');
            $stage->status = $request->input('status');
            if ($stage->save()) {
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(string $id)
    {
        $stage = Auth::user()->customer->stages()->findOrFail($id);
        $stages = Auth::user()->customer->stages()->where('stages.status', 1)->get();
        $stage_podiums = $stage->podiums()->get();
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.stage.show', compact(['stage', 'stages', 'stage_podiums', 'statuses']));

    }
    public function edit(string $id)
    {
        $stage = Auth::user()->customer->meetingHalls()->findOrFail($id);
        return new StageResource($stage);
    }
    public function update(StageRequest $request, string $id)
    {
        if ($request->validated()) {
            $stage = Auth::user()->customer->stages()->findOrFail($id);
            $stage->meeting_hall_id = $request->input('meeting_hall_id');
            $stage->title = $request->input('title');
            $stage->status = $request->input('status');
            if ($stage->save()) {
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(string $id)
    {
        $stage = Auth::user()->customer->stages()->findOrFail($id);
        if ($stage->delete()) {
            $stage->deleted_by = Auth::user()->id;
            $stage->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
