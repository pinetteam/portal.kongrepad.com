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
        $meeting_halls = Auth::user()->customer->meetingHalls()->where('meeting_halls.status', 1)->get();
        $types = [
            'session' => ["value" => "session", "title" => __('common.session')],
            'break' => ["value" => "break", "title" => __('common.break')],
            'other' => ["value" => "break", "title" => __('common.other')],
        ];
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.session.index', compact(['sessions', 'meeting_halls', 'types', 'statuses']));
    }
    public function store(SessionRequest $request)
    {
        if ($request->validated()) {
            $session = new Session();
            $session->meeting_hall_id = $request->input('meeting_hall_id');
            $session->sort_id = $request->input('sort_id');
            $session->code = $request->input('code');
            $session->title = $request->input('title');
            $session->description = $request->input('description');
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
            $session->main_session_id = $request->input('main_session_id');
            $session->meeting_hall_id = $request->input('meeting_hall_id');
            $session->sort_id = $request->input('sort_id');
            $session->code = $request->input('code');
            $session->title = $request->input('title');
            $session->description = $request->input('description');
            $session->start_at = $request->input('start_at');
            $session->finish_at = $request->input('finish_at');
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
