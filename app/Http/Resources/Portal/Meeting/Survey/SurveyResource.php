<?php

namespace App\Http\Resources\Portal\Meeting\Survey;

use App\Models\System\Setting\Variable\Variable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class SurveyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'meeting_id' => ['value'=>$this->meeting_id, 'type'=>'select'],
            'sort_order' => ['value'=>$this->sort_order, 'type'=>'number'],
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'description' => ['value'=>$this->description, 'type'=>'text'],
            'start_at' => ['value'=>$this->start_at, 'type'=>'datetime'],
            'finish_at' => ['value'=>$this->finish_at, 'type'=>'datetime'],
            'on_vote' => ['value'=>$this->on_vote, 'type'=>'radio'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.meeting.survey.update', ['meeting' => $this->meeting_id, 'survey' => $this->id]),
        ];
    }
}
