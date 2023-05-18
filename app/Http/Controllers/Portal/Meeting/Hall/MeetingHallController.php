<?php

namespace App\Http\Controllers\Portal\Meeting\Hall;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\MeetingHallRequest;
use App\Http\Resources\Portal\Meeting\Hall\MeetingHallResource;
use App\Models\Meeting\Hall\MeetingHall;
use Illuminate\Support\Facades\Auth;

class MeetingHallController extends Controller
{
    public function index()
    {
        $meeting_halls = Auth::user()->customer->meetingHalls()->paginate(20);
        $meetings = Auth::user()->customer->meetings()->where('status', 1)->get();
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting-hall.index', compact(['meeting_halls', 'meetings', 'statuses']));
    }
    public function store(MeetingHallRequest $request)
    {
        if ($request->validated()) {
            $meeting_hall = new MeetingHall();
            $meeting_hall->meeting_id = $request->input('meeting_id');
            $meeting_hall->title = $request->input('title');
            $meeting_hall->status = $request->input('status');
            if ($meeting_hall->save()) {
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(string $id)
    {
        $meeting_hall = Auth::user()->customer->meetingHalls()->findOrFail($id);
        $meeting_halls = Auth::user()->customer->meetingHalls()->where('meeting_halls.status', 1)->get();
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting-hall.show', compact(['meeting_hall', 'meeting_halls', 'statuses']));
    }
    public function edit(string $id)
    {
        $meeting_hall = Auth::user()->customer->meetingHalls()->findOrFail($id);
        return new MeetingHallResource($meeting_hall);
    }
    public function update(MeetingHallRequest $request, string $id)
    {
        if ($request->validated()) {
            $meeting_hall = Auth::user()->customer->meetingHalls()->findOrFail($id);
            $meeting_hall->meeting_id = $request->input('meeting_id');
            $meeting_hall->title = $request->input('title');
            $meeting_hall->status = $request->input('status');
            if ($meeting_hall->save()) {
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(string $id)
    {
        $meeting_hall = Auth::user()->customer->meetingHalls()->findOrFail($id);
        if ($meeting_hall->delete()) {
            $meeting_hall->deleted_by = Auth::user()->id;
            $meeting_hall->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
