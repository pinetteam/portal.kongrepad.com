<?php

namespace App\Http\Controllers\API\Meeting\Hall;

use App\Events\FormSubmitted;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\MeetingHallRequest;
use App\Http\Resources\Portal\Meeting\Hall\MeetingHallResource;
use App\Models\Meeting\Hall\MeetingHall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeetingHallController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->meeting->halls()->get();
    }
    public function store(MeetingHallRequest $request)
    {
        if ($request->validated()) {
            $meeting_hall = new MeetingHall();
            $meeting_hall->meeting_id = $request->input('meeting_id');
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
    public function show(Request $request, string $meeting_id, string $meeting_hall_id)
    {

        return new MeetingHallResource($request->user()->meeting->halls()->findOrFail($meeting_hall_id)) ;
    }
    public function active_document(Request $request, string $meeting_id,string $id)
    {
        $meeting_hall =  $request-user()->meeting->meetingHalls()->where('meeting_id',$meeting_id)->where("meeting_halls.id",$id)->first();
        return $meeting_hall->programSessions()->where('is_started', 1)->first()->document()->get();
    }
}
