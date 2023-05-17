<?php

namespace App\Models\System\Route;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;
    protected $table = 'system_routes';
    protected $fillable = [
        'code',
        'route',
    ];
}
