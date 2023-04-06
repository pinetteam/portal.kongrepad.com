<?php

namespace App\Models\Program\Moderator;

use App\Models\Participant\Participant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramModerator extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'program_moderators';
    protected $fillable = [
        'program_id',
        'moderator_id',
        'status',
        'deleted_by',
    ];
    protected $dates = [
        'deleted_at',
    ];
    protected $casts = [
        'deleted_at' => 'datetime',
    ];
    public function moderator()
    {
        return $this->belongsTo(Participant::class, 'moderator_id', 'id');
    }
}
