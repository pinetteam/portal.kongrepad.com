<?php

namespace App\Http\Resources\API\Meeting\Hall;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HallResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'meeting_id' => $this->meeting_id,
            'code' => $this->code,
            'title' => $this->title,
            'status' => $this->status,
            ];
    }
}
