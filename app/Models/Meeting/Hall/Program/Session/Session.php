<?php

namespace App\Models\Meeting\Hall\Program\Session;

use App\Models\Meeting\Document\Document;
use App\Models\Meeting\Hall\Program\Program;
use App\Models\Meeting\Hall\Program\Session\Keypad\Keypad;
use App\Models\Meeting\Hall\Program\Session\Question\Question;
use App\Models\Meeting\Participant\Participant;
use App\Models\System\Setting\Variable\Variable;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Session extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_hall_program_sessions';
    protected $fillable = [
        'sort_order',
        'program_id',
        'speaker_id',
        'document_id',
        'code',
        'title',
        'description',
        'start_at',
        'finish_at',
        'on_air',
        'questions_allowed',
        'questions_limit',
        'questions_auto_start',
        'is_questions_started',
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
        $date_time_format = Variable::where('variable','date_time_format')->first()->settings()->where('customer_id', Auth::user()->customer->id ?? User::first()->id)->first()->value;
        return Attribute::make(
            get: fn (string $startAt) => Carbon::createFromFormat('Y-m-d H:i:s', $startAt)->format($date_time_format),
            set: fn (string $startAt) => Carbon::createFromFormat($date_time_format, $startAt)->format('Y-m-d H:i:s'),
        );
    }
    protected function finishAt(): Attribute
    {
        $date_time_format = Variable::where('variable','date_time_format')->first()->settings()->where('customer_id', Auth::user()->customer->id ?? User::first()->id)->first()->value;
        return Attribute::make(
            get: fn (string $finishAt) => Carbon::createFromFormat('Y-m-d H:i:s', $finishAt)->format($date_time_format),
            set: fn (string $finishAt) => Carbon::createFromFormat($date_time_format, $finishAt)->format('Y-m-d H:i:s'),
        );
    }
    public function getCreatedByNameAttribute()
    {
        return isset($this->created_by) ? User::findOrFail($this->created_by)->full_name : __('common.unspecified');
    }
    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id', 'id');
    }
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }
    public function keypads()
    {
        return $this->hasMany(Keypad::class,'session_id','id');
    }
    public function questions()
    {
        return $this->hasMany(Question::class,'session_id','id');
    }
    public function speaker()
    {
        return $this->belongsTo(Participant::class, 'speaker_id', 'id');
    }
}
