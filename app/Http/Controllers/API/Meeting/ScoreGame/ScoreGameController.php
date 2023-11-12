<?php

namespace App\Http\Controllers\API\Meeting\ScoreGame;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\ScoreGame\ScoreGameResource;
use Illuminate\Http\Request;

class ScoreGameController extends Controller
{
    public function index(Request $request)
    {
        try{
            return [
                'data' => new ScoreGameResource($request->user()->meeting->scoreGames()->first()),
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
