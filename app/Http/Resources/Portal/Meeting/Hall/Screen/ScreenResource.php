<?php

namespace App\Http\Resources\Portal\Meeting\Hall\Screen;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScreenResource extends JsonResource
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
