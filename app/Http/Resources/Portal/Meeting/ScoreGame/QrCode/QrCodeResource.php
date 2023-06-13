<?php

namespace App\Http\Resources\Portal\Meeting\ScoreGame\QrCode;

use App\Models\Customer\Setting\Variable\Variable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class QrCodeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'score_game_id' => ['value'=>$this->score_game_id, 'type'=>'select'],
            'title' => ['value'=>$this->title, 'type'=>'text'],
            'logo' => ['value'=>$this->logo, 'type'=>'file'],
            'point' => ['value'=>$this->point, 'type'=>'number'],
            'start_at' => ['value'=>Carbon::createFromFormat(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value.' '.Variable::where('variable','time_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value, $this->start_at)->format('d/m/Y H:i'), 'type'=>'datetime'],
            'finish_at' => ['value'=>Carbon::createFromFormat(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value.' '.Variable::where('variable','time_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value, $this->finish_at)->format('d/m/Y H:i'), 'type'=>'datetime'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.qr-code.update', $this->id),
        ];
    }
}
