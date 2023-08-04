<?php

namespace App\Http\Resources\Portal\Meeting\Hall\Program;

use App\Models\Customer\Setting\Variable\Variable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProgramResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'meeting_hall_id' => ['value'=>$this->meeting_hall_id, 'type'=>'select'],
            'sort_order' => ['value'=>$this->sort_order, 'type'=>'number'],
            'code' => ['value'=>$this->code, 'type'=>'text'],
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'description' => ['value'=>$this->description, 'type'=>'text'],
            'logo' => ['value'=>$this->logo, 'type'=>'file'],
            'start_at' => ['value'=>Carbon::createFromFormat(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value.' '.Variable::where('variable','time_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value, $this->start_at)->format('Y-m-d H:i'), 'type'=>'datetime'],
            'finish_at' => ['value'=>Carbon::createFromFormat(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value.' '.Variable::where('variable','time_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value, $this->finish_at)->format('Y-m-d H:i'), 'type'=>'datetime'],
            'on_air' => ['value'=>$this->on_air, 'type'=>'radio'],
            'type' => ['value'=>$this->type, 'type'=>'select'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.meeting.hall.program.update', ['meeting' => $this->hall->meeting->id, 'hall' => $this->hall->id, 'program' => $this->id]),
        ];
    }
}
