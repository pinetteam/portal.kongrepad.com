<?php

namespace App\Http\Resources\API\Meeting;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeetingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'title' => $this->title,
            'banner_name' => $this->banner_name,
            'banner_extension' => $this->banner_extension,
            'start_at' => $this->start_at,
            'finish_at' => $this->finish_at,
            'session_hall_count' => $this->halls()->where('show_on_session', 1)->count(),
            'session_first_hall_id' => $this->halls()->where('show_on_session', 1)->count() > 0 ? $this->halls()->where('show_on_session', 1)->first()->id : 0,
            'question_hall_count' => $this->halls()->where('show_on_ask_question', 1)->count(),
            'question_first_hall_id' => $this->halls()->where('show_on_ask_question', 1)->count() ? $this->halls()->where('show_on_ask_question', 1)->first()->id : 0,
            'program_hall_count' => $this->halls()->where('show_on_view_program', 1)->count(),
            'program_first_hall_id' => $this->halls()->where('show_on_view_program', 1)->count() > 0 ? $this->halls()->where('show_on_view_program', 1)->first()->id : 0,
            'mail_hall_count' => $this->halls()->where('show_on_send_mail', 1)->count(),
            'mail_first_hall_id' => $this->halls()->where('show_on_send_mail', 1)->count() ? $this->halls()->where('show_on_send_mail', 1)->first()->id : 0,
            'status' => $this->status,
        ];
    }
}
