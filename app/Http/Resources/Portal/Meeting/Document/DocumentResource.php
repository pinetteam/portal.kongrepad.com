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
            'sharing_via_email' => ['value'=>$this->sharing_via_email, 'type' => 'radio'],
            'type' => ['value' => $this->type, 'type' => 'select'],
            'status' => ['value' => $this->status, 'type' => 'radio'],
            'route' => route('portal.meeting.document.update', ['meeting' => $this->meeting_id, 'document' => $this->id]),
        ];
    }
}
