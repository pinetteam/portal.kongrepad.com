<?php

namespace App\Models\Document;

use App\Models\Meeting\Meeting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'documents';
    protected $fillable = [
        'meeting_id',
        'file_name',
        'file_extension',
        'title',
        'sharing_via_email',
        'type',
        'status',
        'deleted_by',
    ];
    protected $dates = [
        'deleted_at',
    ];
    protected $casts = [
        'deleted_at' => 'datetime',
        'sharing_via_email' => 'boolean',
        'status' => 'boolean',
    ];
    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }
}
