<?php

namespace App\Models\User\Role\Scope;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRoleScope extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'user_role_scopes';
    protected $fillable = [
        'code',
        'route',
    ];
    protected $dates = [
        'deleted_at',
    ];
}
