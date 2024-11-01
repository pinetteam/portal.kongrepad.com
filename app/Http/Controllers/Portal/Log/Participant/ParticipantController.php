<?php

namespace App\Http\Controllers\Portal\Log\Participant;

use App\Http\Controllers\Controller;
use App\Models\Log\Meeting\Participant\Participant;
use Illuminate\Support\Facades\Auth;

class ParticipantController extends Controller
{
    public function index(int $meeting)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $logs = \App\Models\Log\Meeting\Participant\Participant::whereNot('action', 'get-participant')->whereNot('action', 'get-meeting')->whereNot('action', 'get-active-session')->whereNot('action', 'get-survey')->whereNot('action', 'get-active-debate')->whereNot('action', 'get-survey-questions')->whereNot('action', 'get-hall')->whereNot('action', 'get-halls')->whereNot('action', 'get-documents')->whereNot('action', 'get-virtual-stand')->orderBy('id', 'DESC')->paginate(250);
        return view('portal.meeting.log.participant.index', compact(['meeting', 'logs']));
    }
    public function show(int $meeting, int $id)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $participant = $meeting->participants()->findOrFail($id);
        $logs = \App\Models\Log\Meeting\Participant\Participant::where('participant_id', $participant->id)->orderBy('id', 'DESC')->whereNot('action', 'get-participant')->whereNot('action', 'get-meeting')->whereNot('action', 'get-active-session')->whereNot('action', 'get-survey')->whereNot('action', 'get-active-debate')->whereNot('action', 'get-survey-questions')->whereNot('action', 'get-hall')->whereNot('action', 'get-halls')->whereNot('action', 'get-documents')->whereNot('action', 'get-virtual-stand')->get();
        return view('portal.meeting.participant.log.index', compact(['meeting', 'participant', 'logs']));
    }
}
