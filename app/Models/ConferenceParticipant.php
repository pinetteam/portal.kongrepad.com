<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ConferenceParticipant extends Authenticatable
{
    use HasFactory, HasUuids, SoftDeletes, Notifiable, HasApiTokens;

    protected $fillable = [
        'conference_id',
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'phone',
        'organization',
        'job_title',
        'bio',
        'avatar_path',
        'country_code',
        'language',
        'type',
        'status',
        'is_active',
        'approved_at',
        'approved_by',
        'last_seen_at',
        'last_ip_address',
        'user_agent',
        'permissions',
        'settings',
        'metadata',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'approved_at' => 'datetime',
            'last_seen_at' => 'datetime',
            'is_active' => 'boolean',
            'permissions' => 'array',
            'settings' => 'array',
            'metadata' => 'array',
        ];
    }

    /**
     * Relationships
     */
    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function country()
    {
        return $this->belongsTo(SystemCountry::class, 'country_code', 'code');
    }

    public function sessionSpeakers()
    {
        return $this->hasMany(ConferenceSessionSpeaker::class, 'participant_id');
    }

    public function questions()
    {
        return $this->hasMany(ConferenceQuestion::class, 'participant_id');
    }

    public function pollVotes()
    {
        return $this->hasMany(ConferencePollVote::class, 'participant_id');
    }

    public function surveyResponses()
    {
        return $this->hasMany(ConferenceSurveyResponse::class, 'participant_id');
    }

    public function documentNotifications()
    {
        return $this->hasMany(ConferenceDocumentNotification::class, 'participant_id');
    }

    public function logs()
    {
        return $this->hasMany(ConferenceParticipantLog::class, 'participant_id');
    }

    public function dailyAccesses()
    {
        return $this->hasMany(ConferenceParticipantDailyAccess::class, 'participant_id');
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeRecentlyActive($query, $minutes = 30)
    {
        return $query->where('last_seen_at', '>=', now()->subMinutes($minutes));
    }

    public function scopeByConference($query, $conferenceId)
    {
        return $query->where('conference_id', $conferenceId);
    }

    /**
     * Sanctum Token Abilities
     */
    public function getDefaultTokenAbilities(): array
    {
        return [
            'participant:read',
            'participant:update-profile',
            'session:read',
            'session:join',
            'question:create',
            'poll:vote',
            'survey:respond',
            'document:download',
        ];
    }

    /**
     * Get token abilities based on participant type
     */
    public function getTokenAbilitiesForType(): array
    {
        $abilities = $this->getDefaultTokenAbilities();

        switch ($this->type) {
            case 'speaker':
                $abilities = array_merge($abilities, [
                    'session:manage-own',
                    'session:start-presentation',
                    'question:moderate-own',
                ]);
                break;
            case 'moderator':
                $abilities = array_merge($abilities, [
                    'session:moderate',
                    'question:moderate',
                    'poll:manage',
                    'participant:manage-session',
                ]);
                break;
            case 'organizer':
                $abilities = array_merge($abilities, [
                    'conference:read',
                    'session:manage',
                    'participant:manage',
                    'document:manage',
                    'notification:send',
                ]);
                break;
        }

        return $abilities;
    }

    /**
     * Create API token with appropriate abilities
     */
    public function createApiToken(string $name = 'participant-token'): string
    {
        return $this->createToken($name, $this->getTokenAbilitiesForType())->plainTextToken;
    }

    /**
     * Check if participant has specific permission
     */
    public function hasPermission(string $permission): bool
    {
        $permissions = $this->permissions ?? [];
        return in_array($permission, $permissions);
    }

    /**
     * Update last seen timestamp
     */
    public function updateLastSeen(?string $ipAddress = null, ?string $userAgent = null): void
    {
        $this->update([
            'last_seen_at' => now(),
            'last_ip_address' => $ipAddress ?? request()->ip(),
            'user_agent' => $userAgent ?? request()->userAgent(),
        ]);
    }

    /**
     * Check if participant is approved and active
     */
    public function canParticipate(): bool
    {
        return $this->is_active && $this->status === 'approved';
    }

    /**
     * Get full name
     */
    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    /**
     * Get display name with title if available
     */
    public function getDisplayNameAttribute(): string
    {
        $name = $this->full_name;
        
        if ($this->job_title) {
            $name .= ' (' . $this->job_title . ')';
        }
        
        return $name;
    }
} 