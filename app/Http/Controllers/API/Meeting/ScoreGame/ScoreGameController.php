<?php

namespace App\Http\Controllers\API\Meeting\ScoreGame;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\ScoreGame\ScoreGameResource;
use App\Http\Traits\ParticipantLog;
use Illuminate\Http\Request;

class ScoreGameController extends Controller
{
    use ParticipantLog;
    public function index(Request $request)
    {
        try{
            $meeting = $request->user()->meeting;
            $this->logParticipantAction($request->user()->id, "get-score-games", __('common.meeting') . ': ' . $meeting->title);
            return [
                'data' => new ScoreGameResource($meeting->scoreGames()->first()),
                'status' => true,
                'errors' => null
            ];
        } catch (\Throwable $e){
            return [
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ];
        }
    }
}
