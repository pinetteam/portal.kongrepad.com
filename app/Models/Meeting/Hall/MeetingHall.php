<?php

namespace App\Models\Meeting\Hall;

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
}
