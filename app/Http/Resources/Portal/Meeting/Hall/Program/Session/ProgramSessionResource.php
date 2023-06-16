<?php

namespace App\Http\Resources\Portal\Meeting\Hall\Program\Session;

use App\Models\Customer\Setting\Variable\Variable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProgramSessionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'program_id' => ['value'=>$this->program_id, 'type'=>'hidden'],
            'speaker_id' => ['value'=>$this->speaker_id, 'type'=>'select'],
            'document_id' => ['value'=>$this->document_id, 'type'=>'select'],
            'sort_order' => ['value'=>$this->sort_order, 'type'=>'number'],
            'code' => ['value'=>$this->code, 'type'=>'text'],
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'description' => ['value'=>$this->description, 'type'=>'text'],
            'start_at' => ['value'=>Carbon::createFromFormat(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value.' '.Variable::where('variable','time_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value, $this->start_at)->format('d/m/Y H:i'), 'type'=>'datetime'],
            'finish_at' => ['value'=>Carbon::createFromFormat(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value.' '.Variable::where('variable','time_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value, $this->finish_at)->format('d/m/Y H:i'), 'type'=>'datetime'],
            'is_started' => ['value'=>$this->is_started, 'type'=>'radio'],
            'questions' => ['value'=>$this->questions, 'type'=>'radio'],
            'questions_auto_start' => ['value'=>$this->questions, 'type'=>'radio'],
            'question_limit' => ['value'=>$this->question_limit, 'type'=>'number'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.session.update', [$this->program_id, $this->id]),
        ];
    }
}
