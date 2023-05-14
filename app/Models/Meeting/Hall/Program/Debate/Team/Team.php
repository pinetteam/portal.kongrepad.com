<?php

namespace App\Models\Meeting\Hall\Program\Debate\Team;

use App\Models\Meeting\Hall\Program\Debate\Debate;
use App\Models\Meeting\Hall\Program\Session\Keypad\Keypad;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Team extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'meeting_hall_program_debate_teams';
    protected $fillable = [
        'sort_order',
        'debate_id',
        'title',
        'description',
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
    public function debate()
    {
        return $this->belongsTo(Debate::class, 'debate_id', 'id');
    }
}
