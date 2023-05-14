<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Program\Session\Keypad\Option;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Program\Session\Keypad\Option\OptionRequest;
use App\Http\Resources\Portal\Meeting\Hall\Program\Session\Keypad\Option\OptionResource;
use App\Models\Meeting\Hall\Program\Session\Keypad\Option\Option;
use Illuminate\Support\Facades\Auth;

class OptionController extends Controller
{
    public function store(OptionRequest $request)
    {
        if ($request->validated()) {
            $option = new Option();
            $option->keypad_id = $request->input('keypad_id');
            $option->sort_order = $request->input('sort_order');
            $option->title = $request->input('title');
            if ($option->save()) {
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
        $option = Auth::user()->customer->options()->findOrFail($id);
        return new OptionResource($option);
    }
    public function update(OptionRequest $request, string $id)
    {
        if ($request->validated()) {
            $option = Auth::user()->customer->options()->findOrFail($id);
            $option->keypad_id = $request->input('keypad_id');
            $option->code = $request->input('sort_order');
            $option->title = $request->input('title');
            if ($option->save()) {
                return back()->with('success',__('common.created-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(string $id)
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
