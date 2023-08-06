<?php

namespace App\Models\Meeting;

use App\Models\Customer\Setting\Setting;
use App\Models\Customer\Setting\Variable\Variable;
use App\Models\Meeting\Document\Document;
use App\Models\Meeting\Hall\Hall;
use App\Models\Meeting\Hall\Program\Chair\Chair;
use App\Models\Meeting\Hall\Program\Debate\Debate;
use App\Models\Meeting\Hall\Program\Program;
use App\Models\Meeting\Hall\Program\Session\Keypad\Keypad;
use App\Models\Meeting\Hall\Program\Session\Session;
use App\Models\Meeting\Participant\Participant;
use App\Models\Meeting\ScoreGame\ScoreGame;
use App\Models\Meeting\Survey\Survey;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Meeting extends Model
{
    use SoftDeletes;
    protected $table = 'meetings';
    protected $fillable = [
        'customer_id',
        'code',
        'title',
        'start_at',
        'finish_at',
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
        'start_at' => 'datetime:Y-m-d',
        'finish_at' => 'datetime:Y-m-d',
    ];

    protected function startAt(): Attribute
    {
        $date_format = Setting::where('customer_id', 1)->where('variable_id', 7)->first()->value;
        return Attribute::make(
            get: fn(string $startAt) => Carbon::createFromFormat('Y-m-d', $startAt)->format($date_format),
            set: fn(string $startAt) => Carbon::createFromFormat($date_format, $startAt)->format('Y-m-d'),
        );
    }

    protected function finishAt(): Attribute
    {
        $date_format = Setting::where('customer_id', 1)->where('variable_id', 7)->first()->value;
        return Attribute::make(
            get: fn(string $finishAt) => Carbon::createFromFormat('Y-m-d', $finishAt)->format($date_format),
            set: fn(string $finishAt) => Carbon::createFromFormat($date_format, $finishAt)->format('Y-m-d'),
        );
    }

    public function halls()
    {
        return $this->hasMany(Hall::class, 'meeting_id', 'id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'meeting_id', 'id');
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class, 'meeting_id', 'id');
    }

    public function scoreGames()
    {
        return $this->hasMany(ScoreGame::class, 'meeting_id', 'id');
    }

    public function participants()
    {
        return $this->hasMany(Participant::class, 'meeting_id', 'id');
    }

    public function programs()
    {
        return $this->hasManyThrough(Program::class, Hall::class, 'meeting_id', 'meeting_hall_id', 'id');
    }

    public function programSessions()
    {
        $program_sessions = Session::select('meeting_hall_program_sessions.*')
            ->join('meeting_hall_programs', 'meeting_hall_program_sessions.program_id', '=', 'meeting_hall_programs.id')
            ->join('meeting_halls', 'meeting_hall_programs.meeting_hall_id', '=', 'meeting_halls.id')
            ->join('meetings', 'meeting_halls.meeting_id', '=', 'meetings.id')
            ->where('meetings.id', $this->getkey());
        return $program_sessions;
    }

    public function keypads()
    {
        $keypads = Keypad::select('meeting_hall_program_session_keypads.*')
            ->join('meeting_hall_program_sessions', 'meeting_hall_program_session_keypads.session_id', '=', 'meeting_hall_program_sessions.id')
            ->join('meeting_hall_programs', 'meeting_hall_program_sessions.program_id', '=', 'meeting_hall_programs.id')
            ->join('meeting_halls', 'meeting_hall_programs.meeting_hall_id', '=', 'meeting_halls.id')
            ->join('meetings', 'meeting_halls.meeting_id', '=', 'meetings.id')
            ->where('meetings.id', $this->getkey());
        return $keypads;
    }

    public function debates()
    {
        $debates = Debate::select('meeting_hall_program_debates.*')
            ->join('meeting_hall_programs', 'meeting_hall_program_debates.program_id', '=', 'meeting_hall_programs.id')
            ->join('meeting_halls', 'meeting_hall_programs.meeting_hall_id', '=', 'meeting_halls.id')
            ->join('meetings', 'meeting_halls.meeting_id', '=', 'meetings.id')
            ->where('meetings.id', $this->getkey());
        return $debates;
    }

    public function programChairs()
    {
        $chairs = Chair::select('meeting_hall_program_chairs.*')
            ->join('meeting_hall_programs', 'meeting_hall_program_chairs.program_id', '=', 'meeting_hall_programs.id')
            ->join('meeting_halls', 'meeting_hall_programs.meeting_hall_id', '=', 'meeting_halls.id')
            ->join('meetings', 'meeting_halls.meeting_id', '=', 'meetings.id')
            ->where('meetings.id', $this->getkey());
        return $chairs;
    }
}
