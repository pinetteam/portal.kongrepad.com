<?php

namespace App\Http\Resources\Portal\Program;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProgramResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'meeting_hall_id' => ['value'=>$this->meeting_hall_id, 'type'=>'select'],
            'sort_id' => ['value'=>$this->sort_id, 'type'=>'number'],
            'code' => ['value'=>$this->code, 'type'=>'text'],
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'description' => ['value'=>$this->description, 'type'=>'text'],
            'start_at' => ['value'=>Carbon::createFromFormat(Auth::user()->customer->settings['date-format'].' '.Auth::user()->customer->settings['time-format'], $this->start_at)->format('d/m/Y H:i'), 'type'=>'datetime'],
            'finish_at' => ['value'=>Carbon::createFromFormat(Auth::user()->customer->settings['date-format'].' '.Auth::user()->customer->settings['time-format'], $this->finish_at)->format('d/m/Y H:i'), 'type'=>'datetime'],
            'type' => ['value'=>$this->type, 'type'=>'select'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.program.update', $this->id),
        ];
    }
}
