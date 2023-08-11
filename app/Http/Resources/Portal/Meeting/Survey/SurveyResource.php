<?php

namespace App\Http\Resources\Portal\Meeting\Survey;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SurveyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'meeting_id' => ['value'=>$this->meeting_id, 'type'=>'select'],
            'sort_order' => ['value'=>$this->sort_order, 'type'=>'number'],
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'description' => ['value'=>$this->description, 'type'=>'text'],
            'start_at' => ['value'=>$this->start_at, 'type'=>'datetime'],
            'finish_at' => ['value'=>$this->finish_at, 'type'=>'datetime'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.meeting.survey.update', ['meeting' => $this->meeting_id, 'survey' => $this->id]),
        ];
    }
}
