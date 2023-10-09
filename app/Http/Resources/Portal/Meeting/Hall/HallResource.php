<?php

namespace App\Http\Resources\Portal\Meeting\Hall;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HallResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'meeting_id' => ['value' => $this->meeting_id, 'type' => 'hidden'],
            'code' => ['value' => $this->code, 'type' => 'hidden'],
            'title' => ['value' => $this->title, 'type' => 'text'],
            'show_on_session' => ['value' => $this->show_on_session, 'type' => 'radio'],
            'show_on_view_program' => ['value' => $this->show_on_view_program, 'type' => 'radio'],
            'show_on_ask_question' => ['value' => $this->show_on_ask_question, 'type' => 'radio'],
            'show_on_send_mail' => ['value' => $this->show_on_send_mail, 'type' => 'radio'],
            'status' => ['value' => $this->status, 'type' => 'radio'],
            'route' => route('portal.meeting.hall.update', ['meeting' => $this->meeting_id, 'hall' => $this->id]),
        ];
    }
}
