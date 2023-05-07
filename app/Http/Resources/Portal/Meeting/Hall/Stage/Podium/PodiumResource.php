<?php

namespace App\Http\Resources\Portal\Meeting\Hall\Stage\Podium;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PodiumResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'stage_id' => ['value'=>$this->stage_id, 'type'=>'select'],
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.meeting-hall.update', $this->id),
        ];
    }
}
