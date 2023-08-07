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
        $halls = Auth::user()->customer->meetingHalls()->where('meeting_id', $meeting)->paginate(20);
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.hall.index', compact(['halls', 'meeting', 'statuses']));
    }
    public function store(HallRequest $request, int $meeting)
    {
        if ($request->validated()) {
            $hall = new Hall();
            $hall->meeting_id = $meeting;
            $hall->title = $request->input('title');
            $hall->status = $request->input('status');
            if ($hall->save()) {
                $hall->created_by = Auth::user()->id;
                $hall->save();
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(int $meeting, int $id)
    {
        $hall = Auth::user()->customer->meetingHalls()->where('meeting_id', $meeting)->findOrFail($id);
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.hall.show', compact(['hall', 'meeting', 'statuses']));
    }
    public function edit(int $meeting, int $id)
    {
        $hall = Auth::user()->customer->meetingHalls()->where('meeting_id', $meeting)->findOrFail($id);
        return new HallResource($hall);
    }
    public function update(HallRequest $request, int $meeting, int $id)
    {
        if ($request->validated()) {
            $hall = Auth::user()->customer->meetingHalls()->where('meeting_id', $meeting)->findOrFail($id);
            $hall->meeting_id = $meeting;
            $hall->title = $request->input('title');
            $hall->status = $request->input('status');
            if ($hall->save()) {
                $hall->updated_by = Auth::user()->id;
                $hall->save();
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(int $meeting, int $id)
    {
        $hall = Auth::user()->customer->meetingHalls()->where('meeting_id', $meeting)->findOrFail($id);
        if ($hall->delete()) {
            $hall->deleted_by = Auth::user()->id;
            $hall->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }

    public function current_speaker(string $id)
    {
        $hall = Auth::user()->customer->meetingHalls()->findOrFail($id);
        $session = $hall->programSessions()->where('is_started',1)->first();
        $speaker = $session && $session->program->on_air && $session ? $session->speaker : null;
        event(new FormSubmitted("sdsdsd"));
        return view('portal.current-speaker.show', compact(['speaker']));
    }

    public function chair_board(string $id)
    {
        $hall = Auth::user()->customer->meetingHalls()->findOrFail($id);
        $session = $hall->programSessions()->where('is_started',1)->first();
        $questions = $session && $session->program->on_air ? $session->questions()->get() : null;
        return view('portal.chair-board.index', compact(['session', 'questions']));
    }

    public function current_chair(string $id, string $chair_index)
    {
        $hall = Auth::user()->customer->meetingHalls()->findOrFail($id);
        $program = $hall->programs()->where('on_air',1)->first();
        if(isset($program))
            $chair = $program->programChairs->values()->get($chair_index-1);
        else
            $chair = null;
        return view('portal.program.chair.show', compact(['chair', 'chair_index']));
    }
}
