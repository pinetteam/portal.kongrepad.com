<?php

namespace App\Models\Meeting\Hall;

use App\Models\Meeting\Hall\Program\Program;
use App\Models\Meeting\Hall\Screen\Screen;
use App\Models\Meeting\Meeting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeetingHall extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'meeting_halls';
    protected $fillable = [
        'meeting_id',
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
    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }
    public function programs()
    {
        return $this->hasMany(Program::class, 'meeting_hall_id', 'id');
    }
}
