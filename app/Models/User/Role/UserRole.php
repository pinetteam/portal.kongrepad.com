<?php

namespace App\Models\User\Role;

use App\Casts\JSON;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRole extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'user_roles';
    protected $fillable = [
        'customer_id',
        'title',
        'access_scopes',
        'status',
        'deleted_by',
    ];
    protected $dates = [
        'deleted_at',
    ];
    protected $casts = [
        'access_scopes' => JSON::class,
        'deleted_at' => 'datetime',
    ];
}
