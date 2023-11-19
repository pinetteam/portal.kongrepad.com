<?php

namespace App\Http\Controllers\Portal\Report\Debate;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DebateController extends Controller
{
    public function index(int $meeting)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $debates = $meeting->debates()->paginate(20);
        $on_vote = [
            'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.report.debate.index', compact(['meeting', 'debates', 'on_vote']));
    }
    public function showParticipants(int $meeting, int $id)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $title = $meeting->debates()->findOrFail($id);
        $votes = Auth::user()->customer->debateVotes()->where('debate_id', $id)->paginate(20);
        return view('portal.meeting.report.debate.participant.index', compact(['votes', 'title']));
    }
    public function showReport(int $meeting, int $id)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $debate = $meeting->debates()->findOrFail($id);
        $teams = Auth::user()->customer->teams()->where('debate_id', $id)->paginate(20);
        return view('portal.meeting.report.debate.report', compact(['debate', 'teams']));
    }
}
