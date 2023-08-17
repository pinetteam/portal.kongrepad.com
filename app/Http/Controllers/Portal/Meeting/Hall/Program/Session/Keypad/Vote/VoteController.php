<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Program\Session\Keypad\Vote;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Program\Session\Keypad\Vote\VoteRequest;
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
                $vote->created_by = Auth::user()->id;
                $vote->save();
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
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
