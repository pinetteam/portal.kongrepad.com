<?php

namespace App\Http\Resources\Portal\ScoreGame\QrCode;

use App\Models\ScoreGame\QrCode\QrCode;
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
            'score' => ['value'=>$this->score, 'type'=>'number'],
            'start_at' => ['value'=>Carbon::createFromFormat(Auth::user()->customer->settings['date-format'].' '.Auth::user()->customer->settings['time-format'], $this->start_at)->format('d/m/Y H:i'), 'type'=>'datetime'],
            'finish_at' => ['value'=>Carbon::createFromFormat(Auth::user()->customer->settings['date-format'].' '.Auth::user()->customer->settings['time-format'], $this->finish_at)->format('d/m/Y H:i'), 'type'=>'datetime'],
            'status' => ['value'=>$this->status, 'type'=>'radio'],
            'route' => route('portal.qr-code.update', $this->id),
        ];
    }
}
