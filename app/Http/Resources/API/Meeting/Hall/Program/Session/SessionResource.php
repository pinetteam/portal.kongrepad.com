<?php

namespace App\Http\Resources\API\Meeting\Hall\Program\Session;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sort_order' => $this->sort_order,
            'program_id' => $this->program_id,
            'speaker_id' => $this->speaker_id,
            'document_id' => $this->document_id,
            'code' => $this->code,
            'title' => $this->title,
            'description' => $this->description,
            'start_at' => $this->start_at,
            'finish_at' => $this->finish_at,
            'on_air' => $this->on_air,
            'questions_allowed' => $this->questions_allowed,
            'questions_limit' => $this->questions_limit,
            'questions_auto_start' => $this->questions_auto_start,
            'status' => $this->status,
            ];
    }
}
