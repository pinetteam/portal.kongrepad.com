<?php

namespace App\Models\Meeting\Hall\Program\Debate\Team;

use App\Models\Meeting\Hall\Program\Debate\Debate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Team extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_hall_program_debate_teams';
    protected $fillable = [
        'sort_order',
        'debate_id',
        'code',
        'logo',
        'title',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
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
    public function debate()
    {
        return $this->belongsTo(Debate::class, 'debate_id', 'id');
    }
}
