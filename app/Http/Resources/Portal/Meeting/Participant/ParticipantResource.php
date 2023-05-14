<?php

namespace App\Http\Resources\Portal\Meeting\Participant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParticipantResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'meeting_id' => ['value'=>$this->meeting_id, 'type'=>'select'],
            'username' => ['value'=>$this->username, 'type'=>'text'],
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'first_name' => ['value'=>$this->first_name, 'type'=>'text'],
            'last_name' => ['value'=>$this->last_name, 'type'=>'text'],
            'organisation' => ['value'=>$this->organisation, 'type'=>'text'],
            'identification_number' => ['value'=>$this->identification_number, 'type'=>'text'],
            'email' => ['value'=>$this->email, 'type'=>'email'],
            'phone_country_id' => ['value'=>$this->phone_country_id, 'type'=>'select'],
            'phone' => ['value'=>$this->phone, 'type'=>'number'],
            'password' => ['value'=>$this->password, 'type'=>'text'],
            'type' => ['value'=>$this->type, 'type'=>'select'],
            'confirmation' => ['value'=>$this->confirmation, 'type'=>'radio'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.participant.update', $this->id),
        ];
    }
}
