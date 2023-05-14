<?php

namespace App\Models\Meeting\Hall\Program\Session;

use App\Models\Customer\Setting\Variable\Variable;
use App\Models\Meeting\Document\Document;
use App\Models\Meeting\Hall\Program\Session\Keypad\Keypad;
use App\Models\Meeting\Participant\Participant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ProgramSession extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'meeting_hall_program_sessions';
    protected $fillable = [
        'program_id',
        'speaker_id',
        'document_id',
        'document_sharing_via_email',
        'sort_order',
        'code',
        'title',
        'description',
        'start_at',
        'finish_at',
        'questions',
        'question_limit',
        'status',
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
    protected function startAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $startAt) => Carbon::createFromFormat('Y-m-d H:i:s', $startAt)->format(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value.' '.Variable::where('variable','time_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value),
            set: fn (string $startAt) => Carbon::createFromFormat('d/m/Y H:i', $startAt)->format('Y-m-d H:i:s'),
        );
    }
    protected function finishAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $finishAt) => Carbon::createFromFormat('Y-m-d H:i:s', $finishAt)->format(Variable::where('variable','date_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value.' '.Variable::where('variable','time_format')->first()->settings()->where('customer_id',Auth::user()->customer->id)->first()->value),
            set: fn (string $finishAt) => Carbon::createFromFormat('d/m/Y H:i', $finishAt)->format('Y-m-d H:i:s'),
        );
    }
    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id', 'id');
    }
    public function speaker()
    {
        return $this->belongsTo(Participant::class, 'speaker_id', 'id');
    }
    public function keypads()
    {
        return $this->hasMany(Keypad::class,'session_id','id');
    }
}
