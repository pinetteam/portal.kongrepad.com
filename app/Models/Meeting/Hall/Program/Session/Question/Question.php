<?php

namespace App\Models\Meeting\Hall\Program\Session\Question;

use App\Models\Meeting\Hall\Program\Session\ProgramSession;
use App\Models\Meeting\Participant\Participant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'meeting_hall_program_session_questions';
    protected $fillable = [
        'sort_order',
        'session_id',
        'owner_id',
        'on_screen',
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
    public function programSession()
    {
        return $this->belongsTo(ProgramSession::class, 'session_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo(Participant::class, 'owner_id', 'id');
    }
}
