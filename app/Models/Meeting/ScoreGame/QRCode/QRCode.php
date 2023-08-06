<?php

namespace App\Models\Meeting\ScoreGame\QRCode;

use App\Models\Customer\Setting\Variable\Variable;
use App\Models\Meeting\ScoreGame\ScoreGame;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class QRCode extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_score_game_qr_codes';
    protected $fillable = [
        'score_game_id',
        'title',
        'code',
        'logo',
        'point',
        'start_at',
        'finish_at',
        'participation_for_agent',
        'participation_for_attendee',
        'participation_for_team',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'start_at',
        'finish_at',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'start_at' => 'datetime',
        'finish_at' => 'datetime',
    ];

    protected function startAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $startAt) => Carbon::createFromFormat('Y-m-d H:i:s', $startAt)->format(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value.' '.Variable::where('variable','time_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value),
            set: fn (string $startAt) => Carbon::createFromFormat('Y-m-d H:i', $startAt)->format('Y-m-d H:i:s'),
        );
    }
    protected function finishAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $finishAt) => Carbon::createFromFormat('Y-m-d H:i:s', $finishAt)->format(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value.' '.Variable::where('variable','time_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value),
            set: fn (string $finishAt) => Carbon::createFromFormat('Y-m-d H:i', $finishAt)->format('Y-m-d H:i:s'),
        );
    }
    public function scoreGame()
    {
        return $this->belongsTo(ScoreGame::class, 'score_game_id', 'id');
    }
}
