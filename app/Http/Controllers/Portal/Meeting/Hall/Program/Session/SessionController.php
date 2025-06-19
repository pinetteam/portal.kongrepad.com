<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Program\Session;

use App\Events\Service\QuestionBoard\QuestionBoardEvent;
use App\Events\Service\Screen\QuestionsEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Program\Session\SessionRequest;
use App\Http\Resources\Portal\Meeting\Hall\Program\Session\SessionResource;
use App\Models\Meeting\Hall\Program\Session\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function store(SessionRequest $request, int $meeting, int $hall, int $program)
    {
        try {
            $program_session = new Session();
            $program_session->program_id = $request->input('program_id');
            $program_session->title = $request->input('title');
            $program_session->start_at = $request->input('start_at');
            $program_session->finish_at = $request->input('finish_at');
            $program_session->questions_allowed = 0;
            $program_session->questions_limit = 0;
            $program_session->questions_auto_start = 0;
            $program_session->is_questions_started = 0;
            $program_session->status = 1;
            
            if ($program_session->save()) {
                $program_session->created_by = Auth::user()->id;
                $program_session->save();
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        } catch (\Exception $e) {
            \Log::error('Session creation error: ' . $e->getMessage());
            return back()->with('create_modal', true)->with('error', 'Debug Error: ' . $e->getMessage())->withInput();
        }
    }
    public function show(int $meeting, int $hall, int $program, int $id)
    {
        $session = Auth::user()->customer->programSessions()->findOrFail($id);
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        return view('portal.meeting.hall.program.session.show', compact(['session', 'meeting']));
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
            $program_session->start_at = $request->input('start_at') ? 
                Carbon::createFromFormat('Y-m-d\TH:i', $request->input('start_at'))->format('Y-m-d H:i:s') : null;
            $program_session->finish_at = $request->input('finish_at') ? 
                Carbon::createFromFormat('Y-m-d\TH:i', $request->input('finish_at'))->format('Y-m-d H:i:s') : null;
            $program_session->questions_allowed = $request->input('questions_allowed') ? 1 : 0;
            $program_session->questions_auto_start = $request->input('questions_auto_start') ? 1 : 0;
            $program_session->is_questions_started = $request->input('questions_auto_start') ? 1 : 0;
            $program_session->questions_limit = $request->input('questions_limit') ?: 0;
            $program_session->status = $request->input('status') ? 1 : 0;
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
    public function start_stop(int $meeting, int $hall, int $program, int $id)
    {
        $meeting_hall = Auth::user()->customer->halls()->findOrFail($hall);
        foreach($meeting_hall->programSessions as $session) {
            if($session->id == $id)
                continue;
            if($session->on_air == 1) {
                $session_log = new \App\Models\Log\Meeting\Hall\Program\Session\Session();
                $session_log->session_id = $session->id;
                $session_log->created_by = Auth::user()->id;
                $session_log->action = 'stop';
                $session_log->save();
                $session->on_air = 0;
                $session->save();
            }
        }
        $program_session = Auth::user()->customer->programSessions()->findOrFail($id);
        $program_session->on_air = !$program_session->on_air;
        if($program_session->on_air == 0) {
            $session_log = new \App\Models\Log\Meeting\Hall\Program\Session\Session();
            $session_log->session_id = $program_session->id;
            $session_log->created_by = Auth::user()->id;
            $session_log->action = 'stop';
            $session_log->save();
        } else {
            $session_log = new \App\Models\Log\Meeting\Hall\Program\Session\Session();
            $session_log->session_id = $program_session->id;
            $session_log->created_by = Auth::user()->id;
            $session_log->action = 'start';
            $session_log->save();
        }
        if ($program_session->save()) {
            event(new QuestionBoardEvent($meeting_hall));
            $meeting_hall_screen = $meeting_hall->screens()->where('type', 'questions')->first();
            if ($meeting_hall_screen != null) {
                event(new QuestionsEvent($meeting_hall_screen));
            }
            if($program_session->on_air)
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
        $program_session->questions_limit = $program_session->questions_limit + $increment;
        if($program_session->questions_limit > 0)
            $program_session->save();
        return back();
    }
}
