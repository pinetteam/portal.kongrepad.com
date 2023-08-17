<?php

namespace App\Models\Meeting\Survey;

use App\Models\Meeting\Survey\Question\Question;
use App\Models\System\Setting\Variable\Variable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Survey extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_surveys';
    protected $fillable = [
        'sort_order',
        'meeting_id',
        'title',
        'description',
        'start_at',
        'finish_at',
        'on_vote',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'start_at',
        'finish_at',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'start_at' => 'datetime',
        'finish_at' => 'datetime',
    ];
    protected function startAt(): Attribute
    {
        $date_time_format = Variable::where('variable','date_time_format')->first()->settings()->where('customer_id', Auth::user()->customer->id)->first()->value;
        return Attribute::make(
            get: fn ($startAt) => $startAt ? Carbon::createFromFormat('Y-m-d H:i:s', $startAt)->format($date_time_format) : null,
            set: fn ($startAt) => $startAt ? Carbon::createFromFormat($date_time_format, $startAt)->format('Y-m-d H:i:s') : null,
        );
    }
    protected function finishAt(): Attribute
    {
        $date_time_format = Variable::where('variable','date_time_format')->first()->settings()->where('customer_id', Auth::user()->customer->id)->first()->value;
        return Attribute::make(
            get: fn ($finishAt) => $finishAt ? Carbon::createFromFormat('Y-m-d H:i:s', $finishAt)->format($date_time_format) : null,
            set: fn ($finishAt) => $finishAt ? Carbon::createFromFormat($date_time_format, $finishAt)->format('Y-m-d H:i:s') : null,
        );
    }
    public function questions()
    {
        return $this->hasMany(Question::class, 'survey_id', 'id');
    }
}
