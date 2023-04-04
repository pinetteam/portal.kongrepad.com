<?php

namespace App\Http\Resources\Portal\Document;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'participant_id' => ['value'=>$this->participant_id, 'type'=>'select'],
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'sharing_via_email' => ['value'=>$this->sharing_via_email, 'type'=>'radio'],
            'type' => ['value'=>$this->type, 'type'=>'select'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.document.update', $this->id),
        ];
    }
}
