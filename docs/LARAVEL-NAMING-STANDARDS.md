# 📏 Laravel Naming Standards & Conventions

> **Comprehensive coding standards and naming conventions for KongrePad Laravel application**

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PSR](https://img.shields.io/badge/PSR-12-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php-fig.org/psr/psr-12/)
[![Standards](https://img.shields.io/badge/Standards-Enterprise-2563EB?style=for-the-badge)](#enterprise-standards)

---

## 📋 Table of Contents

1. [General Naming Principles](#-general-naming-principles)
2. [File & Directory Naming](#-file--directory-naming)
3. [Class Naming Conventions](#-class-naming-conventions)
4. [Database Naming Standards](#-database-naming-standards)
5. [API Naming Conventions](#-api-naming-conventions)
6. [Variable & Method Naming](#-variable--method-naming)
7. [Configuration & Environment](#-configuration--environment)
8. [Testing Conventions](#-testing-conventions)
9. [Code Documentation](#-code-documentation)
10. [Git & Version Control](#-git--version-control)

---

## 🎯 General Naming Principles

### Core Standards
- **Consistency**: All naming must be consistent across the entire codebase
- **Clarity**: Names should be self-documenting and descriptive
- **English Only**: All code, comments, and documentation in English
- **PSR-12 Compliance**: Follow PHP-FIG standards strictly
- **Laravel Conventions**: Adhere to Laravel's built-in naming patterns

### Case Conventions
```yaml
PascalCase: ClassNames, InterfaceNames, TraitNames
camelCase: methodNames, variableNames, propertyNames
snake_case: file_names, database_tables, database_columns
SCREAMING_SNAKE_CASE: CONSTANTS, ENV_VARIABLES
kebab-case: URLs, route-names, CSS-classes
```

---

## 📁 File & Directory Naming

### Directory Structure
```
app/
├── Foundation/              # PascalCase for base classes
├── Modules/                 # PascalCase for business domains
│   ├── ConferenceCore/     # PascalCase module names
│   ├── UserManagement/     # PascalCase module names
│   └── InteractiveFeatures/
├── Shared/                  # PascalCase for shared resources
│   ├── Services/           # PascalCase for service types
│   ├── Traits/             # PascalCase for trait collections
│   └── Contracts/          # PascalCase for interfaces
└── Integration/             # PascalCase for external integrations
```

### File Naming Conventions
```php
// Models (PascalCase + Singular)
User.php
Conference.php
ConferenceSession.php
ConferenceParticipant.php

// Controllers (PascalCase + Controller suffix)
UserController.php
ConferenceController.php
SessionController.php
ParticipantController.php

// Services (PascalCase + Service suffix)
UserService.php
ConferenceService.php
NotificationService.php

// Repositories (PascalCase + Repository suffix)
UserRepository.php
ConferenceRepository.php

// Requests (PascalCase + Request suffix)
CreateUserRequest.php
UpdateConferenceRequest.php
StoreSessionRequest.php

// Resources (PascalCase + Resource suffix)
UserResource.php
ConferenceResource.php
SessionResource.php

// Middlewares (PascalCase + descriptive name)
ResolveTenant.php
CheckPermissions.php
LogActivity.php

// Jobs (PascalCase + descriptive action)
SendEmailNotification.php
ProcessConferenceRegistration.php
GenerateConferenceReport.php

// Events (PascalCase + past tense)
UserRegistered.php
ConferenceCreated.php
SessionStarted.php

// Listeners (PascalCase + Listener suffix)
SendWelcomeEmailListener.php
UpdateAnalyticsListener.php

// Exceptions (PascalCase + Exception suffix)
TenantNotFoundException.php
ConferenceAccessDeniedException.php
```

---

## 🏗️ Class Naming Conventions

### Models
```php
// Singular, PascalCase
class User extends Model
class Conference extends Model
class ConferenceSession extends Model
class ConferenceParticipant extends Model

// Relationships follow Laravel conventions
public function conferences(): HasMany
public function participants(): BelongsToMany
public function sessions(): HasManyThrough
```

### Controllers
```php
// Resource Controllers (PascalCase + Controller)
class ConferenceController extends Controller
{
    public function index()     // List resources
    public function show()      // Show single resource
    public function create()    // Show creation form
    public function store()     // Store new resource
    public function edit()      // Show edit form
    public function update()    // Update existing resource
    public function destroy()   // Delete resource
}

// API Controllers (PascalCase + Api + Controller)
class ApiConferenceController extends Controller
class ApiUserController extends Controller

// Specialized Controllers (descriptive names)
class AuthController extends Controller
class DashboardController extends Controller
class ReportController extends Controller
```

### Services
```php
// Business Logic Services (PascalCase + Service)
class ConferenceService
{
    public function createConference(array $data): Conference
    public function publishConference(string $id): bool
    public function generateReport(string $id): array
}

class NotificationService
{
    public function sendEmail(string $to, string $template, array $data): bool
    public function sendSms(string $to, string $message): bool
    public function broadcastToChannel(string $channel, array $data): void
}
```

### Repositories
```php
// Data Access Layer (PascalCase + Repository)
interface ConferenceRepositoryInterface
{
    public function findByTenant(string $tenantId): Collection;
    public function findPublished(): Collection;
    public function findUpcoming(): Collection;
}

class ConferenceRepository implements ConferenceRepositoryInterface
{
    public function findByTenant(string $tenantId): Collection
    {
        return Conference::where('tenant_id', $tenantId)->get();
    }
}
```

---

## 🗃️ Database Naming Standards

### Table Names
```sql
-- snake_case, plural
users
tenants
conferences
conference_sessions
conference_participants
conference_session_speakers
conference_participant_logs
```

### Column Names
```sql
-- snake_case, descriptive
id                          -- UUID primary key
tenant_id                   -- Foreign key with _id suffix
user_id                     -- Foreign key reference
first_name                  -- Descriptive field names
last_name                   -- Descriptive field names
email_verified_at           -- Timestamp fields with _at suffix
created_at                  -- Laravel timestamp
updated_at                  -- Laravel timestamp
deleted_at                  -- Soft delete timestamp
```

### Index Names
```sql
-- Format: idx_[table]_[columns]
CREATE INDEX idx_users_tenant_email ON users (tenant_id, email);
CREATE INDEX idx_conferences_status_date ON conferences (status, start_date);
CREATE INDEX idx_sessions_conference_time ON conference_sessions (conference_id, start_time);

-- Unique indexes: unique_[table]_[columns]
CREATE UNIQUE INDEX unique_users_tenant_email ON users (tenant_id, email);
CREATE UNIQUE INDEX unique_conferences_tenant_slug ON conferences (tenant_id, slug);

-- Foreign key indexes: fk_[table]_[referenced_table]
CREATE INDEX fk_conferences_tenants ON conferences (tenant_id);
CREATE INDEX fk_sessions_conferences ON conference_sessions (conference_id);
```

### Migration Names
```php
// Format: YYYY_MM_DD_HHNN_action_table_table.php
2024_01_01_0001_create_users_table.php
2024_01_01_0002_create_conferences_table.php
2024_01_01_0003_add_status_to_conferences_table.php
2024_01_01_0004_create_conference_sessions_table.php
```

---

## 🔌 API Naming Conventions

### Route Names
```php
// Resource routes (kebab-case)
Route::apiResource('conferences', ConferenceController::class);
Route::apiResource('conference-sessions', SessionController::class);
Route::apiResource('virtual-stands', VirtualStandController::class);

// Named routes (dot notation)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::post('/conferences/{id}/publish', [ConferenceController::class, 'publish'])
     ->name('conferences.publish');
```

### API Endpoints
```yaml
# RESTful resource patterns
GET    /api/v1/conferences                    # conferences.index
POST   /api/v1/conferences                    # conferences.store  
GET    /api/v1/conferences/{id}               # conferences.show
PUT    /api/v1/conferences/{id}               # conferences.update
DELETE /api/v1/conferences/{id}               # conferences.destroy

# Nested resources
GET    /api/v1/conferences/{id}/sessions      # conference.sessions.index
POST   /api/v1/conferences/{id}/sessions      # conference.sessions.store

# Action-based endpoints (verbs for non-CRUD operations)
POST   /api/v1/conferences/{id}/publish       # conferences.publish
POST   /api/v1/conferences/{id}/duplicate     # conferences.duplicate
POST   /api/v1/sessions/{id}/start            # sessions.start
POST   /api/v1/polls/{id}/vote                # polls.vote
```

### Request/Response Naming
```php
// Request Classes
class CreateConferenceRequest extends FormRequest
class UpdateConferenceRequest extends FormRequest
class StoreSessionRequest extends FormRequest

// Resource Classes  
class ConferenceResource extends JsonResource
class ConferenceCollection extends ResourceCollection
class SessionResource extends JsonResource

// Response structure
{
    "success": true,
    "data": {
        "id": "uuid",
        "title": "Conference Title",
        "created_at": "2024-01-15T16:45:00Z"
    },
    "meta": {
        "pagination": {...}
    }
}
```

---

## 🔤 Variable & Method Naming

### Method Names
```php
// Action methods (verbs)
public function createConference(): Conference
public function updateUser(): User
public function deleteSession(): bool
public function publishConference(): bool

// Query methods (descriptive)
public function findActiveConferences(): Collection
public function getUpcomingSessions(): Collection
public function getUsersByRole(string $role): Collection

// Boolean methods (is/has/can/should)
public function isPublished(): bool
public function hasPermission(string $permission): bool
public function canManageConference(): bool
public function shouldSendNotification(): bool

// Accessor methods (get prefix)
public function getFullNameAttribute(): string
public function getStatusLabelAttribute(): string

// Mutator methods (set prefix)
public function setPasswordAttribute(string $value): void
public function setEmailAttribute(string $value): void
```

### Variable Names
```php
// camelCase, descriptive
$conferenceId = '123e4567-e89b-12d3-a456-426614174000';
$participantCount = 150;
$isPublished = true;
$upcomingSessions = collect();

// Arrays and collections (plural)
$conferences = Conference::all();
$users = User::where('active', true)->get();
$sessionIds = $sessions->pluck('id');

// Temporary variables (short but clear)
$participant = $conference->participants()->first();
$session = Session::find($sessionId);
$venue = $conference->venues()->where('type', 'main')->first();
```

### Constants
```php
// Class constants (SCREAMING_SNAKE_CASE)
class ConferenceStatus
{
    public const DRAFT = 'draft';
    public const PUBLISHED = 'published';
    public const ONGOING = 'ongoing';
    public const COMPLETED = 'completed';
    public const CANCELLED = 'cancelled';
}

class UserRole
{
    public const ADMIN = 'admin';
    public const ORGANIZER = 'organizer';
    public const SPEAKER = 'speaker';
    public const ATTENDEE = 'attendee';
}
```

---

## ⚙️ Configuration & Environment

### Environment Variables
```bash
# SCREAMING_SNAKE_CASE with prefixes
APP_NAME="KongrePad"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://kongrepad.com

# Database configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kongrepad_production
DB_USERNAME=kongrepad_user
DB_PASSWORD=secure_password

# Cache configuration  
CACHE_DRIVER=redis
CACHE_PREFIX=kongrepad

# Queue configuration
QUEUE_CONNECTION=redis
QUEUE_PREFIX=kongrepad

# Mail configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=postmaster@mg.kongrepad.com
MAIL_PASSWORD=mail_password
MAIL_FROM_ADDRESS=noreply@kongrepad.com
MAIL_FROM_NAME="KongrePad Platform"

# Tenant configuration
TENANT_DOMAIN_STRATEGY=subdomain
TENANT_DATABASE_PREFIX=kongrepad_
```

### Configuration Files
```php
// config/kongrepad.php
return [
    'conference' => [
        'max_participants_default' => 1000,
        'registration_deadline_days' => 7,
        'auto_approve_questions' => false,
    ],
    
    'gamification' => [
        'points_per_session' => 10,
        'points_per_question' => 5,
        'points_per_poll_vote' => 2,
    ],
    
    'notifications' => [
        'email_enabled' => true,
        'sms_enabled' => false,
        'push_enabled' => true,
    ],
];
```

---

## 🧪 Testing Conventions

### Test File Names
```php
// Feature Tests (descriptive scenarios)
tests/Feature/Conference/ConferenceManagementTest.php
tests/Feature/User/UserRegistrationTest.php
tests/Feature/Session/SessionSchedulingTest.php

// Unit Tests (class being tested + Test)
tests/Unit/Services/ConferenceServiceTest.php
tests/Unit/Models/UserTest.php
tests/Unit/Repositories/ConferenceRepositoryTest.php
```

### Test Method Names
```php
class ConferenceManagementTest extends TestCase
{
    /** @test */
    public function it_can_create_a_new_conference()
    {
        // Test implementation
    }
    
    /** @test */ 
    public function it_prevents_unauthorized_conference_creation()
    {
        // Test implementation
    }
    
    /** @test */
    public function it_publishes_conference_when_all_requirements_met()
    {
        // Test implementation
    }
}
```

### Factory Names
```php
// database/factories/ConferenceFactory.php
class ConferenceFactory extends Factory
{
    protected $model = Conference::class;
    
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'start_date' => $this->faker->dateTimeBetween('now', '+1 month'),
        ];
    }
    
    public function published(): static
    {
        return $this->state(['status' => 'published']);
    }
}
```

---

## 📚 Code Documentation

### Class Documentation
```php
/**
 * Conference management service for handling conference lifecycle operations.
 * 
 * This service provides methods for creating, updating, publishing, and managing
 * conferences within the multi-tenant KongrePad system. It handles business logic
 * validation, event dispatching, and cross-module communication.
 *
 * @package App\Modules\ConferenceCore\Services
 * @author KongrePad Development Team
 * @since 2.0.0
 */
class ConferenceService
{
    /**
     * Create a new conference with optional venues and sessions.
     *
     * @param CreateConferenceRequest $request The validated conference data
     * @return Conference The created conference instance
     * @throws TenantNotFoundException When tenant is not found
     * @throws ValidationException When business rules are violated
     */
    public function createConference(CreateConferenceRequest $request): Conference
    {
        // Implementation
    }
}
```

### Method Documentation
```php
/**
 * Find conferences by status for a specific tenant.
 *
 * @param string $tenantId The UUID of the tenant
 * @param string $status The conference status to filter by
 * @param array $with Optional relationships to eager load
 * @return Collection<Conference> Collection of matching conferences
 */
public function findByTenantAndStatus(string $tenantId, string $status, array $with = []): Collection
{
    return Conference::where('tenant_id', $tenantId)
                    ->where('status', $status)
                    ->with($with)
                    ->orderBy('start_date')
                    ->get();
}
```

---

## 🔄 Git & Version Control

### Branch Naming
```bash
# Feature branches
feature/conference-management
feature/user-authentication
feature/real-time-polling

# Bug fix branches  
bugfix/session-timezone-handling
bugfix/notification-delivery
bugfix/qr-code-generation

# Hot fix branches
hotfix/security-vulnerability
hotfix/database-performance

# Release branches
release/v2.1.0
release/v2.2.0
```

### Commit Messages
```bash
# Format: type(scope): description
feat(conference): add conference publishing functionality
fix(auth): resolve token expiration handling
docs(api): update endpoint documentation
refactor(user): improve user service architecture
test(session): add session scheduling tests
chore(deps): update Laravel to 12.x
style(code): fix PSR-12 formatting issues
perf(database): optimize conference queries
```

### Tag Naming
```bash
# Semantic versioning
v2.0.0    # Major release
v2.1.0    # Minor release  
v2.1.1    # Patch release
v2.2.0-beta.1  # Pre-release
```

---

## 📋 Code Review Checklist

### Naming Standards Compliance
- [ ] All class names follow PascalCase convention
- [ ] All method names follow camelCase convention
- [ ] All database tables use snake_case and are plural
- [ ] All database columns use snake_case
- [ ] All constants use SCREAMING_SNAKE_CASE
- [ ] All file names follow appropriate conventions
- [ ] All route names follow kebab-case convention

### Code Quality Standards
- [ ] Code is written in English only
- [ ] Names are descriptive and self-documenting
- [ ] No abbreviations or unclear acronyms
- [ ] Consistent naming patterns throughout
- [ ] PSR-12 coding standards followed
- [ ] Proper documentation and comments
- [ ] Test coverage for new functionality

---

## 🎯 Best Practices Summary

### Do's ✅
- Use descriptive, self-documenting names
- Follow Laravel's built-in conventions
- Be consistent across the entire codebase
- Use English for all code and documentation
- Follow PSR-12 standards strictly
- Write comprehensive tests
- Document complex business logic

### Don'ts ❌
- Don't use abbreviations or unclear acronyms
- Don't mix naming conventions
- Don't use Turkish or other non-English languages
- Don't skip documentation for public methods
- Don't ignore Laravel's conventions
- Don't use generic names like `data`, `info`, `item`
- Don't create overly long method or class names

---

**📅 Last Updated**: 2024-01-15 16:45 UTC  
**👨‍💻 Maintained By**: KongrePad Development Team  
**📝 Version**: 2.0.0  
**🔗 Related Documents**: 
- [Project Architecture](./PROJECT-ARCHITECTURE.md)
- [Module Specifications](./MODULE-SPECIFICATIONS.md)
- [Migration Implementation Guide](./MIGRATION-IMPLEMENTATION-GUIDE.md)
- [Development Workflow](./DEVELOPMENT-WORKFLOW.md) 