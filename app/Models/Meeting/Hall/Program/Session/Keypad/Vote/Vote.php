<?php

namespace App\Models\Meeting\Hall\Program\Session\Keypad\Vote;

use App\Models\Customer\Customer;
use App\Models\Meeting\Hall\Program\Session\Keypad\Keypad;
use App\Models\Meeting\Hall\Program\Session\Keypad\Option\Option;
use App\Models\Meeting\Participant\Participant;
use App\Models\System\Setting\Variable\Variable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Vote extends Model
{
    protected $table = 'meeting_hall_program_session_keypad_votes';
    protected $fillable = [
        'keypad_id',
        'option_id',
        'participant_id',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected function createdAt(): Attribute
{
    $date_time_format = Variable::where('variable', 'date_time_format')->first()->settings()->where('customer_id', Auth::user()->customer->id ?? Customer::first()->id)->first()->value;

    return Attribute::make(
        get: fn ($createdAt) => $createdAt ? Carbon::createFromFormat('Y-m-d H:i:s', $createdAt)->format($date_time_format) : null,
    );
}
    public function option()
    {
        return $this->belongsTo(Option::class, 'option_id', 'id');
    }
    public function keypad()
    {
        return $this->belongsTo(Keypad::class, 'keypad_id', 'id');
    }
    public function owner()
    {
        return $this->belongsTo(Participant::class, 'participant_id', 'id');
    }
}
