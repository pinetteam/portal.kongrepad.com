<?php

namespace App\Models\User\Session;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'user_sessions';
    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'payload',
        'last_activity',
    ];
    protected $dates = [
        'last_activity',
    ];
    protected $casts = [
        'last_activity' => 'timestamp',
    ];
}
