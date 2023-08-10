<?php

namespace App\Http\Resources\Portal\Meeting\Hall\Program\Debate;

use App\Models\Customer\Setting\Variable\Variable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class DebateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'program_id' => 'required|exists:meeting_hall_programs,id',
            'sort_order' => ['value'=>$this->sort_order, 'type'=>'number'],
            'code' => ['value'=>$this->code, 'type'=>'text'],
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'description' => ['value'=>$this->description, 'type'=>'text'],
            'voting_started_at' => ['value'=> $this->voting_started_at ? Carbon::createFromFormat(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value.' '.Variable::where('variable','time_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value, $this->voting_started_at)->format('Y-m-d H:i') : null, 'type'=>'datetime'],
            'voting_finished_at' => ['value'=> $this->voting_finished_at ? Carbon::createFromFormat(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value.' '.Variable::where('variable','time_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value, $this->voting_finished_at)->format('Y-m-d H:i')  : null, 'type'=>'datetime'],
            'on_vote' => ['value'=>$this->on_vote, 'type'=>'radio'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.meeting.hall.program.debate.show', ['meeting' => $this->program->hall->meeting->id, 'hall' => $this->program->hall->id, 'program' => $this->program->id, 'debate' => $this->id]),
        ];
    }
}
