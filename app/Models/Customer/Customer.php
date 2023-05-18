<?php

namespace App\Models\Customer;

use App\Models\Customer\Setting\Setting;
use App\Models\Customer\Setting\Variable\Variable;
use App\Models\Meeting\Document\Document;
use App\Models\Meeting\Hall\MeetingHall;
use App\Models\Meeting\Hall\Program\Chair\Chair;
use App\Models\Meeting\Hall\Program\Debate\Debate;
use App\Models\Meeting\Hall\Program\Debate\Team\Team;
use App\Models\Meeting\Hall\Program\Debate\Vote\Vote;
use App\Models\Meeting\Hall\Program\Program;
use App\Models\Meeting\Hall\Program\Session\Keypad\Keypad;
use App\Models\Meeting\Hall\Program\Session\Keypad\Option\Option;
use App\Models\Meeting\Hall\Program\Session\ProgramSession;
use App\Models\Meeting\Meeting;
use App\Models\Meeting\Participant\Participant;
use App\Models\Meeting\ScoreGame\QrCode\QrCode;
use App\Models\Meeting\ScoreGame\ScoreGame;
use App\Models\User\Role\UserRole;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;
    use HasFactory, SoftDeletes;
    protected $table = 'customers';
    protected $fillable = [
        'title',
        'description',
        'icon',
        'logo',
        'policy_status',
        'language',
        'status',
        'deleted_by',
    ];
    protected $dates = [
        'deleted_at',
    ];
    protected $casts = [
        'deleted_at' => 'datetime',
    ];
    public function documents()
    {
        $documents = Document::select('meeting_documents.*')
            ->join('meetings', 'meeting_documents.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $documents;
    }
    public function meetings()
    {
        return $this->hasMany(Meeting::class, 'customer_id', 'id');
    }
    public function meetingHalls()
    {
        return $this->hasOneThrough(MeetingHall::class, Meeting::class, 'customer_id', 'meeting_id', 'id', 'id');
    }
    public function participants()
    {
        return $this->hasOneThrough(Participant::class, Meeting::class, 'customer_id', 'meeting_id', 'id', 'id');
    }
    public function programs()
    {
        $programs = Program::select('meeting_hall_programs.*')
            ->join('meeting_halls', 'meeting_hall_programs.meeting_hall_id', '=', 'meeting_halls.id')
            ->join('meetings', 'meeting_halls.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $programs;
    }
    public function programChairs()
    {
        $chairs = Chair::select('meeting_hall_program_chairs.*')
            ->join('meeting_hall_programs', 'meeting_hall_program_chairs.program_id', '=', 'meeting_hall_programs.id')
            ->join('meeting_halls', 'meeting_hall_programs.meeting_hall_id', '=', 'meeting_halls.id')
            ->join('meetings', 'meeting_halls.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $chairs;
    }
    public function programSessions()
    {
        $program_sessions = ProgramSession::select('meeting_hall_program_sessions.*')
            ->join('meeting_hall_programs', 'meeting_hall_program_sessions.program_id', '=', 'meeting_hall_programs.id')
            ->join('meeting_halls', 'meeting_hall_programs.meeting_hall_id', '=', 'meeting_halls.id')
            ->join('meetings', 'meeting_halls.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $program_sessions;
    }

    public function debates()
    {
        return $this->hasManyDeep(Debate::class, [Meeting::class, MeetingHall::class, Program::class]);
    }

    public function teams()
    {
        return $this->hasManyDeep(Team::class, [Meeting::class, MeetingHall::class, Program::class, Debate::class]);
    }

    public function keypads()
    {
        $keypads = Keypad::select('meeting_hall_program_session_keypads.*')
            ->join('meeting_hall_program_sessions', 'meeting_hall_program_session_keypads.session_id', '=', 'meeting_hall_program_sessions.id')
            ->join('meeting_hall_programs', 'meeting_hall_program_sessions.program_id', '=', 'meeting_hall_programs.id')
            ->join('meeting_halls', 'meeting_hall_programs.meeting_hall_id', '=', 'meeting_halls.id')
            ->join('meetings', 'meeting_halls.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $keypads;
    }

    public function options()
    {
        $keypads = Option::select('meeting_hall_program_session_keypad_options.*')
            ->join('meeting_hall_program_session_keypads', 'meeting_hall_program_session_keypad_options.keypad_id', '=', 'meeting_hall_program_session_keypads.id')
            ->join('meeting_hall_program_sessions', 'meeting_hall_program_session_keypads.session_id', '=', 'meeting_hall_program_sessions.id')
            ->join('meeting_hall_programs', 'meeting_hall_program_sessions.program_id', '=', 'meeting_hall_programs.id')
            ->join('meeting_halls', 'meeting_hall_programs.meeting_hall_id', '=', 'meeting_halls.id')
            ->join('meetings', 'meeting_halls.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $keypads;
    }

    public function debateVotes()
    {
        return $this->hasManyDeep(Vote::class, [Meeting::class, MeetingHall::class, Program::class, Debate::class, Team::class]);
    }

    public function settings()
    {
     $settings = Setting::select('customer_settings.*','system_setting_variables.*')
            ->join('system_setting_variables', 'customer_settings.variable_id','=', 'system_setting_variables.id')
            ->join('customers', 'customer_settings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $settings;
    }
    public function scoreGames()
    {
        return $this->hasOneThrough(ScoreGame::class, Meeting::class, 'customer_id', 'meeting_id', 'id', 'id');
    }
    public function qrCodes()
    {
        return $this->hasManyDeep(QrCode::class, [Meeting::class, ScoreGame::class]);
    }
    public function users()
    {
        return $this->hasMany(User::class, 'customer_id', 'id');
    }
    public function userRoles()
    {
        return $this->hasMany(UserRole::class, 'customer_id', 'id');
    }

}
