<?php

namespace App\Http\Resources\Portal\Meeting\Hall\Program\Session\Keypad;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KeypadResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'sort_order' => ['value'=>$this->sort_order, 'type'=>'number'],
            'session_id' => ['value'=>$this->session_id, 'type'=>'hidden'],
            'code' => ['value'=>$this->code, 'type'=>'text'],
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'keypad' => ['value'=>$this->keypad, 'type'=>'text'],
            'voting_started_at' => ['value'=> $this->voting_started_at, 'type'=>'datetime'],
            'voting_finished_at' => ['value'=> $this->voting_finished_at, 'type'=>'datetime'],
            'on_vote' => ['value'=>$this->on_vote, 'type'=>'radio'],
            'route' => route('portal.meeting.hall.program.session.keypad.update', ['meeting'=>$this->session->program->hall->meeting_id, 'hall'=>$this->session->program->hall_id, 'program'=>$this->session->program_id, 'session'=> $this->session->id, 'keypad' => $this->id]),
        ];
    }
}
