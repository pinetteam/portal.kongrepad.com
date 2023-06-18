<?php

namespace App\Http\Resources\Portal\Meeting\ScoreGame;

use App\Models\Customer\Setting\Variable\Variable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ScoreGameResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'meeting_id' => ['value'=>$this->meeting_id, 'type'=>'select'],
            'start_at' => ['value'=>Carbon::createFromFormat(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value.' '.Variable::where('variable','time_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value, $this->start_at)->format('Y-m-d H:i'), 'type'=>'datetime'],
            'finish_at' => ['value'=>Carbon::createFromFormat(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value.' '.Variable::where('variable','time_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value, $this->finish_at)->format('Y-m-d H:i'), 'type'=>'datetime'],
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'types' => ['value'=>$this->types, 'type'=>'checkbox'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.score-game.update', $this->id),
        ];
    }
}
