<?php

namespace App\Http\Resources\Portal\Meeting\Announcement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnnouncementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'meeting_id' => ['value' => $this->meeting_id, 'type' => 'hidden'],
            'title' => ['value' => $this->title, 'type' => 'text'],
            'publish_at' => ['value' => $this->publish_at, 'type' => 'datetime'],
            'status' => ['value' => $this->status, 'type' => 'radio'],
            'route' => route('portal.meeting.announcement.update', ['meeting' => $this->meeting_id, 'announcement' => $this->id]),
        ];
    }
}
