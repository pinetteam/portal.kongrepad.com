<?php

namespace App\Http\Controllers\Portal\Meeting\Hall;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\HallRequest;
use App\Http\Resources\Portal\Meeting\Hall\HallResource;
use App\Models\Meeting\Hall\Hall;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HallController extends Controller
{
    public function index(int $meeting)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $halls = $meeting->halls()->paginate(20);
        $statuses = [
            'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.hall.index', compact(['meeting', 'halls', 'statuses']));
    }
    public function store(HallRequest $request, int $meeting)
    {
        if ($request->validated()) {
            $hall = new Hall();
            $hall->meeting_id = $meeting;
            $hall->code = Str::uuid()->toString();
            $hall->title = $request->input('title');
            $hall->show_on_session = $request->input('show_on_session');
            $hall->show_on_view_program = $request->input('show_on_view_program');
            $hall->show_on_ask_question = $request->input('show_on_ask_question');
            $hall->show_on_send_mail = $request->input('show_on_send_mail');
            $hall->status = $request->input('status');
            if ($hall->save()) {
                $hall->created_by = Auth::user()->id;
                $hall->save();
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(int $meeting, int $id)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $hall = $meeting->halls()->findOrFail($id);
        return view('portal.meeting.hall.show', compact(['meeting', 'hall']));
    }
    public function edit(int $meeting, int $id)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $hall = $meeting->halls()->findOrFail($id);
        return new HallResource($hall);
    }
    public function update(HallRequest $request, int $meeting, int $id)
    {
        if ($request->validated()) {
            $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
            $hall = $meeting->halls()->findOrFail($id);
            $hall->title = $request->input('title');
            $hall->show_on_session = $request->input('show_on_session');
            $hall->show_on_view_program = $request->input('show_on_view_program');
            $hall->show_on_ask_question = $request->input('show_on_ask_question');
            $hall->show_on_send_mail = $request->input('show_on_send_mail');
            $hall->status = $request->input('status');
            if ($hall->save()) {
                $hall->updated_by = Auth::user()->id;
                $hall->save();
                return back()->with('success', __('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(int $meeting, int $id)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $hall = $meeting->halls()->findOrFail($id);
        if ($hall->delete()) {
            $hall->deleted_by = Auth::user()->id;
            $hall->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
