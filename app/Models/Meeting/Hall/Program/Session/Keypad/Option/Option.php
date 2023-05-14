<?php

namespace App\Models\Meeting\Hall\Program\Session\Keypad\Option;

use App\Models\Meeting\Hall\Program\Session\Keypad\Keypad;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Option extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'meeting_hall_program_session_keypad_options';
    protected $fillable = [
        'sort_order',
        'keypad_id',
        'title',
        'created_by',
        'edited_by',
        'deleted_by',
    ];
    protected $dates = [
        'deleted_at',
    ];
    protected $casts = [
        'deleted_at' => 'datetime',
    ];
    public function keypad()
    {
        return $this->belongsTo(Keypad::class, 'keypad_id', 'id');
    }
}
