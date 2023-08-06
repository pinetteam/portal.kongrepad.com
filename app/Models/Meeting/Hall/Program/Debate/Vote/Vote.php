<?php

namespace App\Models\Meeting\Hall\Program\Debate\Vote;

use App\Models\Meeting\Participant\Participant;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $table = 'meeting_hall_program_debate_votes';
    protected $fillable = [
        'debate_id',
        'team_id',
        'participant_id',
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
    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id', 'id');
    }
}
