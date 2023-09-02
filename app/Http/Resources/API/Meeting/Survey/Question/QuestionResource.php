<?php

namespace App\Http\Resources\API\Meeting\Survey\Question;

use App\Http\Resources\API\Meeting\Survey\Question\Option\OptionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'survey_id' => $this->survey_id,
            'sort_order' => $this->sort_order,
            'question' => $this->question,
            'options' => OptionResource::collection($this->options),
            'status' => $this->status,
            ];
    }
}
