<?php

namespace App\Models\Meeting\Hall\Program\Session\Keypad;

use App\Models\Customer\Setting\Variable\Variable;
use App\Models\Meeting\Hall\Program\Session\Keypad\Option\Option;
use App\Models\Meeting\Hall\Program\Session\Keypad\Vote\Vote;
use App\Models\Meeting\Hall\Program\Session\Session;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Keypad extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_hall_program_session_keypads';
    protected $fillable = [
        'sort_order',
        'session_id',
        'title',
        'keypad',
        'on_vote',
        'voting_started_at',
        'voting_finished_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'voting_started_at',
        'voting_finished_at',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'voting_started_at' => 'datetime',
        'voting_finished_at' => 'datetime',
    ];
    protected function votingStartedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($startAt) => $startAt ? Carbon::createFromFormat('Y-m-d H:i:s', $startAt)->format(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id ?? 1)->first()->value.' '.Variable::where('variable','time_format')->first()->settings()->where('customer_id',Auth::user()->customer->id ?? 1)->first()->value) : null,
            set: fn ($startAt) => $startAt ? Carbon::createFromFormat('Y-m-d H:i', $startAt)->format('Y-m-d H:i:s') : null,
        );
    }
    protected function votingFinishedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($finishAt) => $finishAt ? Carbon::createFromFormat('Y-m-d H:i:s', $finishAt)->format(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id ?? 1)->first()->value.' '.Variable::where('variable','time_format')->first()->settings()->where('customer_id',Auth::user()->customer->id ?? 1)->first()->value) : null,
            set: fn ($finishAt) => $finishAt ? Carbon::createFromFormat('Y-m-d H:i', $finishAt)->format('Y-m-d H:i:s') : null,
        );
    }
    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id', 'id');
    }

    public function options()
    {
        return $this->hasMany(Option::class, 'keypad_id', 'id');
    }

    public function votes()
    {
        return $this->hasManyThrough(Vote::class, Option::class, 'keypad_id', 'option_id', 'id', 'id');

    }
}
