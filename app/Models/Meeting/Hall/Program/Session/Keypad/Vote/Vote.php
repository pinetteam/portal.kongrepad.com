<?php

namespace App\Models\Meeting\Hall\Program\Session\Keypad\Vote;

use App\Models\Meeting\Hall\Program\Session\Keypad\Option\Option;
use App\Models\Meeting\Participant\Participant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vote extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'meeting_hall_program_session_keypad_votes';
    protected $fillable = [
        'sort_order',
        'keypad_id',
        'option_id',
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
    public function option()
    {
        return $this->belongsTo(Option::class, 'option_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo(Participant::class, 'participant_id', 'id');
    }
}
