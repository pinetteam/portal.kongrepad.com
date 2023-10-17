<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Program\Debate;

use App\Events\DebateEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Program\Debate\DebateRequest;
use App\Http\Resources\Portal\Meeting\Hall\Program\Debate\DebateResource;
use App\Models\Meeting\Hall\Program\Debate\Debate;
use App\Notifications\DebateNotification;
use Illuminate\Support\Facades\Auth;

class DebateController extends Controller
{
    public function store(DebateRequest $request, int $meeting, int $hall, int $program)
    {
        if ($request->validated()) {
            $debate = new Debate();
            $debate->sort_order = $request->input('sort_order');
            $debate->program_id = $program;
            $debate->code = $request->input('code');
            $debate->title = $request->input('title');
            $debate->description = $request->input('description');
            $debate->status = $request->input('status');
            if ($debate->save()) {
                $debate->created_by = Auth::user()->id;
                $debate->save();
                return back()->with('success',__('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(int $meeting, int $hall, int $program, int $id)
    {
        $debate = Auth::user()->customer->debates()->findOrFail($id);
        return view('portal.meeting.hall.program.debate.show', compact(['debate']));

    }
    public function edit(int $meeting, int $hall, int $program, int $id)
    {
        $debate = Auth::user()->customer->debates()->findOrFail($id);
        return new DebateResource($debate);
    }
    public function update(DebateRequest $request, int $meeting, int $hall, int $program, int $id)
    {
        if ($request->validated()) {
            $debate = Auth::user()->customer->debates()->findOrFail($id);
            $debate->sort_order = $request->input('sort_order');
            $debate->program_id = $request->input('program_id');
            $debate->code = $request->input('code');
            $debate->title = $request->input('title');
            $debate->description = $request->input('description');
            $debate->status = $request->input('status');
            if ($debate->save()) {
                $debate->updated_by = Auth::user()->id;
                $debate->save();
                return back()->with('success', __('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(int $meeting, int $hall, int $program, int $id)
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
    public function start_stop_voting(int $meeting, int $hall, int $program, int $id)
    {
        $program = Auth::user()->customer->programs()->findOrFail($program);
        $hall = Auth::user()->customer->halls()->findOrFail($hall);
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        event(new DebateEvent($hall, false));
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
            event(new DebateEvent($hall, $debate->on_vote));
            if($debate->on_vote){
                $debate->voting_started_at = now()->format('Y-m-d H:i');;
                $debate->voting_finished_at = null;
                $debate->save();
                $meeting->participants->first()->notify(new DebateNotification($hall));
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
