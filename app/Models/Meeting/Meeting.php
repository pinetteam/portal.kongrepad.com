<?php

namespace App\Models\Meeting;

use App\Models\Customer\Setting\Variable\Variable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Meeting extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'meetings';
    protected $fillable = [
        'customer_id',
        'code',
        'title',
        'start_at',
        'finish_at',
        'status',
        'deleted_by',
    ];
    protected $dates = [
        'start_at',
        'finish_at',
        'deleted_at',
    ];
    protected $casts = [
        'start_at' => 'datetime:Y-m-d',
        'finish_at' => 'datetime:Y-m-d',
        'deleted_at' => 'datetime',
    ];
    protected function startAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $startAt) => Carbon::createFromFormat('Y-m-d', $startAt)->format(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value),
            set: fn (string $startAt) => Carbon::createFromFormat('d/m/Y', $startAt)->format('Y-m-d'),
        );
    }
    protected function finishAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $finishAt) => Carbon::createFromFormat('Y-m-d', $finishAt)->format(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value),
            set: fn (string $finishAt) => Carbon::createFromFormat('d/m/Y', $finishAt)->format('Y-m-d'),
        );
    }
}
