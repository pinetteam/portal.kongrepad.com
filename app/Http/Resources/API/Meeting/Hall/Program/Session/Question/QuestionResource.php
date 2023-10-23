<?php

namespace App\Http\Resources\API\Meeting\Hall\Program\Session\Question;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'survey_id' => $this->survey_id,
            'owner_id' => $this->survey_id,
            'sort_order' => $this->sort_order,
            'title' => $this->title,
            'on_screen' => $this->on_screen,
            'status' => $this->status,
        ];
    }
}
