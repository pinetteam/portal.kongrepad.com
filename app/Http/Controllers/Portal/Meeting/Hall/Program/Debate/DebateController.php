<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Program\Debate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Program\Debate\DebateRequest;
use App\Http\Resources\Portal\Meeting\Hall\Program\Debate\DebateResource;
use App\Models\Meeting\Hall\Program\Debate\Debate;
use Illuminate\Support\Facades\Auth;

class DebateController extends Controller
{
    public function store(DebateRequest $request)
    {
        if ($request->validated()) {
            $debate = new Debate();
            $debate->program_id = $request->input('program_id');
            $debate->sort_order = $request->input('sort_order');
            $debate->code = $request->input('code');
            $debate->title = $request->input('title');
            $debate->description = $request->input('description');
            $debate->voting_started_at = $request->input('voting_started_at');
            $debate->voting_finished_at = $request->input('voting_finished_at');
            $debate->status = $request->input('status');
            if ($debate->save()) {
                return back()->with('success',__('common.created-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(string $id)
    {
        $debate = Auth::user()->customer->debates()->findOrFail($id);
        $votes = $debate->votes()->get();
        $teams = $debate->teams()->get();
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.debate.show', compact(['teams', 'votes', 'debate', 'statuses']));

    }
    public function edit(string $id)
    {
        $debate = Auth::user()->customer->debates()->findOrFail($id);
        return new DebateResource($debate);
    }
    public function update(DebateRequest $request, string $id)
    {
        if ($request->validated()) {
            $debate = Auth::user()->customer->programSessions()->findOrFail($id);
            $debate->program_id = $request->input('program_id');
            $debate->sort_order = $request->input('sort_order');
            $debate->code = $request->input('code');
            $debate->title = $request->input('title');
            $debate->description = $request->input('description');
            $debate->voting_started_at = $request->input('voting_started_at');
            $debate->voting_finished_at = $request->input('voting_finished_at');
            $debate->status = $request->input('status');
            if ($debate->save()) {
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(string $id)
    {
        $debate = Auth::user()->customer->debates()->findOrFail($id);
        if ($debate->delete()) {
            $debate->deleted_by = Auth::user()->id;
            $debate->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
