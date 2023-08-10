<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Program\Debate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Program\Debate\DebateRequest;
use App\Http\Resources\Portal\Meeting\Hall\Program\Debate\DebateResource;
use App\Models\Meeting\Hall\Program\Debate\Debate;
use Illuminate\Support\Facades\Auth;

class DebateController extends Controller
{
    public function store(DebateRequest $request, string $program_id)
    {
        if ($request->validated()) {
            $debate = new Debate();
            $debate->program_id = $request->input('program_id');
            $debate->sort_order = $request->input('sort_order');
            $debate->code = $request->input('code');
            $debate->title = $request->input('title');
            $debate->description = $request->input('description');
            $debate->status = $request->input('status');
            if ($debate->save()) {
                $debate->created_by = Auth::user()->id;
                $debate->save();
                return back()->with('success',__('common.created-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(string $program_id, string $id)
    {
        $debate = Auth::user()->customer->debates()->findOrFail($id);
        $teams = $debate->teams()->get();
        $statuses = [
            'passive' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'active' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.hall.program.debate.show', compact(['teams', 'debate', 'statuses']));

    }
    public function edit(string $program_id, string $id)
    {
        $debate = Auth::user()->customer->debates()->findOrFail($id);
        return new DebateResource($debate);
    }
    public function update(DebateRequest $request, string $program_id, string $id)
    {
        if ($request->validated()) {
            $debate = Auth::user()->customer->debates()->findOrFail($id);
            $debate->program_id = $request->input('program_id');
            $debate->sort_order = $request->input('sort_order');
            $debate->code = $request->input('code');
            $debate->title = $request->input('title');
            $debate->description = $request->input('description');
            $debate->status = $request->input('status');
            if ($debate->save()) {
                $debate->updated_by = Auth::user()->id;
                $debate->save();
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(string $program_id, string $id)
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
    public function start_stop_voting(string $program_id, string $id)
    {
        $program = Auth::user()->customer->programs()->findOrFail($program_id);
        foreach($program->debates as $debate){
            if($debate->id == $id)
                continue;
            $debate = Auth::user()->customer->debates()->findOrFail($debate->id);
            $debate->on_vote = 0;
            $debate->save();
        }
        $debate = Auth::user()->customer->debates()->findOrFail($id);
        $debate->on_vote = !$debate->on_vote;
        if ($debate->save()) {
            if($debate->on_vote){
                $debate->voting_started_at = now()->format('Y-m-d H:i');;
                $debate->voting_finished_at = null;
                $debate->save();
                return back()->with('success',__('common.voting-started'));
            }
            else{
                $debate->voting_finished_at = now()->format('Y-m-d H:i');
                $debate->save();
                return back()->with('success',__('common.voting-stopped'));
            }
        } else {
            return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
