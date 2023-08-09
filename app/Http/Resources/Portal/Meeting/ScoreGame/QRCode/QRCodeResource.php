<?php

namespace App\Http\Resources\Portal\Meeting\ScoreGame\QRCode;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QRCodeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'score_game_id' => ['value'=>$this->score_game_id, 'type'=>'select'],
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'point' => ['value'=>$this->point, 'type'=>'number'],
            'start_at' => ['value'=> $this->start_at, 'type'=>'datetime'],
            'finish_at' => ['value'=> $this->finish_at, 'type'=>'datetime'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.meeting.score-game.qr-code.update', ['meeting' => $this->scoreGame->meeting->id, 'score_game' => $this->score_game_id, 'qr_code' =>$this->id]),
        ];
    }
}
