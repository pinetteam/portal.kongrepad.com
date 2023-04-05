<?php

namespace App\Http\Resources\Portal\Meeting;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class MeetingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'code' => ['value'=>$this->code, 'type'=>'text'],
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'start_at' => ['value'=>Carbon::createFromFormat(Auth::user()->customer->settings['date-format'], $this->start_at)->format('d/m/Y'), 'type'=>'date'],
            'finish_at' => ['value'=>Carbon::createFromFormat(Auth::user()->customer->settings['date-format'], $this->finish_at)->format('d/m/Y'), 'type'=>'date'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.meeting.update', $this->id),
        ];
    }
}
