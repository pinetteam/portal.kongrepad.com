<?php

namespace App\Http\Resources\API\Meeting\Hall\Program\Debate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DebateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sort_order' => $this->sort_order,
            'program_id' => $this->program_id,
            'code' => $this->code,
            'title' => $this->title,
            'description' => $this->description,
            'voting_started_at' => $this->voting_started_at,
            'voting_finished_at' => $this->voting_finished_at,
            'on_vote' => $this->on_vote,
            'status' => $this->status,
            ];
    }
}
