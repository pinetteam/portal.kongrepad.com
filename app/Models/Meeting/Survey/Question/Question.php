<?php

namespace App\Models\Meeting\Survey\Question;

use App\Models\Meeting\Survey\Question\Option\Option;
use App\Models\Meeting\Survey\Survey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_survey_questions';
    protected $fillable = [
        'sort_order',
        'survey_id',
        'question',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
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
    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id', 'id');
    }
    public function options()
    {
        return $this->hasMany(Option::class, 'question_id', 'id');
    }
}
