<?php

namespace App\Http\Resources\Portal\Meeting\Hall\Program\Session;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'sort_order' => ['value' => $this->sort_order, 'type' => 'number'],
            'program_id' => ['value' => $this->program_id, 'type' => 'hidden'],
            'speaker_id' => ['value' => $this->speaker_id, 'type' => 'select'],
            'document_id' => ['value' => $this->document_id, 'type' => 'select'],
            'code' => ['value' => $this->code, 'type' => 'text'],
            'title' => ['value' => $this->title, 'type' => 'text'],
            'description' => ['value' => $this->description, 'type' => 'text'],
            'start_at' => ['value' => $this->start_at, 'type' => 'datetime'],
            'finish_at' => ['value' => $this->finish_at, 'type' => 'datetime'],
            'on_air' => ['value' => $this->on_air, 'type' => 'radio'],
            'questions_allowed' => ['value' => $this->questions_allowed, 'type' => 'radio'],
            'questions_limit' => ['value' => $this->questions_limit, 'type' => 'number'],
            'questions_auto_start' => ['value' => $this->questions_auto_start, 'type' => 'radio'],
            'status' => ['value' => $this->status, 'type' => 'radio'],
            'route' => route('portal.meeting.hall.program.session.update', ['meeting' => $this->program->hall->meeting_id, 'hall' => $this->program->hall->id, 'program' => $this->program->id, 'session' => $this->id]),
        ];
    }
}
