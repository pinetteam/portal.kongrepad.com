<?php

namespace App\Http\Resources\Pusher\Meeting\Hall\Program\Debate\Team;

use Illuminate\Http\Resources\Json\JsonResource;


class TeamResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'votes_count' => $this->votes_count,
        ];
    }
}
