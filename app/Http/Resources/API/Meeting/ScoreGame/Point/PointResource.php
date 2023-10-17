<?php

namespace App\Http\Resources\API\Meeting\ScoreGame\Point;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class PointResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        App::setLocale('tr');
        return [
            'id' => $this->id,
            'qr_code_id' => $this->qr_code_id,
            'participant_id' => $this->participant_id,
            'point' => $this->point,
            'title' => $this->qrCode->title,
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('H:i, d F'),
        ];
    }
}
