<?php

namespace App\Http\Resources\API\Meeting\VirtualStand;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VirtualStandResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'meeting_id' => $this->meeting_id,
            'title' => $this->title,
            'file_name' => $this->file_name,
            'file_extension' => $this->file_extension,
            'status' => $this->status,
            ];
    }
}
