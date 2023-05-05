<?php

namespace App\Http\Resources\Portal\ScoreGame;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ScoreGameResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'meeting_id' => ['value'=>$this->meeting_id, 'type'=>'select'],
            'start_at' => ['value'=>Carbon::createFromFormat(Auth::user()->customer->settings['date-format'].' '.Auth::user()->customer->settings['time-format'], $this->start_at)->format('d/m/Y H:i'), 'type'=>'datetime'],
            'finish_at' => ['value'=>Carbon::createFromFormat(Auth::user()->customer->settings['date-format'].' '.Auth::user()->customer->settings['time-format'], $this->finish_at)->format('d/m/Y H:i'), 'type'=>'datetime'],
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'types' => ['value'=>$this->types, 'type'=>'checkbox'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.score-game.update', $this->id),
        ];
    }
}
