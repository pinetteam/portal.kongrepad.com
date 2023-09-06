<?php

namespace App\Http\Resources\API\Meeting\ScoreGame;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScoreGameResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'meeting_id' => $this->meeting_id,
            'title' => $this->title,
            'logo' => $this->logo,
            'start_at' => $this->start_at,
            'finish_at' => $this->finish_at,
            'status' => $this->status,
            ];
    }
}
