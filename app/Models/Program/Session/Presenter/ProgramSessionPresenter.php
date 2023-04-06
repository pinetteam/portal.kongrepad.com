<?php

namespace App\Models\Program\Session\Presenter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramSessionPresenter extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'program_session_presenters';
    protected $fillable = [
        'program_session_id',
        'presenter_id',
        'status',
        'deleted_by',
    ];
    protected $dates = [
        'deleted_at',
    ];
    protected $casts = [
        'deleted_at' => 'datetime',
    ];
}
