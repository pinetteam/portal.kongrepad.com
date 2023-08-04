<?php

namespace App\Http\Controllers\Portal\Meeting\Hall;

use App\Events\FormSubmitted;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\HallRequest;
use App\Http\Resources\Portal\Meeting\Hall\HallResource;
use App\Models\Meeting\Hall\Hall;
use Illuminate\Support\Facades\Auth;

class HallController extends Controller
{
    public function index(int $meeting)
    {
        $meeting_halls = Auth::user()->customer->meetingHalls()->where('meeting_id', $meeting)->paginate(20);
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.meeting-hall.index', compact(['meeting_halls', 'meeting', 'statuses']));
    }
    public function store(HallRequest $request, int $meeting)
    {
        if ($request->validated()) {
            $meeting_hall = new Hall();
            $meeting_hall->meeting_id = $meeting;
            $meeting_hall->title = $request->input('title');
            $meeting_hall->status = $request->input('status');
            if ($meeting_hall->save()) {
                $meeting_hall->created_by = Auth::user()->id;
                $meeting_hall->save();
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(int $meeting, int $id)
    {
        $meeting_hall = Auth::user()->customer->meetingHalls()->where('meeting_id', $meeting)->findOrFail($id);
        $meeting_halls = Auth::user()->customer->meetingHalls()->where('meeting_halls.status', 1)->get();
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.meeting-hall.show', compact(['meeting_hall', 'meeting_halls', 'statuses']));
    }
    public function edit(int $meeting, int $id)
    {
        $meeting_hall = Auth::user()->customer->meetingHalls()->where('meeting_id', $meeting)->findOrFail($id);
        return new HallResource($meeting_hall);
    }
    public function update(HallRequest $request, int $meeting, int $id)
    {
        if ($request->validated()) {
            $meeting_hall = Auth::user()->customer->meetingHalls()->where('meeting_id', $meeting)->findOrFail($id);
            $meeting_hall->meeting_id = $meeting;
            $meeting_hall->title = $request->input('title');
            $meeting_hall->status = $request->input('status');
            if ($meeting_hall->save()) {
                $meeting_hall->edited_by = Auth::user()->id;
                $meeting_hall->save();
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(int $meeting, int $id)
    {
        $meeting_hall = Auth::user()->customer->meetingHalls()->where('meeting_id', $meeting)->findOrFail($id);
        if ($meeting_hall->delete()) {
            $meeting_hall->deleted_by = Auth::user()->id;
            $meeting_hall->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }

    public function current_speaker(string $id)
    {
        $meeting_hall = Auth::user()->customer->meetingHalls()->findOrFail($id);
        $session = $meeting_hall->programSessions()->where('is_started',1)->first();
        $speaker = $session && $session->program->on_air && $session ? $session->speaker : null;
        event(new FormSubmitted("sdsdsd"));
        return view('portal.current-speaker.show', compact(['speaker']));
    }

    public function chair_board(string $id)
    {
        $meeting_hall = Auth::user()->customer->meetingHalls()->findOrFail($id);
        $session = $meeting_hall->programSessions()->where('is_started',1)->first();
        $questions = $session && $session->program->on_air ? $session->questions()->get() : null;
        return view('portal.chair-board.index', compact(['session', 'questions']));
    }

    public function current_chair(string $id, string $chair_index)
    {
        $meeting_hall = Auth::user()->customer->meetingHalls()->findOrFail($id);
        $program = $meeting_hall->programs()->where('on_air',1)->first();
        if(isset($program))
            $chair = $program->programChairs->values()->get($chair_index-1);
        else
            $chair = null;
        return view('portal.program.chair.show', compact(['chair', 'chair_index']));
    }
}
