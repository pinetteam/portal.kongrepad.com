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
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.question.update', [Survey::where('id',$this->meeting_id)->first()->meeting_id, $this->survey_id, $this->id]),
        ];
    }
}
