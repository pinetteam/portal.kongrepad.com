<?php

namespace App\Http\Controllers\Portal\Meeting\Participant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Participant\ParticipantRequest;
use App\Http\Resources\Portal\Meeting\Participant\ParticipantResource;
use App\Models\Meeting\ScoreGame\Point\Point;
use Illuminate\Http\Request;
use App\Models\Meeting\Participant\Participant;
use App\Models\System\Country\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ParticipantController extends Controller
{
    public function index(Request $request, int $meeting)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        if ($request->has('search')){
            $participants = $meeting->participants()->orderBy('last_name')->searchByName($request->input('search'))->paginate();
        }
        else {
            $participants = $meeting->participants()->orderBy('last_name')->paginate();
        }
        $phone_countries = Country::get();
        $types = [
            'agent' => ['value' => 'agent', 'title' => __('common.agent')],
            'attendee' => ['value' => 'attendee', 'title' => __('common.attendee')],
            'team' => ['value' => 'team', 'title' => __('common.team')],
        ];
        $statuses = [
            'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.participant.index', compact(['meeting', 'participants', 'phone_countries', 'types', 'statuses']));
    }

    public function search(Request $request, int $meeting)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $name = $request->input('search');
        $participants = $meeting->participants()->orderBy('last_name')->searchByName($name)->paginate();
        $phone_countries = Country::get();
        $types = [
            'agent' => ['value' => 'agent', 'title' => __('common.agent')],
            'attendee' => ['value' => 'attendee', 'title' => __('common.attendee')],
            'team' => ['value' => 'team', 'title' => __('common.team')],
        ];
        $statuses = [
            'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
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
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $participant = $meeting->participants()->findOrFail($id);
        $survey_votes = \App\Models\Meeting\Survey\Vote\Vote::where('participant_id', $participant->id)->groupBy('survey_id')->get();
        $debate_votes = \App\Models\Meeting\Hall\Program\Debate\Vote\Vote::where('participant_id', $participant->id)->groupBy('debate_id')->get();
        $keypad_votes = \App\Models\Meeting\Hall\Program\Session\Keypad\Vote\Vote::where('participant_id', $participant->id)->groupBy('keypad_id')->get();
        $requested_documents = \App\Models\Meeting\Document\Mail\Mail::where('participant_id', $participant->id)->groupBy('document_id')->get();
        $score_game_points = Point::where('participant_id', $participant->id)->get();
        $logs = \App\Models\Log\Meeting\Participant\Participant::where('participant_id', $participant->id)->orderBy('id', 'DESC')->whereNot('action', 'get-participant')->whereNot('action', 'get-meeting')->whereNot('action', 'get-active-session')->whereNot('action', 'get-survey')->whereNot('action', 'get-active-debate')->whereNot('action', 'get-survey-questions')->whereNot('action', 'get-hall')->whereNot('action', 'get-halls')->get();
        return view('portal.meeting.participant.show', compact(['debate_votes', 'keypad_votes', 'meeting', 'participant', 'requested_documents', 'survey_votes', 'score_game_points', 'logs']));
    }
    public function edit(int $meeting, int $id)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $participant = $meeting->participants()->findOrFail($id);
        return new ParticipantResource($participant);
    }
    public function update(ParticipantRequest $request, int $meeting, int $id)
    {
        if ($request->validated()) {
            $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
            $participant = $meeting->participants()->findOrFail($id);
            $participant->title = $request->input('title');
            $participant->first_name = $request->input('first_name');
            $participant->last_name = $request->input('last_name');
            $participant->identification_number = $request->input('identification_number');
            $participant->organisation = $request->input('organisation');
            $participant->email = $request->input('email');
            $participant->phone_country_id = $request->input('phone_country_id');
            $participant->type = $request->input('type');
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
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $participant = $meeting->participants()->findOrFail($id);
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
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $participant = $meeting->participants()->findOrFail($id);
        return QrCode::size(256)->generate($participant->username);
    }
    public function showSurvey(int $meeting, int $id, int $survey)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $participant = $meeting->participants()->findOrFail($id);
        $survey = Auth::user()->customer->surveys()->findOrFail($survey);
        $survey_votes = $survey->votes()->where('participant_id', $id)->paginate(20);;
        return view('portal.meeting.participant.show-survey.index', compact(['participant', 'survey', 'survey_votes']) );
    }
}
