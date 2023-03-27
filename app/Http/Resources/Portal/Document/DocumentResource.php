<?php

namespace App\Http\Resources\Portal\Document;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'meeting_id' => ['value'=>$this->meeting_id, 'type'=>'select'],
            'participant_id' => ['value'=>$this->participant_id, 'type'=>'select'],
            'file_link' => ['value'=>$this->file_name.'.'.$this->file_extension, 'type'=>'link'],
            'file_name' => ['value'=>$this->file_name, 'type'=>'text'],
            'file_extension' => ['value'=>$this->file_extension, 'type'=>'text'],
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'type' => ['value'=>$this->type, 'type'=>'select'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.document.update', $this->id),
        ];
    }
}
