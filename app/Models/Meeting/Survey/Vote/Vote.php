<?php

namespace App\Models\Meeting\Survey\Vote;

use App\Models\Meeting\Survey\Question\Option\Option;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $table = 'meeting_survey_votes';
    protected $fillable = [
        'survey_id',
        'question_id',
        'option_id',
        'participant_id',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function option()
    {
        return $this->belongsTo(Option::class, 'option_id', 'id');
    }
}

