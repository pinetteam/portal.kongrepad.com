<?php

namespace App\Http\Resources\API\Meeting\Survey;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SurveyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'sort_order' => $this->sort_order,
            'meeting_id' => $this->meeting_id,
            'title' => $this->title,
            'description' => $this->description,
            'start_at' => $this->start_at,
            'finish_at' => $this->finish_at,
            'status' => $this->status,
        ];
    }
}
