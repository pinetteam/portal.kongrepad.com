<?php

namespace App\Models\Meeting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meeting extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'meetings';
    protected $fillable = [
        'customer_id',
        'code',
        'title',
        'start_at',
        'finish_at',
        'status',
        'deleted_by',
    ];
    protected $dates = [
        'start_at',
        'finish_at',
        'deleted_at',
    ];
    protected $casts = [
        'start_at' => 'date',
        'finish_at' => 'date',
        'deleted_at' => 'datetime',
    ];
}
