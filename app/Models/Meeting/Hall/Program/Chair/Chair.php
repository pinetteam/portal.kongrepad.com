<?php

namespace App\Models\Meeting\Hall\Program\Chair;

use App\Models\Meeting\Participant\Participant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chair extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'meeting_hall_program_chairs';
    protected $fillable = [
        'program_id',
        'chair_id',
        'sort_order',
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
    public function chair()
    {
        return $this->belongsTo(Participant::class, 'chair_id', 'id');
    }
}
