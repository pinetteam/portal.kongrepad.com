<?php

namespace App\Http\Resources\Portal\Meeting\Document;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'meeting_id' => ['value' => $this->meeting_id, 'type' => 'hidden'],
            'title' => ['value' => $this->title, 'type' => 'text'],
            'allowed_to_review' => ['value' => $this->allowed_to_review, 'type' => 'radio'],
            'sharing_via_email' => ['value' => $this->sharing_via_email, 'type' => 'radio'],
            'status' => ['value' => $this->status, 'type' => 'radio'],
            'route' => route('portal.meeting.document.update', ['meeting' => $this->meeting_id, 'document' => $this->id]),
        ];
    }
}
