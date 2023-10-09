<?php

namespace App\Http\Resources\API\Meeting\Hall\Program\Session;

use App\Http\Resources\API\Meeting\Document\DocumentResource;
use App\Models\Meeting\Document\Mail\Mail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sort_order' => $this->sort_order,
            'program_id' => $this->program_id,
            'speaker_id' => $this->speaker_id,
            'document_id' => $this->document_id,
            'is_document_requested' => $this->document_id ? Mail::where([['participant_id', $request->user()->id], ['document_id', $this->document_id]])->count() > 0 : false,
            'document_sharing_via_email' => $this->document_id ? $this->document->sharing_via_email == 1 : false,
            'code' => $this->code,
            'title' => $this->title,
            'speaker_name' => $this->speaker->full_name,
            'description' => $this->description,
            'start_at' => Carbon::parse($this->start_at)->format('H:i'),
            'finish_at' => Carbon::parse($this->finish_at)->format('H:i'),
            'on_air' => $this->on_air,
            'questions_allowed' => $this->questions_allowed,
            'questions_limit' => $this->questions_limit,
            'questions_auto_start' => $this->questions_auto_start,
            'status' => $this->status,
            ];
    }
}
