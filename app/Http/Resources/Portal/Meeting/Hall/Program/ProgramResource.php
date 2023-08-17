<?php

namespace App\Http\Resources\Portal\Meeting\Hall\Program;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'hall_id' => ['value' => $this->hall_id, 'type' => 'hidden'],
            'sort_order' => ['value' => $this->sort_order, 'type' => 'number'],
            'code' => ['value' => $this->code, 'type' => 'text'],
            'title' => ['value' => $this->title, 'type' => 'text'],
            'description' => ['value' => $this->description, 'type' => 'text'],
            'logo' => ['value' => $this->logo, 'type' => 'file'],
            'start_at' => ['value' => $this->start_at, 'type' => 'datetime'],
            'finish_at' => ['value' => $this->finish_at, 'type' => 'datetime'],
            'on_air' => ['value' => $this->on_air, 'type' => 'radio'],
            'type' => ['value' => $this->type, 'type' => 'select'],
            'status' => ['value' => $this->status, 'type' => 'radio'],
            'route' => route('portal.meeting.hall.program.update', ['meeting' => $this->hall->meeting->id, 'hall' => $this->hall->id, 'program' => $this->id]),
        ];
    }
}
