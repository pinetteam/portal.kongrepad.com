<?php

namespace App\Models\Meeting\ScoreGame\QrCode;

use App\Models\Customer\Setting\Variable\Variable;
use App\Models\Meeting\ScoreGame\ScoreGame;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class QrCode extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'meeting_score_game_qr_codes';
    protected $fillable = [
        'code',
        'score_game_id',
        'title',
        'point',
        'participation_for_agent',
        'participation_for_attendee',
        'participation_for_team',
        'start_at',
        'finish_at',
        'status',
        'deleted_by',
    ];
    protected $dates = [
        'start_at',
        'finish_at',
        'deleted_at',
    ];
    protected $casts = [
        'start_at' => 'datetime:Y-m-d',
        'finish_at' => 'datetime:Y-m-d',
        'deleted_at' => 'datetime',
    ];

    protected function startAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $startAt) => Carbon::createFromFormat('Y-m-d H:i:s', $startAt)->format(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value.' '.Variable::where('variable','time_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value),
            set: fn (string $startAt) => Carbon::createFromFormat('d/m/Y H:i', $startAt)->format('Y-m-d H:i:s'),
        );
    }
    protected function finishAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $finishAt) => Carbon::createFromFormat('Y-m-d H:i:s', $finishAt)->format(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value.' '.Variable::where('variable','time_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value),
            set: fn (string $finishAt) => Carbon::createFromFormat('d/m/Y H:i', $finishAt)->format('Y-m-d H:i:s'),
        );
    }
    public function scoreGame()
    {
        return $this->belongsTo(ScoreGame::class, 'score_game_id', 'id');
    }
}
