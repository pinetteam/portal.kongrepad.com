<?php

namespace App\Models\Customer\Subscription;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $table = 'customer_subscriptions';
    protected $fillable = [
        'start_at',
        'finish_at',
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
    public function systemSubscription()
    {
        return $this->belongsTo(\App\Models\Customer\Subscription\System\Subscription::class, 'variable_id', 'id');
    }
}
