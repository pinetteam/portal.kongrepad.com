<?php

namespace App\Http\Controllers\Portal\Program\Session;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Program\Session\ProgramSessionRequest;
use App\Http\Resources\Portal\Program\Session\ProgramSessionResource;
use App\Models\Program\Session\ProgramSession;
use Illuminate\Support\Facades\Auth;

class ProgramSessionController extends Controller
{
    public function store(ProgramSessionRequest $request)
    {
        if ($request->validated()) {
            $program_session = new ProgramSession();
            $program_session->program_id = $request->input('program_id');
            $program_session->presenter_id = $request->input('presenter_id');
            $program_session->document_id = $request->input('document_id');
            $program_session->sort_id = $request->input('sort_id');
            $program_session->code = $request->input('code');
            $program_session->title = $request->input('title');
            $program_session->description = $request->input('description');
            $program_session->start_at = $request->input('start_at');
            $program_session->finish_at = $request->input('finish_at');
            $program_session->questions = $request->input('questions');
            $program_session->question_limit = $request->input('question_limit');
            $program_session->status = $request->input('status');
            if ($program_session->save()) {
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
        return new ProgramSessionResource($program_session);
    }
    public function update(ProgramSessionRequest $request, string $id)
    {
        if ($request->validated()) {
            $program_session = Auth::user()->customer->programSessions()->findOrFail($id);
            $program_session->presenter_id = $request->input('presenter_id');
            $program_session->document_id = $request->input('document_id');
            $program_session->sort_id = $request->input('sort_id');
            $program_session->code = $request->input('code');
            $program_session->title = $request->input('title');
            $program_session->description = $request->input('description');
            $program_session->start_at = $request->input('start_at');
            $program_session->finish_at = $request->input('finish_at');
            $program_session->questions = $request->input('questions');
            $program_session->question_limit = $request->input('question_limit');
            $program_session->status = $request->input('status');
            if ($program_session->save()) {
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(string $id)
    {
        $program_session = Auth::user()->customer->programSessions()->findOrFail($id);
        if ($program_session->delete()) {
            $program_session->deleted_by = Auth::user()->id;
            $program_session->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
