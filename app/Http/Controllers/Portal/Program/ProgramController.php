<?php

namespace App\Http\Controllers\Portal\Program;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Program\ProgramRequest;
use App\Http\Resources\Portal\Program\ProgramResource;
use App\Models\Program\Program;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Auth::user()->customer->programs()->orderBy('meeting_hall_programs.sort_id')->paginate(20);
        $meeting_halls = Auth::user()->customer->meetingHalls()->where('meeting_halls.status', 1)->get();
        $types = [
            'break' => ["value" => "break", "title" => __('common.break')],
            'event' => ["value" => "event", "title" => __('common.event')],
            'other' => ["value" => "break", "title" => __('common.other')],
            'session' => ["value" => "session", "title" => __('common.session')],
        ];
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.program.index', compact(['programs', 'meeting_halls', 'types', 'statuses']));
    }
    public function store(ProgramRequest $request)
    {
        if ($request->validated()) {
            $program = new Program();
            $program->meeting_hall_id = $request->input('meeting_hall_id');
            $program->sort_id = $request->input('sort_id');
            $program->code = $request->input('code');
            $program->title = $request->input('title');
            $program->description = $request->input('description');
            if ($request->has('logo')) {
                $logo = Image::make($request->file('logo'))->encode('data-url');
                $program->logo = $logo;
            }
            $program->start_at = $request->input('start_at');
            $program->finish_at = $request->input('finish_at');
            $program->type = $request->input('type');
            $program->status = $request->input('status');
            if ($program->save()) {
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show($id)
    {
        $program = Auth::user()->customer->programs()->findOrFail($id);
        if($program->type=='session') {
            $documents = Auth::user()->customer->documents()->get();
            $moderators = Auth::user()->customer->participants()->whereNotIn('meeting_participants.id', $program->programModerators()->pluck('program_moderators.moderator_id'))->whereNot('meeting_participants.type', 'team')->get();
            $presenters = Auth::user()->customer->participants()->whereNot('meeting_participants.type', 'team')->get();
            $program_moderators = $program->programModerators()->get();
            $program_sessions = $program->programSessions()->get();
            $questions = [
                'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
                'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
            ];
            $statuses = [
                'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
                'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
            ];
            return view('portal.program.show-session', compact(['documents', 'moderators', 'presenters', 'program', 'program_moderators', 'program_sessions', 'questions', 'statuses']));
        }
    }
    public function edit($id)
    {
        $program = Auth::user()->customer->programs()->findOrFail($id);
        return new ProgramResource($program);
    }
    public function update(ProgramRequest $request, $id)
    {
        if ($request->validated()) {
            $program = Auth::user()->customer->programs()->findOrFail($id);
            $program->meeting_hall_id = $request->input('meeting_hall_id');
            $program->sort_id = $request->input('sort_id');
            $program->code = $request->input('code');
            $program->title = $request->input('title');
            $program->description = $request->input('description');
            if ($request->has('logo')) {
                $logo = Image::make($request->file('logo'))->encode('data-url');
                $program->logo = $logo;
            }
            $program->start_at = $request->input('start_at');
            $program->finish_at = $request->input('finish_at');
            $program->status = $request->input('status');
            if ($program->save()) {
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy($id)
    {
        $program = Auth::user()->customer->programs()->findOrFail($id);
        if ($program->delete()) {
            $program->deleted_by = Auth::user()->id;
            $program->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
