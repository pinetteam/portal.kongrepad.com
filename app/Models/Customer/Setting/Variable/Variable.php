<?php

namespace App\Models\Customer\Setting\Variable;

use App\Models\Customer\Setting\Setting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    use HasFactory;
    protected $table = 'system_setting_variables';

    public function settings()
    {
        return $this->hasMany(Setting::class, 'variable_id', 'id');
    }
}
