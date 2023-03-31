<?php

namespace App\Models\Session;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Session extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'sessions';
    protected $fillable = [
        'session_id',
        'meeting_hall_id',
        'sort_id',
        'code',
        'title',
        'date',
        'start_at',
        'finish_at',
        'type',
        'status',
        'deleted_by',
    ];
    protected $dates = [
        'deleted_at',
    ];
    protected $casts = [
    ];
}
