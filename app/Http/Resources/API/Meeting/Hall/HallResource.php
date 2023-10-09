<?php

namespace App\Http\Resources\API\Meeting\Hall;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HallResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'meeting_id' => $this->meeting_id,
            'code' => $this->code,
            'title' => $this->title,
            'show_on_session' => $this->show_on_session,
            'show_on_view_program' => $this->show_on_view_program,
            'show_on_ask_question' => $this->show_on_ask_question,
            'show_on_send_mail' => $this->show_on_send_mail,
            'status' => $this->status,
            ];
    }
}
