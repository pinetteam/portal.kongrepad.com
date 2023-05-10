<?php

namespace App\Models\Customer\Setting;

use App\Models\Customer\Setting\Variable\Variable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table = 'customer_settings';
    protected $fillable = [
        'value',
    ];
    public function variable()
    {
        return $this->belongsTo(Variable::class, 'variable_id', 'id');
    }
}
