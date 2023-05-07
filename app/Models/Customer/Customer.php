<?php

namespace App\Models\Customer;

use App\Casts\JSON;
use App\Models\Document\Document;
use App\Models\Meeting\Hall\Stage\Podium\Podium;
use App\Models\Meeting\Hall\Stage\Stage;
use App\Models\Meeting\Meeting;
use App\Models\Meeting\Hall\MeetingHall;
use App\Models\Participant\Participant;
use App\Models\Program\Moderator\ProgramModerator;
use App\Models\Program\Program;
use App\Models\Program\Session\ProgramSession;
use App\Models\ScoreGame\QrCode\QrCode;
use App\Models\ScoreGame\ScoreGame;
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
        'settings',
        'status',
        'deleted_by',
    ];
    protected $dates = [
        'deleted_at',
    ];
    protected $casts = [
        'deleted_at' => 'datetime',
        'settings' => JSON::class,
    ];
    public function documents()
    {
        $documents = Document::select('documents.*')
            ->join('meetings', 'documents.meeting_id', '=', 'meetings.id')
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
        $programs = Program::select('programs.*')
            ->join('meeting_halls', 'programs.meeting_hall_id', '=', 'meeting_halls.id')
            ->join('meetings', 'meeting_halls.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $programs;
    }
    public function programModerators()
    {
        $program_moderators = ProgramModerator::select('program_moderators.*')
            ->join('programs', 'program_moderators.program_id', '=', 'programs.id')
            ->join('meeting_halls', 'programs.meeting_hall_id', '=', 'meeting_halls.id')
            ->join('meetings', 'meeting_halls.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $program_moderators;
    }
    public function programSessions()
    {
        $program_sessions = ProgramSession::select('program_sessions.*')
            ->join('programs', 'program_sessions.program_id', '=', 'programs.id')
            ->join('meeting_halls', 'programs.meeting_hall_id', '=', 'meeting_halls.id')
            ->join('meetings', 'meeting_halls.meeting_id', '=', 'meetings.id')
            ->join('customers', 'meetings.customer_id', '=', 'customers.id')
            ->where('customers.id', $this->getkey());
        return $program_sessions;
    }
    public function scoreGames()
    {
        return $this->hasOneThrough(ScoreGame::class, Meeting::class, 'customer_id', 'meeting_id', 'id', 'id');
    }
    public function qrCodes()
    {
        return $this->hasManyDeep(QrCode::class, [Meeting::class, ScoreGame::class]);
    }
    public function stages()
    {
        return $this->hasManyDeep(Stage::class, [Meeting::class, MeetingHall::class]);
    }
    public function podiums()
    {
        return $this->hasManyDeep(Podium::class, [Meeting::class, MeetingHall::class, Stage::class]);
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
