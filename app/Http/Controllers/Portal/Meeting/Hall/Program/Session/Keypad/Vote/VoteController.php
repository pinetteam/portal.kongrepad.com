<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Program\Session\Keypad\Vote;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Program\Session\Keypad\Vote\VoteRequest;
use App\Http\Resources\Portal\Meeting\Hall\Program\Session\Keypad\Vote\VoteResource;
use App\Models\Meeting\Hall\Program\Session\Keypad\Vote\Vote;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function store(VoteRequest $request)
    {
        if ($request->validated()) {
            $vote = new Vote();
            $vote->option_id = $request->input('option_id');
            $vote->participant_id = $request->input('participant_id');
            if ($vote->save()) {
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
        $program_session = Auth::user()->customer->programSessions()->findOrFail($id);
        return new VoteResource($program_session);
    }
    public function update(VoteRequest $request, string $id)
    {
        if ($request->validated()) {
            $vote = Auth::user()->customer->keypadVotes()->findOrFail($id);
            $vote->option_id = $request->input('option_id');
            $vote->participant_id = $request->input('participant_id');
            if ($vote->save()) {
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(string $id)
    {
        $vote = Auth::user()->customer->keypadVotes()->findOrFail($id);
        if ($vote->delete()) {
            $vote->deleted_by = Auth::user()->id;
            $vote->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
