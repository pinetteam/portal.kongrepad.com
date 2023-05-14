<?php

namespace App\Http\Resources\Portal\Meeting\Hall\Program\Session\Keypad\Option;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'keypad_id' => ['value'=>$this->debate_id, 'type'=>'hidden'],
            'sort_order' => ['value'=>$this->sort_order, 'type'=>'number'],
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'route' => route('portal.option.update', $this->id),
        ];
    }
}
