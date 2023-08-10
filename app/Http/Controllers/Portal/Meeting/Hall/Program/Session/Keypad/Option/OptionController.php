<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Program\Session\Keypad\Option;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Program\Session\Keypad\Option\OptionRequest;
use App\Http\Resources\Portal\Meeting\Hall\Program\Session\Keypad\Option\OptionResource;
use App\Models\Meeting\Hall\Program\Session\Keypad\Option\Option;
use Illuminate\Support\Facades\Auth;

class OptionController extends Controller
{
    public function store(OptionRequest $request, string $meeting, string $hall, string $program, string $session, string $keypad)
    {
        if ($request->validated()) {
            $option = new Option();
            $option->keypad_id = $request->input('keypad_id');
            $option->sort_order = $request->input('sort_order');
            $option->option = $request->input('option');
            if ($option->save()) {
                $option->created_by = Auth::user()->id;
                $option->save();
                return back()->with('success',__('common.created-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(string $meeting, string $hall, string $program, string $session, string $keypad, string $id)
    {
        $option = Auth::user()->customer->options()->findOrFail($id);
        $votes = $option->votes()->get();
        return view('portal.program.session.keypad.option.show', compact(['option', 'votes']));
    }
    public function edit(string $meeting, string $hall, string $program, string $session, string $keypad, string $id)
    {
        $option = Auth::user()->customer->options()->findOrFail($id);
        return new OptionResource($option);
    }
    public function update(OptionRequest $request, string $meeting, string $hall, string $program, string $session, string $keypad, string $id)
    {
        if ($request->validated()) {
            $option = Auth::user()->customer->options()->findOrFail($id);
            $option->keypad_id = $request->input('keypad_id');
            $option->sort_order = $request->input('sort_order');
            $option->option = $request->input('option');
            if ($option->save()) {
                $option->updated_by = Auth::user()->id;
                $option->save();
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(string $meeting, string $hall, string $program, string $session, string $keypad, string $id)
    {
        $option = Auth::user()->customer->options()->findOrFail($id);
        if ($option->delete()) {
            $option->deleted_by = Auth::user()->id;
            $option->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
