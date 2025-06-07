# 📦 KongrePad Modül Spesifikasyonları

> **Detaylı modül analizi ve implementasyon rehberi**

[![Modules](https://img.shields.io/badge/Modules-11-blue.svg)](#)
[![Database](https://img.shields.io/badge/Tables-42-green.svg)](#)
[![Architecture](https://img.shields.io/badge/Architecture-Modular-orange.svg)](#)

---

## 📋 İçindekiler

1. [System Core Module](#1--system-core-module)
2. [Tenant Management Module](#2--tenant-management-module)
3. [User Management Module](#3--user-management-module)
4. [Conference Core Module](#4--conference-core-module)
5. [Session & Speaker Module](#5--session--speaker-module)
6. [Interactive Features Module](#6--interactive-features-module)
7. [Document Management Module](#7--document-management-module)
8. [Display Management Module](#8--display-management-module)
9. [Analytics & Logging Module](#9--analytics--logging-module)
10. [Gamification Module](#10--gamification-module)
11. [Authentication Module](#11--authentication-module)

---

## 1. 🔧 System Core Module

### 📊 Database Schema

#### system_cache
```sql
CREATE TABLE system_cache (
    key VARCHAR(255) PRIMARY KEY,
    value MEDIUMTEXT NOT NULL,
    expiration INT(11) NOT NULL
);
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
    created_at INT UNSIGNED NOT NULL
);
```

#### system_countries
```sql
CREATE TABLE system_countries (
    id UUID PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    code CHAR(2) UNIQUE NOT NULL,
    phone_code VARCHAR(10),
    flag_emoji VARCHAR(10),
    currency_code CHAR(3),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

#### system_languages
```sql
CREATE TABLE system_languages (
    id UUID PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    code CHAR(2) UNIQUE NOT NULL,
    native_name VARCHAR(255),
    is_rtl BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### 🎯 Sorumluluklar
- Cache yönetimi (Redis/Database)
- Queue job processing
- Session management
- Ülke ve dil verilerinin yönetimi
- System route yönetimi
- Fail-safe job handling

### 🔌 API Endpoints
```
GET    /api/v1/system/countries
GET    /api/v1/system/languages
GET    /api/v1/system/cache/stats
POST   /api/v1/system/cache/clear
GET    /api/v1/system/jobs/stats
```

### 💻 Implementation
```php
// Models
app/Models/System/Country.php
app/Models/System/Language.php
app/Models/System/Job.php

// Services
app/Services/System/CacheService.php
app/Services/System/QueueService.php
app/Services/System/LocalizationService.php

// Controllers
app/Http/Controllers/System/CountryController.php
app/Http/Controllers/System/LanguageController.php
```

---

## 2. 🏢 Tenant Management Module

### 📊 Database Schema

#### tenants
```sql
CREATE TABLE tenants (
    id UUID PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    domain VARCHAR(255) UNIQUE NOT NULL,
    subdomain VARCHAR(50) UNIQUE,
    database_name VARCHAR(100),
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    subscription_plan VARCHAR(50),
    subscription_expires_at TIMESTAMP NULL,
    settings JSON,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

#### tenant_settings
```sql
CREATE TABLE tenant_settings (
    id UUID PRIMARY KEY,
    tenant_id UUID NOT NULL,
    key VARCHAR(255) NOT NULL,
    value TEXT,
    type VARCHAR(50) DEFAULT 'string',
    is_public BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    UNIQUE KEY unique_tenant_key (tenant_id, key)
);
```

### 🎯 Sorumluluklar
- Multi-tenant architecture
- Tenant isolation
- Subdomain/domain routing
- Subscription management
- Tenant-specific configurations
- Database connection management

### 🔌 API Endpoints
```
GET    /api/v1/tenants
POST   /api/v1/tenants
GET    /api/v1/tenants/{id}
PUT    /api/v1/tenants/{id}
DELETE /api/v1/tenants/{id}
GET    /api/v1/tenants/{id}/settings
PUT    /api/v1/tenants/{id}/settings
```

### 💻 Implementation
```php
// Models
app/Models/Tenant.php
app/Models/TenantSetting.php

// Services
app/Services/TenantService.php
app/Services/TenantResolverService.php
app/Services/SubscriptionService.php

// Middleware
app/Http/Middleware/ResolveTenant.php
app/Http/Middleware/CheckTenantAccess.php

// Controllers
app/Http/Controllers/TenantController.php
app/Http/Controllers/TenantSettingController.php
```

---

## 3. 👥 User Management Module

### 📊 Database Schema

#### users
```sql
CREATE TABLE users (
    id UUID PRIMARY KEY,
    tenant_id UUID NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    avatar VARCHAR(255),
    language_code CHAR(2) DEFAULT 'tr',
    timezone VARCHAR(50) DEFAULT 'Europe/Istanbul',
    last_login_at TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    UNIQUE KEY unique_tenant_email (tenant_id, email)
);
```

#### user_roles
```sql
CREATE TABLE user_roles (
    id UUID PRIMARY KEY,
    tenant_id UUID NOT NULL,
    user_id UUID NOT NULL,
    role VARCHAR(50) NOT NULL,
    permissions JSON,
    assigned_at TIMESTAMP,
    assigned_by UUID,
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### 🎯 Sorumluluklar
- User authentication
- Role-based authorization
- Permission management
- Profile management
- Email verification
- Password reset
- Multi-tenant user isolation

### 🔌 API Endpoints
```
POST   /api/v1/auth/register
POST   /api/v1/auth/login
POST   /api/v1/auth/logout
POST   /api/v1/auth/forgot-password
POST   /api/v1/auth/reset-password
GET    /api/v1/users/profile
PUT    /api/v1/users/profile
GET    /api/v1/users
POST   /api/v1/users
PUT    /api/v1/users/{id}
DELETE /api/v1/users/{id}
PUT    /api/v1/users/{id}/roles
```

### 💻 Implementation
```php
// Models
app/Models/User.php
app/Models/UserRole.php

// Services
app/Services/AuthService.php
app/Services/UserService.php
app/Services/RoleService.php

// Controllers
app/Http/Controllers/Auth/LoginController.php
app/Http/Controllers/Auth/RegisterController.php
app/Http/Controllers/UserController.php
app/Http/Controllers/UserRoleController.php

// Requests
app/Http/Requests/Auth/LoginRequest.php
app/Http/Requests/Auth/RegisterRequest.php
app/Http/Requests/User/StoreUserRequest.php
app/Http/Requests/User/UpdateUserRequest.php
```

---

## 4. 🎪 Conference Core Module

### 📊 Database Schema

#### conferences
```sql
CREATE TABLE conferences (
    id UUID PRIMARY KEY,
    tenant_id UUID NOT NULL,
    title VARCHAR(255) NOT NULL,
    subtitle VARCHAR(255),
    description TEXT,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    start_time TIME,
    end_time TIME,
    timezone VARCHAR(50) DEFAULT 'Europe/Istanbul',
    status ENUM('draft', 'published', 'ongoing', 'completed', 'cancelled') DEFAULT 'draft',
    max_participants INT DEFAULT 1000,
    registration_start_date TIMESTAMP,
    registration_end_date TIMESTAMP,
    logo VARCHAR(255),
    banner VARCHAR(255),
    website_url VARCHAR(255),
    social_links JSON,
    contact_info JSON,
    tags JSON,
    is_public BOOLEAN DEFAULT TRUE,
    created_by UUID,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id)
);
```

#### conference_venues
```sql
CREATE TABLE conference_venues (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    name VARCHAR(255) NOT NULL,
    type ENUM('physical', 'virtual', 'hybrid') DEFAULT 'physical',
    address TEXT,
    city VARCHAR(100),
    country VARCHAR(100),
    postal_code VARCHAR(20),
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    capacity INT,
    virtual_url VARCHAR(255),
    facilities JSON,
    contact_info JSON,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE
);
```

### 🎯 Sorumluluklar
- Conference creation and management
- Venue management (physical/virtual/hybrid)
- Program scheduling
- Conference metadata
- Registration settings
- Status management
- Public/private access control

### 🔌 API Endpoints
```
GET    /api/v1/conferences
POST   /api/v1/conferences
GET    /api/v1/conferences/{id}
PUT    /api/v1/conferences/{id}
DELETE /api/v1/conferences/{id}
POST   /api/v1/conferences/{id}/publish
POST   /api/v1/conferences/{id}/duplicate
GET    /api/v1/conferences/{id}/venues
POST   /api/v1/conferences/{id}/venues
PUT    /api/v1/conferences/{id}/venues/{venue_id}
```

### 💻 Implementation
```php
// Models
app/Models/Conference.php
app/Models/ConferenceVenue.php
app/Models/ConferenceProgram.php
app/Models/ConferenceProgramChair.php

// Services
app/Services/ConferenceService.php
app/Services/ConferenceVenueService.php
app/Services/ConferenceProgramService.php

// Controllers
app/Http/Controllers/ConferenceController.php
app/Http/Controllers/ConferenceVenueController.php
app/Http/Controllers/ConferenceProgramController.php

// Enums
app/Enums/ConferenceStatus.php
app/Enums/VenueType.php
```

---

## 5. 🎤 Session & Speaker Module

### 📊 Database Schema

#### conference_sessions
```sql
CREATE TABLE conference_sessions (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    venue_id UUID,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    type ENUM('keynote', 'presentation', 'panel', 'workshop', 'break') DEFAULT 'presentation',
    start_time TIMESTAMP NOT NULL,
    end_time TIMESTAMP NOT NULL,
    duration_minutes INT,
    room VARCHAR(100),
    capacity INT,
    language_code CHAR(2) DEFAULT 'tr',
    level ENUM('beginner', 'intermediate', 'advanced') DEFAULT 'intermediate',
    tags JSON,
    materials JSON,
    recording_url VARCHAR(255),
    live_stream_url VARCHAR(255),
    is_public BOOLEAN DEFAULT TRUE,
    requires_registration BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (venue_id) REFERENCES conference_venues(id)
);
```

#### conference_participants
```sql
CREATE TABLE conference_participants (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    user_id UUID,
    email VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    organization VARCHAR(255),
    title VARCHAR(255),
    bio TEXT,
    avatar VARCHAR(255),
    type ENUM('attendee', 'speaker', 'organizer', 'sponsor', 'media') DEFAULT 'attendee',
    status ENUM('registered', 'confirmed', 'attended', 'cancelled') DEFAULT 'registered',
    registration_data JSON,
    attendance_data JSON,
    qr_code VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id),
    UNIQUE KEY unique_conference_email (conference_id, email)
);
```

#### conference_session_speakers
```sql
CREATE TABLE conference_session_speakers (
    id UUID PRIMARY KEY,
    session_id UUID NOT NULL,
    participant_id UUID NOT NULL,
    type ENUM('primary', 'co-speaker', 'moderator', 'panelist') DEFAULT 'primary',
    order_index INT DEFAULT 0,
    bio TEXT,
    social_links JSON,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (session_id) REFERENCES conference_sessions(id) ON DELETE CASCADE,
    FOREIGN KEY (participant_id) REFERENCES conference_participants(id) ON DELETE CASCADE
);
```

### 🎯 Sorumluluklar
- Session scheduling and management
- Speaker assignment and management
- Participant registration
- Session capacity management
- Live streaming integration
- Recording management
- Multi-language support

### 🔌 API Endpoints
```
GET    /api/v1/conferences/{id}/sessions
POST   /api/v1/conferences/{id}/sessions
GET    /api/v1/sessions/{id}
PUT    /api/v1/sessions/{id}
DELETE /api/v1/sessions/{id}
GET    /api/v1/conferences/{id}/participants
POST   /api/v1/conferences/{id}/participants
GET    /api/v1/participants/{id}
PUT    /api/v1/participants/{id}
POST   /api/v1/sessions/{id}/speakers
DELETE /api/v1/sessions/{id}/speakers/{participant_id}
```

### 💻 Implementation
```php
// Models
app/Models/ConferenceSession.php
app/Models/ConferenceParticipant.php
app/Models/ConferenceSessionSpeaker.php

// Services
app/Services/SessionService.php
app/Services/ParticipantService.php
app/Services/SpeakerService.php

// Controllers
app/Http/Controllers/SessionController.php
app/Http/Controllers/ParticipantController.php
app/Http/Controllers/SpeakerController.php

// Enums
app/Enums/SessionType.php
app/Enums/ParticipantType.php
app/Enums/ParticipantStatus.php
app/Enums/SpeakerType.php
```

---

## 6. 🙋 Interactive Features Module

### 📊 Database Schema

#### conference_questions
```sql
CREATE TABLE conference_questions (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    session_id UUID,
    participant_id UUID NOT NULL,
    question TEXT NOT NULL,
    type ENUM('text', 'multiple_choice', 'rating') DEFAULT 'text',
    status ENUM('pending', 'approved', 'answered', 'rejected') DEFAULT 'pending',
    upvotes INT DEFAULT 0,
    answer TEXT,
    answered_by UUID,
    answered_at TIMESTAMP NULL,
    is_anonymous BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (session_id) REFERENCES conference_sessions(id),
    FOREIGN KEY (participant_id) REFERENCES conference_participants(id)
);
```

#### conference_polls
```sql
CREATE TABLE conference_polls (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    session_id UUID,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    type ENUM('single_choice', 'multiple_choice', 'rating', 'text') DEFAULT 'single_choice',
    status ENUM('draft', 'active', 'closed') DEFAULT 'draft',
    starts_at TIMESTAMP,
    ends_at TIMESTAMP,
    max_selections INT DEFAULT 1,
    is_anonymous BOOLEAN DEFAULT TRUE,
    show_results BOOLEAN DEFAULT FALSE,
    created_by UUID,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (session_id) REFERENCES conference_sessions(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);
```

#### conference_surveys
```sql
CREATE TABLE conference_surveys (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    type ENUM('feedback', 'evaluation', 'registration', 'general') DEFAULT 'feedback',
    status ENUM('draft', 'active', 'closed') DEFAULT 'draft',
    starts_at TIMESTAMP,
    ends_at TIMESTAMP,
    is_anonymous BOOLEAN DEFAULT TRUE,
    is_required BOOLEAN DEFAULT FALSE,
    show_results BOOLEAN DEFAULT FALSE,
    created_by UUID,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id)
);
```

### 🎯 Sorumluluklar
- Q&A system management
- Real-time polling
- Survey creation and management
- Vote and response collection
- Result analytics
- Moderation system
- Anonymous participation support

### 🔌 API Endpoints
```
GET    /api/v1/conferences/{id}/questions
POST   /api/v1/conferences/{id}/questions
PUT    /api/v1/questions/{id}
POST   /api/v1/questions/{id}/upvote
POST   /api/v1/questions/{id}/answer
GET    /api/v1/conferences/{id}/polls
POST   /api/v1/conferences/{id}/polls
POST   /api/v1/polls/{id}/vote
GET    /api/v1/polls/{id}/results
GET    /api/v1/conferences/{id}/surveys
POST   /api/v1/conferences/{id}/surveys
POST   /api/v1/surveys/{id}/respond
```

### 💻 Implementation
```php
// Models
app/Models/ConferenceQuestion.php
app/Models/ConferencePoll.php
app/Models/ConferencePollOption.php
app/Models/ConferencePollVote.php
app/Models/ConferenceSurvey.php
app/Models/ConferenceSurveyQuestion.php
app/Models/ConferenceSurveyResponse.php

// Services
app/Services/QuestionService.php
app/Services/PollService.php
app/Services/SurveyService.php

// Controllers
app/Http/Controllers/QuestionController.php
app/Http/Controllers/PollController.php
app/Http/Controllers/SurveyController.php
```

---

## 7. 📄 Document Management Module

### 📊 Database Schema

#### conference_documents
```sql
CREATE TABLE conference_documents (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    session_id UUID,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    type ENUM('presentation', 'handout', 'certificate', 'agenda', 'other') DEFAULT 'other',
    file_path VARCHAR(500) NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_size BIGINT UNSIGNED,
    mime_type VARCHAR(100),
    download_count INT DEFAULT 0,
    access_level ENUM('public', 'participants', 'speakers', 'organizers') DEFAULT 'participants',
    is_downloadable BOOLEAN DEFAULT TRUE,
    uploaded_by UUID,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (session_id) REFERENCES conference_sessions(id),
    FOREIGN KEY (uploaded_by) REFERENCES users(id)
);
```

#### conference_notifications
```sql
CREATE TABLE conference_notifications (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    type ENUM('general', 'session', 'document', 'poll', 'question') DEFAULT 'general',
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    target_audience ENUM('all', 'attendees', 'speakers', 'organizers') DEFAULT 'all',
    delivery_method ENUM('push', 'email', 'sms', 'in_app') DEFAULT 'in_app',
    status ENUM('draft', 'scheduled', 'sent', 'failed') DEFAULT 'draft',
    scheduled_at TIMESTAMP,
    sent_at TIMESTAMP,
    sent_count INT DEFAULT 0,
    created_by UUID,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id)
);
```

### 🎯 Sorumluluklar
- File upload and management
- Document access control
- Download tracking
- Notification system
- Email/SMS/Push notifications
- Scheduled notifications
- Audience targeting

### 🔌 API Endpoints
```
GET    /api/v1/conferences/{id}/documents
POST   /api/v1/conferences/{id}/documents
GET    /api/v1/documents/{id}
DELETE /api/v1/documents/{id}
GET    /api/v1/documents/{id}/download
GET    /api/v1/conferences/{id}/notifications
POST   /api/v1/conferences/{id}/notifications
PUT    /api/v1/notifications/{id}
POST   /api/v1/notifications/{id}/send
```

### 💻 Implementation
```php
// Models
app/Models/ConferenceDocument.php
app/Models/ConferenceNotification.php
app/Models/ConferenceDocumentNotification.php

// Services
app/Services/DocumentService.php
app/Services/NotificationService.php
app/Services/FileStorageService.php

// Controllers
app/Http/Controllers/DocumentController.php
app/Http/Controllers/NotificationController.php

// Jobs
app/Jobs/SendNotificationJob.php
app/Jobs/ProcessFileUploadJob.php
```

---

## 8. 📺 Display Management Module

### 📊 Database Schema

#### conference_screens
```sql
CREATE TABLE conference_screens (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    name VARCHAR(255) NOT NULL,
    type ENUM('welcome', 'agenda', 'session', 'poll', 'announcement', 'sponsor') DEFAULT 'welcome',
    content JSON NOT NULL,
    layout VARCHAR(100) DEFAULT 'default',
    is_active BOOLEAN DEFAULT TRUE,
    display_order INT DEFAULT 0,
    auto_refresh_seconds INT DEFAULT 30,
    background_color VARCHAR(7) DEFAULT '#ffffff',
    background_image VARCHAR(255),
    created_by UUID,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id)
);
```

#### conference_screen_timers
```sql
CREATE TABLE conference_screen_timers (
    id UUID PRIMARY KEY,
    screen_id UUID NOT NULL,
    name VARCHAR(255) NOT NULL,
    type ENUM('countdown', 'countup', 'clock') DEFAULT 'countdown',
    target_datetime TIMESTAMP,
    duration_seconds INT,
    is_active BOOLEAN DEFAULT TRUE,
    auto_hide_when_finished BOOLEAN DEFAULT FALSE,
    alert_seconds_before INT DEFAULT 60,
    format VARCHAR(50) DEFAULT 'HH:MM:SS',
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (screen_id) REFERENCES conference_screens(id) ON DELETE CASCADE
);
```

### 🎯 Sorumluluklar
- Digital signage management
- Screen content management
- Timer and countdown systems
- Auto-refresh functionality
- Layout customization
- Real-time updates

### 🔌 API Endpoints
```
GET    /api/v1/conferences/{id}/screens
POST   /api/v1/conferences/{id}/screens
GET    /api/v1/screens/{id}
PUT    /api/v1/screens/{id}
DELETE /api/v1/screens/{id}
GET    /api/v1/screens/{id}/timers
POST   /api/v1/screens/{id}/timers
PUT    /api/v1/timers/{id}
GET    /api/v1/screens/{id}/display
```

### 💻 Implementation
```php
// Models
app/Models/ConferenceScreen.php
app/Models/ConferenceScreenTimer.php

// Services
app/Services/ScreenService.php
app/Services/TimerService.php

// Controllers
app/Http/Controllers/ScreenController.php
app/Http/Controllers/TimerController.php

// Enums
app/Enums/ScreenType.php
app/Enums/TimerType.php
```

---

## 9. 📊 Analytics & Logging Module

### 📊 Database Schema

#### conference_participant_logs
```sql
CREATE TABLE conference_participant_logs (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    participant_id UUID,
    session_id UUID,
    action VARCHAR(100) NOT NULL,
    details JSON,
    ip_address VARCHAR(45),
    user_agent TEXT,
    occurred_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (participant_id) REFERENCES conference_participants(id),
    FOREIGN KEY (session_id) REFERENCES conference_sessions(id)
);
```

#### conference_participant_daily_accesses
```sql
CREATE TABLE conference_participant_daily_accesses (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    participant_id UUID NOT NULL,
    access_date DATE NOT NULL,
    session_count INT DEFAULT 0,
    total_duration_minutes INT DEFAULT 0,
    first_access_at TIMESTAMP,
    last_access_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (participant_id) REFERENCES conference_participants(id),
    UNIQUE KEY unique_daily_access (conference_id, participant_id, access_date)
);
```

#### conference_session_logs
```sql
CREATE TABLE conference_session_logs (
    id UUID PRIMARY KEY,
    session_id UUID NOT NULL,
    event_type VARCHAR(100) NOT NULL,
    data JSON,
    occurred_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (session_id) REFERENCES conference_sessions(id) ON DELETE CASCADE
);
```

### 🎯 Sorumluluklar
- User activity tracking
- Session analytics
- Performance monitoring
- Daily access reports
- Real-time metrics
- Data visualization

### 🔌 API Endpoints
```
GET    /api/v1/conferences/{id}/analytics
GET    /api/v1/conferences/{id}/analytics/participants
GET    /api/v1/conferences/{id}/analytics/sessions
GET    /api/v1/conferences/{id}/analytics/daily-access
GET    /api/v1/sessions/{id}/analytics
GET    /api/v1/participants/{id}/activity
```

### 💻 Implementation
```php
// Models
app/Models/ConferenceParticipantLog.php
app/Models/ConferenceParticipantDailyAccess.php
app/Models/ConferenceSessionLog.php

// Services
app/Services/AnalyticsService.php
app/Services/LoggingService.php
app/Services/ReportingService.php

// Controllers
app/Http/Controllers/AnalyticsController.php

// Jobs
app/Jobs/ProcessDailyAccessJob.php
app/Jobs/GenerateAnalyticsReportJob.php
```

---

## 10. 🎮 Gamification Module

### 📊 Database Schema

#### conference_debates
```sql
CREATE TABLE conference_debates (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    topic TEXT NOT NULL,
    type ENUM('public', 'moderated', 'team_based') DEFAULT 'public',
    status ENUM('upcoming', 'active', 'voting', 'completed') DEFAULT 'upcoming',
    starts_at TIMESTAMP,
    ends_at TIMESTAMP,
    voting_ends_at TIMESTAMP,
    max_teams INT DEFAULT 2,
    created_by UUID,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id)
);
```

#### conference_virtual_stands
```sql
CREATE TABLE conference_virtual_stands (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    participant_id UUID NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    type ENUM('sponsor', 'exhibitor', 'partner', 'startup') DEFAULT 'exhibitor',
    booth_number VARCHAR(50),
    logo VARCHAR(255),
    banner VARCHAR(255),
    materials JSON,
    contact_info JSON,
    visit_count INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (participant_id) REFERENCES conference_participants(id)
);
```

#### conference_score_games
```sql
CREATE TABLE conference_score_games (
    id UUID PRIMARY KEY,
    conference_id UUID NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    type ENUM('qr_hunt', 'quiz', 'survey_complete', 'session_attend') DEFAULT 'qr_hunt',
    rules JSON,
    point_system JSON,
    status ENUM('draft', 'active', 'completed') DEFAULT 'draft',
    starts_at TIMESTAMP,
    ends_at TIMESTAMP,
    max_points INT DEFAULT 1000,
    created_by UUID,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (conference_id) REFERENCES conferences(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id)
);
```

### 🎯 Sorumluluklar
- Debate system management
- Virtual exhibition stands
- Score-based games
- QR code treasure hunts
- Leaderboards
- Achievement system
- Point tracking

### 🔌 API Endpoints
```
GET    /api/v1/conferences/{id}/debates
POST   /api/v1/conferences/{id}/debates
POST   /api/v1/debates/{id}/vote
GET    /api/v1/conferences/{id}/virtual-stands
POST   /api/v1/conferences/{id}/virtual-stands
POST   /api/v1/virtual-stands/{id}/visit
GET    /api/v1/conferences/{id}/score-games
POST   /api/v1/conferences/{id}/score-games
POST   /api/v1/score-games/{id}/scan-qr
GET    /api/v1/conferences/{id}/leaderboard
```

### 💻 Implementation
```php
// Models
app/Models/ConferenceDebate.php
app/Models/ConferenceDebateTeam.php
app/Models/ConferenceDebateVote.php
app/Models/ConferenceVirtualStand.php
app/Models/ConferenceScoreGame.php
app/Models/ConferenceScoreGameQrCode.php
app/Models/ConferenceScoreGamePoint.php

// Services
app/Services/DebateService.php
app/Services/VirtualStandService.php
app/Services/ScoreGameService.php
app/Services/LeaderboardService.php

// Controllers
app/Http/Controllers/DebateController.php
app/Http/Controllers/VirtualStandController.php
app/Http/Controllers/ScoreGameController.php
```

---

## 11. 🔑 Authentication Module

### 📊 Database Schema

#### personal_access_tokens
```sql
CREATE TABLE personal_access_tokens (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    tokenable_type VARCHAR(255) NOT NULL,
    tokenable_id UUID NOT NULL,
    name VARCHAR(255) NOT NULL,
    token VARCHAR(64) UNIQUE NOT NULL,
    abilities TEXT,
    last_used_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    INDEX tokenable (tokenable_type, tokenable_id)
);
```

### 🎯 Sorumluluklar
- Sanctum token management
- API authentication
- Token lifecycle management
- Permission-based access control
- Token expiration handling
- Rate limiting

### 🔌 API Endpoints
```
POST   /api/v1/auth/token
DELETE /api/v1/auth/token
GET    /api/v1/auth/tokens
DELETE /api/v1/auth/tokens/{id}
POST   /api/v1/auth/refresh
GET    /api/v1/auth/user
```

### 💻 Implementation
```php
// Models
app/Models/PersonalAccessToken.php

// Services
app/Services/TokenService.php
app/Services/AuthenticationService.php

// Controllers
app/Http/Controllers/Auth/TokenController.php

// Middleware
app/Http/Middleware/EnsureTokenIsValid.php
app/Http/Middleware/CheckTokenPermissions.php
```

---

## 🎯 Modül Entegrasyon Örnekleri

### Cross-Module Service Communication
```php
// Conference Service using other modules
class ConferenceService 
{
    public function __construct(
        private TenantService $tenantService,
        private UserService $userService,
        private NotificationService $notificationService,
        private AnalyticsService $analyticsService
    ) {}
    
    public function createConference(array $data): Conference
    {
        return DB::transaction(function() use ($data) {
            // Create conference
            $conference = $this->repository->create($data);
            
            // Log activity
            $this->analyticsService->logActivity('conference_created', $conference);
            
            // Send notification
            $this->notificationService->notifyTenantUsers(
                $conference->tenant_id,
                'New conference created: ' . $conference->title
            );
            
            return $conference;
        });
    }
}
```

### Event-Driven Architecture
```php
// Events for cross-module communication
event(new ConferenceCreated($conference));
event(new ParticipantRegistered($participant));
event(new SessionStarted($session));
event(new PollCompleted($poll));
```

---

**📅 Son Güncelleme**: {{ date('Y-m-d') }}  
**👨‍💻 Hazırlayan**: KongrePad Development Team  
**📝 Versiyon**: 1.0.0  
**🔗 Ana Dokümantasyon**: [Project Architecture](./PROJECT-ARCHITECTURE.md) 