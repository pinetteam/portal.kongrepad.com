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
        'is_published',
        'publish_at',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $dates = [
        'publish_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $casts = [
        'publish_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected function publishAt(): Attribute
    {
        $time_format = Variable::where('variable','time_format')->first()->settings()->where('customer_id', Auth::user()->customer->id ?? Customer::first()->id)->first()->value == '24H' ? ' H:i' : ' g:i A';
        $date_time_format = Variable::where('variable','date_format')->first()->settings()->where('customer_id', Auth::user()->customer->id ?? Customer::first()->id)->first()->value . $time_format;
        return Attribute::make(
            get: fn (string $publishAt) => Carbon::createFromFormat('Y-m-d H:i:s', $publishAt)->format($date_time_format),
            set: fn (string $publishAt) => Carbon::createFromFormat($date_time_format, $publishAt)->format('Y-m-d H:i:s'),
        );
    }
    protected function createdAt(): Attribute
    {
        $time_format = Variable::where('variable','time_format')->first()->settings()->where('customer_id', Auth::user()->customer->id ?? Customer::first()->id)->first()->value == '24H' ? ' H:i' : ' g:i A';
        $date_time_format = Variable::where('variable','date_format')->first()->settings()->where('customer_id', Auth::user()->customer->id ?? Customer::first()->id)->first()->value . $time_format;
        return Attribute::make(
            get: fn ($createdAt) => $createdAt ? Carbon::createFromFormat('Y-m-d H:i:s', $createdAt)->format($date_time_format): null,
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
