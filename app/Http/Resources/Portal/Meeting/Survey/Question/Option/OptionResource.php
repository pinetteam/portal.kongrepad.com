<?php

namespace App\Http\Resources\Portal\Meeting\Survey\Question\Option;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'question_id' => ['value'=>$this->question_id, 'type'=>'hidden'],
            'sort_order' => ['value'=>$this->sort_order, 'type'=>'number'],
            'title' => ['value'=>$this->title, 'type'=>'text'],
        ];
    }
}
