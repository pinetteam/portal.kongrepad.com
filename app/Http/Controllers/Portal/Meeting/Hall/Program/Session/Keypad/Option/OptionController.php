<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Program\Session\Keypad\Option;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Program\Session\Keypad\Option\OptionRequest;
use App\Http\Resources\Portal\Meeting\Hall\Program\Session\Keypad\Option\OptionResource;
use App\Models\Meeting\Hall\Program\Session\Keypad\Option\Option;
use Illuminate\Support\Facades\Auth;

class OptionController extends Controller
{
    public function store(OptionRequest $request, int $meeting, int $hall, int $program, int $session, int $keypad)
    {
        if ($request->validated()) {
            $option = new Option();
            $option->sort_order = $request->input('sort_order');
            $option->keypad_id = $keypad;
            $option->option = $request->input('option');
            if ($option->save()) {
                $option->created_by = Auth::user()->id;
                $option->save();
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function edit(int $meeting, int $hall, int $program, int $session, int $keypad, int $id)
    {
        $option = Auth::user()->customer->options()->findOrFail($id);
        return new OptionResource($option);
    }
    public function update(OptionRequest $request, int $meeting, int $hall, int $program, int $session, int $keypad, int $id)
    {
        if ($request->validated()) {
            $option = Auth::user()->customer->options()->findOrFail($id);
            $option->sort_order = $request->input('sort_order');
            $option->keypad_id = $request->input('keypad_id');
            $option->option = $request->input('option');
            if ($option->save()) {
                $option->updated_by = Auth::user()->id;
                $option->save();
                return back()->with('success', __('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(int $meeting, int $hall, int $program, int $session, int $keypad, int $id)
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
