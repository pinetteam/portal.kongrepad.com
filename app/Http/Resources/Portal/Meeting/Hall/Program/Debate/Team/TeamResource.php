<?php

namespace App\Http\Resources\Portal\Meeting\Hall\Program\Debate\Team;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'sort_order' => ['value'=>$this->sort_order, 'type'=>'number'],
            'debate_id' => ['value'=>$this->debate_id, 'type'=>'hidden'],
            'code' => ['value'=>$this->code, 'type'=>'text'],
            'logo' => ['value'=>$this->logo, 'type'=>'file'],
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'description' => ['value'=>$this->description, 'type'=>'text'],
            'route' => route('portal.meeting.hall.program.debate.team.update', ['meeting' => $this->debate->program->hall->meeting_id, 'hall' => $this->debate->program->hall_id, 'program' => $this->debate->program_id, 'debate' => $this->debate_id, 'team' => $this->id]),
        ];
    }
}
