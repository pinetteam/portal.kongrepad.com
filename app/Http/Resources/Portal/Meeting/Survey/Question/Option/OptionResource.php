<?php

namespace App\Http\Resources\Portal\Meeting\Survey\Question\Option;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'survey_id' => ['value'=>$this->survey_id, 'type'=>'hidden'],
            'question_id' => ['value'=>$this->question_id, 'type'=>'hidden'],
            'sort_order' => ['value'=>$this->sort_order, 'type'=>'number'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'option' => ['value'=>$this->option, 'type'=>'text'],
            'route' => route('portal.survey-option.update', [$this->question->survey->meeting_id, $this->question->survey_id, $this->question_id, $this->id]),
        ];
    }
}
