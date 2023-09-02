<?php

namespace App\Http\Resources\API\Meeting\Survey\Question\Option;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'sort_order' => $this->sort_order,
            'survey_id' => $this->survey_id,
            'question_id' => $this->question_id,
            'option' => $this->option,
            'status' => $this->status,
            ];
    }
}
