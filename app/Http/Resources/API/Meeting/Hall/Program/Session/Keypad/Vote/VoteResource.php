<?php

namespace App\Http\Resources\API\Meeting\Hall\Program\Session\Keypad\Vote;

use App\Models\Customer\Setting\Variable\Variable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class VoteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'option_id' => ['value'=>$this->option_id, 'type'=>'hidden'],
            'participant_id' => ['value'=>$this->participant_id, 'type'=>'hidden'],
            'route' => route('portal.keypad-vote.update', $this->id),
        ];
    }
}
