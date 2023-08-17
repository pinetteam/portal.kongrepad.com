<?php

namespace App\Http\Resources\Portal\Meeting\Hall\Program\Debate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DebateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'sort_order' => ['value' => $this->sort_order, 'type' => 'number'],
            'program_id' => ['value' => $this->program_id, 'type' => 'hidden'],
            'code' => ['value' => $this->code, 'type' => 'text'],
            'title' => ['value' => $this->title, 'type' => 'text'],
            'description' => ['value' => $this->description, 'type' => 'text'],
            'voting_started_at' => ['value' => $this->voting_started_at, 'type' => 'datetime'],
            'voting_finished_at' => ['value' => $this->voting_finished_at, 'type' => 'datetime'],
            'on_vote' => ['value' => $this->on_vote, 'type' => 'radio'],
            'status' => ['value' => $this->status, 'type' => 'radio'],
            'route' => route('portal.meeting.hall.program.debate.show', ['meeting' => $this->program->hall->meeting_id, 'hall' => $this->program->hall->id, 'program' => $this->program->id, 'debate' => $this->id]),
        ];
    }
}
