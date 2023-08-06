<?php

namespace App\Models\Meeting\Hall\Program\Session\Keypad\Vote;

use App\Models\Meeting\Hall\Program\Session\Keypad\Option\Option;
use App\Models\Meeting\Participant\Participant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vote extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_hall_program_session_keypad_votes';
    protected $fillable = [
        'keypad_id',
        'option_id',
        'participant_id',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function option()
    {
        return $this->belongsTo(Option::class, 'option_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo(Participant::class, 'participant_id', 'id');
    }
}
