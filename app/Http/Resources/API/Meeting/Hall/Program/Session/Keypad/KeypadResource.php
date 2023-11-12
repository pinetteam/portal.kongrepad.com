<?php

namespace App\Http\Resources\API\Meeting\Hall\Program\Session\Keypad;

use App\Http\Resources\API\Meeting\Hall\Program\Session\Keypad\Option\OptionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KeypadResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sort_order' => $this->sort_order,
            'session_id' => $this->session_id,
            'code' => $this->code,
            'title' => $this->title,
            'keypad' => $this->keypad,
            'options' => OptionResource::collection($this->options),
            'voting_started_at' => $this->voting_started_at,
            'voting_finished_at' => $this->voting_finished_at,
            'on_vote' => $this->on_vote,
        ];
    }
}
