<?php

namespace App\Http\Resources\Portal\Meeting;

use App\Models\Customer\Setting\Variable\Variable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class MeetingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'code' => ['value'=>$this->code, 'type'=>'text'],
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'start_at' => ['value'=>Carbon::createFromFormat(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value, $this->start_at)->format('Y-m-d'), 'type'=>'date'],
            'finish_at' => ['value'=>Carbon::createFromFormat(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value, $this->finish_at)->format('Y-m-d'), 'type'=>'date'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.meeting.update', $this->id),
        ];
    }
}
