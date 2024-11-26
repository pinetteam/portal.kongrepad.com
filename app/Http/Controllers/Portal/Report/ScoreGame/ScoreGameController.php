<?php

namespace App\Http\Controllers\Portal\Report\ScoreGame;

use App\Http\Controllers\Controller;
use App\Models\Log\Meeting\Participant\Participant;
use App\Models\Meeting\ScoreGame\Point\Point;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScoreGameController extends Controller
{
    public function index(int $meeting)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $score_games = $meeting->scoreGames()->paginate(20);
        return view('portal.meeting.report.score-game.index', compact(['meeting', 'score_games']));
    }
    public function show(int $meeting, int $id)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $score_game = $meeting->scoreGames()->findOrFail($id);
        $score_game_points = $score_game->points()
            ->select('meeting_score_game_points.*', DB::raw('SUM(meeting_score_game_points.point) as total_points'))
            ->groupBy('meeting_score_game_points.participant_id')->orderBy('total_points', 'DESC')->paginate(300);
        return view('portal.meeting.report.score-game.show', compact(['score_game', 'score_game_points']));
    }
}
