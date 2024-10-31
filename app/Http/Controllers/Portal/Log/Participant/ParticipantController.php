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
        $logs = $meeting->participantLogs()->orderBy('id', 'DESC')->paginate(50);
        return view('portal.meeting.log.participant.index', compact(['meeting', 'logs']));
    }
    public function show(int $meeting, int $id)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $participant = $meeting->participants()->findOrFail($id);
        $logs = Participant::where('participant_id', $participant->id)->orderBy('id', 'DESC')->paginate(50);
        return view('portal.meeting.participant.log.index', compact(['meeting', 'participant', 'logs']));
    }
}
