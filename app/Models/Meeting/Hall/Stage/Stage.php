<?php

namespace App\Models\Meeting\Hall\Stage;

use App\Models\Meeting\Hall\MeetingHall;
use App\Models\Meeting\Hall\Stage\Podium\Podium;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stage extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'stages';
    protected $fillable = [
        'meeting_hall_id',
        'title',
        'status',
        'deleted_by',
    ];
    protected $dates = [
        'deleted_at',
    ];
    protected $casts = [
        'deleted_at' => 'datetime',
    ];
    public function meetingHall()
    {
        return $this->belongsTo(MeetingHall::class, 'meeting_hall_id', 'id');
    }
    public function podiums()
    {
        return $this->hasMany(Podium::class, 'stage_id', 'id');
    }
}
