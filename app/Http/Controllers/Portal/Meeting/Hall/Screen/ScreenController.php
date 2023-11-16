<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Screen;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Screen\ScreenRequest;
use App\Http\Resources\Portal\Meeting\Hall\Screen\ScreenResource;
use App\Models\Meeting\Hall\Screen\Screen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ScreenController extends Controller
{
    public function index(int $meeting, int $hall)
    {
        $hall = Auth::user()->customer->halls()->findOrFail($hall);
        $screens = $hall->screens()->paginate(10);
        $types = [
            'chair' => ['value' => 'chair', 'title' => __('common.chair')],
            'document' => ['value' => 'document', 'title' => __('common.document')],
            'keypad' => ['value' => 'keypad', 'title' => __('common.keypad')],
            'questions' => ['value' => 'questions', 'title' => __('common.questions')],
            'speaker' => ['value' => 'speaker', 'title' => __('common.speaker')],
            'timer' => ['value' => 'timer', 'title' => __('common.timer')],
        ];
        $statuses = [
            'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.hall.screen.index', compact(['hall', 'screens', 'types', 'statuses']));
    }
    public function store(ScreenRequest $request, int $meeting, int $hall)
    {
        if ($request->validated()) {
            $screen = new Screen();
            $screen->hall_id = $hall;
            $screen->code = Str::uuid()->toString();
            $screen->title = $request->input('title');
            $screen->description = $request->input('description');
            $screen->font = $request->input('font');
            $screen->font_size = $request->input('font_size');
            $screen->type = $request->input('type');
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $file_name = Str::uuid()->toString();
                $file_extension = $file->getClientOriginalExtension();
                if(Storage::putFileAs('public/screen-backgrounds', $request->file('logo'), $file_name . '.' . $file_extension)) {
                    $screen->logo_name = $file_name;
                    $screen->logo_extension = $file_extension;
                } else {
                    return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
                }
            }
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
        $hall = Auth::user()->customer->halls()->findOrFail($hall);
        $screen = $hall->screens()->findOrFail($id);
        return view('portal.meeting.hall.screen.show', compact(['screen']));
    }
    public function edit(int $meeting, int $hall, int $id)
    {
        $hall = Auth::user()->customer->halls()->findOrFail($hall);
        $screen = $hall->screens()->findOrFail($id);
        return new ScreenResource($screen);
    }
    public function update(ScreenRequest $request, int $meeting, int $hall, int $id)
    {
        if ($request->validated()) {
            $hall = Auth::user()->customer->halls()->findOrFail($hall);
            $screen = $hall->screens()->findOrFail($id);
            $screen->hall_id = $request->input('hall_id');
            $screen->title = $request->input('title');
            $screen->description = $request->input('description');
            $screen->font = $request->input('font');
            $screen->font_size = $request->input('font_size');
            $screen->type = $request->input('type');
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $file_name = Str::uuid()->toString();
                $file_extension = $file->getClientOriginalExtension();
                if(Storage::putFileAs('public/screen-backgrounds', $request->file('logo'), $file_name . '.' . $file_extension)) {
                    $screen->logo_name = $file_name;
                    $screen->logo_extension = $file_extension;
                } else {
                    return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
                }
            }
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
        $hall = Auth::user()->customer->halls()->findOrFail($hall);
        $screen = $hall->screens()->findOrFail($id);
        if ($screen->delete()) {
            $screen->deleted_by = Auth::user()->id;
            $screen->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
