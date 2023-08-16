<?php

namespace App\Http\Controllers\Portal\Meeting\Participant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Participant\ParticipantRequest;
use App\Http\Resources\Portal\Meeting\Participant\ParticipantResource;
use App\Models\Meeting\Meeting;
use App\Models\Meeting\Participant\Participant;
use App\Models\System\Country\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ParticipantController extends Controller
{
    public function index(int $meeting)
    {
        $meeting = Meeting::findOrFail($meeting);
        $participants = Auth::user()->customer->participants()->where('meeting_id', $meeting->id)->paginate(20);
        $phone_countries = Country::get(['id', 'name']);
        $types = [
            'agent' => ["value" => "agent", "title" => __('common.agent')],
            'attendee' => ["value" => "attendee", "title" => __('common.attendee')],
            'team' => ["value" => "team", "title" => __('common.team')],
        ];
        $statuses = [
            'passive' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'active' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.participant.index', compact(['meeting', 'participants', 'phone_countries', 'types', 'statuses']));
    }
    public function store(ParticipantRequest $request, int $meeting)
    {
        if ($request->validated()) {
            $participant = new Participant();
            $participant->meeting_id = $meeting;
            $participant->username = Str::uuid()->toString();
            $participant->title = $request->input('title');
            $participant->first_name = $request->input('first_name');
            $participant->last_name = $request->input('last_name');
            $participant->identification_number = $request->input('identification_number');
            $participant->organisation = $request->input('organisation');
            $participant->email = $request->input('email');
            $participant->phone_country_id = $request->input('phone_country_id');
            $participant->phone = $request->input('phone');
            $participant->password = $request->input('password');
            $participant->type = $request->input('type');
            $participant->status = $request->input('status');
            if ($participant->save()) {
                $participant->created_by = Auth::user()->id;
                $participant->save();
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(int $meeting, int $id)
    {
        $participant = Auth::user()->customer->participants()->where('meeting_id', $meeting)->findOrFail($id);
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.participant.show', compact(['participant', 'statuses']));
    }
    public function edit(int $meeting, int $id)
    {
        $participant = Auth::user()->customer->participants()->where('meeting_id', $meeting)->findOrFail($id);
        return new ParticipantResource($participant);
    }
    public function update(ParticipantRequest $request, int $meeting, int $id)
    {
        if ($request->validated()) {
            $participant = Auth::user()->customer->participants()->where('meeting_id', $meeting)->findOrFail($id);
            $participant->title = $request->input('title');
            $participant->first_name = $request->input('first_name');
            $participant->last_name = $request->input('last_name');
            $participant->identification_number = $request->input('identification_number');
            $participant->organisation = $request->input('organisation');
            $participant->email = $request->input('email');
            $participant->phone_country_id = $request->input('phone_country_id');
            $participant->phone = $request->input('phone');
            if ($request->has('password')) {
                $participant->password = $request->input('password');
            }
            $participant->status = $request->input('status');
            if ($participant->save()) {
                $participant->updated_by = Auth::user()->id;
                $participant->save();
                return back()->with('success', __('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(int $meeting, int $id)
    {
        $participant = Auth::user()->customer->participants()->where('meeting_id', $meeting)->findOrFail($id);
        if ($participant->delete()) {
            $participant->deleted_by = Auth::user()->id;
            $participant->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
    public function qrCode(int $meeting, int $id)
    {
        $participant = Auth::user()->customer->participants()->where('meeting_id', $meeting)->findOrFail($id);
        return QrCode::size(200)->generate($participant->username);
    }
}
