<?php

namespace App\Http\Controllers\Portal\Meeting\Announcement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Announcement\AnnouncementRequest;
use App\Http\Resources\Portal\Meeting\Announcement\AnnouncementResource;
use App\Models\Meeting\Announcement\Announcement;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index(int $meeting)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $announcements = $meeting->announcements()->paginate(20);
        $statuses = [
            'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.announcement.index', compact(['meeting', 'announcements', 'statuses']));
    }
    public function store(AnnouncementRequest $request, int $meeting)
    {
        if ($request->validated()) {
            $announcement = new Announcement();
            $announcement->meeting_id = $meeting;
            $announcement->title = $request->input('title');
            $announcement->status = $request->input('status');
            if ($announcement->save()) {
                $announcement->created_by = Auth::user()->id;
                $announcement->save();
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(int $meeting, int $id)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $announcement = $meeting->announcements()->findOrFail($id);
        return view('portal.meeting.announcement.show', compact(['announcement', 'meeting']));
    }
    public function edit(int $meeting, int $id)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $announcement = $meeting->announcements()->findOrFail($id);
        return new AnnouncementResource($announcement);
    }
    public function update(AnnouncementRequest $request, int $meeting, int $id)
    {
        if ($request->validated()) {
            $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
            $announcement = $meeting->announcements()->findOrFail($id);
            $announcement->title = $request->input('title');
            $announcement->status = $request->input('status');
            if ($announcement->save()) {
                $announcement->updated_by = Auth::user()->id;
                $announcement->save();
                return back()->with('success', __('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(string $meeting, string $id)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $announcement = $meeting->announcements()->findOrFail($id);
        if ($announcement->delete()) {
            $announcement->deleted_by = Auth::user()->id;
            $announcement->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
