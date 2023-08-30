<?php

namespace App\Http\Resources\API\Meeting\Document;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'meeting_id' => $this->meeting_id,
            'title' => $this->title,
            'file_name' => $this->file_name,
            'file_extension' => $this->file_extension,
            'sharing_via_email' => $this->sharing_via_email,
            'status' => $this->status,
        ];
    }
}
