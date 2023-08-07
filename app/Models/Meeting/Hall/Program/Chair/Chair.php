<?php

namespace App\Models\Meeting\Hall\Program\Chair;

use App\Models\Meeting\Participant\Participant;
use Illuminate\Database\Eloquent\Model;

class Chair extends Model
{
    protected $table = 'meeting_hall_program_chairs';
    protected $fillable = [
        'sort_order',
        'program_id',
        'chair_id',
        'created_by',
        'updated_by',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function chair()
    {
        return $this->belongsTo(Participant::class, 'chair_id', 'id');
    }
}
