<?php

namespace App\Models\Meeting\Hall;

use App\Models\Meeting\Hall\Program\Program;
use App\Models\Meeting\Hall\Screen\Screen;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hall extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_halls';
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
    public function programs()
    {
        return $this->hasMany(Program::class, 'hall_id', 'id');
    }
    public function screens()
    {
        return $this->hasMany(Screen::class, 'hall_id', 'id');
    }
    /*
    public function programSessions()
    {
        return $this->hasManyThrough(Session::class, Program::class, 'hall_id', 'program_id', 'id');
    }
    */
}
