<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Program\Session;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Program\Session\SessionRequest;
use App\Http\Resources\Portal\Meeting\Hall\Program\Session\SessionResource;
use App\Models\Meeting\Hall\Program\Session\Session;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function store(SessionRequest $request, int $meeting, int $hall, int $program)
    {
        if ($request->validated()) {
            $program_session = new Session();
            $program_session->sort_order = $request->input('sort_order');
            $program_session->program_id = $program;
            $program_session->speaker_id = $request->input('speaker_id');
            $program_session->document_id = $request->input('document_id');
            $program_session->code = $request->input('code');
            $program_session->title = $request->input('title');
            $program_session->description = $request->input('description');
            $program_session->start_at = $request->input('start_at');
            $program_session->finish_at = $request->input('finish_at');
            $program_session->questions_allowed = $request->input('questions_allowed');
            $program_session->questions_limit = $request->input('questions_limit');
            $program_session->questions_auto_start = $request->input('questions_auto_start');
            $program_session->is_questions_started = $request->input('questions_auto_start');
            $program_session->status = $request->input('status');
            if ($program_session->save()) {
                $program_session->created_by = Auth::user()->id;
                $program_session->save();
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(int $meeting, int $hall, int $program, int $id)
    {
        $session = Auth::user()->customer->programSessions()->findOrFail($id);
        return view('portal.meeting.hall.program.session.show', compact(['session']));
    }
    public function edit(int $meeting, int $hall, int $program, int $id)
    {
        $program_session = Auth::user()->customer->programSessions()->findOrFail($id);
        return new SessionResource($program_session);
    }
    public function update(SessionRequest $request, int $meeting, int $hall, int $program, int $id)
    {
        if ($request->validated()) {
            $program_session = Auth::user()->customer->programSessions()->findOrFail($id);
            $program_session->speaker_id = $request->input('speaker_id');
            $program_session->document_id = $request->input('document_id');
            $program_session->sort_order = $request->input('sort_order');
            $program_session->code = $request->input('code');
            $program_session->title = $request->input('title');
            $program_session->description = $request->input('description');
            $program_session->start_at = $request->input('start_at');
            $program_session->finish_at = $request->input('finish_at');
            $program_session->questions_allowed = $request->input('questions_allowed');
            $program_session->questions_auto_start = $request->input('questions_auto_start');
            $program_session->is_questions_started = $request->input('questions_auto_start');
            $program_session->questions_limit = $request->input('questions_limit');
            $program_session->status = $request->input('status');
            if ($program_session->save()) {
                $program_session->updated_by = Auth::user()->id;
                $program_session->save();
                return back()->with('success', __('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(int $meeting, int $hall, int $program, int $id)
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
    /*public function start_stop(int $meeting, int $hall, int $program, int $id)
    {
        $program = Auth::user()->customer->programs()->findOrFail($program);
        $meeting_hall = Auth::user()->customer->meetingHalls()->findOrFail($program);
        foreach($meeting_hall->programSessions as $session){
            if($session->id == $id)
                continue;
            $session->is_started = 0;
            $session->save();
        }
        $program_session = Auth::user()->customer->programSessions()->findOrFail($id);
        $program_session->is_started = !$program_session->is_started;
        if ($program_session->save()) {
            if($program_session->is_started)
                return back()->with('success', __('common.session-started'));
            else
                return back()->with('success', __('common.session-stopped'));
        } else {
            return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
    public function start_stop_questions(int $meeting, int $hall, int $program, int $id)
    {
        $program_session = Auth::user()->customer->programSessions()->findOrFail($id);
        $program_session->is_questions_started = !$program_session->is_questions_started;
        if ($program_session->save()) {
            if($program_session->is_questions_started)
                return back()->with('success', __('common.session-questions-started'));
            else
                return back()->with('success', __('common.session-questions-stopped'));
        } else {
            return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }

    public function edit_question_limit(int $meeting, int $hall, int $program, int $id, int $increment){
        $program_session = Auth::user()->customer->programSessions()->findOrFail($id);
        $program_session->question_limit = $program_session->question_limit + $increment;
        if($program_session->question_limit > 0)
            $program_session->save();
        return back();
    }*/
}
