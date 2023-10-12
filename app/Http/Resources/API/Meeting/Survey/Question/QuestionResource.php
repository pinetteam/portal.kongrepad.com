<?php

namespace App\Http\Resources\API\Meeting\Survey\Question;

use App\Http\Resources\API\Meeting\Survey\Question\Option\OptionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $vote = $this->votes()->where('participant_id',$request->user()->id)->first();
        return [
            'id' => $this->id,
            'survey_id' => $this->survey_id,
            'sort_order' => $this->sort_order,
            'question' => $this->question,
            'selected_option' => $vote ? $vote->option_id : null,
            'options' => OptionResource::collection($this->options),
            'status' => $this->status,
            ];
    }
}
