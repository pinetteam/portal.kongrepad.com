<?php

namespace App\Http\Resources\API\Meeting\Hall\Program\Session\Keypad\Option;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sort_order' => $this->sort_order,
            'keypad_id' => $this->keypad_id,
            'option' => $this->option,
            ];
    }
}
