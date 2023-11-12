<?php

namespace App\Http\Resources\Portal\Meeting\Hall\Screen;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScreenResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'hall_id' => ['value' => $this->hall_id, 'type' => 'select'],
            'code' => ['value' => $this->code, 'type' => 'text'],
            'title' => ['value' => $this->title, 'type' => 'text'],
            'description' => ['value' => $this->description, 'type' => 'text'],
            'type' => ['value' => $this->type, 'type' => 'select'],
            'status' => ['value' => $this->status, 'type' => 'radio'],
            'route' => route('portal.meeting.hall.screen.update', ['meeting' => $this->hall->meeting_id, 'hall' => $this->hall->id, 'screen' => $this->id]),
        ];
    }
}
