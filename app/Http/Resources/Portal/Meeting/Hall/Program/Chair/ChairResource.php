<?php

namespace App\Http\Resources\Portal\Meeting\Hall\Program\Chair;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChairResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'program_id' => ['value'=>$this->program_id, 'type'=>'hidden'],
            'moderator_id' => ['value'=>$this->moderator_id, 'type'=>'hidden'],
            'route' => route('portal.meeting.hall.program.chair.update', $this->id),
        ];
    }
}
