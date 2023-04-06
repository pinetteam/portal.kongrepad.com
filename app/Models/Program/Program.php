<?php

namespace App\Models\Program;

use App\Models\Meeting\Hall\MeetingHall;
use App\Models\Program\Moderator\ProgramModerator;
use App\Models\Program\Session\ProgramSession;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Program extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'programs';
    protected $fillable = [
        'meeting_hall_id',
        'sort_id',
        'code',
        'title',
        'description',
        'logo',
        'start_at',
        'finish_at',
        'type',
        'status',
        'deleted_by',
    ];
    protected $dates = [
        'start_at',
        'finish_at',
        'deleted_at',
    ];
    protected $casts = [
        'start_at' => 'datetime',
        'finish_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    protected function startAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $startAt) => Carbon::createFromFormat('Y-m-d H:i:s', $startAt)->format(Auth::user()->customer->settings['date-format'].' '.Auth::user()->customer->settings['time-format']),
            set: fn (string $startAt) => Carbon::createFromFormat('d/m/Y H:i', $startAt)->format('Y-m-d H:i:s'),
        );
    }
    protected function finishAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $finishAt) => Carbon::createFromFormat('Y-m-d H:i:s', $finishAt)->format(Auth::user()->customer->settings['date-format'].' '.Auth::user()->customer->settings['time-format']),
            set: fn (string $finishAt) => Carbon::createFromFormat('d/m/Y H:i', $finishAt)->format('Y-m-d H:i:s'),
        );
    }
    public function meetingHall()
    {
        return $this->belongsTo(MeetingHall::class, 'meeting_hall_id', 'id');
    }
    public function programModerators()
    {
        return $this->hasMany(ProgramModerator::class, 'program_id', 'id');
    }
    public function programSessions()
    {
        return $this->hasMany(ProgramSession::class, 'program_id', 'id');
    }
}
