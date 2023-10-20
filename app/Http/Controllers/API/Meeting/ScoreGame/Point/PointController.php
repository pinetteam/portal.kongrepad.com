<?php

namespace App\Http\Controllers\API\Meeting\ScoreGame\Point;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\ScoreGame\Point\PointResource;
use App\Models\Meeting\ScoreGame\Point\Point;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PointController extends Controller
{
    public function index(Request $request, int $score_game)
    {
        return [
            'data' => PointResource::collection($request->user()->meeting->scoreGames()->first()->points()->get()->where('participant_id', $request->user()->id)),
            'status' => true,
            'errors' => null
        ];
    }
    public function store(Request $request, int $score_game)
    {

        if($request->user()->meeting->qrCodes()->get()->where('code', $request->input('code'))->count() == 0){
            return [
                'data' => null,
                'status' => false,
                'errors' => ["Geçersiz bir kare kod okuttunuz!"]
            ];
        }
        $qr_code = $request->user()->meeting->qrCodes()->get()->where('code', $request->input('code'))->first();
        if($request->user()->meeting->scoreGames()->first()->points()->get()->where('participant_id', $request->user()->id)->where('qr_code_id', $qr_code->id)->count() > 0){
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
        try{
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
