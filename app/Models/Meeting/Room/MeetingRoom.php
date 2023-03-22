<?php

namespace App\Models\Meeting\Room;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeetingRoom extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'meeting_rooms';
    protected $fillable = [
        'meeting_id',
        'title',
        'status',
    ];
    protected $dates = [
        'deleted_at',
    ];
}
