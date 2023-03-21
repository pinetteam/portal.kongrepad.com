<?php

namespace App\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Customer\Customer;
use App\Models\System\Country\SystemCountry;
use App\Models\User\Role\UserRole;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'branch_id',
        'customer_id',
        'user_role_id',
        'username',
        'first_name',
        'last_name',
        'email',
        'email_verified_at',
        'phone_country_code',
        'phone',
        'phone_verified_at',
        'password',
        'status',
        'register_ip',
        'register_user_agent',
        'last_login_ip',
        'last_login_agent',
        'last_login_datetime',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_datetime' => 'datetime',
    ];

    protected $dates = [
        'deleted_at',
        'last_login_datetime',
    ];

    public function getFullNameAttribute()
    {
        return "$this->first_name $this->last_name";
    }

    public function getFullPhoneNumberAttribute()
    {
        return "$this->phone_country_code $this->phone";
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

    public function phone_country()
    {
        return $this->belongsTo(SystemCountry::class, 'phone_country_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(UserRole::class, 'user_role_id', 'id');
    }

}
