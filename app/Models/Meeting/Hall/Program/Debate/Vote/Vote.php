<?php

namespace App\Models\Meeting\Hall\Program\Debate\Vote;

use App\Models\Meeting\Hall\Program\Session\Keypad\Option\Team;
use App\Models\Meeting\Participant\Participant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vote extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'meeting_hall_program_debate_votes';
    protected $fillable = [
        'sort_order',
        'debate_id',
        'team_id',
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
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id', 'id');
    }
}
