<?php

namespace App\Http\Resources\API\Meeting\ScoreGame\Point;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PointResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'qr_code_id' => $this->qr_code_id,
            'participant_id' => $this->participant_id,
            'point' => $this->point,
            'title' => $this->qrCode->title,
            'created_at' => $this->created_at,
        ];
    }
}
