<?php

namespace App\Http\Controllers\API\Meeting\ScoreGame\Point;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\ScoreGame\Point\PointResource;
use App\Http\Traits\ParticipantLog;
use App\Models\Meeting\ScoreGame\Point\Point;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PointController extends Controller
{
    use ParticipantLog;
    public function index(Request $request, int $score_game)
    {
        try{
            $score_game = $request->user()->meeting->scoreGames()->first();
            $this->logParticipantAction($request->user(), "get-score-game-points", __('common.score-game') . ': ' . $score_game->title);
            return [
                'data' => PointResource::collection($score_game->points()->get()->where('participant_id', $request->user()->id)),
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
    public function store(Request $request, int $score_game)
    {

        try{
            $score_game = $request->user()->meeting->scoreGames()->first();
            $this->logParticipantAction($request->user(), "scan-qr-code", __('common.score-game') . ': ' . $score_game->title);
            if($request->user()->meeting->qrCodes()->get()->where('code', $request->input('code'))->count() == 0){
                return [
                    'data' => null,
                    'status' => false,
                    'errors' => ["Geçersiz bir kare kod okuttunuz!"]
                ];
            }
            $qr_code = $request->user()->meeting->qrCodes()->get()->where('code', $request->input('code'))->first();
            if($score_game->points()->get()->where('participant_id', $request->user()->id)->where('qr_code_id', $qr_code->id)->count() > 0){
                return [
                    'data' => null,
                    'status' => false,
                    'errors' => ["Bu kare kodu daha önceden gösterdiniz!"]
                ];
            }

            if(!isset($qr_code)){
                return [
                    'data' => null,
                    'status' => false,
                    'errors' => ["Daha önce okutulmuş veya yanlış qr code"]
                ];
            } elseif (!Carbon::parse($qr_code->start_at)->isPast() || Carbon::parse($qr_code->finish_at)->isPast() ) {
                return [
                    'data' => null,
                    'status' => false,
                    'errors' => ["Bu kare kod şu anda aktif değildir!"]
                ];
            }
            $point = new Point();
            $point->qr_code_id = $qr_code->id;
            $point->participant_id = $request->user()->id;
            $point->point = $qr_code->point;
            return [
                'data' => $point->save(),
                'status' => true,
                'errors' => null
            ];
        } catch (\Throwable $e){

            return [
                'data' => null,
                'status' => false,
                'errors' => ["error"]
            ];
        }
    }
}
