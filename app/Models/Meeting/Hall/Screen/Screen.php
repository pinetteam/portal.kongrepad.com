<?php

namespace App\Models\Meeting\Hall\Screen;

use App\Models\Meeting\Hall\MeetingHall;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Screen extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'meeting_hall_screens';
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
}
