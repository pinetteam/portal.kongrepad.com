<?php

namespace App\Models\Meeting;

use App\Models\Customer\Setting\Variable\Variable;
use App\Models\Meeting\Document\Document;
use App\Models\Meeting\Hall\MeetingHall;
use App\Models\Meeting\Hall\Program\Chair\Chair;
use App\Models\Meeting\Hall\Program\Debate\Debate;
use App\Models\Meeting\Hall\Program\Program;
use App\Models\Meeting\Hall\Program\Session\ProgramSession;
use App\Models\Meeting\Participant\Participant;
use App\Models\Meeting\ScoreGame\ScoreGame;
use App\Models\Meeting\Survey\Survey;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Meeting extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'meetings';
    protected $fillable = [
        'customer_id',
        'code',
        'title',
        'start_at',
        'finish_at',
        'status',
        'created_by',
        'edited_by',
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
            get: fn(string $startAt) => Carbon::createFromFormat('Y-m-d', $startAt)->format(Variable::where('variable', 'date_format')->first()->settings()->where('customer_id', Auth::user()->customer->id)->first()->value),
            set: fn(string $startAt) => Carbon::createFromFormat('Y-m-d', $startAt)->format('Y-m-d'),
        );

    }

    protected function finishAt(): Attribute
    {
        return Attribute::make(
            get: fn(string $finishAt) => Carbon::createFromFormat('Y-m-d', $finishAt)->format(Variable::where('variable', 'date_format')->first()->settings()->where('customer_id', Auth::user()->customer->id)->first()->value),
            set: fn(string $finishAt) => Carbon::createFromFormat('Y-m-d', $finishAt)->format('Y-m-d'),
        );
    }

    public function halls()
    {
        return $this->hasMany(MeetingHall::class, 'meeting_id', 'id');
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
        return $this->hasManyThrough(Program::class, MeetingHall::class, 'meeting_id', 'meeting_hall_id', 'id');
    }

    public function programSessions()
    {
        $program_sessions = ProgramSession::select('meeting_hall_program_sessions.*')
            ->join('meeting_hall_programs', 'meeting_hall_program_sessions.program_id', '=', 'meeting_hall_programs.id')
            ->join('meeting_halls', 'meeting_hall_programs.meeting_hall_id', '=', 'meeting_halls.id')
            ->join('meetings', 'meeting_halls.meeting_id', '=', 'meetings.id')
            ->where('meetings.id', $this->getkey());
        return $program_sessions;
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
