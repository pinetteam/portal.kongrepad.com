<?php

namespace App\Http\Resources\Portal\Meeting\Hall\Program\Debate\Team\Vote;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'team_id' => ['value'=>$this->team_id, 'type'=>'hidden'],
            'participant_id' => ['value'=>$this->participant_id, 'type'=>'hidden'],
            'route' => route('portal.debate-vote.update', $this->id),
        ];
    }
}
