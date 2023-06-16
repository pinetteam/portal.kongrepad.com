<?php

namespace App\Http\Resources\Portal\Meeting\Survey;

use App\Models\Customer\Setting\Variable\Variable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class SurveyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'meeting_id' => 'required|exists:meetings,id',
            'sort_order' => ['value'=>$this->sort_order, 'type'=>'number'],
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'description' => ['value'=>$this->description, 'type'=>'text'],
            'start_at' => ['value'=> $this->voting_started_at ? Carbon::createFromFormat(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value.' '.Variable::where('variable','time_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value, $this->voting_started_at)->format('d/m/Y H:i') : null, 'type'=>'datetime'],
            'finish_at' => ['value'=> $this->voting_finished_at ? Carbon::createFromFormat(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value.' '.Variable::where('variable','time_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value, $this->voting_finished_at)->format('d/m/Y H:i') : null, 'type'=>'datetime'],
            'on_air' => ['value'=>$this->on_vote, 'type'=>'radio'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.meeting.survey.update', [$this->meeting_id, $this->id]),
        ];
    }
}
