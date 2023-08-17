<?php

namespace App\Http\Controllers\Portal\Meeting\ScoreGame;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\ScoreGame\ScoreGameRequest;
use App\Http\Resources\Portal\Meeting\ScoreGame\ScoreGameResource;
use App\Models\Meeting\ScoreGame\ScoreGame;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class ScoreGameController extends Controller
{
    public function index(int $meeting)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $score_games = $meeting->scoreGames()->paginate(20);
        $statuses = [
            'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.score-game.index', compact(['meeting', 'score_games', 'statuses']));
    }
    public function store(ScoreGameRequest $request)
    {
        if ($request->validated()) {
            $score_game = new ScoreGame();
            $score_game->meeting_id = $request->input('meeting_id');
            $score_game->title = $request->input('title');
            if ($request->has('logo')) {
                $logo = Image::make($request->file('logo'))->encode('data-url');
                $score_game->logo = $logo;
            }
            $score_game->start_at = $request->input('start_at');
            $score_game->finish_at = $request->input('finish_at');
            $score_game->status = $request->input('status');
            if ($score_game->save()) {
                $score_game->created_by = Auth::user()->id;
                $score_game->save();
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(int $meeting, string $id)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $score_game = $meeting->scoreGames()->findOrFail($id);
        $statuses = [
            'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.score-game.show', compact(['points', 'score_game', 'score_games', 'score_game_qr_codes', 'statuses']));

    }
    public function edit(int $meeting, string $id)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $score_game = $meeting->scoreGames()->findOrFail($id);
        return new ScoreGameResource($score_game);
    }
    public function update(ScoreGameRequest $request, string $meeting_id, string $id)
    {
        if ($request->validated()) {
            $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
            $score_game = $meeting->scoreGames()->findOrFail($id);
            $score_game->meeting_id = $request->input('meeting_id');
            $score_game->title = $request->input('title');
            if ($request->has('logo')) {
                $logo = Image::make($request->file('logo'))->encode('data-url');
                $score_game->logo = $logo;
            }
            $score_game->start_at = $request->input('start_at');
            $score_game->finish_at = $request->input('finish_at');
            $score_game->status = $request->input('status');
            if ($score_game->save()) {
                $score_game->updated_by = Auth::user()->id;
                $score_game->save();
                return back()->with('success', __('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(string $meeting_id, string $id)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $score_game = $meeting->scoreGames()->findOrFail($id);
        if ($score_game->delete()) {
            $score_game->deleted_by = Auth::user()->id;
            $score_game->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
