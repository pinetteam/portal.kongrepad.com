<?php

namespace App\Http\Resources\Pusher\Meeting\Hall\Program\Session\Keypad\Option;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'option' => $this->option,
            'votes_count' => $this->votes_count,
        ];
    }
}
