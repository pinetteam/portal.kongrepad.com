<?php

namespace App\Http\Resources\Portal\Meeting\Survey\Question;

use App\Models\Meeting\Survey\Survey;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'survey_id' => ['value'=>$this->survey_id, 'type'=>'hidden'],
            'sort_order' => ['value'=>$this->sort_order, 'type'=>'number'],
            'question' => ['value'=>$this->question, 'type'=>'text'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.meeting.survey.question.update', [Survey::where('id',$this->survey_id)->first()->meeting_id, $this->survey_id, $this->id]),
        ];
    }
}
