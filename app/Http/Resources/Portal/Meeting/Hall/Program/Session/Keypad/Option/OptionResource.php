<?php

namespace App\Http\Resources\Portal\Meeting\Hall\Program\Session\Keypad\Option;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'keypad_id' => ['value'=>$this->keypad_id, 'type'=>'hidden'],
            'sort_order' => ['value'=>$this->sort_order, 'type'=>'number'],
            'option' => ['value'=>$this->option, 'type'=>'text'],
            'route' => route('portal.meeting.hall.program.session.keypad.option.update', ['meeting'=>$this->keypad->session->program->hall->meeting_id, 'hall'=>$this->keypad->session->program->hall_id, 'program'=>$this->keypad->session->program_id, 'session'=> $this->keypad->session->id, 'keypad' => $this->keypad->id, 'option' => $this->id]),
        ];
    }
}
