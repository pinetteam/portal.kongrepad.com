<?php

namespace App\Http\Resources\Portal\Meeting\ScoreGame;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScoreGameResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'meeting_id' => ['value'=>$this->meeting_id, 'type'=>'hidden'],
            'start_at' => ['value'=>$this->start_at, 'type'=>'datetime'],
            'finish_at' => ['value'=>$this->finish_at, 'type'=>'datetime'],
            'logo' => ['value'=>$this->logo, 'type'=>'file'],
            'title' => ['value'=> $this->title, 'type'=>'text'],
            'status' => ['value'=> $this->status, 'type'=>'radio'],
            'route' => route('portal.meeting.score-game.update', ['meeting' => $this->meeting_id,'score_game' => $this->id]),
        ];
    }
}
