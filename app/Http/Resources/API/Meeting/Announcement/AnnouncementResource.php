<?php

namespace App\Http\Resources\API\Meeting\Announcement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnnouncementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'meeting_id' => $this->meeting_id,
            'title' => $this->title,
            'status' => $this->status,
            'created_at' => $this->created_at,
            ];
    }
}
