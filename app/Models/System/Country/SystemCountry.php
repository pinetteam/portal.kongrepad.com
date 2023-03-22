<?php

namespace App\Models\System\Country;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemCountry extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'system_countries';
    protected $fillable = [
        'long_name',
        'short_name_2d',
        'short_name_3d',
        'phone_code',
    ];
    protected $dates = [
        'deleted_at',
    ];
    public function getNameAndCodeAttribute()
    {
        return $this->name . " | +". $this->phone_code;
    }
}
