<?php

namespace App\Models\User;

use App\Models\Customer\Customer;
use App\Models\System\Country\SystemCountry;
use App\Models\User\Role\UserRole;
use App\Models\User\Session\UserSession;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    protected $table = 'users';
    protected $fillable = [
        'user_role_id',
        'username',
        'first_name',
        'last_name',
        'email',
        'email_verified_at',
        'phone_country_id',
        'phone',
        'phone_verified_at',
        'password',
        'register_ip',
        'register_user_agent',
        'last_login_ip',
        'last_login_agent',
        'last_login_datetime',
        'status',
        'deleted_by',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $dates = [
        'email_verified_at',
        'last_login_datetime',
        'deleted_at',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_datetime' => 'datetime',
    ];
    public function getActivityStatusAttribute()
    {
        if($this->sessions()->max('last_activity') !== null) {
            $now = Carbon::now()->timestamp;
            $last_activity = $this->sessions()->max('last_activity');
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
    public function getFullNameAttribute()
    {
        return Str::of("$this->first_name $this->last_name")->trim();
    }
    public function getLastLoginAttribute()
    {
        if(isset($this->last_login_datetime)) {
            return Carbon::parse($this->last_login_datetime)->diffForHumans();
        } else {
            return __('common.not-logged-in-yet');
        }
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function phoneCountry()
    {
        return $this->belongsTo(SystemCountry::class, 'phone_country_id', 'id');
    }
    public function userRole()
    {
        return $this->belongsTo(UserRole::class, 'user_role_id', 'id');
    }
    public function sessions()
    {
        return $this->hasMany(UserSession::class, 'user_id', 'id');
    }
}
