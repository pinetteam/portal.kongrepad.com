<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Screen;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Screen\ScreenRequest;
use App\Http\Resources\Portal\Meeting\Hall\Screen\ScreenResource;
use App\Models\Meeting\Hall\Screen\Screen;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class ScreenController extends Controller
{
    public function index(int $meeting, int $hall)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $hall = Auth::user()->customer->meetingHalls()->findOrFail($hall);
        $screens = $hall->screens()->paginate(10);
        $types = [
            'participant' => ["value" => "participant", "title" => __('common.participant')],
            'chair' => ["value" => "chair", "title" => __('common.chair')],
            'document' => ["value" => "document", "title" => __('common.document')],
        ];
        $statuses = [
            'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.hall.screen.index', compact(['screens', 'meeting', 'hall', 'types', 'statuses']));
    }
    public function store(ScreenRequest $request, int $meeting, int $hall)
    {
        if ($request->validated()) {
            $screen = new Screen();
            $screen->hall_id = $hall;
            $screen->code = $request->input('code');
            $screen->title = $request->input('title');
            $screen->description = $request->input('description');
            $screen->type = $request->input('type');
            $screen->status = $request->input('status');
            if ($screen->save()) {
                $screen->created_by = Auth::user()->id;
                $screen->save();
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(int $meeting, int $hall, int $id)
    {
        $screen = Auth::user()->customer->screens()->findOrFail($id);
        return view('portal.meeting.hall.screen.show', compact(['screen']));
    }
    public function edit(int $meeting, int $hall, int $id)
    {
        $screen = Auth::user()->customer->screens()->findOrFail($id);
        return new ScreenResource($screen);
    }
    public function update(ScreenRequest $request, int $meeting, int $hall, int $id)
    {
        if ($request->validated()) {
            $screen = Auth::user()->customer->screens()->findOrFail($id);
            $screen->hall_id = $request->input('hall_id');
            $screen->code = $request->input('code');
            $screen->title = $request->input('title');
            $screen->description = $request->input('description');
            $screen->type = $request->input('type');
            $screen->status = $request->input('status');
            if ($screen->save()) {
                $screen->updated_by = Auth::user()->id;
                $screen->save();
                return back()->with('success', __('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(int $meeting, int $hall, int $id)
    {
        $screen = Auth::user()->customer->screens()->findOrFail($id);
        if ($screen->delete()) {
            $screen->deleted_by = Auth::user()->id;
            $screen->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
