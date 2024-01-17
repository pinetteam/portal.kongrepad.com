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
            'total_point' => intval($this->qrCodes()->sum('point')),
            'user_total_point' => intval($this->points()->where('participant_id', $request->user()->id)->sum('meeting_score_game_points.point')),
            'start_at' => $this->start_at,
            'finish_at' => $this->finish_at,
            'theme' => $this->theme,
            'status' => $this->status,
            ];
    }
}
