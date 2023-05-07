<?php

namespace App\Http\Resources\Portal\Meeting\Hall\Stage;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'meeting_hall_id' => ['value'=>$this->meeting_hall_id, 'type'=>'select'],
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.meeting-hall.update', $this->id),
        ];
    }
}
