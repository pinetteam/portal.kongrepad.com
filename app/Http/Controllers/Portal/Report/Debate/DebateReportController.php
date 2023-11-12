<?php

namespace App\Http\Controllers\Portal\Report\Debate;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DebateReportController extends Controller
{
    public function index()
    {
        $debates = Auth::user()->customer->debates()->paginate(20);
        $on_vote = [
            'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.report.debate-report.index', compact(['debates', 'on_vote']));
    }
    public function showParticipants(string $debate)
    {
        $title = Auth::user()->customer->debates()->findOrFail($debate);
        $votes = Auth::user()->customer->debateVotes()->where('debate_id', $debate)->paginate(20);
        return view('portal.report.debate-report.participant.index', compact(['votes', 'title']));
    }
    public function showReport(string $debate_id)
    {
        $debate = Auth::user()->customer->debates()->findOrFail($debate_id);
        $teams = Auth::user()->customer->teams()->where('debate_id', $debate_id)->paginate(20);
        return view('portal.report.debate-report.show-report', compact(['debate', 'teams']));
    }
}
