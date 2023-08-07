<?php

namespace App\Models\Meeting\Hall;

use App\Models\Meeting\Hall\Program\Program;
use App\Models\Meeting\Hall\Program\Session\Keypad\Keypad;
use App\Models\Meeting\Hall\Program\Session\Session;
use App\Models\Meeting\Meeting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hall extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_halls';
    protected $fillable = [
        'meeting_id',
        'title',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }
    public function programs()
    {
        return $this->hasMany(Program::class, 'hall_id', 'id');
    }
    public function keypads()
    {
        $keypads = Keypad::select('meeting_hall_program_session_keypads.*')
            ->join('meeting_hall_program_sessions', 'meeting_hall_program_session_keypads.session_id', '=', 'meeting_hall_program_sessions.id')
            ->join('meeting_hall_programs', 'meeting_hall_program_sessions.program_id', '=', 'meeting_hall_programs.id')
            ->join('meeting_halls', 'meeting_hall_programs.hall_id', '=', 'meeting_halls.id')
            ->where('meeting_halls.id', $this->getkey());
        return $keypads;
    }
    public function programSessions()
    {
        return $this->hasManyThrough(Session::class, Program::class, 'hall_id', 'program_id', 'id');
    }
}
