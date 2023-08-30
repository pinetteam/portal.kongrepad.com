<?php

namespace App\Http\Resources\API\Meeting\Hall\Program;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'hall_id' => $this->hall_id,
            'sort_order' => $this->sort_order,
            'code' => $this->code,
            'title' => $this->title,
            'description' => $this->description,
            'logo' => $this->logo,
            'start_at' => $this->start_at,
            'finish_at' => $this->finish_at,
            'on_air' => $this->on_air,
            'type' => $this->type,
            'status' => $this->status,
            ];
    }
}
