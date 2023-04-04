<?php

namespace App\Models\Participant;

use App\Models\Meeting\Meeting;
use App\Models\System\Country\SystemCountry;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Participant extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'participants';
    protected $fillable = [
        'meeting_id',
        'username',
        'title',
        'first_name',
        'last_name',
        'organisation',
        'identification_number',
        'email',
        'phone_country_id',
        'phone',
        'password',
        'last_login_ip',
        'last_login_agent',
        'last_login_datetime',
        'last_activity',
        'type',
        'confirmation',
        'status',
        'deleted_by',
    ];
    protected $dates = [
        'last_login_datetime',
        'last_activity',
        'deleted_at',
    ];
    protected $casts = [
        'last_login_datetime' => 'datetime',
        'last_activity' => 'timestamp',
        'deleted_at' => 'datetime',
    ];
    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }
    public function getActivityStatusAttribute()
    {
        if($this->last_activity !== null) {
            $now = Carbon::now()->timestamp;
            $last_activity = $this->last_activity;
            $diff_in_seconds = $now-$last_activity;
            if($diff_in_seconds<300) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function phoneCountry()
    {
        return $this->belongsTo(SystemCountry::class, 'phone_country_id', 'id');
    }
    public function getLastLoginAttribute()
    {
        if(isset($this->last_login_datetime)) {
            return Carbon::parse($this->last_login_datetime)->diffForHumans();
        } else {
            return __('common.not-logged-in-yet');
        }
    }
    public function getFullNameAttribute()
    {
        return Str::of("$this->title $this->first_name $this->last_name")->trim();
;
    }
}
