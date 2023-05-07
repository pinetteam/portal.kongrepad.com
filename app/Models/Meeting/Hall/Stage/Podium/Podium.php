<?php

namespace App\Models\Meeting\Hall\Stage\Podium;

use App\Models\Meeting\Hall\Stage\Stage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Podium extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'podiums';
    protected $fillable = [
        'stage_id',
        'title',
        'status',
        'deleted_by',
    ];
    protected $dates = [
        'deleted_at',
    ];
    protected $casts = [
        'deleted_at' => 'datetime',
    ];
    public function stage()
    {
        return $this->belongsTo(Stage::class, 'meeting_hall_id', 'id');
    }
}
