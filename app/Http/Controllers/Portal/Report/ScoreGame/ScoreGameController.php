<?php

namespace App\Http\Controllers\Portal\Report\ScoreGame;

use App\Http\Controllers\Controller;
use App\Models\Meeting\Participant\Participant;
use Illuminate\Support\Facades\Auth;

class ScoreGameController extends Controller
{
    public function index()
    {
        $score_games = Auth::user()->customer->scoreGames()->paginate(20);
        return view('portal.report.score-game.index', compact(['score_games']));
    }
    public function show(int $id)
    {
        $score_game = Auth::user()->customer->scoreGames()->findOrFail($id);
        $participants = $score_game->meeting->participants;
        $participants = $participants->sortByDesc(function ($participant) use ($score_game) {
            return $participant->getTotalScoreGamePoint($score_game->id);
        });
        return view('portal.report.score-game.show', compact(['score_game', 'participants']));
    }
}
