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
use Illuminate\Support\Facades\DB;
use App\Models\System\Setting\Variable\Variable;
use App\Models\Customer\Customer;

class SessionController extends Controller
{
    public function store(SessionRequest $request, int $meeting, int $hall, int $program)
    {
        try {
            // Get user's date time format
            $time_format = Variable::where('variable','time_format')->first()->settings()->where('customer_id', Auth::user()->customer->id ?? Customer::first()->id)->first()->value == '24H' ? ' H:i' : ' g:i A';
            $date_time_format = Variable::where('variable','date_format')->first()->settings()->where('customer_id', Auth::user()->customer->id ?? Customer::first()->id)->first()->value . $time_format;
            
            $program_session = new Session();
            $program_session->sort_order = $request->input('sort_order');
            $program_session->program_id = $request->input('program_id');
            $program_session->speaker_id = $request->input('speaker_id');
            $program_session->document_id = $request->input('document_id');
            $program_session->code = $request->input('code');
            $program_session->title = $request->input('title');
            $program_session->description = $request->input('description');
            
            // Convert datetime-local format to user's date_time_format for model accessors
            if ($request->input('start_at')) {
                $startAtValue = $request->input('start_at');
                // Convert from "2025-06-19T12:47" to user's format (e.g., "19/06/2025 12:47")
                $carbon = Carbon::createFromFormat('Y-m-d\TH:i', $startAtValue);
                $program_session->start_at = $carbon->format($date_time_format);
            }
            if ($request->input('finish_at')) {
                $finishAtValue = $request->input('finish_at');
                // Convert from "2025-06-19T12:47" to user's format (e.g., "19/06/2025 12:47")
                $carbon = Carbon::createFromFormat('Y-m-d\TH:i', $finishAtValue);
                $program_session->finish_at = $carbon->format($date_time_format);
            }
            
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
        } catch (\Exception $e) {
            \Log::error('Session creation error: ' . $e->getMessage());
            \Log::error('Request data: ' . json_encode($request->all()));
            return back()->with('create_modal', true)->with('error', 'Debug Error: ' . $e->getMessage() . ' | Data: ' . json_encode($request->all()))->withInput();
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
        // Load session with relationships - verify it belongs to customer
        $program_session = Session::with(['speaker', 'document', 'program.hall.meeting.customer'])
            ->findOrFail($id);
            
        // Security check: ensure session belongs to current user's customer
        if ($program_session->program->hall->meeting->customer_id !== Auth::user()->customer_id) {
            abort(403, 'Unauthorized access to session');
        }
        
        return new SessionResource($program_session);
    }
    public function update(SessionRequest $request, int $meeting, int $hall, int $program, int $id)
    {
        try {
            // Get user's date time format
            $time_format = Variable::where('variable','time_format')->first()->settings()->where('customer_id', Auth::user()->customer->id ?? Customer::first()->id)->first()->value == '24H' ? ' H:i' : ' g:i A';
            $date_time_format = Variable::where('variable','date_format')->first()->settings()->where('customer_id', Auth::user()->customer->id ?? Customer::first()->id)->first()->value . $time_format;
            
            $program_session = Auth::user()->customer->programSessions()->findOrFail($id);
            $program_session->sort_order = $request->input('sort_order');
            $program_session->speaker_id = $request->input('speaker_id');
            $program_session->document_id = $request->input('document_id');
            $program_session->code = $request->input('code');
            $program_session->title = $request->input('title');
            $program_session->description = $request->input('description');
            
            // Convert datetime-local format to user's date_time_format for model accessors
            if ($request->input('start_at')) {
                $startAtValue = $request->input('start_at');
                // Convert from "2025-06-19T12:47" to user's format (e.g., "19/06/2025 12:47")
                $carbon = Carbon::createFromFormat('Y-m-d\TH:i', $startAtValue);
                $program_session->start_at = $carbon->format($date_time_format);
            }
            if ($request->input('finish_at')) {
                $finishAtValue = $request->input('finish_at');
                // Convert from "2025-06-19T12:47" to user's format (e.g., "19/06/2025 12:47")
                $carbon = Carbon::createFromFormat('Y-m-d\TH:i', $finishAtValue);
                $program_session->finish_at = $carbon->format($date_time_format);
            }
            
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
        } catch (\Exception $e) {
            \Log::error('Session update error: ' . $e->getMessage());
            return back()->with('edit_modal', true)->with('error', 'Debug Error: ' . $e->getMessage())->withInput();
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
