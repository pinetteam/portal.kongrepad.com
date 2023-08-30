<?php

namespace App\Http\Resources\Portal\Meeting\Survey\Vote;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'survey_id' => ['value'=>$this->survey_id, 'type'=>'hidden'],
            'sort_order' => ['value'=>$this->sort_order, 'type'=>'number'],
            'question' => ['value'=>$this->question, 'type'=>'text'],
            'option' => ['value'=>$this->option, 'type'=>'text'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
        ];
    }
}
