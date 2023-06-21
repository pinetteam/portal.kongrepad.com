<?php

namespace App\Http\Resources\Portal\Meeting\Hall\Program\Session\Question;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'survey_id' => ['value'=>$this->survey_id, 'type'=>'hidden'],
            'owner_id' => ['value'=>$this->survey_id, 'type'=>'hidden'],
            'sort_order' => ['value'=>$this->sort_order, 'type'=>'number'],
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'on_screen' => ['value'=>$this->status, 'type'=>'radio'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.session-question.update', $this->id),
        ];
    }
}
