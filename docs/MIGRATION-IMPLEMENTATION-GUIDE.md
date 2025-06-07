# 🗃️ KongrePad Migration Implementation Guide

> **Database şeması implementasyonu ve en iyi uygulamalar rehberi**

[![Migrations](https://img.shields.io/badge/Migrations-42-blue.svg)](#)
[![UUID7](https://img.shields.io/badge/UUID-Version%207-green.svg)](#)
[![Multi-Tenant](https://img.shields.io/badge/Multi--Tenant-Ready-orange.svg)](#)

---

## 📋 İçindekiler

1. [Migration Stratejisi](#-migration-stratejisi)
2. [UUID7 Implementation](#-uuid7-implementation)
3. [Multi-Tenant Schema](#-multi-tenant-schema)
4. [Foreign Key Patterns](#-foreign-key-patterns)
5. [Index Optimization](#-index-optimization)
6. [Data Types ve Constraints](#-data-types-ve-constraints)
7. [Migration Best Practices](#-migration-best-practices)
8. [Performance Considerations](#-performance-considerations)
9. [Migration Examples](#-migration-examples)
10. [Rollback Strategies](#-rollback-strategies)

---

## 🚀 Migration Stratejisi

### Numaralandırma Sistemi
```
Format: YYYY_MM_DD_HHNN_action_table_table.php

Kategoriler:
00xx - System Foundation (Cache, Jobs, Sessions)
01xx - Core Infrastructure (Tenants, Users, Settings)
02xx - Conference Management (Conferences, Venues, Programs)
03xx - Session & Speaker Management
04xx - Interactive Features (Q&A, Polls, Surveys)
05xx - Document & Notification Management
06xx - Display Management (Screens, Timers)
07xx - Analytics & Logging
08xx - Gamification (Debates, Games, Virtual Stands)
09xx - API & Authentication
```

### Migration Order (Dependency-based)
```bash
# Phase 1: Foundation
2024_01_01_0001_create_system_cache_table.php
2024_01_01_0002_create_system_sessions_table.php
2024_01_01_0003_create_system_jobs_table.php
2024_01_01_0004_create_system_failed_jobs_table.php
2024_01_01_0005_create_system_countries_table.php
2024_01_01_0006_create_system_languages_table.php
2024_01_01_0007_create_system_routes_table.php

# Phase 2: Core
2024_01_01_0101_create_tenants_table.php
2024_01_01_0102_create_users_table.php
2024_01_01_0103_create_user_roles_table.php
2024_01_01_0104_create_system_settings_table.php
2024_01_01_0105_create_tenant_settings_table.php
2024_01_01_0106_create_password_reset_tokens_table.php

# Phase 3: Conference Core
2024_01_01_0201_create_conferences_table.php
2024_01_01_0202_create_conference_venues_table.php
# ... ve devamı
```

---

## 🔑 UUID7 Implementation

### UUID7 Trait
```php
// app/Traits/HasUuid7.php
<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasUuid7
{
    protected static function bootHasUuid7(): void
    {
        static::creating(function (Model $model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = self::generateUuid7();
            }
        });
    }

    public function getIncrementing(): bool
    {
        return false;
    }

    public function getKeyType(): string
    {
        return 'string';
    }

    public static function generateUuid7(): string
    {
        // UUID7 implementation
        return Str::uuid7();
    }
}
```

### Migration Template
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('table_name', function (Blueprint $table) {
            // Primary Key - UUID7
            $table->uuid('id')->primary();
            
            // Foreign Keys - UUID7
            $table->uuid('tenant_id');
            $table->uuid('parent_id')->nullable();
            
            // Content fields
            // ...
            
            // Timestamps
            $table->timestamps();
            
            // Foreign Key Constraints
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('parent_table')->onDelete('cascade');
            
            // Indexes
            $table->index(['tenant_id']);
            $table->index(['created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('table_name');
    }
};
```

---

## 🏢 Multi-Tenant Schema

### Tenant Isolation Pattern
```php
// Her tabloda tenant_id zorunlu
Schema::create('conferences', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->uuid('tenant_id'); // Her zaman gerekli
    
    // Content fields
    $table->string('title');
    $table->text('description')->nullable();
    
    // Timestamps
    $table->timestamps();
    
    // Foreign Keys
    $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
    
    // Tenant-based Indexes
    $table->index(['tenant_id', 'created_at']);
    $table->index(['tenant_id', 'status']);
    
    // Unique Constraints (tenant-scoped)
    $table->unique(['tenant_id', 'slug']);
});
```

### Global Scope Implementation
```php
// app/Models/Conference.php
<?php

namespace App\Models;

use App\Traits\HasUuid7;
use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    use HasUuid7;

    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);
    }

    // Relationships
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
```

---

## 🔗 Foreign Key Patterns

### Standard Foreign Key
```php
Schema::create('conference_sessions', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->uuid('conference_id');
    $table->uuid('venue_id')->nullable();
    
    // Content
    $table->string('title');
    $table->text('description')->nullable();
    
    $table->timestamps();
    
    // Foreign Key Constraints with Cascade
    $table->foreign('conference_id')
          ->references('id')
          ->on('conferences')
          ->onDelete('cascade');
          
    $table->foreign('venue_id')
          ->references('id')
          ->on('conference_venues')
          ->onDelete('set null');
});
```

### Polymorphic Relationships
```php
Schema::create('conference_logs', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->uuid('tenant_id');
    
    // Polymorphic fields
    $table->string('loggable_type');
    $table->uuid('loggable_id');
    
    $table->string('action');
    $table->json('data')->nullable();
    $table->timestamp('occurred_at');
    
    $table->timestamps();
    
    // Indexes for polymorphic relationship
    $table->index(['loggable_type', 'loggable_id']);
    $table->index(['tenant_id', 'occurred_at']);
});
```

### Pivot Tables
```php
Schema::create('conference_session_speakers', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->uuid('session_id');
    $table->uuid('participant_id');
    
    // Pivot specific fields
    $table->enum('type', ['primary', 'co-speaker', 'moderator', 'panelist'])->default('primary');
    $table->integer('order_index')->default(0);
    $table->text('bio')->nullable();
    $table->json('social_links')->nullable();
    
    $table->timestamps();
    
    // Foreign Keys
    $table->foreign('session_id')->references('id')->on('conference_sessions')->onDelete('cascade');
    $table->foreign('participant_id')->references('id')->on('conference_participants')->onDelete('cascade');
    
    // Unique constraint to prevent duplicates
    $table->unique(['session_id', 'participant_id']);
    
    // Indexes
    $table->index(['session_id']);
    $table->index(['participant_id']);
});
```

---

## 📊 Index Optimization

### Primary Indexes
```php
// Performance-critical indexes
$table->index(['tenant_id']); // Tenant filtering
$table->index(['created_at']); // Sorting
$table->index(['updated_at']); // Recent changes
$table->index(['status']); // Status filtering
```

### Composite Indexes
```php
// Multi-column indexes for complex queries
$table->index(['tenant_id', 'conference_id']); // Tenant + Conference filtering
$table->index(['tenant_id', 'status', 'created_at']); // Tenant + Status + Time
$table->index(['conference_id', 'start_time']); // Conference sessions by time
$table->index(['participant_id', 'created_at']); // User activity timeline
```

### Full-Text Search Indexes
```php
// For search functionality
Schema::create('conferences', function (Blueprint $table) {
    // ... other columns
    
    $table->string('title');
    $table->text('description')->nullable();
    $table->json('tags')->nullable();
    
    // Full-text search index
    $table->fullText(['title', 'description']);
});
```

---

## 📝 Data Types ve Constraints

### String Fields
```php
// Optimized string lengths
$table->string('title', 255); // Standard title
$table->string('slug', 255); // URL slug
$table->string('email', 320); // RFC compliant email
$table->string('phone', 20); // International phone
$table->char('language_code', 2); // ISO language code
$table->char('country_code', 2); // ISO country code
$table->string('timezone', 50); // Timezone identifier
```

### Enum Fields
```php
// Status enums
$table->enum('status', ['draft', 'published', 'ongoing', 'completed', 'cancelled'])->default('draft');
$table->enum('type', ['physical', 'virtual', 'hybrid'])->default('physical');
$table->enum('level', ['beginner', 'intermediate', 'advanced'])->default('intermediate');
```

### JSON Fields
```php
// Structured data
$table->json('settings')->nullable(); // Configuration
$table->json('metadata')->nullable(); // Additional data
$table->json('social_links')->nullable(); // Social media links
$table->json('contact_info')->nullable(); // Contact information
$table->json('permissions')->nullable(); // User permissions
```

### Decimal ve Numeric Fields
```php
// Geographic coordinates
$table->decimal('latitude', 10, 8)->nullable();
$table->decimal('longitude', 11, 8)->nullable();

// Financial data
$table->decimal('price', 10, 2)->nullable();
$table->decimal('discount_amount', 8, 2)->default(0);

// Percentages
$table->decimal('completion_rate', 5, 2)->default(0); // 0.00-100.00
```

---

## ✅ Migration Best Practices

### 1. Atomic Migrations
```php
public function up(): void
{
    DB::transaction(function () {
        Schema::create('table_name', function (Blueprint $table) {
            // Table definition
        });
        
        // Related operations
        DB::statement('CREATE INDEX CONCURRENTLY...');
    });
}
```

### 2. Backward Compatibility
```php
public function up(): void
{
    Schema::table('conferences', function (Blueprint $table) {
        $table->string('new_field')->nullable()->after('title');
    });
    
    // Set default values for existing records
    DB::table('conferences')->whereNull('new_field')->update([
        'new_field' => 'default_value'
    ]);
    
    // Make field required after setting defaults
    Schema::table('conferences', function (Blueprint $table) {
        $table->string('new_field')->nullable(false)->change();
    });
}
```

### 3. Data Migration
```php
public function up(): void
{
    // Create new table
    Schema::create('new_table', function (Blueprint $table) {
        // ... definition
    });
    
    // Migrate data from old structure
    $oldData = DB::table('old_table')->get();
    
    foreach ($oldData as $record) {
        DB::table('new_table')->insert([
            'id' => Str::uuid7(),
            'migrated_field' => $record->old_field,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
```

### 4. Safe Column Changes
```php
public function up(): void
{
    // Add new column
    Schema::table('conferences', function (Blueprint $table) {
        $table->string('new_title')->nullable()->after('title');
    });
    
    // Copy data
    DB::update('UPDATE conferences SET new_title = title');
    
    // Remove old column
    Schema::table('conferences', function (Blueprint $table) {
        $table->dropColumn('title');
    });
    
    // Rename new column
    Schema::table('conferences', function (Blueprint $table) {
        $table->renameColumn('new_title', 'title');
    });
}
```

---

## ⚡ Performance Considerations

### Large Table Migrations
```php
public function up(): void
{
    // For large tables, use raw SQL
    DB::statement('
        CREATE TABLE large_table_new AS 
        SELECT 
            id,
            CAST(id AS CHAR(36)) as uuid_id,
            other_columns
        FROM large_table
    ');
    
    // Add indexes after data insertion
    DB::statement('ALTER TABLE large_table_new ADD PRIMARY KEY (uuid_id)');
    DB::statement('CREATE INDEX idx_created_at ON large_table_new (created_at)');
}
```

### Batch Processing
```php
public function up(): void
{
    Schema::create('new_table', function (Blueprint $table) {
        // ... definition
    });
    
    // Process in batches
    DB::table('source_table')
      ->orderBy('id')
      ->chunk(1000, function ($records) {
          $insertData = $records->map(function ($record) {
              return [
                  'id' => Str::uuid7(),
                  'data' => $record->data,
                  'created_at' => now(),
              ];
          })->toArray();
          
          DB::table('new_table')->insert($insertData);
      });
}
```

---

## 📋 Migration Examples

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

## 🔄 Rollback Strategies

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

## 🔍 Testing Migrations

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

## 📈 Monitoring ve Maintenance

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

**📅 Son Güncelleme**: {{ date('Y-m-d') }}  
**👨‍💻 Hazırlayan**: KongrePad Development Team  
**📝 Versiyon**: 1.0.0  
**🔗 İlgili Dokümanlar**: 
- [Project Architecture](./PROJECT-ARCHITECTURE.md)
- [Module Specifications](./MODULES-SPECIFICATION.md)
- [Laravel Naming Standards](../README-LARAVEL-NAMING-STANDARDS.md) 