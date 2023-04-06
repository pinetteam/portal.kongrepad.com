<?php

namespace App\Http\Controllers\Portal\Program\Moderator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Program\Moderator\ProgramModeratorRequest;
use App\Models\Program\Moderator\ProgramModerator;
use Illuminate\Support\Facades\Auth;

class ProgramModeratorController extends Controller
{
    public function store(ProgramModeratorRequest $request)
    {
        if ($request->validated()) {
            $program_moderator = new ProgramModerator();
            $program_moderator->program_id = $request->input('program_id');
            $program_moderator->moderator_id = $request->input('moderator_id');
            if ($program_moderator->save()) {
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(string $id)
    {
        $program_moderator = Auth::user()->customer->programModerators()->findOrFail($id);
        if ($program_moderator->delete()) {
            $program_moderator->deleted_by = Auth::user()->id;
            $program_moderator->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
