<?php

namespace App\Models\Meeting\Hall\Program;

use App\Models\Customer\Setting\Variable\Variable;
use App\Models\Meeting\Hall\Hall;
use App\Models\Meeting\Hall\Program\Chair\Chair;
use App\Models\Meeting\Hall\Program\Debate\Debate;
use App\Models\Meeting\Hall\Program\Session\Session;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Program extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_hall_programs';
    protected $fillable = [
        'hall_id',
        'sort_order',
        'code',
        'title',
        'description',
        'logo',
        'start_at',
        'finish_at',
        'type',
        'is_started',
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
            get: fn (string $startAt) => Carbon::createFromFormat('Y-m-d H:i:s', $startAt)->format(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id ?? 1)->first()->value.' '.Variable::where('variable','time_format')->first()->settings()->where('customer_id',Auth::user()->customer->id ?? 1)->first()->value),
            set: fn (string $startAt) => Carbon::createFromFormat('Y-m-d H:i', $startAt)->format('Y-m-d H:i:s'),
        );
    }
    protected function finishAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $finishAt) => Carbon::createFromFormat('Y-m-d H:i:s', $finishAt)->format(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id ?? 1)->first()->value.' '.Variable::where('variable','time_format')->first()->settings()->where('customer_id',Auth::user()->customer->id ?? 1)->first()->value),
            set: fn (string $finishAt) => Carbon::createFromFormat('Y-m-d H:i', $finishAt)->format('Y-m-d H:i:s'),
        );
    }
    public function hall()
    {
        return $this->belongsTo(Hall::class, 'meeting_hall_id', 'id');
    }
    public function programChairs()
    {
        return $this->hasMany(Chair::class, 'program_id', 'id');
    }
    public function programSessions()
    {
        return $this->hasMany(Session::class, 'program_id', 'id');
    }

    public function debates()
    {
        return $this->hasMany(Debate::class, 'program_id', 'id');
    }
}
