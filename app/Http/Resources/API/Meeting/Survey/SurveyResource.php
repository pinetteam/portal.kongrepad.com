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
            'id' => $this->id,
            'meeting_id' => $this->meeting_id,
            'title' => $this->title,
            'description' => $this->description,
            'start_at' => $this->start_at,
            'finish_at' => $this->finish_at,
            'is_completed' => $this->votes->where('participant_id', $request->user()->id)->count() > 0 ? true : false,
            'status' => $this->status,
        ];
    }
}
