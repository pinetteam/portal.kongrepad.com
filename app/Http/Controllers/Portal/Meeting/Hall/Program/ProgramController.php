<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Program;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Program\ProgramRequest;
use App\Http\Resources\Portal\Meeting\Hall\Program\ProgramResource;
use App\Models\Meeting\Hall\Program\Program;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProgramController extends Controller
{
    public function index(int $meeting, int $hall)
    {
        $hall = Auth::user()->customer->halls()->findOrFail($hall);
        $programs = $hall->programs()->orderBy('sort_order', 'ASC')->orderBy('start_at', 'ASC')->get();
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $speakers = $meeting->participants()->whereNot('meeting_participants.type', 'team')->get();
        $documents = $meeting->documents()->get();
        $questions = [
            'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
        ];
        $questions_auto_start = [
            'no' => ['value' => 0, 'title' => __('common.no'), 'color' => 'danger'],
            'yes' => ['value' => 1, 'title' => __('common.yes'), 'color' => 'success'],
        ];
        $types = [
            'debate' => ['value' => 'debate', 'title' => __('common.debate')],
            'other' => ['value' => 'other', 'title' => __('common.other')],
            'session' => ['value' => 'session', 'title' => __('common.session')],
        ];
        $statuses = [
            'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.hall.program.index', compact(['programs', 'hall', 'meeting', 'types', 'statuses', 'speakers', 'documents', 'questions', 'questions_auto_start']));
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
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $file_name = Str::uuid()->toString();
                $file_extension = $file->getClientOriginalExtension();
                if(Storage::putFileAs('public/program-logos', $request->file('logo'), $file_name . '.' . $file_extension)) {
                    $program->logo_name = $file_name;
                    $program->logo_extension = $file_extension;
                } else {
                    return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
                }
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
        $hall = Auth::user()->customer->halls()->findOrFail($hall);
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $program = $hall->programs()->findOrFail($id);
        $statuses = [
            'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
        ];
        if($program->type=='session') {
            $documents = $meeting->documents()->get();
            $chairs = $meeting->participants()->whereNotIn('meeting_participants.id', $program->programChairs()->pluck('meeting_hall_program_chairs.chair_id'))->whereNot('meeting_participants.type', 'team')->get();
            $speakers = $meeting->participants()->whereNot('meeting_participants.type', 'team')->get();
            $program_chairs = $program->programChairs()->get();
            $program_sessions = $program->sessions()->get();
            $questions = [
                'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
                'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
            ];
            $questions_auto_start = [
                'no' => ['value' => 0, 'title' => __('common.no'), 'color' => 'danger'],
                'yes' => ['value' => 1, 'title' => __('common.yes'), 'color' => 'success'],
            ];
            $chair_types = [
                'chair' => ['value' => 'chair', 'title' => __('common.chair')],
                'moderator' => ['value' => 'moderator', 'title' => __('common.moderator')],
            ];
            return view('portal.meeting.hall.program.show-session', compact(['meeting', 'documents', 'chairs', 'chair_types', 'speakers', 'program', 'program_chairs', 'program_sessions', 'questions', 'questions_auto_start', 'statuses']));
        } else if($program->type == 'debate') {
            $debates = $program->debates()->get();
            $chairs = $meeting->participants()->whereNotIn('meeting_participants.id', $program->programChairs()->pluck('meeting_hall_program_chairs.chair_id'))->whereNot('meeting_participants.type', 'team')->get();
            $program_chairs = $program->programChairs()->get();
            $chair_types = [
                'chair' => ['value' => 'chair', 'title' => __('common.chair')],
                'moderator' => ['value' => 'moderator', 'title' => __('common.moderator')],
            ];
            return view('portal.meeting.hall.program.show-debate', compact(['meeting', 'program', 'chair_types', 'program_chairs', 'chairs', 'debates', 'statuses']));
        } else if($program->type == 'other') {
            return view('portal.meeting.hall.program.show-other', compact(['meeting', 'program', 'statuses']));
        }
    }
    public function edit(int $meeting, int $hall, int $id)
    {
        $hall = Auth::user()->customer->halls()->findOrFail($hall);
        $program = $hall->programs()->findOrFail($id);
        return new ProgramResource($program);
    }
    public function update(ProgramRequest $request, int $meeting, int $hall, int $id)
    {
        if ($request->validated()) {
            $hall = Auth::user()->customer->halls()->findOrFail($hall);
            $program = $hall->programs()->findOrFail($id);
            $program->hall_id = $request->input('hall_id');
            $program->sort_order = $request->input('sort_order');
            $program->code = $request->input('code');
            $program->title = $request->input('title');
            $program->description = $request->input('description');
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $file_name = Str::uuid()->toString();
                $file_extension = $file->getClientOriginalExtension();
                if(Storage::putFileAs('public/program-logos', $request->file('logo'), $file_name . '.' . $file_extension)) {
                    $program->logo_name = $file_name;
                    $program->logo_extension = $file_extension;
                } else {
                    return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
                }
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
        $hall = Auth::user()->customer->halls()->findOrFail($hall);
        $program = $hall->programs()->findOrFail($id);
        if ($program->delete()) {
            $program->deleted_by = Auth::user()->id;
            $program->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
