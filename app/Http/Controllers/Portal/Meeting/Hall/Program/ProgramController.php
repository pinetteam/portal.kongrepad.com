<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Program;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Program\ProgramRequest;
use App\Http\Resources\Portal\Meeting\Hall\Program\ProgramResource;
use App\Models\Meeting\Hall\Program\Program;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class ProgramController extends Controller
{
    public function index(int $meeting, int $hall)
    {
        $programs = Auth::user()->customer->programs()->where('hall_id', $hall)->paginate(10);
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $hall = Auth::user()->customer->meetingHalls()->findOrFail($hall);
        $types = [
            'debate' => ["value" => "debate", "title" => __('common.debate')],
            'other' => ["value" => "other", "title" => __('common.other')],
            'session' => ["value" => "session", "title" => __('common.session')],
        ];
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.hall.program.index', compact(['programs', 'meeting', 'hall', 'types', 'statuses']));
    }
    public function store(ProgramRequest $request, int $meeting, int $hall)
    {
        if ($request->validated()) {
            $program = new Program();
            $program->hall_id = $hall;
            $program->sort_order = $request->input('sort_order');
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
                $program->created_by = Auth::user()->id;
                $program->save();
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(int $meeting, int $hall, int $id)
    {
        $program = Auth::user()->customer->programs()->findOrFail($id);
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        if($program->type=='session') {
            $documents = Auth::user()->customer->documents()->get();
            $chairs = Auth::user()->customer->participants()->whereNotIn('meeting_participants.id', $program->programChairs()->pluck('meeting_hall_program_chairs.chair_id'))->whereNot('meeting_participants.type', 'team')->get();
            $speakers = Auth::user()->customer->participants()->whereNot('meeting_participants.type', 'team')->get();
            $program_chairs = $program->programChairs()->get();
            $program_sessions = $program->sessions()->get();
            $questions = [
                'passive' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
                'active' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
            ];
            $questions_auto_start = [
                'no' => ["value" => 0, "title" => __('common.no'), 'color' => 'danger'],
                'yes' => ["value" => 1, "title" => __('common.yes'), 'color' => 'success'],
            ];
            return view('portal.meeting.hall.program.show-session', compact(['documents', 'chairs', 'speakers', 'program', 'program_chairs', 'program_sessions', 'questions', 'questions_auto_start', 'statuses']));
        } else if($program->type == 'debate') {
            $debates = $program->debates()->get();
            $chairs = Auth::user()->customer->participants()->whereNotIn('meeting_participants.id', $program->programChairs()->pluck('meeting_hall_program_chairs.chair_id'))->whereNot('meeting_participants.type', 'team')->get();
            $program_chairs = $program->programChairs()->get();
            return view('portal.meeting.hall.program.show-debate', compact(['program', 'program_chairs', 'chairs', 'debates', 'statuses']));
        } else if($program->type == 'other') {
            return view('portal.meeting.hall.program.show-other', compact(['program', 'statuses']));
        }
    }
    public function edit(int $meeting, int $hall, int $id)
    {
        $program = Auth::user()->customer->programs()->findOrFail($id);
        return new ProgramResource($program);
    }
    public function update(ProgramRequest $request, int $meeting, int $hall, int $id)
    {
        if ($request->validated()) {
            $program = Auth::user()->customer->programs()->findOrFail($id);
            $program->hall_id = $request->input('hall_id');
            $program->sort_order = $request->input('sort_order');
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
                $program->updated_by = Auth::user()->id;
                $program->save();
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(int $meeting, int $hall, int $id)
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
