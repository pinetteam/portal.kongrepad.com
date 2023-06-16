<?php

namespace App\Models\Meeting\Survey\Question\Option;

use App\Models\Meeting\Survey\Question\Question;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Option extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'meeting_survey_question_options';
    protected $fillable = [
        'sort_order',
        'question_id',
        'title',
        'status',
        'created_by',
        'edited_by',
        'deleted_by',
    ];
    protected $dates = [
        'deleted_at',
    ];
    protected $casts = [
        'deleted_at' => 'datetime',
    ];
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }
}
