<?php

namespace App\Models\Meeting\Announcement;

use App\Models\Meeting\Meeting;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_announcements';
    protected $fillable = [
        'meeting_id',
        'title',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
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
    public function getCreatedByNameAttribute()
    {
        return isset($this->created_by) ? User::findOrFail($this->created_by)->full_name : __('common.unspecified');
    }
    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }
}
