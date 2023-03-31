<?php

namespace App\Http\Resources\Portal\Session;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'session_id' => ['value'=>$this->session_id, 'type'=>'select'],
            'meeting_hall_id' => ['value'=>$this->meeting_hall_id, 'type'=>'select'],
            'sort_id' => ['value'=>$this->sort_id, 'type'=>'text'],
            'code' => ['value'=>$this->code, 'type'=>'text'],
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'description' => ['value'=>$this->description, 'type'=>'text'],
            'date' => ['value'=>$this->date, 'type'=>'date'],
            'start_at' => ['value'=>$this->start_at, 'type'=>'time'],
            'finish_at' => ['value'=>$this->finish_at, 'type'=>'time'],
            'type' => ['value'=>$this->type, 'type'=>'select'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.session.update', $this->id),
        ];
    }
}
