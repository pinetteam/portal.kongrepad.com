<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Screen;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Screen\ScreenRequest;
use App\Http\Resources\Portal\Meeting\Hall\Screen\ScreenResource;
use App\Models\Meeting\Hall\Screen\Screen;
use Illuminate\Support\Facades\Auth;

class ScreenController extends Controller
{
    public function index()
    {
        $meeting_halls = Auth::user()->customer->meetingHalls()->get();
        $screens = Auth::user()->customer->screens()->where('meeting_hall_screens.status', 1)->paginate(20);
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.screen.index', compact(['screens', 'statuses', 'meeting_halls']));
    }
    public function store(ScreenRequest $request)
    {
        if ($request->validated()) {
            $screen = new Screen();
            $screen->meeting_hall_id = $request->input('meeting_hall_id');
            $screen->title = $request->input('title');
            $screen->status = $request->input('status');
            if ($screen->save()) {
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(string $id)
    {
        $screen = Auth::user()->customer->screens()->findOrFail($id);
        $screens = Auth::user()->customer->screens()->where('meeting_hall_screens.status', 1)->get();
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.screen.show', compact(['screen', 'screens', 'statuses']));

    }
    public function edit(string $id)
    {
        $screen = Auth::user()->customer->meetingHalls()->findOrFail($id);
        return new ScreenResource($screen);
    }
    public function update(ScreenRequest $request, string $id)
    {
        if ($request->validated()) {
            $screen = Auth::user()->customer->screens()->findOrFail($id);
            $screen->meeting_hall_id = $request->input('meeting_hall_id');
            $screen->title = $request->input('title');
            $screen->status = $request->input('status');
            if ($screen->save()) {
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(string $id)
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
