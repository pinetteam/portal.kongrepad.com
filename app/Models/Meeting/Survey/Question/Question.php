<?php

namespace App\Models\Meeting\Survey\Question;

use App\Models\Meeting\Survey\Question\Option\Option;
use App\Models\Meeting\Survey\Survey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'meeting_survey_questions';
    protected $fillable = [
        'sort_order',
        'survey_id',
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
    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id', 'id');
    }

    public function options()
    {
        return $this->hasMany(Option::class, 'question_id', 'id');
    }
}
