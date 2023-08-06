<?php

namespace App\Models\User;

use App\Models\Customer\Customer;
use App\Models\System\Country\Country;
use App\Models\User\Role\Role;
use App\Models\User\Session\Session;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;
    protected $table = 'users';
    protected $fillable = [
        'customer_id',
        'user_role_id',
        'username',
        'first_name',
        'last_name',
        'email',
        'email_verified_at',
        'phone_country_id',
        'phone',
        'phone_verified_at',
        'register_ip',
        'register_user_agent',
        'last_login_ip',
        'last_login_agent',
        'last_login_datetime',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'email_verified_at',
        'phone_verified_at',
        'last_login_datetime',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'email_verified_at' => 'timestamp',
        'phone_verified_at' => 'timestamp',
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
    public function getFullPhoneAttribute()
    {
        if(isset($this->phone_country_id) && isset($this->phone)) {
            return Str::of('+'.$this->phoneCountry->phone_code.$this->phone)->trim();
        } else {
            return __('common.unspecified');
        }
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
        return $this->belongsTo(Country::class, 'phone_country_id', 'id');
    }
    public function userRole()
    {
        return $this->belongsTo(Role::class, 'user_role_id', 'id');
    }
    public function sessions()
    {
        return $this->hasMany(Session::class, 'user_id', 'id');
    }
}
