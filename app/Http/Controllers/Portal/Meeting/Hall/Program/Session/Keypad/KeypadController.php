<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Program\Session\Keypad;

use App\Events\KeypadEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Program\Session\Keypad\KeypadRequest;
use App\Http\Resources\Portal\Meeting\Hall\Program\Session\Keypad\KeypadResource;
use App\Models\Meeting\Hall\Program\Session\Keypad\Keypad;
use Illuminate\Support\Facades\Auth;

class KeypadController extends Controller
{
    public function store(KeypadRequest $request, int $meeting, int $hall, int $program, int $session)
    {
        if ($request->validated()) {
            $keypad = new Keypad();
            $keypad->sort_order = $request->input('sort_order');
            $keypad->session_id = $request->input('session_id');
            $keypad->title = $request->input('title');
            $keypad->keypad = $request->input('keypad');
            if ($keypad->save()) {
                $keypad->created_by = Auth::user()->id;
                $keypad->save();
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(int $meeting, int $hall, int $program, int $session, int $id)
    {
        $keypad = Auth::user()->customer->keypads()->findOrFail($id);
        return view('portal.meeting.hall.program.session.keypad.show', compact(['keypad']));
    }
    public function edit(int $meeting, int $hall, int $program, int $session, int $id)
    {
        $keypad = Auth::user()->customer->keypads()->findOrFail($id);
        return new KeypadResource($keypad);
    }
    public function update(KeypadRequest $request, int $meeting, int $hall, int $program, int $session, int $id)
    {
        if ($request->validated()) {
            $keypad = Auth::user()->customer->keypads()->findOrFail($id);
            $keypad->session_id = $request->input('session_id');
            $keypad->sort_order = $request->input('sort_order');
            $keypad->title = $request->input('title');
            $keypad->keypad = $request->input('keypad');
            if ($keypad->save()) {
                $keypad->updated_by = Auth::user()->id;
                $keypad->save();
                return back()->with('success', __('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(int $meeting, int $hall, int $program, int $session, int $id)
    {
        $keypad = Auth::user()->customer->keypads()->findOrFail($id);
        if ($keypad->delete()) {
            $keypad->deleted_by = Auth::user()->id;
            $keypad->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
    public function start_stop_voting(int $meeting, int $hall, int $program, int $session, int $id)
    {
        $session = Auth::user()->customer->programSessions()->findOrFail($session);
        $hall = Auth::user()->customer->halls()->findOrFail($hall);
        foreach($session->keypads as $keypad){
            if($keypad->id == $id)
                continue;
            $keypad = Auth::user()->customer->keypads()->findOrFail($keypad->id);
            $keypad->on_vote = 0;
            $keypad->save();
        }
        $keypad = Auth::user()->customer->keypads()->findOrFail($id);
        $keypad->on_vote = !$keypad->on_vote;
        if ($keypad->save()) {
            event(new KeypadEvent($hall));
            if($keypad->on_vote){
                $keypad->voting_started_at = now()->format('Y-m-d H:i');;
                $keypad->voting_finished_at = null;
                $keypad->save();
                return back()->with('success', __('common.voting-started'));
            }
            else{
                $keypad->voting_finished_at = now()->format('Y-m-d H:i');;
                $keypad->save();
                return back()->with('success', __('common.voting-stopped'));
            }
        } else {
            return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
