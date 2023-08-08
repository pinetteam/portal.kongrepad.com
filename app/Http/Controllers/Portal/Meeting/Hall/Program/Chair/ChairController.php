<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Program\Chair;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Program\Chair\ChairRequest;
use App\Models\Meeting\Hall\Program\Chair\Chair;
use Illuminate\Support\Facades\Auth;

class ChairController extends Controller
{
    public function store(ChairRequest $request)
    {
        if ($request->validated()) {
            $chair = new Chair();
            $chair->program_id = $request->input('program_id');
            $chair->chair_id = $request->input('chair_id');
            if ($chair->save()) {
                $chair->created_by = Auth::user()->id;
                $chair->save();
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(string $meeting, string $hall, string $program, string $id)
    {
        $chair = Auth::user()->customer->programChairs()->findOrFail($id);
        if ($chair->delete()) {
            $chair->deleted_by = Auth::user()->id;
            $chair->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
