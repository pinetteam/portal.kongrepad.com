<?php

namespace App\Http\Controllers\Portal\Meeting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\MeetingRequest;
use App\Http\Resources\Portal\Meeting\MeetingResource;
use App\Models\Meeting\Meeting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MeetingController extends Controller
{
    public function index()
    {
        $meetings = Auth::user()->customer->meetings()->paginate();
        $statuses = [
            'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.index', compact(['meetings', 'statuses']));
    }
    public function store(MeetingRequest $request)
    {
        if ($request->validated()) {
            $meeting = new Meeting();
            $meeting->customer_id = Auth::user()->customer->id;
            if ($request->hasFile('banner')) {
                $file = $request->file('banner');
                $banner_name = Str::uuid()->toString();
                $file_extension = $file->getClientOriginalExtension();
                if(Storage::putFileAs('public/meeting-banners', $request->file('banner'), $banner_name.'.'.$file_extension)) {
                    $meeting->banner_name = $banner_name;
                    $meeting->banner_extension = $file_extension;
                    $meeting->banner_size = $request->file('banner')->getSize();
                } else {
                    return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
                }
            }
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
    public function show(int $id)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($id);
        return view('portal.meeting.show', compact(['meeting']));
    }
    public function edit(int $id)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($id);
        return new MeetingResource($meeting);
    }
    public function update(MeetingRequest $request, int $id)
    {
        if ($request->validated()) {
            $meeting = Auth::user()->customer->meetings()->findOrFail($id);
            if ($request->hasFile('banner')) {
                $file = $request->file('banner');
                $banner_name = Str::uuid()->toString();
                $file_extension = $file->getClientOriginalExtension();
                if(Storage::putFileAs('public/meeting-banners', $request->file('banner'), $banner_name . '.' . $file_extension)) {
                    $meeting->banner_name = $banner_name;
                    $meeting->banner_extension = $file_extension;
                    $meeting->banner_size = $request->file('banner')->getSize();
                } else {
                    return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
                }
            }
            $meeting->code = $request->input('code');
            $meeting->title = $request->input('title');
            $meeting->start_at = $request->input('start_at');
            $meeting->finish_at = $request->input('finish_at');
            $meeting->status = $request->input('status');
            if ($meeting->save()) {
                $meeting->updated_by = Auth::user()->id;
                $meeting->save();
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy($id)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($id);
        if ($meeting->delete()) {
            $meeting->deleted_by = Auth::user()->id;
            $meeting->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
