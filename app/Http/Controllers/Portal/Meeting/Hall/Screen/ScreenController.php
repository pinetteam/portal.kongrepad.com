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
            'debate' => ['value' => 'debate', 'title' => __('common.debate')],
            'keypad' => ['value' => 'keypad', 'title' => __('common.keypad')],
            'questions' => ['value' => 'questions', 'title' => __('common.questions')],
            'speaker' => ['value' => 'speaker', 'title' => __('common.speaker')],
            'timer' => ['value' => 'timer', 'title' => __('common.timer')],
        ];
        $fonts = [
            'Roboto' => ['value' => 'Roboto', 'title' => 'Roboto', 'font_type' => 'Roboto'],
            'Hedvig Letters Serif' => ['value' => 'Hedvig Letters Serif', 'title' => 'Hedvig Letters Serif', 'font_type' => 'Hedvig Letters Serif'],
            'Open Sans' => ['value' => 'Open Sans', 'title' => 'Open Sans', 'font_type' => 'Open Sans'],
            'Montserrat' => ['value' => 'Montserrat', 'title' => 'Montserrat', 'font_type' => 'Montserrat'],
            'Nunito' => ['value' => 'Nunito', 'title' => 'Nunito', 'font_type' => 'Nunito'],
        ];
        $statuses = [
            'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.hall.screen.index', compact(['hall', 'fonts', 'screens', 'types', 'statuses']));
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
            $screen->font_color = $request->input('font_color');
            $screen->type = $request->input('type');
            if ($request->hasFile('background')) {
                $file = $request->file('background');
                $file_name = Str::uuid()->toString();
                $file_extension = $file->getClientOriginalExtension();
                if(Storage::putFileAs('public/screen-backgrounds', $request->file('background'), $file_name . '.' . $file_extension)) {
                    $screen->background_name = $file_name;
                    $screen->background_extension = $file_extension;
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
            $screen->font_color = $request->input('font_color');
            $screen->type = $request->input('type');
            if ($request->hasFile('background')) {
                $file = $request->file('background');
                $file_name = Str::uuid()->toString();
                $file_extension = $file->getClientOriginalExtension();
                if(Storage::putFileAs('public/screen-backgrounds', $request->file('background'), $file_name . '.' . $file_extension)) {
                    $screen->background_name = $file_name;
                    $screen->background_extension = $file_extension;
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
