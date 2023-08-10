<?php

namespace App\Http\Resources\Portal\Meeting\Hall\Program\Session\Keypad;

use App\Models\Customer\Setting\Variable\Variable;
use App\Models\Meeting\Hall\Program\Program;
use App\Models\Meeting\Hall\Program\Session\Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class KeypadResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'session_id' => 'required|exists:meeting_hall_program_sessions,id',
            'sort_order' => ['value'=>$this->sort_order, 'type'=>'number'],
            'code' => ['value'=>$this->code, 'type'=>'text'],
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'description' => ['value'=>$this->description, 'type'=>'text'],
            'voting_started_at' => ['value'=> $this->voting_started_at, 'type'=>'datetime'],
            'voting_finished_at' => ['value'=> $this->voting_finished_at, 'type'=>'datetime'],
            'on_vote' => ['value'=>$this->on_vote, 'type'=>'radio'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.meeting.hall.program.session.keypad.update', ['meeting'=>$this->session->program->hall->meeting_id, 'hall'=>$this->session->program->hall_id, 'program'=>$this->session->program_id, 'session'=> $this->session->id, 'keypad' => $this->id]),
        ];
    }
}
