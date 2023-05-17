<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Program\Session\Keypad;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Program\Session\Keypad\KeypadRequest;
use App\Http\Resources\Portal\Meeting\Hall\Program\Session\Keypad\KeypadResource;
use App\Models\Meeting\Hall\Program\Session\Keypad\Keypad;
use Illuminate\Support\Facades\Auth;

class KeypadController extends Controller
{
    public function store(KeypadRequest $request, string $program_id, string $session_id)
    {
        if ($request->validated()) {
            $keypad = new Keypad();
            $keypad->session_id = $request->input('session_id');
            $keypad->sort_order = $request->input('sort_order');
            $keypad->code = $request->input('code');
            $keypad->title = $request->input('title');
            $keypad->voting_started_at = $request->input('voting_started_at');
            $keypad->voting_finished_at = $request->input('voting_finished_at');
            if ($keypad->save()) {
                return back()->with('success',__('common.created-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(string $program_id, string $session_id, string $id)
    {
        $keypad = Auth::user()->customer->keypads()->findOrFail($id);
        $votes = $keypad->votes()->get();
        $options = $keypad->options()->get();
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.program.session.keypad.show', compact(['options', 'votes', 'keypad', 'statuses']));
    }
    public function edit(string $program_id, string $session_id, string $id)
    {
        $keypad = Auth::user()->customer->keypads()->findOrFail($id);
        return new KeypadResource($keypad);
    }
    public function update(KeypadRequest $request, string $program_id, string $session_id, string $id)
    {
        if ($request->validated()) {
            $keypad = Auth::user()->customer->keypads()->findOrFail($id);
            $keypad->session_id = $request->input('session_id');
            $keypad->sort_order = $request->input('sort_order');
            $keypad->code = $request->input('code');
            $keypad->title = $request->input('title');
            $keypad->voting_started_at = $request->input('voting_started_at');
            $keypad->voting_finished_at = $request->input('voting_finished_at');
            if ($keypad->save()) {
                return back()->with('success',__('common.created-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(string $program_id, string $session_id, string $id)
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
}
