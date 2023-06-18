<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $meetings = Auth::user()->customer->meetings()->where('status','1')->paginate(20);
        $participants = Auth::user()->customer->participantsLastLogin()->take(10)->get();
        $document_count = 0;
        $meeting_hall_count = 0;
        $participant_count = 0;
        $program_count = 0;
        $session_count = 0;
        $debate_count = 0;
        $chair_count = 0;
        $survey_count = 0;
        $score_game_count = 0;
        foreach($meetings as $meeting){
            $document_count += $meeting->documents()->where('status','1')->count();
            $meeting_hall_count += $meeting->halls()->where('status','1')->count();
            $participant_count += $meeting->participants()->where('status','1')->count();
            $program_count += $meeting->programs()->where('meeting_hall_programs.status','1')->count();
            $session_count += $meeting->programSessions()->where('meeting_hall_program_sessions.status','1')->count();
            $debate_count += $meeting->debates()->where('meeting_hall_program_debates.status','1')->count();
            // todo -> survey eklendikten sonra düzeltilecek
            // $survey_count += $meeting->surveys()->where('meeting_hall_surveys.status','1')->count();
            $score_game_count += $meeting->scoreGames()->where('meeting_score_games.status','1')->count();
            $chair_count += $meeting->programChairs()->count();
        }
        return view('portal.dashboard.index', compact(['meetings', 'participants', 'chair_count', 'score_game_count', 'survey_count', 'program_count', 'debate_count', 'session_count', 'document_count', 'meeting_hall_count', 'participant_count', ]));
    }
}
