<?php

namespace App\Models\Log\Meeting\Hall\Program\Session\Keypad;

use App\Models\Meeting\Hall\Program\Session\Keypad\Keypad as KeypadModel;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Keypad extends Model
{
    use HasFactory, Uuid;
    
    protected $table = 'meeting_hall_program_session_keypad_logs';
    
    protected $guarded = [];
    
    public function keypad()
    {
        return $this->belongsTo(KeypadModel::class, 'keypad_id');
    }
    
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
} 