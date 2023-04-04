<?php

namespace App\Models\Session;

use App\Models\Meeting\Hall\MeetingHall;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Session extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'sessions';
    protected $fillable = [
        'main_session_id',
        'meeting_hall_id',
        'sort_id',
        'code',
        'title',
        'description',
        'start_at',
        'finish_at',
        'type',
        'status',
        'deleted_by',
    ];
    protected $dates = [
        'start_at',
        'finish_at',
        'deleted_at',
    ];
    protected $casts = [
        'start_at' => 'datetime',
        'finish_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    public function mainSession()
    {
        return $this->belongsTo(Session::class, 'main_session_id', 'id');
    }
    public function meetingHall()
    {
        return $this->belongsTo(MeetingHall::class, 'meeting_hall_id', 'id');
    }
}
