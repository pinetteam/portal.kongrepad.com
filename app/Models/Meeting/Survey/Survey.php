<?php

namespace App\Models\Meeting\Survey;

use App\Models\Customer\Setting\Variable\Variable;
use App\Models\Meeting\Meeting;
use App\Models\Meeting\Survey\Question\Question;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Survey extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'meeting_surveys';
    protected $fillable = [
        'sort_order',
        'meeting_id',
        'code',
        'title',
        'description',
        'on_air',
        'status',
        'start_at',
        'finish_at',
        'created_by',
        'edited_by',
        'deleted_by',
    ];
    protected $dates = [
        'start_at',
        'finish_at',
        'deleted_at',
    ];
    protected $casts = [
        'start_at' => 'datetime',
        'finish_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    protected function finishAt(): Attribute
    {
        return Attribute::make(
            get: fn ($startAt) => $startAt ? Carbon::createFromFormat('Y-m-d H:i:s', $startAt)->format(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value.' '.Variable::where('variable','time_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value) : null,
            set: fn ($startAt) => $startAt ? Carbon::createFromFormat('d/m/Y H:i', $startAt)->format('Y-m-d H:i:s') : null,
        );
    }
    protected function startAt(): Attribute
    {
        return Attribute::make(
            get: fn ($finishAt) => $finishAt ? Carbon::createFromFormat('Y-m-d H:i:s', $finishAt)->format(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value.' '.Variable::where('variable','time_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value) : null,
            set: fn ($finishAt) => $finishAt ? Carbon::createFromFormat('d/m/Y H:i', $finishAt)->format('Y-m-d H:i:s') : null,
        );
    }
    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'survey_id', 'id');
    }
}
