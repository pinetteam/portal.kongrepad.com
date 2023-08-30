<?php

namespace App\Http\Resources\API\Meeting;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeetingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'title' => $this->title,
            'banner_name' => $this->banner_name,
            'banner_extension' => $this->banner_extension,
            'start_at' => $this->start_at,
            'finish_at' => $this->finish_at,
            'status' => $this->status,
        ];
    }
}
