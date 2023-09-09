<?php

namespace App\Models\Meeting\Announcement;

use App\Models\Customer\Customer;
use App\Models\Meeting\Meeting;
use App\Models\System\Setting\Variable\Variable;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Announcement extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_announcements';
    protected $fillable = [
        'meeting_id',
        'title',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    protected function createdAt(): Attribute
    {
        $date_time_format = Variable::where('variable', 'date_time_format')->first()->settings()->where('customer_id', Auth::user()->customer->id ?? Customer::first()->id)->first()->value;

        return Attribute::make(
            get: fn (string $createdAt) => Carbon::createFromFormat('Y-m-d H:i:s', $createdAt)->format($date_time_format),
            set: fn (string $createdAt) => Carbon::createFromFormat($date_time_format, $createdAt)->format('Y-m-d H:i:s'),
        );
    }
    public function getCreatedByNameAttribute()
    {
        return isset($this->created_by) ? User::findOrFail($this->created_by)->full_name : __('common.unspecified');
    }
    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }
}
