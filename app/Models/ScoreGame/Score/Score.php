<?php

namespace App\Models\ScoreGame\Score;

use App\Models\ScoreGame\ScoreGame;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Score extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'scores';
    protected $fillable = [
        'meeting_id',
        'score',
        'status',
        'deleted_by',
    ];
    protected $dates = [
        'deleted_at',
    ];
    protected $casts = [
        'deleted_at' => 'datetime',
    ];
    public function score_game()
    {
        return $this->belongsTo(ScoreGame::class, 'score_game_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
