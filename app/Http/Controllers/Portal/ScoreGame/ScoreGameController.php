<?php

namespace App\Http\Controllers\Portal\ScoreGame;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\ScoreGame\ScoreGameRequest;
use App\Http\Resources\Portal\ScoreGame\ScoreGameResource;
use App\Models\ScoreGame\ScoreGame;
use Illuminate\Support\Facades\Auth;

class ScoreGameController extends Controller
{
    public function index()
    {
        $score_games = Auth::user()->customer->scoreGames()->paginate(20);
        $meetings = Auth::user()->customer->meetings()->where('status', 1)->get();
        $types = [
            'agent' => ["value" => "agent", "title" => __('common.agent')],
            'attendee' => ["value" => "attendee", "title" => __('common.attendee')],
            'team' => ["value" => "team", "title" => __('common.team')],
        ];
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.score-game.index', compact(['score_games', 'meetings', 'statuses', 'types']));
    }
    public function store(ScoreGameRequest $request)
    {
        if ($request->validated()) {
            $score_game = new ScoreGame();
            $score_game->meeting_id = $request->input('meeting_id');
            $score_game->start_at = $request->input('start_at');
            $score_game->finish_at = $request->input('finish_at');
            $score_game->title = $request->input('title');
            $score_game->types = $request->input('types');
            $score_game->status = $request->input('status');
            if ($score_game->save()) {
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(string $id)
    {
        $score_game = Auth::user()->customer->scoreGames()->findOrFail($id);
        $score_games = Auth::user()->customer->scoreGames()->where('score_games.status', 1)->get();
        $scores = $score_game->scores()->paginate(10);
        $score_game_qr_codes = $score_game->qrCodes()->get();
        $types = [
            'agent' => ["value" => "agent", "title" => __('common.agent')],
            'attendee' => ["value" => "attendee", "title" => __('common.attendee')],
            'team' => ["value" => "team", "title" => __('common.team')],
        ];
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.score-game.show', compact(['scores', 'score_game', 'score_games', 'score_game_qr_codes', 'statuses', 'types']));

    }
    public function edit(string $id)
    {
        $score_game = Auth::user()->customer->scoreGames()->findOrFail($id);
        return new ScoreGameResource($score_game);
    }
    public function update(ScoreGameRequest $request, string $id)
    {
        if ($request->validated()) {
            $score_game = Auth::user()->customer->scoreGames()->findOrFail($id);
            $score_game->meeting_id = $request->input('meeting_id');
            $score_game->title = $request->input('title');
            $score_game->start_at = $request->input('start_at');
            $score_game->finish_at = $request->input('finish_at');
            $score_game->status = $request->input('status');
            if ($score_game->save()) {
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(string $id)
    {
        $score_game = Auth::user()->customer->scoreGames()->findOrFail($id);
        if ($score_game->delete()) {
            $score_game->deleted_by = Auth::user()->id;
            $score_game->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
