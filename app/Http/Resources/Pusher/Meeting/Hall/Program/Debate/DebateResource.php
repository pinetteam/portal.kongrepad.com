<?php

namespace App\Http\Resources\Pusher\Meeting\Hall\Program\Debate;

use App\Http\Resources\Pusher\Meeting\Hall\Program\Debate\Team\TeamResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DebateResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'teams' => TeamResource::collection($this->teams),
            'votes_count' => $this->votes_count,
        ];
    }
}
