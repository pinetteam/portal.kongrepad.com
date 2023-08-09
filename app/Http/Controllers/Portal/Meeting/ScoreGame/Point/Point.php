<?php

namespace App\Models\Meeting\ScoreGame\Point\Point;

use App\Models\Meeting\Participant\Participant;
use App\Models\Meeting\ScoreGame\QrCode\QrCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Point extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_score_game_points';
    protected $fillable = [
        'participant_id',
        'qr_code_id',
        'score',
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
    public function qrCode()
    {
        return $this->belongsTo(QrCode::class, 'qr_code_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo(Participant::class, 'participant_id', 'id');
    }
}
