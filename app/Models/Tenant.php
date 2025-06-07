<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'domain',
        'email',
        'phone',
        'description',
        'logo_path',
        'favicon_path',
        'status',
        'plan_type',
        'max_conferences',
        'max_participants',
        'trial_ends_at',
        'subscription_expires_at',
        'is_active',
        'conferences_count',
        'last_activity_at',
        'settings',
        'features',
        'branding',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'trial_ends_at' => 'datetime',
            'subscription_expires_at' => 'datetime',
            'last_activity_at' => 'datetime',
            'is_active' => 'boolean',
            'max_conferences' => 'integer',
            'max_participants' => 'integer',
            'conferences_count' => 'integer',
            'settings' => 'array',
            'features' => 'array',
            'branding' => 'array',
            'metadata' => 'array',
        ];
    }

    /**
     * Relationships
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function conferences()
    {
        return $this->hasMany(Conference::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
} 