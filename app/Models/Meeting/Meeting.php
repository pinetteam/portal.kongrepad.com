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
        'title',
        'start_at',
        'finish_at',
        'status',
    ];
    protected $dates = [
        'start_at',
        'finish_at',
        'deleted_at',
    ];
}
