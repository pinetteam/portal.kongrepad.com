<?php

namespace App\Http\Resources\Portal\Meeting;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeetingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'start_at' => ['value'=>$this->start_at, 'type'=>'text'],
            'finish_at' => ['value'=>$this->finish_at, 'type'=>'text'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.meeting.update', $this->id),
        ];
    }
}
