<?php

namespace App\Models\Meeting\Hall\Screen;

use App\Models\Meeting\Hall\Hall;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Screen extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_hall_screens';
    protected $fillable = [
        'hall_id',
        'code',
        'title',
        'description',
        'type',
        'background_name',
        'background_extension',
        'font',
        'font_size',
        'font_color',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
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
    public function hall()
    {
        return $this->belongsTo(Hall::class, 'hall_id', 'id');
    }
}
