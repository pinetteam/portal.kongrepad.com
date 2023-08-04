<?php

namespace App\Models\Meeting\Hall;

use App\Models\Meeting\Hall\Program\Program;
use App\Models\Meeting\Hall\Program\Session\Keypad\Keypad;
use App\Models\Meeting\Hall\Program\Session\ProgramSession;
use App\Models\Meeting\Hall\Screen\Screen;
use App\Models\Meeting\Meeting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeetingHall extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'meeting_halls';
    protected $fillable = [
        'meeting_id',
        'title',
        'status',
        'created_by',
        'edited_by',
        'deleted_by',
    ];
    protected $dates = [
        'deleted_at',
    ];
    protected $casts = [
        'deleted_at' => 'datetime',
    ];
    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }
    public function programs()
    {
        return $this->hasMany(Program::class, 'meeting_hall_id', 'id');
    }

    public function keypads()
    {
        $keypads = Keypad::select('meeting_hall_program_session_keypads.*')
            ->join('meeting_hall_program_sessions', 'meeting_hall_program_session_keypads.session_id', '=', 'meeting_hall_program_sessions.id')
            ->join('meeting_hall_programs', 'meeting_hall_program_sessions.program_id', '=', 'meeting_hall_programs.id')
            ->join('meeting_halls', 'meeting_hall_programs.meeting_hall_id', '=', 'meeting_halls.id')
            ->where('meeting_halls.id', $this->getkey());
        return $keypads;
    }
    public function programSessions()
    {
        return $this->hasManyThrough(ProgramSession::class, Program::class, 'meeting_hall_id', 'program_id', 'id');
    }
}
