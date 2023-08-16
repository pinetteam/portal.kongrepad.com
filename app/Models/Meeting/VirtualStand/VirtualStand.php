<?php

namespace App\Models\Meeting\VirtualStand;

use App\Models\Meeting\Meeting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VirtualStand extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_virtual_stands';
    protected $fillable = [
        'meeting_id',
        'file_name',
        'file_extension',
        'file_size',
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
    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }
}
