<?php

namespace App\Models\ScoreGame;

use App\Models\Customer\Setting\Variable\Variable;
use App\Models\Meeting\Meeting;
use App\Models\ScoreGame\QrCode\QrCode;
use App\Models\ScoreGame\Score\Score;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ScoreGame extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'score_games';
    protected $fillable = [
        'meeting_id',
        'title',
        'status',
        'start_at',
        'finish_at',
        'deleted_by',
    ];
    protected $dates = [
        'start_at',
        'finish_at',
        'deleted_at',
    ];
    protected $casts = [
        'types' => 'array',
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

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }
    public function qrCodes(){
        return $this->hasMany(QrCode::class, 'score_game_id', 'id');
    }
    public function scores(){
        return $this->hasMany(Score::class, 'score_game_id', 'id');
    }

}
