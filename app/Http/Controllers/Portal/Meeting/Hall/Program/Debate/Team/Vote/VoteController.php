<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Program\Debate\Team\Vote;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Program\Debate\Team\Vote\VoteRequest;
use App\Http\Resources\Portal\Meeting\Hall\Program\Debate\Team\Vote\VoteResource;
use App\Models\Meeting\Hall\Program\Debate\Vote\Vote;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function store(VoteRequest $request)
    {
        if ($request->validated()) {
            $vote = new Vote();
            $vote->team_id = $request->input('team_id');
            $vote->participant_id = $request->input('participant_id');
            if ($vote->save()) {
                $vote->created_by = Auth::user()->id;
                $vote->save();
                return back()->with('success',__('common.created-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(string $id)
    {
        //
    }
    public function edit(string $id)
    {
        $vote = Auth::user()->customer->debateVotes()->findOrFail($id);
        return new VoteResource($vote);
    }
    public function update(VoteRequest $request, string $id)
    {
        if ($request->validated()) {
            $vote = Auth::user()->customer->debateVotes()->findOrFail($id);
            $vote->team_id = $request->input('team_id');
            $vote->participant_id = $request->input('participant_id');
            if ($vote->save()) {
                $vote->edited_by = Auth::user()->id;
                $vote->save();
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(string $id)
    {
        $vote = Auth::user()->customer->debateVotes()->findOrFail($id);
        if ($vote->delete()) {
            $vote->deleted_by = Auth::user()->id;
            $vote->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
