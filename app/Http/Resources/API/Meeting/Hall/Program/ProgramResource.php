<?php

namespace App\Http\Resources\API\Meeting\Hall\Program;

use App\Http\Resources\API\Meeting\Hall\Program\Debate\DebateResource;
use App\Http\Resources\API\Meeting\Hall\Program\Session\SessionResource;
use App\Http\Resources\API\Meeting\Participant\ParticipantResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'hall_id' => $this->hall_id,
            'sort_order' => $this->sort_order,
            'code' => $this->code,
            'title' => $this->title,
            'description' => $this->description,
            'logo' => $this->logo,
            'chairs' => ParticipantResource::collection($this->chairs),
            'sessions' => SessionResource::collection($this->sessions),
            'debates' => DebateResource::collection($this->debates),
            'start_at' => Carbon::parse($this->start_at)->format('H:i'),
            'finish_at' => Carbon::parse($this->finish_at)->format('H:i'),
            'on_air' => $this->on_air,
            'type' => $this->type,
            'status' => $this->status,
            ];
    }
}
