# 🗃️ KongrePad Migration Implementation Guide

> **Enterprise Database Schema Implementation & Best Practices Guide**

[![Migrations](https://img.shields.io/badge/Migrations-42-2563EB?style=for-the-badge)](docs/PROJECT-ARCHITECTURE.md)
[![UUID7](https://img.shields.io/badge/UUID-Version%207-10B981?style=for-the-badge)](https://datatracker.ietf.org/doc/draft-peabody-dispatch-new-uuid-format/)
[![Multi-Tenant](https://img.shields.io/badge/Multi--Tenant-Enterprise-F59E0B?style=for-the-badge)](#multi-tenant-architecture)
[![Performance](https://img.shields.io/badge/Performance-Optimized-EF4444?style=for-the-badge)](#performance-optimization)

---

## 📋 Table of Contents

1. [Migration Architecture](#-migration-architecture)
2. [UUID7 Implementation Strategy](#-uuid7-implementation-strategy)
3. [Multi-Tenant Schema Design](#-multi-tenant-schema-design)
4. [Advanced Indexing Strategies](#-advanced-indexing-strategies)
5. [Data Types & Constraints](#-data-types--constraints)
6. [Migration Best Practices](#-migration-best-practices)
7. [Performance Optimization](#-performance-optimization)
8. [Production Migration Examples](#-production-migration-examples)
9. [Rollback & Recovery Strategies](#-rollback--recovery-strategies)
10. [Testing & Validation](#-testing--validation)
11. [Monitoring & Maintenance](#-monitoring--maintenance)

---

## 🏗️ Migration Architecture

### Enterprise Migration Strategy
The KongrePad migration system follows a **dependency-driven, phase-based approach** designed for zero-downtime deployments and enterprise-scale operations.

### Migration Taxonomy & Numbering
```yaml
Format: YYYY_MM_DD_HHNN_action_resource_table.php

Category System:
  00xx: System Foundation
    - Cache infrastructure (00-09)
    - Job processing (10-19)
    - Session management (20-29)
    - Internationalization (30-39)
    
  01xx: Multi-Tenant Infrastructure
    - Tenant management (00-19)
    - User authentication (20-39)
    - Role & permissions (40-59)
    - System settings (60-79)
    
  02xx: Conference Core Domain
    - Conference entities (00-19)
    - Venue management (20-39)
    - Program structure (40-59)
    - Speaker coordination (60-79)
    
  03xx: Session & Participant Management
    - Session lifecycle (00-19)
    - Participant registration (20-39)
    - Speaker assignments (40-59)
    - Attendance tracking (60-79)
    
  04xx: Interactive Engagement
    - Q&A systems (00-19)
    - Real-time polling (20-39)
    - Survey management (40-59)
    - Response analytics (60-79)
    
  05xx: Content & Communication
    - Document management (00-19)
    - Notification systems (20-39)
    - Communication logs (40-59)
    - Media handling (60-79)
    
  06xx: Display & Presentation
    - Digital signage (00-19)
    - Timer systems (20-39)
    - Screen management (40-59)
    - Layout configuration (60-79)
    
  07xx: Analytics & Intelligence
    - Activity logging (00-19)
    - Performance metrics (20-39)
    - Business intelligence (40-59)
    - Reporting systems (60-79)
    
  08xx: Gamification & Engagement
    - Game mechanics (00-19)
    - Virtual exhibitions (20-39)
    - Achievement systems (40-59)
    - Social features (60-79)
    
  09xx: API & Security Infrastructure
    - Authentication tokens (00-19)
    - Rate limiting (20-39)
    - Audit trails (40-59)
    - Security policies (60-79)
```

### Dependency Graph Implementation
```bash
# Phase 1: Foundation Layer (Critical Path)
2024_01_01_0001_create_system_cache_table.php
2024_01_01_0002_create_system_sessions_table.php
2024_01_01_0003_create_system_jobs_table.php
2024_01_01_0004_create_system_failed_jobs_table.php
2024_01_01_0030_create_system_countries_table.php
2024_01_01_0031_create_system_languages_table.php
2024_01_01_0035_create_system_routes_table.php

# Phase 2: Multi-Tenant Core (High Priority)
2024_01_01_0100_create_tenants_table.php
2024_01_01_0101_create_tenant_settings_table.php
2024_01_01_0120_create_users_table.php
2024_01_01_0121_create_user_roles_table.php
2024_01_01_0160_create_system_settings_table.php
2024_01_01_0170_create_password_reset_tokens_table.php

# Phase 3: Conference Domain (Business Critical)
2024_01_01_0200_create_conferences_table.php
2024_01_01_0220_create_conference_venues_table.php
2024_01_01_0240_create_conference_programs_table.php
2024_01_01_0241_create_conference_program_chairs_table.php

# Continue with remaining phases...
```

---

## 🔑 UUID7 Implementation Strategy

### UUID7 Technical Specification
```yaml
Format Structure:
  - Length: 36 characters (with hyphens) / 32 hex characters
  - Pattern: XXXXXXXX-XXXX-7XXX-XXXX-XXXXXXXXXXXX
  - Time Component: First 48 bits (timestamp in milliseconds)
  - Version: 4 bits (always '7')
  - Random Component: 74 bits of randomness
  
Advantages Over UUID4:
  - Time-ordered: Natural clustering in B-tree indexes
  - Performance: 40% faster range queries
  - Scalability: Simplified database sharding
  - Debugging: Chronological ordering for troubleshooting
  
Database Compatibility:
  - MySQL 8.0+: Native UUID functions
  - PostgreSQL 13+: UUID extension support
  - SQLite 3.38+: Built-in UUID support
```

### Production UUID7 Trait Implementation
```php
<?php

namespace App\Foundation\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

trait HasUuid7
{
    /**
     * Boot the UUID7 trait for the model
     */
    protected static function bootHasUuid7(): void
    {
        static::creating(function (Model $model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = static::generateUuid7();
            }
        });
    }

    /**
     * Get the value indicating whether the IDs are incrementing
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * Get the auto-incrementing key type
     */
    public function getKeyType(): string
    {
        return 'string';
    }

    /**
     * Generate a new UUID7 identifier
     */
    public static function generateUuid7(): string
    {
        // Use Laravel 11+ native UUID7 support if available
        if (method_exists(Str::class, 'uuid7')) {
            return (string) Str::uuid7();
        }
        
        // Use system UUID library if available (optimal performance)
        if (function_exists('uuid_create') && defined('UUID_TYPE_TIME')) {
            return uuid_create(UUID_TYPE_TIME);
        }
        
        // Fallback implementation for older systems
        return static::generateUuid7Fallback();
    }

    /**
     * Fallback UUID7 implementation for older systems
     */
    private static function generateUuid7Fallback(): string
    {
        // Get current timestamp in milliseconds
        $timestamp = intval(microtime(true) * 1000);
        
        // Convert to 48-bit hex (6 bytes)
        $timestampHex = str_pad(dechex($timestamp), 12, '0', STR_PAD_LEFT);
        
        // Generate 12 bytes of random data
        $randomBytes = random_bytes(12);
        $randomHex = bin2hex($randomBytes);
        
        // Set version to 7
        $randomHex[0] = '7';
        
        // Set variant bits (RFC 4122)
        $randomHex[16] = dechex(hexdec($randomHex[16]) & 0x3 | 0x8);
        
        // Format as UUID
        return sprintf(
            '%s-%s-%s-%s-%s',
            substr($timestampHex, 0, 8),
            substr($timestampHex, 8, 4),
            substr($randomHex, 0, 4),
            substr($randomHex, 4, 4),
            substr($randomHex, 8, 12)
        );
    }

    /**
     * Validate UUID7 format
     */
    public static function isValidUuid7(string $uuid): bool
    {
        $pattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-7[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';
        return preg_match($pattern, $uuid) === 1;
    }

    /**
     * Extract timestamp from UUID7
     */
    public static function extractTimestamp(string $uuid7): ?\DateTimeImmutable
    {
        if (!static::isValidUuid7($uuid7)) {
            return null;
        }
        
        $hex = str_replace('-', '', $uuid7);
        $timestampHex = substr($hex, 0, 12);
        $timestamp = hexdec($timestampHex) / 1000;
        
        return new \DateTimeImmutable('@' . $timestamp);
    }
}
```

### Migration Template with UUID7
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations
     */
    public function up(): void
    {
        Schema::create('example_table', function (Blueprint $table) {
            // UUID7 Primary Key
            $table->uuid('id')->primary()->comment('UUID7 primary identifier');
            
            // Multi-tenant isolation (always required)
            $table->uuid('tenant_id')->comment('Tenant isolation key');
            
            // Foreign key relationships
            $table->uuid('parent_id')->nullable()->comment('Parent resource reference');
            
            // Business data columns
            $table->string('title')->comment('Resource title');
            $table->text('description')->nullable()->comment('Detailed description');
            $table->enum('status', ['draft', 'active', 'archived'])->default('draft');
            
            // Audit trail
            $table->uuid('created_by')->nullable()->comment('Creator user ID');
            $table->uuid('updated_by')->nullable()->comment('Last modifier user ID');
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign key constraints with proper cascading
            $table->foreign('tenant_id')
                  ->references('id')
                  ->on('tenants')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
                  
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('example_table')
                  ->onDelete('cascade');
                  
            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
            
            // Performance-optimized indexes
            $table->index(['tenant_id', 'status', 'created_at'], 'idx_tenant_status_date');
            $table->index(['tenant_id', 'parent_id'], 'idx_tenant_hierarchy');
            $table->index(['created_at'], 'idx_chronological');
            $table->index(['updated_at'], 'idx_last_modified');
            
            // Full-text search index
            $table->fullText(['title', 'description'], 'ft_content_search');
        });
        
        // Add table comment
        DB::statement("ALTER TABLE example_table COMMENT = 'Example table with UUID7 and multi-tenant support'");
    }

    /**
     * Reverse the migrations
     */
    public function down(): void
    {
        Schema::dropIfExists('example_table');
    }
};
```

---

## 🏢 Multi-Tenant Schema Design

### Tenant Isolation Strategies

#### 1. Schema-Per-Tenant (Recommended for Large Tenants)
```php
// Dynamic schema selection based on tenant
class TenantAwareConnection
{
    public function connection(string $tenantId): \Illuminate\Database\Connection
    {
        $schemaName = "tenant_{$tenantId}";
        
        return DB::connection('mysql')->useDatabase($schemaName);
    }
}
```

#### 2. Row-Level Security (Recommended for Small-Medium Tenants)
```sql
-- Every business table includes tenant_id with strict isolation
CREATE TABLE conferences (
    id UUID PRIMARY KEY,
    tenant_id UUID NOT NULL COMMENT 'Mandatory tenant isolation',
    
    -- Business columns --
    title VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('draft', 'published', 'ongoing', 'completed', 'cancelled') DEFAULT 'draft',
    
    -- Timestamps
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Multi-tenant constraints
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    
    -- Tenant-optimized indexes
    INDEX idx_tenant_primary (tenant_id, created_at),
    INDEX idx_tenant_status (tenant_id, status),
    INDEX idx_tenant_title (tenant_id, title(50)),
    
    -- Tenant-scoped unique constraints
    UNIQUE KEY unique_tenant_slug (tenant_id, slug)
) ENGINE=InnoDB 
  PARTITION BY HASH(tenant_id) 
  PARTITIONS 16
  COMMENT='Conference management with tenant isolation';
```

### Tenant-Aware Model Implementation
```php
<?php

namespace App\Foundation\Models;

use App\Foundation\Traits\HasUuid7;
use App\Foundation\Traits\BelongsToTenant;
use App\Foundation\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class TenantAwareModel extends Model
{
    use HasUuid7, BelongsToTenant, SoftDeletes;

    /**
     * Boot the model with tenant scope
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);
        
        static::creating(function (Model $model) {
            if (!$model->tenant_id && auth()->check()) {
                $model->tenant_id = auth()->user()->tenant_id;
            }
        });
    }

    /**
     * Get the tenant that owns the record
     */
    public function tenant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Scope query to current tenant
     */
    public function scopeForTenant($query, string $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    /**
     * Override delete to ensure tenant isolation
     */
    public function delete(): ?bool
    {
        if (auth()->user()->tenant_id !== $this->tenant_id) {
            throw new \Illuminate\Auth\Access\AuthorizationException(
                'Cannot delete record from different tenant'
            );
        }
        
        return parent::delete();
    }
}
```

### Global Scope for Tenant Isolation
```php
<?php

namespace App\Foundation\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (auth()->check() && auth()->user()->tenant_id) {
            $builder->where($model->getTable() . '.tenant_id', auth()->user()->tenant_id);
        }
    }

    /**
     * Extend the query builder with the needed functions
     */
    public function extend(Builder $builder): void
    {
        $builder->macro('withoutTenantScope', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });

        $builder->macro('withTenant', function (Builder $builder, string $tenantId) {
            return $builder->withoutGlobalScope($this)
                          ->where($builder->getModel()->getTable() . '.tenant_id', $tenantId);
        });
    }
}
```

---

## 📊 Advanced Indexing Strategies

### Performance-Critical Index Patterns

#### 1. Composite Indexes for Multi-Tenant Queries
```sql
-- Tenant-first indexing (most common pattern)
CREATE INDEX idx_tenant_status_date ON conferences (tenant_id, status, created_at);
CREATE INDEX idx_tenant_conference_session ON conference_sessions (tenant_id, conference_id, start_time);

-- Analytics-optimized indexes
CREATE INDEX idx_participant_activity ON conference_participant_logs 
  (conference_id, participant_id, occurred_at);

-- Search and filter optimization
CREATE INDEX idx_conference_search ON conferences 
  (tenant_id, status, start_date, max_participants);
```

#### 2. Covering Indexes for Read Performance
```sql
-- Include commonly selected columns in index
CREATE INDEX idx_conference_list_covering ON conferences 
  (tenant_id, status, start_date)
  INCLUDE (id, title, max_participants, created_at);
  
-- Session lookup optimization  
CREATE INDEX idx_session_speakers_covering ON conference_session_speakers
  (session_id, type)
  INCLUDE (participant_id, order_index, bio);
```

#### 3. Partial Indexes for Selective Filtering
```sql
-- Index only active records (MySQL 8.0+ / PostgreSQL)
CREATE INDEX idx_active_conferences ON conferences (tenant_id, start_date)
  WHERE status IN ('published', 'ongoing');

-- Index only failed jobs for monitoring
CREATE INDEX idx_failed_jobs_recent ON system_failed_jobs (failed_at, queue)
  WHERE failed_at >= DATE_SUB(NOW(), INTERVAL 7 DAY);
```

#### 4. Full-Text Search Optimization
```sql
-- Multi-column full-text search
ALTER TABLE conferences 
ADD FULLTEXT idx_conference_content (title, description, tags);

-- Language-specific full-text (MySQL 8.0+)
ALTER TABLE conferences 
ADD FULLTEXT idx_conference_english (title, description) WITH PARSER ngram;

-- Search with relevance scoring
SELECT 
    id, title, description,
    MATCH(title, description) AGAINST('technology conference' IN NATURAL LANGUAGE MODE) as relevance_score
FROM conferences 
WHERE MATCH(title, description) AGAINST('technology conference' IN NATURAL LANGUAGE MODE)
    AND tenant_id = ?
ORDER BY relevance_score DESC;
```

### Index Monitoring and Optimization
```sql
-- Monitor index usage (MySQL)
SELECT 
    object_schema,
    object_name,
    index_name,
    count_read,
    count_write,
    sum_timer_read / count_read as avg_read_time
FROM performance_schema.table_io_waits_summary_by_index_usage
WHERE object_schema = 'kongrepad'
ORDER BY count_read DESC;

-- Identify unused indexes
SELECT 
    t.TABLE_SCHEMA,
    t.TABLE_NAME,
    s.INDEX_NAME,
    s.CARDINALITY
FROM information_schema.TABLES t
LEFT JOIN information_schema.STATISTICS s ON t.TABLE_SCHEMA = s.TABLE_SCHEMA 
    AND t.TABLE_NAME = s.TABLE_NAME
LEFT JOIN performance_schema.table_io_waits_summary_by_index_usage i 
    ON s.TABLE_SCHEMA = i.OBJECT_SCHEMA 
    AND s.TABLE_NAME = i.OBJECT_NAME 
    AND s.INDEX_NAME = i.INDEX_NAME
WHERE t.TABLE_SCHEMA = 'kongrepad'
    AND s.INDEX_NAME IS NOT NULL
    AND (i.count_read IS NULL OR i.count_read = 0)
ORDER BY t.TABLE_NAME, s.INDEX_NAME;
```

---

## 📝 Data Types & Constraints

### Optimized Data Type Selection

#### String Fields with Proper Sizing
```sql
-- Email addresses (RFC 5322 compliant)
email VARCHAR(320) NOT NULL COMMENT 'Max email length per RFC 5322',

-- International phone numbers
phone VARCHAR(20) NULL COMMENT 'E.164 format: +[country][number]',

-- URLs and file paths
website_url VARCHAR(2048) NULL COMMENT 'RFC 3986 compliant URL',
file_path VARCHAR(500) NOT NULL COMMENT 'File system path',

-- Slugs and identifiers
slug VARCHAR(255) NOT NULL COMMENT 'URL-safe identifier',
code CHAR(2) NOT NULL COMMENT 'ISO standard codes',

-- Names and titles
title VARCHAR(255) NOT NULL COMMENT 'Standard title length',
first_name VARCHAR(100) NOT NULL COMMENT 'International name support',
last_name VARCHAR(100) NOT NULL,

-- Language and locale codes
language_code CHAR(2) DEFAULT 'en' COMMENT 'ISO 639-1 language code',
locale_code VARCHAR(10) NOT NULL COMMENT 'Locale identifier (en_US)',
timezone VARCHAR(50) DEFAULT 'UTC' COMMENT 'IANA timezone identifier',
```

#### Enum Fields for Controlled Values
```sql
-- Status enums with clear states
status ENUM('draft', 'published', 'ongoing', 'completed', 'cancelled') 
    DEFAULT 'draft' 
    COMMENT 'Conference lifecycle status',

-- Type classifications
participant_type ENUM('attendee', 'speaker', 'organizer', 'sponsor', 'media') 
    DEFAULT 'attendee'
    COMMENT 'Participant role classification',

-- Venue types for hybrid events
venue_type ENUM('physical', 'virtual', 'hybrid') 
    DEFAULT 'physical'
    COMMENT 'Event delivery format',

-- Subscription tiers
subscription_plan ENUM('basic', 'professional', 'enterprise', 'custom')
    DEFAULT 'basic'
    COMMENT 'Service tier level',
```

#### JSON Fields for Flexible Data
```sql
-- Configuration and settings
settings JSON NULL COMMENT 'Flexible configuration storage',
branding JSON NULL COMMENT 'Custom branding configuration',
metadata JSON NULL COMMENT 'Additional structured data',

-- Social and contact information
social_links JSON NULL COMMENT 'Social media profiles',
contact_info JSON NULL COMMENT 'Structured contact data',

-- Permissions and capabilities
permissions JSON NOT NULL COMMENT 'Role-based permissions array',
features JSON NULL COMMENT 'Available feature flags',

-- Example JSON structure for settings:
/*
{
  "general": {
    "time_format": "24h",
    "date_format": "Y-m-d",
    "week_start": "monday"
  },
  "notifications": {
    "email": true,
    "sms": false,
    "push": true
  },
  "branding": {
    "primary_color": "#2563eb",
    "logo_url": "https://cdn.example.com/logo.png"
  }
}
*/
```

#### Numeric Fields with Precision
```sql
-- Geographic coordinates (decimal degrees)
latitude DECIMAL(10, 8) NULL COMMENT 'Latitude in decimal degrees',
longitude DECIMAL(11, 8) NULL COMMENT 'Longitude in decimal degrees',

-- Financial amounts
price DECIMAL(12, 4) NULL COMMENT 'Price with 4 decimal precision',
discount_amount DECIMAL(10, 2) DEFAULT 0.00 COMMENT 'Discount value',
tax_rate DECIMAL(5, 4) DEFAULT 0.0000 COMMENT 'Tax percentage (0.1234 = 12.34%)',

-- Percentages and rates
completion_rate DECIMAL(5, 2) DEFAULT 0.00 COMMENT 'Percentage (0.00-100.00)',
conversion_rate DECIMAL(8, 6) DEFAULT 0.000000 COMMENT 'Conversion rate',

-- Sizes and quantities
file_size BIGINT UNSIGNED NULL COMMENT 'File size in bytes',
max_participants INT UNSIGNED DEFAULT 1000 COMMENT 'Participant limit',
display_order INT UNSIGNED DEFAULT 999 COMMENT 'Sort order',
```

#### Temporal Data Management
```sql
-- Standard Laravel timestamps
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Record creation time',
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP 
    COMMENT 'Last modification time',

-- Soft delete support
deleted_at TIMESTAMP NULL COMMENT 'Soft delete timestamp',

-- Business-specific temporal fields
scheduled_at TIMESTAMP NULL COMMENT 'Scheduled execution time',
published_at TIMESTAMP NULL COMMENT 'Publication timestamp',
expires_at TIMESTAMP NULL COMMENT 'Expiration timestamp',

-- Event timing
start_date DATE NOT NULL COMMENT 'Event start date',
end_date DATE NOT NULL COMMENT 'Event end date',
start_time TIME NULL COMMENT 'Daily start time',
end_time TIME NULL COMMENT 'Daily end time',

-- Audit timestamps
first_access_at TIMESTAMP NULL COMMENT 'First access time',
last_access_at TIMESTAMP NULL COMMENT 'Most recent access',
last_login_at TIMESTAMP NULL COMMENT 'Last successful login',
```

---

## ✅ Migration Best Practices

### 1. Atomic Migration Design
```php
public function up(): void
{
    DB::transaction(function () {
        // All schema changes in a single transaction
        Schema::create('complex_table', function (Blueprint $table) {
            // Table definition
        });
        
        // Related data seeding
        $this->seedInitialData();
        
        // Index creation (outside transaction for large tables)
    });
    
    // Create indexes after transaction for performance
    $this->createPerformanceIndexes();
}

private function createPerformanceIndexes(): void
{
    // Create indexes concurrently when possible (PostgreSQL)
    if (DB::connection()->getDriverName() === 'pgsql') {
        DB::statement('CREATE INDEX CONCURRENTLY idx_complex_lookup ON complex_table (tenant_id, status)');
    } else {
        Schema::table('complex_table', function (Blueprint $table) {
            $table->index(['tenant_id', 'status'], 'idx_complex_lookup');
        });
    }
}
```

### 2. Backward-Compatible Changes
```php
public function up(): void
{
    // Step 1: Add new column as nullable
    Schema::table('conferences', function (Blueprint $table) {
        $table->string('new_field')->nullable()->after('title');
    });
    
    // Step 2: Populate existing records with default values
    DB::table('conferences')
      ->whereNull('new_field')
      ->update(['new_field' => 'default_value']);
    
    // Step 3: Make field required after data population
    Schema::table('conferences', function (Blueprint $table) {
        $table->string('new_field')->nullable(false)->change();
    });
}
```

### 3. Data Migration with Validation
```php
public function up(): void
{
    // Create new optimized table
    Schema::create('conferences_v2', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('tenant_id');
        $table->string('title');
        $table->json('metadata')->nullable();
        $table->timestamps();
        
        $table->foreign('tenant_id')->references('id')->on('tenants');
        $table->index(['tenant_id', 'created_at']);
    });
    
    // Migrate data with validation and transformation
    $this->migrateDataWithValidation();
    
    // Verify data integrity
    $this->verifyDataIntegrity();
}

private function migrateDataWithValidation(): void
{
    DB::table('conferences')->orderBy('id')->chunk(1000, function ($conferences) {
        $batch = [];
        
        foreach ($conferences as $conference) {
            // Validate and transform data
            $transformedData = $this->transformConferenceData($conference);
            
            if ($this->validateConferenceData($transformedData)) {
                $batch[] = $transformedData;
            } else {
                Log::warning("Skipping invalid conference data", ['id' => $conference->id]);
            }
        }
        
        if (!empty($batch)) {
            DB::table('conferences_v2')->insert($batch);
        }
    });
}

private function transformConferenceData(object $conference): array
{
    return [
        'id' => $conference->id,
        'tenant_id' => $conference->tenant_id,
        'title' => $conference->title,
        'metadata' => json_encode([
            'old_description' => $conference->description,
            'migrated_at' => now()->toISOString(),
        ]),
        'created_at' => $conference->created_at,
        'updated_at' => now(),
    ];
}

private function validateConferenceData(array $data): bool
{
    return !empty($data['title']) && 
           !empty($data['tenant_id']) && 
           Str::isUuid($data['id']);
}

private function verifyDataIntegrity(): void
{
    $oldCount = DB::table('conferences')->count();
    $newCount = DB::table('conferences_v2')->count();
    
    if ($oldCount !== $newCount) {
        throw new \Exception("Data migration failed: Expected {$oldCount} records, got {$newCount}");
    }
    
    Log::info("Data migration completed successfully", [
        'migrated_records' => $newCount
    ]);
}
```

### 4. Large Table Modifications
```php
public function up(): void
{
    // For tables with millions of records, use online DDL
    if ($this->isLargeTable('conference_participant_logs')) {
        $this->performOnlineDDL();
    } else {
        $this->performStandardMigration();
    }
}

private function performOnlineDDL(): void
{
    // MySQL 8.0+ online DDL
    DB::statement('
        ALTER TABLE conference_participant_logs 
        ADD COLUMN session_duration_minutes INT UNSIGNED NULL,
        ALGORITHM=INPLACE, LOCK=NONE
    ');
    
    // Update in batches to avoid long locks
    $this->updateInBatches();
}

private function updateInBatches(): void
{
    $batchSize = 10000;
    $offset = 0;
    
    do {
        $updated = DB::table('conference_participant_logs')
            ->whereNull('session_duration_minutes')
            ->limit($batchSize)
            ->update([
                'session_duration_minutes' => DB::raw('
                    TIMESTAMPDIFF(MINUTE, created_at, updated_at)
                ')
            ]);
        
        $offset += $batchSize;
        
        // Small delay to avoid overwhelming the database
        usleep(100000); // 100ms
        
    } while ($updated > 0);
}

private function isLargeTable(string $tableName): bool
{
    $rowCount = DB::table($tableName)->count();
    return $rowCount > 1000000; // 1 million rows threshold
}
```

---

## ⚡ Performance Optimization

### Query Performance Monitoring
```php
// Add to migration for performance tracking
public function up(): void
{
    $startTime = microtime(true);
    $startMemory = memory_get_usage(true);
    
    Schema::create('large_analytics_table', function (Blueprint $table) {
        // Table definition
    });
    
    $endTime = microtime(true);
    $endMemory = memory_get_usage(true);
    
    Log::info("Migration performance metrics", [
        'migration' => class_basename(static::class),
        'execution_time_seconds' => round($endTime - $startTime, 2),
        'memory_usage_mb' => round(($endMemory - $startMemory) / 1024 / 1024, 2),
        'peak_memory_mb' => round(memory_get_peak_usage(true) / 1024 / 1024, 2),
    ]);
}
```

### Batch Processing for Large Datasets
```php
public function up(): void
{
    Schema::create('new_optimized_table', function (Blueprint $table) {
        // Optimized schema
    });
    
    // Process in batches for memory efficiency
    $this->migrateInBatches('old_table', 'new_optimized_table', 5000);
}

private function migrateInBatches(string $sourceTable, string $targetTable, int $batchSize): void
{
    $totalRecords = DB::table($sourceTable)->count();
    $processed = 0;
    
    DB::table($sourceTable)
      ->orderBy('id')
      ->chunk($batchSize, function ($records) use ($targetTable, &$processed, $totalRecords) {
          $transformedRecords = $records->map(function ($record) {
              return $this->transformRecord($record);
          })->toArray();
          
          DB::table($targetTable)->insert($transformedRecords);
          
          $processed += count($records);
          $percentage = round(($processed / $totalRecords) * 100, 2);
          
          Log::info("Migration progress: {$percentage}% ({$processed}/{$totalRecords})");
      });
}
```

### Index Creation Strategy
```php
public function up(): void
{
    // Create table without indexes first
    Schema::create('high_volume_table', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('tenant_id');
        $table->string('title');
        $table->text('content');
        $table->timestamps();
        
        // Only add foreign key constraints, not indexes yet
        $table->foreign('tenant_id')->references('id')->on('tenants');
    });
    
    // Add indexes after table creation for better performance
    $this->addIndexesAsync();
}

private function addIndexesAsync(): void
{
    $indexes = [
        ['columns' => ['tenant_id', 'created_at'], 'name' => 'idx_tenant_chronological'],
        ['columns' => ['tenant_id', 'title'], 'name' => 'idx_tenant_title'],
        ['fulltext' => ['title', 'content'], 'name' => 'ft_content_search'],
    ];
    
    foreach ($indexes as $index) {
        if (isset($index['fulltext'])) {
            DB::statement("
                ALTER TABLE high_volume_table 
                ADD FULLTEXT {$index['name']} (" . implode(', ', $index['fulltext']) . ")
            ");
        } else {
            Schema::table('high_volume_table', function (Blueprint $table) use ($index) {
                $table->index($index['columns'], $index['name']);
            });
        }
        
        Log::info("Created index: {$index['name']}");
    }
}
```

---

## 📋 Production Migration Examples

### 1. System Core Migration
```php
<?php
// 2024_01_01_0005_create_system_countries_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_countries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->char('code', 2)->unique();
            $table->string('phone_code', 10)->nullable();
            $table->string('flag_emoji', 10)->nullable();
            $table->char('currency_code', 3)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Indexes
            $table->index(['is_active']);
            $table->index(['code']);
        });
        
        // Seed initial data
        $this->seedCountries();
    }
    
    private function seedCountries(): void
    {
        $countries = [
            ['name' => 'Turkey', 'code' => 'TR', 'phone_code' => '+90', 'currency_code' => 'TRY'],
            ['name' => 'United States', 'code' => 'US', 'phone_code' => '+1', 'currency_code' => 'USD'],
            // ... more countries
        ];
        
        foreach ($countries as $country) {
            DB::table('system_countries')->insert([
                'id' => Str::uuid7(),
                'name' => $country['name'],
                'code' => $country['code'],
                'phone_code' => $country['phone_code'],
                'currency_code' => $country['currency_code'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('system_countries');
    }
};
```

### 2. Conference Core Migration
```php
<?php
// 2024_01_01_0201_create_conferences_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conferences', function (Blueprint $table) {
            // Primary Key
            $table->uuid('id')->primary();
            
            // Foreign Keys
            $table->uuid('tenant_id');
            $table->uuid('created_by')->nullable();
            
            // Basic Information
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            
            // Dates and Times
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('timezone', 50)->default('Europe/Istanbul');
            
            // Status and Settings
            $table->enum('status', ['draft', 'published', 'ongoing', 'completed', 'cancelled'])->default('draft');
            $table->integer('max_participants')->default(1000);
            
            // Registration
            $table->timestamp('registration_start_date')->nullable();
            $table->timestamp('registration_end_date')->nullable();
            
            // Media
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->string('website_url')->nullable();
            
            // JSON Data
            $table->json('social_links')->nullable();
            $table->json('contact_info')->nullable();
            $table->json('tags')->nullable();
            
            // Visibility
            $table->boolean('is_public')->default(true);
            
            // Timestamps
            $table->timestamps();
            
            // Foreign Key Constraints
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            
            // Indexes
            $table->index(['tenant_id']);
            $table->index(['tenant_id', 'status']);
            $table->index(['tenant_id', 'start_date']);
            $table->index(['is_public', 'status']);
            $table->index(['created_at']);
            
            // Full-text search
            $table->fullText(['title', 'description']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conferences');
    }
};
```

### 3. Polymorphic Relationship Migration
```php
<?php
// 2024_01_01_0701_create_conference_participant_logs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conference_participant_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Required references
            $table->uuid('conference_id');
            $table->uuid('participant_id')->nullable();
            $table->uuid('session_id')->nullable();
            
            // Log data
            $table->string('action', 100);
            $table->json('details')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('occurred_at')->useCurrent();
            
            // Standard timestamp
            $table->timestamp('created_at')->useCurrent();
            
            // Foreign Keys
            $table->foreign('conference_id')->references('id')->on('conferences')->onDelete('cascade');
            $table->foreign('participant_id')->references('id')->on('conference_participants')->onDelete('cascade');
            $table->foreign('session_id')->references('id')->on('conference_sessions')->onDelete('cascade');
            
            // Performance Indexes
            $table->index(['conference_id', 'occurred_at']);
            $table->index(['participant_id', 'occurred_at']);
            $table->index(['session_id', 'occurred_at']);
            $table->index(['action']);
            $table->index(['occurred_at']);
            
            // Partitioning hint for large datasets
            $table->index(['conference_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conference_participant_logs');
    }
};
```

---

## 🔄 Rollback & Recovery Strategies

### Safe Rollback Pattern
```php
public function down(): void
{
    // Check for data before dropping
    if (Schema::hasTable('table_name')) {
        $count = DB::table('table_name')->count();
        
        if ($count > 0) {
            throw new Exception("Cannot rollback: Table contains {$count} records");
        }
        
        Schema::dropIfExists('table_name');
    }
}
```

### Data Preservation Rollback
```php
public function down(): void
{
    // Create backup before rollback
    DB::statement('CREATE TABLE table_name_backup AS SELECT * FROM table_name');
    
    // Log the rollback
    Log::warning('Rolling back migration: creating backup table_name_backup');
    
    // Drop the table
    Schema::dropIfExists('table_name');
}
```

### Column Removal Rollback
```php
public function down(): void
{
    Schema::table('conferences', function (Blueprint $table) {
        // Add back the removed column
        $table->string('old_column')->nullable();
    });
    
    // Restore data if backup exists
    if (Schema::hasTable('conferences_backup')) {
        DB::statement('
            UPDATE conferences c
            SET old_column = (
                SELECT old_column 
                FROM conferences_backup cb 
                WHERE cb.id = c.id
            )
        ');
    }
}
```

---

## 🛠️ Development Tools

### Migration Generator Command
```bash
# Standard migration
php artisan make:migration create_table_name_table

# With model
php artisan make:model ModelName -m

# With factory and seeder
php artisan make:model ModelName -mfs

# Custom stub
php artisan make:migration create_table_name_table --path=database/migrations/modules/conference
```

### Migration Status Commands
```bash
# Check migration status
php artisan migrate:status

# Show last batch
php artisan migrate:status --pending

# Dry run
php artisan migrate --pretend

# Rollback last batch
php artisan migrate:rollback

# Reset all migrations
php artisan migrate:reset

# Fresh migration with seeding
php artisan migrate:fresh --seed
```

---

## 🔍 Testing & Validation

### Migration Tests
```php
<?php
// tests/Feature/MigrationsTest.php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

class MigrationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_conferences_table_with_correct_structure()
    {
        $this->assertTrue(Schema::hasTable('conferences'));
        
        $columns = Schema::getColumnListing('conferences');
        $expectedColumns = [
            'id', 'tenant_id', 'title', 'status', 'created_at', 'updated_at'
        ];
        
        foreach ($expectedColumns as $column) {
            $this->assertContains($column, $columns);
        }
    }

    /** @test */
    public function it_has_correct_foreign_keys()
    {
        $foreignKeys = Schema::getForeignKeys('conferences');
        
        $tenantForeignKey = collect($foreignKeys)->first(function ($key) {
            return $key['columns'] === ['tenant_id'];
        });
        
        $this->assertNotNull($tenantForeignKey);
        $this->assertEquals('tenants', $tenantForeignKey['foreign_table']);
        $this->assertEquals(['id'], $tenantForeignKey['foreign_columns']);
    }

    /** @test */
    public function it_can_rollback_migrations()
    {
        // Run specific migration
        $this->artisan('migrate:rollback', ['--step' => 1]);
        
        // Check table is dropped
        $this->assertFalse(Schema::hasTable('conferences'));
        
        // Re-run migration
        $this->artisan('migrate');
        
        // Check table is back
        $this->assertTrue(Schema::hasTable('conferences'));
    }
}
```

---

## 📈 Monitoring & Maintenance

### Migration Performance Monitoring
```php
// Add to migration
public function up(): void
{
    $startTime = microtime(true);
    
    Schema::create('large_table', function (Blueprint $table) {
        // ... definition
    });
    
    $endTime = microtime(true);
    $duration = $endTime - $startTime;
    
    Log::info("Migration completed", [
        'migration' => basename(__FILE__),
        'duration' => $duration,
        'memory_peak' => memory_get_peak_usage(true),
    ]);
}
```

### Health Checks
```php
// Check for missing indexes
public function checkMissingIndexes(): array
{
    $missingIndexes = [];
    
    // Check tenant_id indexes
    $tables = DB::select('SHOW TABLES');
    foreach ($tables as $table) {
        $tableName = array_values((array) $table)[0];
        
        if (Schema::hasColumn($tableName, 'tenant_id')) {
            $indexes = DB::select("SHOW INDEX FROM {$tableName}");
            $hasTenantIndex = collect($indexes)->contains('Column_name', 'tenant_id');
            
            if (!$hasTenantIndex) {
                $missingIndexes[] = "{$tableName}.tenant_id";
            }
        }
    }
    
    return $missingIndexes;
}
```

---

## 📝 Conclusion

This comprehensive migration implementation guide provides enterprise-ready strategies for building scalable, multi-tenant database architectures with Laravel. The UUID7 implementation, advanced indexing strategies, and performance optimization techniques ensure your KongrePad system can handle large-scale operations while maintaining data integrity and optimal performance.

The phased migration approach, combined with proper testing and rollback strategies, enables safe deployment to production environments with minimal downtime.

---

**📅 Last Updated**: 2024-01-15 16:45 UTC  
**👨‍💻 Maintained By**: KongrePad Development Team  
**📝 Version**: 2.0.0  
**🔗 Related Documents**: 
- [Project Architecture](./PROJECT-ARCHITECTURE.md)
- [Module Specifications](./MODULE-SPECIFICATIONS.md)
- [Laravel Naming Standards](./LARAVEL-NAMING-STANDARDS.md)
- [Development Workflow](./DEVELOPMENT-WORKFLOW.md) 