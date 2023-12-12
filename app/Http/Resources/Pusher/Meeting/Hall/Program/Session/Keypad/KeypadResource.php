<?php

namespace App\Http\Resources\Pusher\Meeting\Hall\Program\Session\Keypad;

use App\Http\Resources\Pusher\Meeting\Hall\Program\Session\Keypad\Option\OptionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class KeypadResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'keypad' => $this->keypad,
            'options' => OptionResource::collection($this->options),
            'votes_count' => $this->votes_count,
        ];
    }
}
