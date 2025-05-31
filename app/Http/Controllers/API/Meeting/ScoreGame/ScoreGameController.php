<?php

namespace App\Http\Controllers\API\Meeting\ScoreGame;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\ScoreGame\ScoreGameResource;
use App\Http\Traits\ParticipantLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ScoreGameController extends Controller
{
    use ParticipantLog;
    public function index(Request $request)
    {
        App::setLocale('tr');
        try{
            $meeting = $request->user()->meeting;
            $this->logParticipantAction($request->user()->id, "get-score-games", __('common.meeting') . ': ' . $meeting->title);
            $this->logParticipantAction($request->user(), "get-score-games", __('common.meeting') . ': ' . $meeting->title);
            
            $scoreGame = $meeting->scoreGames()->first();
            if ($scoreGame) {
                return [
                    'data' => new ScoreGameResource($scoreGame),
                    'status' => true,
                    'errors' => null
                ];
            } else {
                return [
                    'data' => null,
                    'status' => false,
                    'errors' => [__('common.no-score-game-found')]
                ];
            }
        } catch (\Throwable $e){
            return [
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ];
        }
    }
}

