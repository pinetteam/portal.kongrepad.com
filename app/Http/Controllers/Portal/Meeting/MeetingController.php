<?php

namespace App\Http\Controllers\Portal\Meeting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\MeetingRequest;
use App\Http\Resources\Portal\Meeting\MeetingResource;
use App\Models\Meeting\Meeting;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{
    public function index()
    {
        $meetings = Auth::user()->customer->meetings()->paginate(20);
        $statuses = [
            'passive' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'active' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.index', compact(['meetings', 'statuses']));
    }
    public function store(MeetingRequest $request)
    {
        if ($request->validated()) {
            $meeting = new Meeting();
            $meeting->customer_id = Auth::user()->customer->id;
            $meeting->code = $request->input('code');
            $meeting->title = $request->input('title');
            $meeting->start_at = $request->input('start_at');
            $meeting->finish_at = $request->input('finish_at');
            $meeting->status = $request->input('status');
            if ($meeting->save()) {
                $meeting->created_by = Auth::user()->id;
                $meeting->save();
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show($id)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($id);
        $meeting_halls = $meeting->halls()->get();
        $surveys = $meeting->surveys()->get();
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.show', compact(['meeting', 'meeting_halls', 'surveys', 'statuses']));

    }
    public function edit($id)
    {
        $user = Auth::user()->customer->meetings()->findOrFail($id);
        return new MeetingResource($user);
    }
    public function update(MeetingRequest $request, $id)
    {
        if ($request->validated()) {
            $meeting = Auth::user()->customer->meetings()->findOrFail($id);
            $meeting->code = $request->input('code');
            $meeting->title = $request->input('title');
            $meeting->start_at = $request->input('start_at');
            $meeting->finish_at = $request->input('finish_at');
            $meeting->status = $request->input('status');
            if ($meeting->save()) {
                $meeting->edited_by = Auth::user()->id;
                $meeting->save();
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy($id)
    {
        $user = Auth::user()->customer->meetings()->findOrFail($id);
        if ($user->delete()) {
            $user->deleted_by = Auth::user()->id;
            $user->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
