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
            'start_at' => ['value'=>$this->start_at, 'type'=>'date'],
            'finish_at' => ['value'=>$this->finish_at, 'type'=>'date'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.meeting.update', $this->id),
        ];
    }
}
