<?php

namespace App\Http\Resources\API\Meeting\Participant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParticipantResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'meeting_id' => $this->meeting_id,
            'username' => $this->username,
            'title' => $this->title,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'identification_number' => $this->identification_number,
            'organisation' => $this->organisation,
            'email' => $this->email,
            'phone_country_id' => $this->phone_country_id,
            'phone' => $this->phone,
            'password' => $this->password,
            'type' => $this->type,
            'status' => $this->status,
            ];
    }
}
