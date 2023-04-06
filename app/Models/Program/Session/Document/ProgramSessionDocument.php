<?php

namespace App\Models\Program\Session\Document;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramSessionDocument extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'program_session_documents';
    protected $fillable = [
        'program_session_id',
        'document_id',
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
