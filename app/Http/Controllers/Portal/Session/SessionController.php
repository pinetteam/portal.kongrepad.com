<?php

namespace App\Http\Controllers\Portal\Session;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Session\SessionRequest;
use App\Http\Resources\Portal\Session\SessionResource;
use App\Models\Session\Session;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = Auth::user()->customer->sessions()->paginate(20);
        $main_sessions = Auth::user()->customer->sessions()->where('type', 'main-session')->whereNull('session_id')->get();
        $meeting_halls = Auth::user()->customer->meetingHalls()->get();
        $types = [
            'main-session' => ["value" => "main-session", "title" => __('common.main-session')],
            'event' => ["value" => "event", "title" => __('common.event')],
            'course' => ["value" => "course", "title" => __('common.course')],
            'presentation' => ["value" => "presentation", "title" => __('common.presentation')],
            'break' => ["value" => "break", "title" => __('common.break')],
            'other' => ["value" => "break", "title" => __('common.other')],
        ];
        $status_options = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.session.index', compact(['sessions', 'main_sessions', 'meeting_halls', 'types', 'status_options']));
    }
    public function store(SessionRequest $request)
    {
        if ($request->validated()) {
            $session = new Session();
            $session->session_id = $request->input('session_id');
            $session->meeting_hall_id = $request->input('meeting_hall_id');
            $session->sort_id = $request->input('sort_id');
            $session->code = $request->input('code');
            $session->title = $request->input('title');
            $session->description = $request->input('description');
            $session->date = $request->input('date');
            $session->start_at = $request->input('start_at');
            $session->finish_at = $request->input('finish_at');
            $session->type = $request->input('type');
            $session->status = $request->input('status');
            if ($session->save()) {
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show($id)
    {

    }
    public function edit($id)
    {
        $session = Auth::user()->customer->sessions()->findOrFail($id);
        return new SessionResource($session);
    }
    public function update(SessionRequest $request, $id)
    {
        if ($request->validated()) {
            $session = Auth::user()->customer->sessions()->findOrFail($id);
            $session->session_id = $request->input('session_id');
            $session->meeting_hall_id = $request->input('meeting_hall_id');
            $session->sort_id = $request->input('sort_id');
            $session->code = $request->input('code');
            $session->title = $request->input('title');
            $session->description = $request->input('description');
            $session->date = $request->input('date');
            $session->start_at = $request->input('start_at');
            $session->finish_at = $request->input('finish_at');
            $session->type = $request->input('type');
            $session->status = $request->input('status');
            if ($session->save()) {
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy($id)
    {
        $session = Auth::user()->customer->sessions()->findOrFail($id);
        if ($session->delete()) {
            $session->deleted_by = Auth::user()->id;
            $session->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
