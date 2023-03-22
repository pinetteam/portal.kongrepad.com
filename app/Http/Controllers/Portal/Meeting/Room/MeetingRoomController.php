<?php

namespace App\Http\Controllers\Portal\Meeting\Room;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Room\MeetingRoomRequest;
use App\Http\Resources\Portal\Meeting\Room\MeetingRoomResource;
use App\Models\Meeting\Room\MeetingRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeetingRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meeting_rooms = MeetingRoom::paginate(20);
        $meetings = Auth::user()->customer->meetings;
        $status_options = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting-room.index', compact(['meeting_rooms', 'meetings', 'status_options']));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MeetingRoomRequest $request)
    {
        if ($request->validated()) {
            $meeting_room = new MeetingRoom();
            $meeting_room->meeting_id = $request->input('meeting_id');
            $meeting_room->title = $request->input('title');
            $meeting_room->status = $request->input('status');
            if ($meeting_room->save()) {
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $meeting_room = Auth::user()->customer->meetingRooms()->findOrFail($id);
        return new MeetingRoomResource($meeting_room);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MeetingRoomRequest $request, string $id)
    {
        if ($request->validated()) {
            $meeting_room = Auth::user()->customer->meetingRooms()->findOrFail($id);
            $meeting_room->meeting_id = $request->input('meeting_id');
            $meeting_room->title = $request->input('title');
            $meeting_room->status = $request->input('status');
            if ($meeting_room->save()) {
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $meeting_room = Auth::user()->customer->meetingRooms()->findOrFail($id);
        if ($meeting_room->delete()) {
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
