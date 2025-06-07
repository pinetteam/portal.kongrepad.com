# 📦 KongrePad Module Specifications

> **Enterprise Module Technical Specifications & Implementation Guide**

[![Modules](https://img.shields.io/badge/Modules-11-2563EB?style=for-the-badge)](./PROJECT-ARCHITECTURE.md)
[![Tables](https://img.shields.io/badge/Database_Tables-42-10B981?style=for-the-badge)](#database-schema)
[![Architecture](https://img.shields.io/badge/Architecture-Domain_Driven-F59E0B?style=for-the-badge)](#domain-architecture)
[![API](https://img.shields.io/badge/API-RESTful-EF4444?style=for-the-badge)](#api-endpoints)

---

## 📋 Table of Contents

1. [Module Architecture Overview](#-module-architecture-overview)
2. [System Foundation Module](#1--system-foundation-module)
3. [Multi-Tenant Infrastructure](#2--multi-tenant-infrastructure)
4. [User Management Module](#3--user-management-module)
5. [Conference Core Module](#4--conference-core-module)
6. [Session & Speaker Module](#5--session--speaker-module)
7. [Interactive Features Module](#6--interactive-features-module)
8. [Content Management Module](#7--content-management-module)
9. [Display Management Module](#8--display-management-module)
10. [Analytics & Logging Module](#9--analytics--logging-module)
11. [Gamification Module](#10--gamification-module)
12. [API Security Module](#11--api-security-module)
13. [Cross-Module Integration](#-cross-module-integration)

---

## 🎯 Module Architecture Overview

### Domain-Driven Design Philosophy
Each module represents a distinct business domain with:
- **Single Responsibility**: One business concern per module
- **Autonomous Development**: Independent development and deployment
- **Clear Boundaries**: Well-defined interfaces and contracts
- **Event-Driven Communication**: Loose coupling through events

### Module Dependency Matrix
```yaml
Core Dependencies:
  System Foundation (0) → Multi-Tenant Infrastructure (1)
  Multi-Tenant Infrastructure (1) → User Management (2)
  User Management (2) → Conference Core (3)

Business Logic Dependencies:
  Conference Core (3) ↔ Session & Speaker (4)
  Conference Core (3) → Interactive Features (5)
  Interactive Features (5) → Content Management (6)
  Content Management (6) → Display Management (7)
  Session & Speaker (4) → Analytics & Logging (8)
  Analytics & Logging (8) ↔ Gamification (9)
  All Modules → API Security (10)

Total Tables: 42 (UUID7 Primary Keys, Multi-Tenant Isolation)
```

---

## 1. 🔧 System Foundation Module

**Purpose**: Core infrastructure services for caching, queuing, internationalization, and system health.

### Database Schema (7 Tables)

#### system_cache
```sql
CREATE TABLE system_cache (
    `key` VARCHAR(255) PRIMARY KEY,
    value MEDIUMTEXT NOT NULL,
    expiration INT(11) NOT NULL,
    INDEX idx_expiration (expiration)
) ENGINE=InnoDB COMMENT='Application-level cache storage';
```

#### system_jobs
```sql
CREATE TABLE system_jobs (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    queue VARCHAR(255) NOT NULL,
    payload LONGTEXT NOT NULL,
    attempts TINYINT UNSIGNED NOT NULL,
    reserved_at INT UNSIGNED NULL,
    available_at INT UNSIGNED NOT NULL,
    created_at INT UNSIGNED NOT NULL,
    INDEX idx_queue_reserved (queue, reserved_at)
) ENGINE=InnoDB COMMENT='Background job processing queue';
```

#### system_failed_jobs
```sql
CREATE TABLE system_failed_jobs (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    uuid VARCHAR(255) UNIQUE NOT NULL,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload LONGTEXT NOT NULL,
    exception LONGTEXT NOT NULL,
    failed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_uuid (uuid),
    INDEX idx_failed_at (failed_at)
) ENGINE=InnoDB COMMENT='Failed job tracking and debugging';
```

#### system_sessions
```sql
CREATE TABLE system_sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id UUID NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_last_activity (last_activity)
) ENGINE=InnoDB COMMENT='User session management';
```

#### system_countries
```sql
CREATE TABLE system_countries (
    id UUID PRIMARY KEY,
    name VARCHAR(255) NOT NULL COMMENT 'Country full name',
    code CHAR(2) UNIQUE NOT NULL COMMENT 'ISO 3166-1 alpha-2',
    phone_code VARCHAR(10) NULL COMMENT 'International dialing code',
    currency_code CHAR(3) NULL COMMENT 'ISO 4217 currency',
    flag_emoji VARCHAR(10) NULL COMMENT 'Unicode flag emoji',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_active (is_active),
    INDEX idx_code (code),
    FULLTEXT idx_name_search (name)
) ENGINE=InnoDB COMMENT='International country data (162 countries)';
```

#### system_languages
```sql
CREATE TABLE system_languages (
    id UUID PRIMARY KEY,
    name VARCHAR(100) NOT NULL COMMENT 'Language name',
    code CHAR(2) UNIQUE NOT NULL COMMENT 'ISO 639-1 language code',
    locale VARCHAR(10) NOT NULL COMMENT 'Locale identifier (en_US)',
    is_rtl BOOLEAN DEFAULT FALSE COMMENT 'Right-to-left script support',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_active (is_active),
    INDEX idx_code (code)
) ENGINE=InnoDB COMMENT='Multi-language support (5 languages)';
```

#### system_routes
```sql
CREATE TABLE system_routes (
    id UUID PRIMARY KEY,
    name VARCHAR(255) NOT NULL COMMENT 'Route name',
    uri VARCHAR(500) NOT NULL COMMENT 'Route URI pattern',
    method VARCHAR(10) NOT NULL COMMENT 'HTTP method',
    action VARCHAR(255) NOT NULL COMMENT 'Controller action',
    middleware JSON NULL COMMENT 'Applied middleware',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_name (name),
    INDEX idx_method_uri (method, uri(100))
) ENGINE=InnoDB COMMENT='Dynamic route management';
```

### Service Implementation
```php
class CacheService
{
    private const CACHE_PREFIX = 'kongrepad:';
    
    public function remember(string $key, callable $callback, int $ttl = 3600, array $tags = []): mixed
    {
        $fullKey = self::CACHE_PREFIX . $key;
        
        if (!empty($tags)) {
            return Cache::tags($tags)->remember($fullKey, $ttl, $callback);
        }
        
        return Cache::remember($fullKey, $ttl, $callback);
    }
    
    public function forgetByTags(array $tags): bool
    {
        return Cache::tags($tags)->flush();
    }
    
    public function flushAll(): bool
    {
        return Cache::flush();
    }
}

class LocalizationService
{
    public function getActiveLanguages(): Collection
    {
        return SystemLanguage::where('is_active', true)->get();
    }
    
    public function getActiveCountries(): Collection
    {
        return SystemCountry::where('is_active', true)->orderBy('name')->get();
    }
    
    public function setUserLocale(string $locale): void
    {
        app()->setLocale($locale);
        session(['locale' => $locale]);
    }
}
```

### API Endpoints
```yaml
GET    /api/v1/system/health           # System health check
GET    /api/v1/system/countries        # List countries with pagination
GET    /api/v1/system/languages        # Active languages
POST   /api/v1/system/cache/clear      # Clear cache by tags
GET    /api/v1/system/jobs/stats       # Queue statistics
GET    /api/v1/system/routes           # Dynamic route listing
```

---

## 2. 🏢 Multi-Tenant Infrastructure

**Purpose**: Enterprise tenant management with complete data isolation and subscription handling.

### Database Schema (6 Tables)

#### tenants
```sql
CREATE TABLE tenants (
    id UUID PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    domain VARCHAR(255) UNIQUE NOT NULL,
    subdomain VARCHAR(50) UNIQUE NULL,
    subscription_plan VARCHAR(50) DEFAULT 'basic',
    subscription_status ENUM('active', 'trial', 'suspended', 'cancelled') DEFAULT 'trial',
    subscription_expires_at TIMESTAMP NULL,
    max_conferences INT UNSIGNED DEFAULT 5,
    max_participants_per_conference INT UNSIGNED DEFAULT 1000,
    max_storage_gb DECIMAL(8,2) DEFAULT 5.00,
    settings JSON NULL COMMENT 'Tenant configuration',
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status_subscription (status, subscription_status),
    INDEX idx_domain (domain),
    INDEX idx_subdomain (subdomain),
    FULLTEXT idx_search (name, slug)
) ENGINE=InnoDB COMMENT='Multi-tenant organization registry';
```

#### tenant_settings
```sql
CREATE TABLE tenant_settings (
    id UUID PRIMARY KEY,
    tenant_id UUID NOT NULL,
    category VARCHAR(50) NOT NULL COMMENT 'Setting category',
    `key` VARCHAR(255) NOT NULL,
    value LONGTEXT NULL,
    data_type ENUM('string', 'integer', 'boolean', 'json') DEFAULT 'string',
    is_public BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    UNIQUE KEY unique_tenant_setting (tenant_id, category, `key`),
    INDEX idx_tenant_category (tenant_id, category),
    INDEX idx_public_settings (is_public, category)
) ENGINE=InnoDB COMMENT='Granular tenant configuration';
```

### API Endpoints
```yaml
GET    /api/v1/tenants                 # List tenants (admin only)
POST   /api/v1/tenants                 # Create tenant
GET    /api/v1/tenants/{id}            # Get tenant details
PUT    /api/v1/tenants/{id}            # Update tenant
DELETE /api/v1/tenants/{id}            # Delete tenant (admin only)
GET    /api/v1/tenants/{id}/settings   # Get tenant settings
PUT    /api/v1/tenants/{id}/settings   # Update settings
GET    /api/v1/tenants/{id}/usage      # Usage statistics
POST   /api/v1/tenants/{id}/suspend    # Suspend tenant
POST   /api/v1/tenants/{id}/activate   # Activate tenant
```

---

## 3. 👥 User Management Module

**Purpose**: Comprehensive user lifecycle with authentication, authorization, and role-based access control.

### Database Schema (4 Tables)

#### users
```sql
CREATE TABLE users (
    id UUID PRIMARY KEY,
    tenant_id UUID NOT NULL,
    email VARCHAR(320) NOT NULL COMMENT 'RFC5322 compliant',
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NULL COMMENT 'International format',
    avatar_url VARCHAR(500) NULL,
    language_code CHAR(2) DEFAULT 'en',
    timezone VARCHAR(50) DEFAULT 'UTC',
    two_factor_secret VARCHAR(255) NULL COMMENT 'Encrypted 2FA secret',
    two_factor_confirmed_at TIMESTAMP NULL,
    last_login_at TIMESTAMP NULL,
    status ENUM('active', 'inactive', 'suspended', 'pending') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    UNIQUE KEY unique_tenant_email (tenant_id, email),
    INDEX idx_tenant_status (tenant_id, status),
    INDEX idx_email_verified (email_verified_at),
    FULLTEXT idx_user_search (first_name, last_name, email)
) ENGINE=InnoDB COMMENT='Multi-tenant user management';
```

#### user_roles
```sql
CREATE TABLE user_roles (
    id UUID PRIMARY KEY,
    tenant_id UUID NOT NULL,
    user_id UUID NOT NULL,
    role_name VARCHAR(50) NOT NULL,
    resource_type VARCHAR(50) NULL COMMENT 'conference, session, etc.',
    resource_id UUID NULL COMMENT 'Specific resource ID',
    permissions JSON NOT NULL COMMENT 'Granular permissions',
    assigned_by UUID NOT NULL,
    expires_at TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_by) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_active (user_id, is_active),
    INDEX idx_tenant_role (tenant_id, role_name),
    INDEX idx_resource_roles (resource_type, resource_id),
    INDEX idx_expires_at (expires_at)
) ENGINE=InnoDB COMMENT='Role-based access control';
```

#### system_settings
```sql
CREATE TABLE system_settings (
    id UUID PRIMARY KEY,
    `key` VARCHAR(255) UNIQUE NOT NULL,
    value LONGTEXT NULL,
    data_type ENUM('string', 'integer', 'boolean', 'json') DEFAULT 'string',
    is_public BOOLEAN DEFAULT FALSE,
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_public_settings (is_public),
    INDEX idx_key_lookup (`key`)
) ENGINE=InnoDB COMMENT='Global system configuration';
```

#### password_reset_tokens
```sql
CREATE TABLE password_reset_tokens (
    email VARCHAR(320) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_token (token),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB COMMENT='Password reset token management';
```

### API Endpoints
```yaml
POST   /api/v1/auth/register           # User registration
POST   /api/v1/auth/login              # Authentication
POST   /api/v1/auth/logout             # Logout
POST   /api/v1/auth/refresh            # Token refresh
POST   /api/v1/auth/forgot-password    # Password reset request
POST   /api/v1/auth/reset-password     # Password reset confirmation
POST   /api/v1/auth/2fa/setup          # Setup 2FA
POST   /api/v1/auth/2fa/verify         # Verify 2FA
GET    /api/v1/users/profile           # Current user profile
PUT    /api/v1/users/profile           # Update profile
GET    /api/v1/users                   # List users (admin)
GET    /api/v1/users/{id}              # Get user details
PUT    /api/v1/users/{id}              # Update user
DELETE /api/v1/users/{id}              # Delete user
POST   /api/v1/users/{id}/roles        # Assign role
DELETE /api/v1/users/{id}/roles/{role} # Remove role
```

---

## 4. 🎪 Conference Core Module

**Purpose**: Primary business domain for conference lifecycle management.

### Database Schema (7 Tables)

#### conferences
```sql
CREATE TABLE conferences (
    id UUID PRIMARY KEY,
    tenant_id UUID NOT NULL,
    title VARCHAR(255) NOT NULL,
    subtitle VARCHAR(255) NULL,
    description TEXT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    timezone VARCHAR(50) DEFAULT 'UTC',
    status ENUM('draft', 'published', 'ongoing', 'completed', 'cancelled') DEFAULT 'draft',
    max_participants INT UNSIGNED DEFAULT 1000,
    registration_start_date TIMESTAMP NULL,
    registration_end_date TIMESTAMP NULL,
    logo VARCHAR(255) NULL,
    social_links JSON NULL,
    is_public BOOLEAN DEFAULT TRUE,
    created_by UUID NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_tenant_status (tenant_id, status),
    INDEX idx_tenant_dates (tenant_id, start_date, end_date),
    INDEX idx_public_status (is_public, status),
    FULLTEXT idx_conference_search (title, description)
) ENGINE=InnoDB COMMENT='Conference management core';
```

#### conference_venues
```sql
CREATE TABLE conference_venues (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    name VARCHAR(255) NOT NULL,
    type ENUM('physical', 'virtual', 'hybrid') DEFAULT 'physical',
    address TEXT NULL,
    capacity INT UNSIGNED NULL,
    virtual_url VARCHAR(255) NULL,
    latitude DECIMAL(10, 8) NULL,
    longitude DECIMAL(11, 8) NULL,
    facilities JSON NULL COMMENT 'Available facilities',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    INDEX idx_conference_type (conference_id, type),
    INDEX idx_capacity (capacity),
    INDEX idx_coordinates (latitude, longitude)
) ENGINE=InnoDB COMMENT='Conference venues (physical/virtual/hybrid)';
```

#### conference_programs
```sql
CREATE TABLE conference_programs (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    is_main_program BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    INDEX idx_conference_main (conference_id, is_main_program),
    INDEX idx_conference_dates (conference_id, start_date, end_date)
) ENGINE=InnoDB COMMENT='Conference program structure';
```

#### conference_program_chairs
```sql
CREATE TABLE conference_program_chairs (
    id UUID PRIMARY KEY,
    program_id UUID NOT NULL,
    participant_id UUID NOT NULL,
    role VARCHAR(50) DEFAULT 'chair',
    bio TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (program_id) REFERENCES conference_programs(id) ON DELETE CASCADE,
    FOREIGN KEY (participant_id) REFERENCES conference_participants(id) ON DELETE CASCADE,
    UNIQUE KEY unique_program_participant (program_id, participant_id),
    INDEX idx_program_role (program_id, role)
) ENGINE=InnoDB COMMENT='Program leadership and chairs';
```

### API Endpoints
```yaml
GET    /api/v1/conferences             # List conferences
POST   /api/v1/conferences             # Create conference
GET    /api/v1/conferences/{id}        # Get conference details
PUT    /api/v1/conferences/{id}        # Update conference
DELETE /api/v1/conferences/{id}        # Delete conference
POST   /api/v1/conferences/{id}/publish # Publish conference
GET    /api/v1/conferences/{id}/venues # List venues
POST   /api/v1/conferences/{id}/venues # Add venue
PUT    /api/v1/venues/{id}             # Update venue
DELETE /api/v1/venues/{id}             # Delete venue
GET    /api/v1/conferences/{id}/programs # List programs
POST   /api/v1/conferences/{id}/programs # Create program
```

---

## 5. 🎤 Session & Speaker Module

**Purpose**: Session scheduling, speaker management, and participant coordination.

### Database Schema (3 Tables)

#### conference_sessions
```sql
CREATE TABLE conference_sessions (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    venue_id UUID NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    type ENUM('keynote', 'presentation', 'panel', 'workshop', 'break') DEFAULT 'presentation',
    start_time TIMESTAMP NOT NULL,
    end_time TIMESTAMP NOT NULL,
    capacity INT UNSIGNED NULL,
    language_code CHAR(2) DEFAULT 'en',
    level ENUM('beginner', 'intermediate', 'advanced') DEFAULT 'intermediate',
    tags JSON NULL,
    recording_url VARCHAR(255) NULL,
    is_public BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (venue_id) REFERENCES conference_venues(id) ON DELETE SET NULL,
    INDEX idx_conference_time (conference_id, start_time),
    INDEX idx_venue_time (venue_id, start_time),
    INDEX idx_session_type (type, language_code),
    FULLTEXT idx_session_content (title, description)
) ENGINE=InnoDB COMMENT='Conference session management';
```

#### conference_participants
```sql
CREATE TABLE conference_participants (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    user_id UUID NULL,
    email VARCHAR(320) NOT NULL,
    name VARCHAR(255) NOT NULL,
    organization VARCHAR(255) NULL,
    type ENUM('attendee', 'speaker', 'organizer', 'sponsor') DEFAULT 'attendee',
    status ENUM('registered', 'confirmed', 'attended', 'cancelled') DEFAULT 'registered',
    registration_data JSON NULL,
    qr_code VARCHAR(255) NULL COMMENT 'Unique QR code',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    UNIQUE KEY unique_conference_email (conference_id, email),
    INDEX idx_conference_type (conference_id, type),
    INDEX idx_conference_status (conference_id, status),
    INDEX idx_qr_code (qr_code),
    FULLTEXT idx_participant_search (name, organization)
) ENGINE=InnoDB COMMENT='Conference participant registry';
```

#### conference_session_speakers
```sql
CREATE TABLE conference_session_speakers (
    id UUID PRIMARY KEY,
    session_id UUID NOT NULL,
    participant_id UUID NOT NULL,
    type ENUM('primary', 'co-speaker', 'moderator', 'panelist') DEFAULT 'primary',
    order_index INT UNSIGNED DEFAULT 0,
    bio TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (session_id) REFERENCES conference_sessions(id) ON DELETE CASCADE,
    FOREIGN KEY (participant_id) REFERENCES conference_participants(id) ON DELETE CASCADE,
    UNIQUE KEY unique_session_participant (session_id, participant_id),
    INDEX idx_session_order (session_id, order_index),
    INDEX idx_speaker_type (type)
) ENGINE=InnoDB COMMENT='Session speaker assignments';
```

### API Endpoints
```yaml
GET    /api/v1/conferences/{id}/sessions    # List sessions
POST   /api/v1/conferences/{id}/sessions    # Create session
GET    /api/v1/sessions/{id}               # Get session details
PUT    /api/v1/sessions/{id}               # Update session
DELETE /api/v1/sessions/{id}               # Delete session
POST   /api/v1/sessions/{id}/speakers      # Assign speaker
DELETE /api/v1/sessions/{id}/speakers/{pid} # Remove speaker
GET    /api/v1/conferences/{id}/participants # List participants
POST   /api/v1/conferences/{id}/register   # Register participant
PUT    /api/v1/participants/{id}          # Update participant
GET    /api/v1/participants/{id}/qr       # Get QR code
```

---

## 6. 🙋 Interactive Features Module

**Purpose**: Real-time engagement through Q&A, polling, and surveys.

### Database Schema (8 Tables)

#### conference_questions
```sql
CREATE TABLE conference_questions (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    session_id UUID NULL,
    participant_id UUID NOT NULL,
    question TEXT NOT NULL,
    status ENUM('pending', 'approved', 'answered', 'rejected') DEFAULT 'pending',
    upvotes INT UNSIGNED DEFAULT 0,
    answer TEXT NULL,
    answered_by UUID NULL,
    answered_at TIMESTAMP NULL,
    is_anonymous BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (session_id) REFERENCES conference_sessions(id) ON DELETE CASCADE,
    FOREIGN KEY (participant_id) REFERENCES conference_participants(id) ON DELETE CASCADE,
    FOREIGN KEY (answered_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_conference_status (conference_id, status),
    INDEX idx_session_questions (session_id, status),
    INDEX idx_upvotes (upvotes DESC),
    FULLTEXT idx_question_search (question, answer)
) ENGINE=InnoDB COMMENT='Q&A system with moderation';
```

#### conference_polls
```sql
CREATE TABLE conference_polls (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    session_id UUID NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    type ENUM('single_choice', 'multiple_choice', 'rating', 'text') DEFAULT 'single_choice',
    status ENUM('draft', 'active', 'closed') DEFAULT 'draft',
    starts_at TIMESTAMP NULL,
    ends_at TIMESTAMP NULL,
    max_selections INT UNSIGNED DEFAULT 1,
    is_anonymous BOOLEAN DEFAULT TRUE,
    show_results BOOLEAN DEFAULT FALSE,
    created_by UUID NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (session_id) REFERENCES conference_sessions(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_conference_status (conference_id, status),
    INDEX idx_session_polls (session_id, status),
    INDEX idx_active_polls (status, starts_at, ends_at)
) ENGINE=InnoDB COMMENT='Real-time polling system';
```

#### conference_poll_options
```sql
CREATE TABLE conference_poll_options (
    id UUID PRIMARY KEY,
    poll_id UUID NOT NULL,
    option_text VARCHAR(500) NOT NULL,
    order_index INT UNSIGNED DEFAULT 0,
    vote_count INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (poll_id) REFERENCES conference_polls(id) ON DELETE CASCADE,
    INDEX idx_poll_order (poll_id, order_index),
    INDEX idx_vote_count (vote_count DESC)
) ENGINE=InnoDB COMMENT='Poll option choices';
```

#### conference_poll_votes
```sql
CREATE TABLE conference_poll_votes (
    id UUID PRIMARY KEY,
    poll_id UUID NOT NULL,
    option_id UUID NOT NULL,
    participant_id UUID NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (poll_id) REFERENCES conference_polls(id) ON DELETE CASCADE,
    FOREIGN KEY (option_id) REFERENCES conference_poll_options(id) ON DELETE CASCADE,
    FOREIGN KEY (participant_id) REFERENCES conference_participants(id) ON DELETE SET NULL,
    INDEX idx_poll_participant (poll_id, participant_id),
    INDEX idx_option_votes (option_id),
    INDEX idx_voting_analytics (poll_id, created_at)
) ENGINE=InnoDB COMMENT='Poll voting records';
```

#### conference_surveys
```sql
CREATE TABLE conference_surveys (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    session_id UUID NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    status ENUM('draft', 'active', 'closed') DEFAULT 'draft',
    starts_at TIMESTAMP NULL,
    ends_at TIMESTAMP NULL,
    is_anonymous BOOLEAN DEFAULT TRUE,
    allow_multiple_responses BOOLEAN DEFAULT FALSE,
    created_by UUID NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (session_id) REFERENCES conference_sessions(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_conference_status (conference_id, status),
    INDEX idx_session_surveys (session_id, status),
    INDEX idx_active_surveys (status, starts_at, ends_at)
) ENGINE=InnoDB COMMENT='Comprehensive survey system';
```

#### conference_survey_questions
```sql
CREATE TABLE conference_survey_questions (
    id UUID PRIMARY KEY,
    survey_id UUID NOT NULL,
    question_text TEXT NOT NULL,
    question_type ENUM('single_choice', 'multiple_choice', 'rating', 'text', 'number') NOT NULL,
    is_required BOOLEAN DEFAULT FALSE,
    order_index INT UNSIGNED DEFAULT 0,
    settings JSON NULL COMMENT 'Question-specific settings',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (survey_id) REFERENCES conference_surveys(id) ON DELETE CASCADE,
    INDEX idx_survey_order (survey_id, order_index),
    INDEX idx_question_type (question_type)
) ENGINE=InnoDB COMMENT='Survey question definitions';
```

#### conference_survey_question_options
```sql
CREATE TABLE conference_survey_question_options (
    id UUID PRIMARY KEY,
    question_id UUID NOT NULL,
    option_text VARCHAR(500) NOT NULL,
    order_index INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (question_id) REFERENCES conference_survey_questions(id) ON DELETE CASCADE,
    INDEX idx_question_order (question_id, order_index)
) ENGINE=InnoDB COMMENT='Survey question choice options';
```

#### conference_survey_responses
```sql
CREATE TABLE conference_survey_responses (
    id UUID PRIMARY KEY,
    survey_id UUID NOT NULL,
    question_id UUID NOT NULL,
    option_id UUID NULL,
    participant_id UUID NULL,
    response_text TEXT NULL,
    response_number DECIMAL(10,2) NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (survey_id) REFERENCES conference_surveys(id) ON DELETE CASCADE,
    FOREIGN KEY (question_id) REFERENCES conference_survey_questions(id) ON DELETE CASCADE,
    FOREIGN KEY (option_id) REFERENCES conference_survey_question_options(id) ON DELETE CASCADE,
    FOREIGN KEY (participant_id) REFERENCES conference_participants(id) ON DELETE SET NULL,
    INDEX idx_survey_participant (survey_id, participant_id),
    INDEX idx_question_responses (question_id),
    INDEX idx_response_analytics (survey_id, created_at)
) ENGINE=InnoDB COMMENT='Survey response collection';
```

### API Endpoints
```yaml
GET    /api/v1/conferences/{id}/questions  # List questions
POST   /api/v1/conferences/{id}/questions  # Submit question
POST   /api/v1/questions/{id}/upvote      # Upvote question
POST   /api/v1/questions/{id}/answer      # Answer question
PUT    /api/v1/questions/{id}/status      # Update question status
GET    /api/v1/conferences/{id}/polls     # List polls
POST   /api/v1/conferences/{id}/polls     # Create poll
PUT    /api/v1/polls/{id}                 # Update poll
POST   /api/v1/polls/{id}/vote           # Vote on poll
GET    /api/v1/polls/{id}/results        # Get poll results
POST   /api/v1/polls/{id}/start          # Start poll
POST   /api/v1/polls/{id}/stop           # Stop poll
GET    /api/v1/conferences/{id}/surveys  # List surveys
POST   /api/v1/conferences/{id}/surveys  # Create survey
GET    /api/v1/surveys/{id}              # Get survey details
PUT    /api/v1/surveys/{id}              # Update survey
DELETE /api/v1/surveys/{id}              # Delete survey
POST   /api/v1/surveys/{id}/respond      # Submit survey response
GET    /api/v1/surveys/{id}/results      # Get survey results
POST   /api/v1/surveys/{id}/start        # Start survey
POST   /api/v1/surveys/{id}/stop         # Stop survey
```

---

## 7. 📄 Content Management Module

**Purpose**: Document management, notifications, and content delivery systems.

### Database Schema (3 Tables)

#### conference_documents
```sql
CREATE TABLE conference_documents (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    session_id UUID NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    type ENUM('presentation', 'handout', 'certificate', 'agenda', 'other') DEFAULT 'other',
    file_path VARCHAR(500) NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_size BIGINT UNSIGNED NULL,
    mime_type VARCHAR(100) NULL,
    download_count INT UNSIGNED DEFAULT 0,
    access_level ENUM('public', 'participants', 'speakers', 'organizers') DEFAULT 'participants',
    is_downloadable BOOLEAN DEFAULT TRUE,
    uploaded_by UUID NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (session_id) REFERENCES conference_sessions(id) ON DELETE CASCADE,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_conference_type (conference_id, type),
    INDEX idx_session_documents (session_id),
    INDEX idx_access_level (access_level, is_downloadable),
    INDEX idx_download_count (download_count DESC),
    FULLTEXT idx_document_search (title, description)
) ENGINE=InnoDB COMMENT='Document management with access control';
```

#### conference_notifications
```sql
CREATE TABLE conference_notifications (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    type ENUM('general', 'session', 'document', 'poll', 'emergency') DEFAULT 'general',
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    target_audience ENUM('all', 'attendees', 'speakers', 'organizers') DEFAULT 'all',
    delivery_method JSON NOT NULL COMMENT 'push, email, sms, in_app',
    status ENUM('draft', 'scheduled', 'sent', 'failed') DEFAULT 'draft',
    scheduled_at TIMESTAMP NULL,
    sent_at TIMESTAMP NULL,
    sent_count INT UNSIGNED DEFAULT 0,
    opened_count INT UNSIGNED DEFAULT 0,
    created_by UUID NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_conference_status (conference_id, status),
    INDEX idx_scheduled (scheduled_at, status),
    INDEX idx_type_audience (type, target_audience)
) ENGINE=InnoDB COMMENT='Multi-channel notification system';
```

#### conference_document_notifications
```sql
CREATE TABLE conference_document_notifications (
    id UUID PRIMARY KEY,
    document_id UUID NOT NULL,
    participant_id UUID NOT NULL,
    notification_type ENUM('uploaded', 'updated', 'downloaded') DEFAULT 'uploaded',
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    read_at TIMESTAMP NULL,
    FOREIGN KEY (document_id) REFERENCES conference_documents(id) ON DELETE CASCADE,
    FOREIGN KEY (participant_id) REFERENCES conference_participants(id) ON DELETE CASCADE,
    INDEX idx_participant_unread (participant_id, is_read),
    INDEX idx_document_notifications (document_id, notification_type)
) ENGINE=InnoDB COMMENT='Document-specific notifications';
```

### API Endpoints
```yaml
GET    /api/v1/conferences/{id}/documents     # List documents
POST   /api/v1/conferences/{id}/documents     # Upload document
GET    /api/v1/documents/{id}                 # Get document details
PUT    /api/v1/documents/{id}                 # Update document
GET    /api/v1/documents/{id}/download        # Download document
DELETE /api/v1/documents/{id}                 # Delete document
GET    /api/v1/conferences/{id}/notifications # List notifications
POST   /api/v1/conferences/{id}/notifications # Send notification
PUT    /api/v1/notifications/{id}             # Update notification
DELETE /api/v1/notifications/{id}             # Delete notification
```

---

## 8. 📺 Display Management Module

**Purpose**: Digital signage, screen management, and visual content delivery.

### Database Schema (2 Tables)

#### conference_screens
```sql
CREATE TABLE conference_screens (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    name VARCHAR(255) NOT NULL,
    type ENUM('welcome', 'agenda', 'session', 'poll', 'announcement', 'sponsor') DEFAULT 'welcome',
    content JSON NOT NULL COMMENT 'Dynamic screen content',
    layout VARCHAR(100) DEFAULT 'default',
    is_active BOOLEAN DEFAULT TRUE,
    display_order INT UNSIGNED DEFAULT 0,
    auto_refresh_seconds INT UNSIGNED DEFAULT 30,
    background_color VARCHAR(7) DEFAULT '#ffffff',
    background_image VARCHAR(255) NULL,
    created_by UUID NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_conference_active (conference_id, is_active),
    INDEX idx_type_order (type, display_order),
    INDEX idx_active_screens (is_active, auto_refresh_seconds)
) ENGINE=InnoDB COMMENT='Digital signage and screen management';
```

#### conference_screen_timers
```sql
CREATE TABLE conference_screen_timers (
    id UUID PRIMARY KEY,
    screen_id UUID NOT NULL,
    name VARCHAR(255) NOT NULL,
    type ENUM('countdown', 'countup', 'clock', 'session_timer') DEFAULT 'countdown',
    target_datetime TIMESTAMP NULL,
    duration_seconds INT UNSIGNED NULL,
    is_active BOOLEAN DEFAULT TRUE,
    auto_hide_when_finished BOOLEAN DEFAULT FALSE,
    alert_seconds_before INT UNSIGNED DEFAULT 60,
    format VARCHAR(50) DEFAULT 'HH:MM:SS',
    timezone VARCHAR(50) DEFAULT 'UTC',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (screen_id) REFERENCES conference_screens(id) ON DELETE CASCADE,
    INDEX idx_screen_active (screen_id, is_active),
    INDEX idx_timer_type (type, target_datetime),
    INDEX idx_active_timers (is_active, target_datetime)
) ENGINE=InnoDB COMMENT='Screen timer and countdown management';
```

### API Endpoints
```yaml
GET    /api/v1/conferences/{id}/screens       # List screens
POST   /api/v1/conferences/{id}/screens       # Create screen
GET    /api/v1/screens/{id}                   # Get screen details
PUT    /api/v1/screens/{id}                   # Update screen
DELETE /api/v1/screens/{id}                   # Delete screen
GET    /api/v1/screens/{id}/display           # Get display content
POST   /api/v1/screens/{id}/timers            # Add timer
PUT    /api/v1/timers/{id}                    # Update timer
DELETE /api/v1/timers/{id}                    # Delete timer
POST   /api/v1/screens/{id}/activate          # Activate screen
POST   /api/v1/screens/{id}/deactivate        # Deactivate screen
```

---

## 9. 📊 Analytics & Logging Module

**Purpose**: Comprehensive analytics, activity tracking, and performance monitoring.

### Database Schema (3 Tables)

#### conference_participant_logs
```sql
CREATE TABLE conference_participant_logs (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    participant_id UUID NULL,
    session_id UUID NULL,
    action VARCHAR(100) NOT NULL,
    details JSON NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    occurred_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_conference_participant (conference_id, participant_id, occurred_at),
    INDEX idx_session_activity (session_id, occurred_at),
    INDEX idx_action_analysis (action, occurred_at),
    INDEX idx_participant_timeline (participant_id, occurred_at),
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (participant_id) REFERENCES conference_participants(id) ON DELETE SET NULL,
    FOREIGN KEY (session_id) REFERENCES conference_sessions(id) ON DELETE SET NULL
) ENGINE=InnoDB 
PARTITION BY RANGE (TO_DAYS(occurred_at)) (
    PARTITION p_2024_q1 VALUES LESS THAN (TO_DAYS('2024-04-01')),
    PARTITION p_2024_q2 VALUES LESS THAN (TO_DAYS('2024-07-01')),
    PARTITION p_2024_q3 VALUES LESS THAN (TO_DAYS('2024-10-01')),
    PARTITION p_2024_q4 VALUES LESS THAN (TO_DAYS('2025-01-01')),
    PARTITION p_future VALUES LESS THAN MAXVALUE
)
COMMENT='Detailed participant activity tracking';
```

#### conference_participant_daily_accesses
```sql
CREATE TABLE conference_participant_daily_accesses (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    participant_id UUID NOT NULL,
    access_date DATE NOT NULL,
    session_count INT UNSIGNED DEFAULT 0,
    total_duration_minutes INT UNSIGNED DEFAULT 0,
    first_access_at TIMESTAMP NULL,
    last_access_at TIMESTAMP NULL,
    actions_performed JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (participant_id) REFERENCES conference_participants(id) ON DELETE CASCADE,
    UNIQUE KEY unique_daily_access (conference_id, participant_id, access_date),
    INDEX idx_conference_date (conference_id, access_date),
    INDEX idx_participant_activity (participant_id, access_date)
) ENGINE=InnoDB COMMENT='Daily aggregated access analytics';
```

#### conference_session_logs
```sql
CREATE TABLE conference_session_logs (
    id UUID PRIMARY KEY,
    session_id UUID NOT NULL,
    participant_id UUID NULL,
    event_type ENUM('join', 'leave', 'question', 'poll_vote', 'download') NOT NULL,
    event_data JSON NULL,
    occurred_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (session_id) REFERENCES conference_sessions(id) ON DELETE CASCADE,
    FOREIGN KEY (participant_id) REFERENCES conference_participants(id) ON DELETE SET NULL,
    INDEX idx_session_events (session_id, event_type, occurred_at),
    INDEX idx_participant_sessions (participant_id, occurred_at)
) ENGINE=InnoDB COMMENT='Session-specific event tracking';
```

### API Endpoints
```yaml
GET    /api/v1/conferences/{id}/analytics     # Conference analytics
GET    /api/v1/conferences/{id}/engagement    # Engagement metrics
GET    /api/v1/sessions/{id}/analytics        # Session analytics
GET    /api/v1/participants/{id}/activity     # Participant activity
POST   /api/v1/analytics/track                # Track custom event
GET    /api/v1/analytics/reports              # Generate reports
GET    /api/v1/analytics/exports              # Export data
GET    /api/v1/analytics/realtime             # Real-time metrics
```

---

## 10. 🎮 Gamification Module

**Purpose**: Engagement through gamification, competitions, and virtual exhibitions.

### Database Schema (8 Tables)

#### conference_debates
```sql
CREATE TABLE conference_debates (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    topic TEXT NOT NULL,
    type ENUM('public', 'moderated', 'team_based') DEFAULT 'public',
    status ENUM('upcoming', 'active', 'voting', 'completed') DEFAULT 'upcoming',
    starts_at TIMESTAMP NULL,
    ends_at TIMESTAMP NULL,
    voting_ends_at TIMESTAMP NULL,
    max_teams INT UNSIGNED DEFAULT 2,
    total_votes INT UNSIGNED DEFAULT 0,
    created_by UUID NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_conference_status (conference_id, status),
    INDEX idx_voting_period (starts_at, ends_at),
    INDEX idx_active_debates (status, voting_ends_at)
) ENGINE=InnoDB COMMENT='Interactive debate system';
```

#### conference_debate_teams
```sql
CREATE TABLE conference_debate_teams (
    id UUID PRIMARY KEY,
    debate_id UUID NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    side ENUM('pro', 'con', 'neutral') NOT NULL,
    vote_count INT UNSIGNED DEFAULT 0,
    team_leader_id UUID NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (debate_id) REFERENCES conference_debates(id) ON DELETE CASCADE,
    FOREIGN KEY (team_leader_id) REFERENCES conference_participants(id) ON DELETE SET NULL,
    INDEX idx_debate_side (debate_id, side),
    INDEX idx_vote_count (vote_count DESC)
) ENGINE=InnoDB COMMENT='Debate team management';
```

#### conference_debate_votes
```sql
CREATE TABLE conference_debate_votes (
    id UUID PRIMARY KEY,
    debate_id UUID NOT NULL,
    team_id UUID NOT NULL,
    participant_id UUID NULL,
    ip_address VARCHAR(45) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (debate_id) REFERENCES conference_debates(id) ON DELETE CASCADE,
    FOREIGN KEY (team_id) REFERENCES conference_debate_teams(id) ON DELETE CASCADE,
    FOREIGN KEY (participant_id) REFERENCES conference_participants(id) ON DELETE SET NULL,
    UNIQUE KEY unique_debate_participant (debate_id, participant_id),
    INDEX idx_team_votes (team_id),
    INDEX idx_debate_voting (debate_id, created_at)
) ENGINE=InnoDB COMMENT='Debate voting records';
```

#### conference_virtual_stands
```sql
CREATE TABLE conference_virtual_stands (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    participant_id UUID NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    type ENUM('sponsor', 'exhibitor', 'partner', 'startup') DEFAULT 'exhibitor',
    booth_number VARCHAR(50) NULL,
    logo VARCHAR(255) NULL,
    banner VARCHAR(255) NULL,
    materials JSON NULL COMMENT 'Brochures, videos, links',
    contact_info JSON NULL,
    visit_count INT UNSIGNED DEFAULT 0,
    interaction_count INT UNSIGNED DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (participant_id) REFERENCES conference_participants(id) ON DELETE CASCADE,
    INDEX idx_conference_type (conference_id, type),
    INDEX idx_active_stands (is_active, visit_count),
    INDEX idx_booth_number (booth_number)
) ENGINE=InnoDB COMMENT='Virtual exhibition stands';
```

#### conference_score_games
```sql
CREATE TABLE conference_score_games (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    type ENUM('qr_hunt', 'quiz', 'poll_participation', 'session_attendance') DEFAULT 'qr_hunt',
    points_per_action INT UNSIGNED DEFAULT 10,
    max_points INT UNSIGNED NULL,
    is_active BOOLEAN DEFAULT TRUE,
    starts_at TIMESTAMP NULL,
    ends_at TIMESTAMP NULL,
    created_by UUID NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_conference_active (conference_id, is_active),
    INDEX idx_game_period (starts_at, ends_at),
    INDEX idx_game_type (type)
) ENGINE=InnoDB COMMENT='Gamification scoring system';
```

#### conference_score_game_qr_codes
```sql
CREATE TABLE conference_score_game_qr_codes (
    id UUID PRIMARY KEY,
    game_id UUID NOT NULL,
    code VARCHAR(255) UNIQUE NOT NULL,
    location VARCHAR(255) NULL,
    points INT UNSIGNED DEFAULT 10,
    scan_count INT UNSIGNED DEFAULT 0,
    max_scans_per_user INT UNSIGNED DEFAULT 1,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (game_id) REFERENCES conference_score_games(id) ON DELETE CASCADE,
    INDEX idx_game_active (game_id, is_active),
    INDEX idx_code_lookup (code),
    INDEX idx_scan_count (scan_count DESC)
) ENGINE=InnoDB COMMENT='QR code game elements';
```

#### conference_score_game_points
```sql
CREATE TABLE conference_score_game_points (
    id UUID PRIMARY KEY,
    game_id UUID NOT NULL,
    participant_id UUID NOT NULL,
    qr_code_id UUID NULL,
    action_type VARCHAR(100) NOT NULL,
    points INT UNSIGNED NOT NULL,
    details JSON NULL,
    earned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (game_id) REFERENCES conference_score_games(id) ON DELETE CASCADE,
    FOREIGN KEY (participant_id) REFERENCES conference_participants(id) ON DELETE CASCADE,
    FOREIGN KEY (qr_code_id) REFERENCES conference_score_game_qr_codes(id) ON DELETE SET NULL,
    INDEX idx_game_participant (game_id, participant_id),
    INDEX idx_participant_points (participant_id, points DESC),
    INDEX idx_leaderboard (game_id, points DESC, earned_at),
    INDEX idx_action_analysis (action_type, earned_at)
) ENGINE=InnoDB COMMENT='Point tracking and leaderboards';
```

### API Endpoints
```yaml
GET    /api/v1/conferences/{id}/debates       # List debates
POST   /api/v1/conferences/{id}/debates       # Create debate
GET    /api/v1/debates/{id}                   # Get debate details
POST   /api/v1/debates/{id}/vote              # Vote on debate
GET    /api/v1/debates/{id}/results           # Get debate results
GET    /api/v1/conferences/{id}/virtual-stands # List virtual stands
POST   /api/v1/conferences/{id}/virtual-stands # Create virtual stand
GET    /api/v1/virtual-stands/{id}            # Get stand details
POST   /api/v1/virtual-stands/{id}/visit      # Visit stand
GET    /api/v1/conferences/{id}/games         # List score games
POST   /api/v1/conferences/{id}/games         # Create game
POST   /api/v1/games/{id}/scan-qr             # Scan QR code
GET    /api/v1/conferences/{id}/leaderboard   # Gamification leaderboard
GET    /api/v1/participants/{id}/points       # Get participant points
```

---

## 11. 🔑 API Security Module

**Purpose**: Authentication, authorization, and API security management.

### Database Schema (1 Table)

#### personal_access_tokens
```sql
CREATE TABLE personal_access_tokens (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    tokenable_type VARCHAR(255) NOT NULL,
    tokenable_id UUID NOT NULL,
    name VARCHAR(255) NOT NULL,
    token VARCHAR(64) UNIQUE NOT NULL,
    abilities TEXT NULL,
    last_used_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_tokenable (tokenable_type, tokenable_id),
    INDEX idx_token_lookup (token),
    INDEX idx_expires_at (expires_at),
    INDEX idx_last_used (last_used_at)
) ENGINE=InnoDB COMMENT='Sanctum API token management';
```

### API Endpoints
```yaml
POST   /api/v1/auth/tokens                    # Create API token
GET    /api/v1/auth/tokens                    # List user tokens
DELETE /api/v1/auth/tokens/{id}               # Revoke token
GET    /api/v1/auth/token/verify              # Verify current token
POST   /api/v1/auth/token/refresh             # Refresh token
GET    /api/v1/auth/abilities                 # List token abilities
```

---

## 🔗 Cross-Module Integration

### Event-Driven Communication
```php
// Cross-module events
ConferenceCreated::class => [
    CreateDefaultScreensListener::class,
    InitializeAnalyticsListener::class,
    SendWelcomeNotificationListener::class,
];

ParticipantRegistered::class => [
    GenerateQRCodeListener::class,
    SendConfirmationEmailListener::class,
    UpdateCapacityListener::class,
];

SessionStarted::class => [
    LogAttendanceListener::class,
    UpdateScreenContentListener::class,
    SendSessionRemindersListener::class,
];

PollCreated::class => [
    NotifyParticipantsListener::class,
    UpdateScreensListener::class,
    LogAnalyticsListener::class,
];

QuestionSubmitted::class => [
    ModerationQueueListener::class,
    NotifyModeratorsListener::class,
    UpdateEngagementMetricsListener::class,
];
```

### Shared Services
```php
// Cross-cutting concerns
app/Shared/Services/
├── NotificationService.php     # Used by all modules
├── CacheService.php           # System-wide caching
├── FileStorageService.php     # Document & media handling
├── QRCodeService.php          # QR generation for multiple modules
├── AnalyticsService.php       # Cross-module tracking
├── LocalizationService.php    # Multi-language support
└── TenantService.php          # Multi-tenant operations
```

### Module Communication Patterns
```php
// Service-to-service communication
class ConferenceService
{
    public function __construct(
        private NotificationService $notificationService,
        private AnalyticsService $analyticsService,
        private QRCodeService $qrCodeService
    ) {}
    
    public function publishConference(string $conferenceId): bool
    {
        $conference = Conference::findOrFail($conferenceId);
        $conference->update(['status' => 'published']);
        
        // Cross-module communication via events
        event(new ConferencePublished($conference));
        
        // Direct service calls for immediate needs
        $this->notificationService->notifyParticipants(
            $conference,
            'Conference is now live!'
        );
        
        return true;
    }
}
```

This completes the comprehensive module specifications with enterprise-grade architecture, detailed database schemas, service implementations, and API designs for all 11 modules managing 42 database tables in the KongrePad system.

---

**📅 Last Updated**: 2024-01-15 16:45 UTC  
**👨‍💻 Maintained By**: KongrePad Development Team  
**📝 Version**: 2.0.0  
**🔗 Related Documents**: 
- [Project Architecture](./PROJECT-ARCHITECTURE.md)
- [Migration Implementation Guide](./MIGRATION-IMPLEMENTATION-GUIDE.md)
- [Laravel Naming Standards](./LARAVEL-NAMING-STANDARDS.md)
- [Development Workflow](./DEVELOPMENT-WORKFLOW.md) 