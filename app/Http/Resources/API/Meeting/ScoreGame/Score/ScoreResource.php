<?php

namespace App\Http\Resources\Portal\Meeting\ScoreGame\Score;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScoreResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'score_game_id' => ['value'=>$this->score_game_id, 'type'=>'select'],
            'user_id' => ['value'=>$this->score_game_id, 'type'=>'select'],
            'score' => ['value'=>$this->title, 'type'=>'number'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.qr-code.update', $this->id),
        ];
    }
}
