<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program\Session;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Program\Session\ProgramSessionRequest;
use App\Http\Resources\Portal\Meeting\Hall\Program\Session\ProgramSessionResource;
use App\Models\Meeting\Hall\Program\Session\ProgramSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramSessionController extends Controller
{
    public function index(Request $request, $program_id){
        return $request->user()->meeting->programs()->where('meeting_hall_programs.id', $program_id)->first()->programSessions()->get();
    }
    public function store(ProgramSessionRequest $request, string $program_id)
    {
        if ($request->validated()) {
            $program_session = new ProgramSession();
            $program_session->program_id = $request->input('program_id');
            $program_session->speaker_id = $request->input('speaker_id');
            $program_session->document_id = $request->input('document_id');
            $program_session->sort_order = $request->input('sort_order');
            $program_session->code = $request->input('code');
            $program_session->title = $request->input('title');
            $program_session->description = $request->input('description');
            $program_session->start_at = $request->input('start_at');
            $program_session->finish_at = $request->input('finish_at');
            $program_session->questions = $request->input('questions');
            $program_session->questions_auto_start = $request->input('questions_auto_start');
            $program_session->is_questions_started = $request->input('questions_auto_start');
            $program_session->question_limit = $request->input('question_limit');
            $program_session->status = $request->input('status');
            if ($program_session->save()) {
                $program_session->created_by = Auth::user()->id;
                $program_session->save();
                return back()->with('success',__('common.created-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(Request $request, string $program_id, string $id)
    {
        $request->user()->customer->programSessions()->where('meeting_hall_program_sessions.id', $id)->first();

    }
    public function edit(string $program_id, string $id)
    {
        $program_session = Auth::user()->customer->programSessions()->findOrFail($id);
        return new ProgramSessionResource($program_session);
    }
}
