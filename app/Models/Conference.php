<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conference extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'title',
        'description',
        'slug',
        'status',
        'type',
        'start_date',
        'end_date',
        'timezone',
        'language',
        'is_public',
        'is_featured',
        'require_approval',
        'max_participants',
        'participants_count',
        'sessions_count',
        'active_sessions_count',
        'last_activity_at',
        'cover_image_path',
        'logo_path',
        'organizers',
        'sponsors',
        'social_links',
        'contact_info',
        'features',
        'branding',
        'settings',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'last_activity_at' => 'datetime',
            'is_public' => 'boolean',
            'is_featured' => 'boolean',
            'require_approval' => 'boolean',
            'max_participants' => 'integer',
            'participants_count' => 'integer',
            'sessions_count' => 'integer',
            'active_sessions_count' => 'integer',
            'organizers' => 'array',
            'sponsors' => 'array',
            'social_links' => 'array',
            'contact_info' => 'array',
            'features' => 'array',
            'branding' => 'array',
            'settings' => 'array',
            'metadata' => 'array',
        ];
    }

    /**
     * Relationships
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function participants()
    {
        return $this->hasMany(ConferenceParticipant::class);
    }

    public function sessions()
    {
        return $this->hasMany(ConferenceSession::class);
    }

    public function venues()
    {
        return $this->hasMany(ConferenceVenue::class);
    }

    public function programs()
    {
        return $this->hasMany(ConferenceProgram::class);
    }

    public function questions()
    {
        return $this->hasMany(ConferenceQuestion::class);
    }

    public function polls()
    {
        return $this->hasMany(ConferencePoll::class);
    }

    public function surveys()
    {
        return $this->hasMany(ConferenceSurvey::class);
    }

    public function documents()
    {
        return $this->hasMany(ConferenceDocument::class);
    }

    public function notifications()
    {
        return $this->hasMany(ConferenceNotification::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now());
    }

    public function scopeOngoing($query)
    {
        return $query->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
    }

    public function scopeByTenant($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    /**
     * Helper methods
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isOngoing(): bool
    {
        $now = now();
        return $this->start_date <= $now && $this->end_date >= $now;
    }

    public function isUpcoming(): bool
    {
        return $this->start_date > now();
    }

    public function hasEnded(): bool
    {
        return $this->end_date < now();
    }

    public function hasCapacityReached(): bool
    {
        return $this->max_participants && $this->participants_count >= $this->max_participants;
    }

    public function canAcceptParticipants(): bool
    {
        return $this->isActive() && 
               !$this->hasEnded() && 
               !$this->hasCapacityReached();
    }

    /**
     * Get conference URL
     */
    public function getUrlAttribute(): string
    {
        return url("/conferences/{$this->slug}");
    }

    /**
     * Get formatted date range
     */
    public function getDateRangeAttribute(): string
    {
        if ($this->start_date->isSameDay($this->end_date)) {
            return $this->start_date->format('F j, Y');
        }
        
        return $this->start_date->format('F j') . ' - ' . $this->end_date->format('j, Y');
    }

    /**
     * Update activity timestamp
     */
    public function updateActivity(): void
    {
        $this->update(['last_activity_at' => now()]);
    }

    /**
     * Increment participants count
     */
    public function incrementParticipants(): void
    {
        $this->increment('participants_count');
        $this->updateActivity();
    }

    /**
     * Decrement participants count
     */
    public function decrementParticipants(): void
    {
        $this->decrement('participants_count');
        $this->updateActivity();
    }
} 