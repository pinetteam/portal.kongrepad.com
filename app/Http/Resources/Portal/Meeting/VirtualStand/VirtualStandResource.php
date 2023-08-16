<?php

namespace App\Http\Resources\Portal\Meeting\VirtualStand;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VirtualStandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'meeting_id' => ['value' => $this->meeting_id, 'type' => 'select'],
            'title' => ['value' => $this->title, 'type' => 'text'],
            'type' => ['value' => $this->type, 'type' => 'select'],
            'status' => ['value' => $this->status, 'type' => 'radio'],
            'route' => route('portal.meeting.virtual-stand.update', ['meeting' => $this->meeting_id, 'virtual_stand' => $this->id]),
        ];
    }
}
