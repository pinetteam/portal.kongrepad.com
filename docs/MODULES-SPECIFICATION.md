# 📦 KongrePad Module Specifications

> **Comprehensive Module Analysis & Implementation Guide for Enterprise Conference Management System**

[![Modules](https://img.shields.io/badge/Modules-11-2563EB?style=for-the-badge)](docs/PROJECT-ARCHITECTURE.md)
[![Database](https://img.shields.io/badge/Tables-42-10B981?style=for-the-badge)](#database-overview)
[![Architecture](https://img.shields.io/badge/Architecture-Modular-F59E0B?style=for-the-badge)](#modular-architecture)
[![API](https://img.shields.io/badge/API-RESTful-EF4444?style=for-the-badge)](#api-specifications)

---

## 📋 Table of Contents

1. [Module Overview](#-module-overview)
2. [System Foundation Module](#1--system-foundation-module)
3. [Multi-Tenant Infrastructure Module](#2--multi-tenant-infrastructure-module)
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

## 🎯 Module Overview

### Architecture Philosophy
The KongrePad system follows a **Domain-Driven Design (DDD)** approach with clear module boundaries, single responsibilities, and well-defined interfaces. Each module encapsulates a specific business domain and can be developed, tested, and deployed independently.

### Module Interaction Matrix
```
┌─────────────────────────────────────────────────────────────────┐
│                    Module Dependency Graph                     │
├─────────────────────────────────────────────────────────────────┤
│ System Foundation (Core Infrastructure)                        │
│     ↓                                                           │
│ Multi-Tenant Infrastructure                                     │
│     ↓                                                           │
│ User Management & API Security                                  │
│     ↓                                                           │
│ Conference Core ←→ Interactive Features                         │
│     ↓                    ↓                                      │
│ Content Management ←→ Analytics & Logging                       │
│     ↓                    ↓                                      │
│ Display Management ←→ Gamification                              │
└─────────────────────────────────────────────────────────────────┘
```

### Database Overview
```yaml
Total Tables: 42
Distribution:
  - System Foundation: 7 tables (16.7%)
  - Multi-Tenant Infrastructure: 6 tables (14.3%)
  - Conference Core: 7 tables (16.7%)
  - Interactive Features: 12 tables (28.6%)
  - Content & Analytics: 8 tables (19.0%)
  - Gamification: 8 tables (19.0%)
  - API Security: 1 table (2.4%)

Key Characteristics:
  - UUID7 primary keys throughout
  - Multi-tenant isolation via tenant_id
  - Comprehensive indexing strategy
  - Foreign key constraints with cascading
  - JSON columns for flexible data storage
```

---

## 1. 🔧 System Foundation Module

### Purpose & Scope
**Core Infrastructure Services**: Provides fundamental platform capabilities including caching, job processing, internationalization, and system health monitoring.

### Database Schema Design

#### system_cache
```sql
-- High-performance application cache storage
CREATE TABLE system_cache (
    `key` VARCHAR(255) PRIMARY KEY COMMENT 'Unique cache key identifier',
    `value` MEDIUMTEXT NOT NULL COMMENT 'Serialized cache value',
    `expiration` INT(11) NOT NULL COMMENT 'Unix timestamp for expiration',
    
    INDEX idx_expiration (expiration),
    INDEX idx_key_prefix (`key`(50))
) ENGINE=InnoDB COMMENT='Application-level cache storage';
```

#### system_jobs
```sql
-- Queue job management and processing
CREATE TABLE system_jobs (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    queue VARCHAR(255) NOT NULL DEFAULT 'default',
    payload LONGTEXT NOT NULL COMMENT 'Serialized job data',
    attempts TINYINT UNSIGNED NOT NULL DEFAULT 0,
    reserved_at INT UNSIGNED NULL COMMENT 'Job reservation timestamp',
    available_at INT UNSIGNED NOT NULL COMMENT 'Job availability timestamp',
    created_at INT UNSIGNED NOT NULL,
    
    INDEX idx_queue_available (queue, available_at),
    INDEX idx_queue_reserved (queue, reserved_at),
    INDEX idx_attempts (attempts)
) ENGINE=InnoDB COMMENT='Background job queue management';
```

#### system_countries
```sql
-- International country data (162 countries)
CREATE TABLE system_countries (
    id UUID PRIMARY KEY,
    name VARCHAR(255) NOT NULL COMMENT 'Country full name',
    code CHAR(2) UNIQUE NOT NULL COMMENT 'ISO 3166-1 alpha-2 code',
    phone_code VARCHAR(10) NULL COMMENT 'International dialing code',
    flag_emoji VARCHAR(10) NULL COMMENT 'Unicode flag emoji',
    currency_code CHAR(3) NULL COMMENT 'ISO 4217 currency code',
    timezone_count TINYINT UNSIGNED DEFAULT 1 COMMENT 'Number of timezones',
    is_active BOOLEAN DEFAULT TRUE COMMENT 'Active status flag',
    display_order INT UNSIGNED DEFAULT 999 COMMENT 'UI display ordering',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_active_order (is_active, display_order),
    INDEX idx_code_lookup (code),
    FULLTEXT idx_country_search (name)
) ENGINE=InnoDB COMMENT='International country reference data';
```

#### system_languages
```sql
-- Multi-language support configuration
CREATE TABLE system_languages (
    id UUID PRIMARY KEY,
    name VARCHAR(255) NOT NULL COMMENT 'Language name in English',
    native_name VARCHAR(255) NOT NULL COMMENT 'Language name in native script',
    code CHAR(2) UNIQUE NOT NULL COMMENT 'ISO 639-1 language code',
    locale_code VARCHAR(10) NOT NULL COMMENT 'Full locale identifier (e.g., en_US)',
    is_rtl BOOLEAN DEFAULT FALSE COMMENT 'Right-to-left text direction',
    is_active BOOLEAN DEFAULT TRUE COMMENT 'Language availability status',
    completion_percentage DECIMAL(5,2) DEFAULT 0.00 COMMENT 'Translation completion',
    display_order INT UNSIGNED DEFAULT 999 COMMENT 'UI display ordering',
    flag_emoji VARCHAR(10) NULL COMMENT 'Representative flag emoji',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_active_order (is_active, display_order),
    INDEX idx_locale_lookup (locale_code),
    INDEX idx_rtl_languages (is_rtl, is_active)
) ENGINE=InnoDB COMMENT='Multi-language and localization support';
```

### Business Logic & Services

#### CacheService Implementation
```php
<?php

namespace App\Modules\SystemCore\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class CacheService
{
    private const DEFAULT_TTL = 3600; // 1 hour
    private const CACHE_PREFIX = 'kongrepad:';
    
    public function __construct(
        private Redis $redis
    ) {}
    
    /**
     * Get cached value with automatic serialization
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $value = Cache::get(self::CACHE_PREFIX . $key);
        
        if ($value === null && $default !== null) {
            return is_callable($default) ? $default() : $default;
        }
        
        return $value;
    }
    
    /**
     * Set cache value with tags for group invalidation
     */
    public function put(string $key, mixed $value, int $ttl = self::DEFAULT_TTL, array $tags = []): bool
    {
        $fullKey = self::CACHE_PREFIX . $key;
        
        if (!empty($tags)) {
            return Cache::tags($tags)->put($fullKey, $value, $ttl);
        }
        
        return Cache::put($fullKey, $value, $ttl);
    }
    
    /**
     * Remember pattern with automatic caching
     */
    public function remember(string $key, callable $callback, int $ttl = self::DEFAULT_TTL, array $tags = []): mixed
    {
        $fullKey = self::CACHE_PREFIX . $key;
        
        if (!empty($tags)) {
            return Cache::tags($tags)->remember($fullKey, $ttl, $callback);
        }
        
        return Cache::remember($fullKey, $ttl, $callback);
    }
    
    /**
     * Invalidate cache by tags
     */
    public function forgetByTags(array $tags): bool
    {
        return Cache::tags($tags)->flush();
    }
    
    /**
     * Get cache statistics
     */
    public function getStats(): array
    {
        return [
            'redis_info' => $this->redis->info(),
            'memory_usage' => $this->redis->info('memory'),
            'keyspace' => $this->redis->info('keyspace'),
            'stats' => $this->redis->info('stats'),
        ];
    }
}
```

#### LocalizationService Implementation
```php
<?php

namespace App\Modules\SystemCore\Services;

use App\Models\SystemLanguage;
use App\Models\SystemCountry;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class LocalizationService
{
    private Collection $languages;
    private Collection $countries;
    
    public function __construct()
    {
        $this->loadData();
    }
    
    /**
     * Get all active languages with caching
     */
    public function getActiveLanguages(): Collection
    {
        return $this->languages->where('is_active', true)
                              ->sortBy('display_order');
    }
    
    /**
     * Get RTL languages
     */
    public function getRtlLanguages(): Collection
    {
        return $this->languages->where('is_rtl', true)
                              ->where('is_active', true);
    }
    
    /**
     * Set application locale with validation
     */
    public function setLocale(string $locale): bool
    {
        $language = $this->languages->firstWhere('locale_code', $locale);
        
        if (!$language || !$language->is_active) {
            return false;
        }
        
        App::setLocale($language->code);
        
        // Set additional locale context
        config([
            'app.locale' => $language->code,
            'app.locale_full' => $language->locale_code,
            'app.is_rtl' => $language->is_rtl,
        ]);
        
        return true;
    }
    
    /**
     * Get countries with timezone information
     */
    public function getCountriesWithTimezones(): Collection
    {
        return $this->countries->map(function ($country) {
            $country->timezones = $this->getCountryTimezones($country->code);
            return $country;
        });
    }
    
    /**
     * Format international phone number
     */
    public function formatPhoneNumber(string $phone, string $countryCode): string
    {
        $country = $this->countries->firstWhere('code', $countryCode);
        
        if (!$country || !$country->phone_code) {
            return $phone;
        }
        
        // Remove non-numeric characters
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        
        // Add country code if not present
        if (!str_starts_with($cleanPhone, ltrim($country->phone_code, '+'))) {
            return $country->phone_code . $cleanPhone;
        }
        
        return '+' . $cleanPhone;
    }
    
    private function loadData(): void
    {
        $this->languages = cache()->remember('system.languages', 3600, function () {
            return SystemLanguage::all();
        });
        
        $this->countries = cache()->remember('system.countries', 3600, function () {
            return SystemCountry::where('is_active', true)
                                ->orderBy('display_order')
                                ->orderBy('name')
                                ->get();
        });
    }
    
    private function getCountryTimezones(string $countryCode): array
    {
        $timezoneMap = [
            'TR' => ['Europe/Istanbul'],
            'US' => ['America/New_York', 'America/Chicago', 'America/Denver', 'America/Los_Angeles'],
            'GB' => ['Europe/London'],
            'FR' => ['Europe/Paris'],
            'DE' => ['Europe/Berlin'],
            // Add more as needed
        ];
        
        return $timezoneMap[$countryCode] ?? ['UTC'];
    }
}
```

### API Endpoints

```yaml
System Information:
  GET    /api/v1/system/health           # System health check
  GET    /api/v1/system/info             # System information
  GET    /api/v1/system/countries        # List countries
  GET    /api/v1/system/languages        # List languages
  GET    /api/v1/system/timezones        # List timezones

Cache Management:
  GET    /api/v1/system/cache/stats      # Cache statistics
  POST   /api/v1/system/cache/clear      # Clear cache
  DELETE /api/v1/system/cache/tags       # Clear by tags

Queue Management:
  GET    /api/v1/system/jobs/stats       # Job queue statistics
  GET    /api/v1/system/jobs/failed      # Failed jobs list
  POST   /api/v1/system/jobs/retry       # Retry failed jobs
```

### Implementation Structure
```php
app/Modules/SystemCore/
├── Controllers/
│   ├── SystemHealthController.php
│   ├── CountryController.php
│   ├── LanguageController.php
│   └── CacheController.php
├── Models/
│   ├── SystemCountry.php
│   ├── SystemLanguage.php
│   └── SystemJob.php
├── Services/
│   ├── CacheService.php
│   ├── LocalizationService.php
│   ├── QueueService.php
│   └── HealthCheckService.php
├── Repositories/
│   ├── CountryRepository.php
│   └── LanguageRepository.php
├── Resources/
│   ├── CountryResource.php
│   └── LanguageResource.php
└── Tests/
    ├── Unit/
    └── Feature/
```

---

## 2. 🏢 Multi-Tenant Infrastructure Module

### Purpose & Scope
**Enterprise Multi-Tenancy**: Provides complete tenant isolation, subdomain routing, subscription management, and tenant-specific configuration capabilities.

### Database Schema Design

#### tenants
```sql
-- Master tenant registry
CREATE TABLE tenants (
    id UUID PRIMARY KEY,
    name VARCHAR(255) NOT NULL COMMENT 'Organization display name',
    slug VARCHAR(100) UNIQUE NOT NULL COMMENT 'URL-safe identifier',
    domain VARCHAR(255) UNIQUE NOT NULL COMMENT 'Primary domain',
    subdomain VARCHAR(50) UNIQUE NULL COMMENT 'Subdomain identifier',
    
    -- Business Information
    business_type ENUM('corporate', 'academic', 'nonprofit', 'government', 'startup') DEFAULT 'corporate',
    industry VARCHAR(100) NULL COMMENT 'Industry classification',
    company_size ENUM('1-10', '11-50', '51-200', '201-1000', '1000+') NULL,
    
    -- Subscription & Billing
    subscription_plan VARCHAR(50) DEFAULT 'basic' COMMENT 'Current plan identifier',
    subscription_status ENUM('active', 'trial', 'suspended', 'cancelled') DEFAULT 'trial',
    subscription_expires_at TIMESTAMP NULL COMMENT 'Subscription expiration',
    billing_email VARCHAR(320) NULL COMMENT 'Billing contact email',
    
    -- Limits & Quotas
    max_conferences INT UNSIGNED DEFAULT 5 COMMENT 'Conference limit',
    max_participants_per_conference INT UNSIGNED DEFAULT 1000,
    max_storage_gb DECIMAL(8,2) DEFAULT 5.00 COMMENT 'Storage quota in GB',
    
    -- Configuration
    settings JSON NULL COMMENT 'Tenant-specific settings',
    branding JSON NULL COMMENT 'Custom branding configuration',
    
    -- Status & Metadata
    status ENUM('active', 'inactive', 'suspended', 'deleted') DEFAULT 'active',
    timezone VARCHAR(50) DEFAULT 'UTC' COMMENT 'Default timezone',
    locale VARCHAR(10) DEFAULT 'en_US' COMMENT 'Default locale',
    
    -- Audit Information
    created_by UUID NULL COMMENT 'Creator user ID',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL COMMENT 'Soft delete timestamp',
    
    INDEX idx_status_subscription (status, subscription_status),
    INDEX idx_domain_lookup (domain),
    INDEX idx_subdomain_lookup (subdomain),
    INDEX idx_created_date (created_at),
    FULLTEXT idx_tenant_search (name, slug)
) ENGINE=InnoDB COMMENT='Multi-tenant organization registry';
```

#### tenant_settings
```sql
-- Granular tenant configuration
CREATE TABLE tenant_settings (
    id UUID PRIMARY KEY,
    tenant_id UUID NOT NULL,
    category VARCHAR(50) NOT NULL COMMENT 'Setting category (e.g., general, branding, features)',
    `key` VARCHAR(255) NOT NULL COMMENT 'Setting key identifier',
    value LONGTEXT NULL COMMENT 'Setting value (JSON or scalar)',
    data_type ENUM('string', 'integer', 'boolean', 'json', 'array') DEFAULT 'string',
    
    -- Access Control
    is_public BOOLEAN DEFAULT FALSE COMMENT 'Publicly accessible via API',
    is_encrypted BOOLEAN DEFAULT FALSE COMMENT 'Value is encrypted',
    
    -- Metadata
    description TEXT NULL COMMENT 'Setting description',
    validation_rules JSON NULL COMMENT 'Validation configuration',
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    UNIQUE KEY unique_tenant_category_key (tenant_id, category, `key`),
    INDEX idx_tenant_category (tenant_id, category),
    INDEX idx_public_settings (tenant_id, is_public)
) ENGINE=InnoDB COMMENT='Granular tenant configuration management';
```

### Business Logic & Services

#### TenantService Implementation
```php
<?php

namespace App\Modules\TenantManagement\Services;

use App\Models\Tenant;
use App\Models\TenantSetting;
use App\Modules\TenantManagement\DTOs\TenantData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TenantService
{
    public function __construct(
        private TenantRepository $repository,
        private TenantResolverService $resolver,
        private SubscriptionService $subscriptionService
    ) {}
    
    /**
     * Create new tenant with default settings
     */
    public function createTenant(TenantData $data): Tenant
    {
        return DB::transaction(function() use ($data) {
            // Generate unique slug and subdomain
            $slug = $this->generateUniqueSlug($data->name);
            $subdomain = $this->generateUniqueSubdomain($slug);
            
            $tenant = $this->repository->create([
                'name' => $data->name,
                'slug' => $slug,
                'domain' => $data->domain,
                'subdomain' => $subdomain,
                'business_type' => $data->businessType,
                'industry' => $data->industry,
                'company_size' => $data->companySize,
                'billing_email' => $data->billingEmail,
                'timezone' => $data->timezone ?? 'UTC',
                'locale' => $data->locale ?? 'en_US',
                'created_by' => $data->createdBy,
            ]);
            
            // Initialize default settings
            $this->initializeDefaultSettings($tenant);
            
            // Setup trial subscription
            $this->subscriptionService->createTrialSubscription($tenant);
            
            event(new TenantCreated($tenant));
            
            return $tenant;
        });
    }
    
    /**
     * Update tenant subscription plan
     */
    public function updateSubscription(string $tenantId, string $plan): bool
    {
        $tenant = $this->repository->findOrFail($tenantId);
        
        $planConfig = $this->subscriptionService->getPlanConfiguration($plan);
        
        return $this->repository->update($tenantId, [
            'subscription_plan' => $plan,
            'max_conferences' => $planConfig['max_conferences'],
            'max_participants_per_conference' => $planConfig['max_participants'],
            'max_storage_gb' => $planConfig['max_storage'],
        ]);
    }
    
    /**
     * Get tenant with usage statistics
     */
    public function getTenantWithUsage(string $tenantId): array
    {
        $tenant = $this->repository->findOrFail($tenantId);
        
        $usage = [
            'conferences' => [
                'current' => $tenant->conferences()->count(),
                'limit' => $tenant->max_conferences,
                'percentage' => ($tenant->conferences()->count() / $tenant->max_conferences) * 100,
            ],
            'storage' => [
                'current_gb' => $this->calculateStorageUsage($tenant),
                'limit_gb' => $tenant->max_storage_gb,
                'percentage' => ($this->calculateStorageUsage($tenant) / $tenant->max_storage_gb) * 100,
            ],
            'participants' => [
                'total' => $tenant->conferences()->withCount('participants')->sum('participants_count'),
                'active_conferences' => $tenant->conferences()->where('status', 'ongoing')->count(),
            ],
        ];
        
        return [
            'tenant' => $tenant,
            'usage' => $usage,
            'features' => $this->subscriptionService->getAvailableFeatures($tenant->subscription_plan),
        ];
    }
    
    private function generateUniqueSlug(string $name): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;
        
        while ($this->repository->existsBySlug($slug)) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
    
    private function generateUniqueSubdomain(string $slug): string
    {
        $subdomain = $slug;
        $counter = 1;
        
        while ($this->repository->existsBySubdomain($subdomain)) {
            $subdomain = $slug . $counter;
            $counter++;
        }
        
        return $subdomain;
    }
    
    private function initializeDefaultSettings(Tenant $tenant): void
    {
        $defaultSettings = [
            'general' => [
                'time_format' => '24h',
                'date_format' => 'Y-m-d',
                'week_start' => 'monday',
                'auto_approve_registrations' => true,
            ],
            'branding' => [
                'primary_color' => '#2563eb',
                'secondary_color' => '#64748b',
                'logo_url' => null,
                'favicon_url' => null,
            ],
            'features' => [
                'allow_public_conferences' => true,
                'enable_qr_codes' => true,
                'enable_analytics' => true,
                'enable_gamification' => false,
            ],
            'notifications' => [
                'email_enabled' => true,
                'sms_enabled' => false,
                'push_enabled' => true,
            ],
        ];
        
        foreach ($defaultSettings as $category => $settings) {
            foreach ($settings as $key => $value) {
                TenantSetting::create([
                    'tenant_id' => $tenant->id,
                    'category' => $category,
                    'key' => $key,
                    'value' => is_array($value) ? json_encode($value) : (string) $value,
                    'data_type' => $this->getDataType($value),
                    'is_public' => in_array($category, ['branding', 'general']),
                ]);
            }
        }
    }
}
```

### API Endpoints

```yaml
Tenant Management:
  GET    /api/v1/tenants                     # List tenants (admin only)
  POST   /api/v1/tenants                     # Create tenant
  GET    /api/v1/tenants/{id}                # Get tenant details
  PUT    /api/v1/tenants/{id}                # Update tenant
  DELETE /api/v1/tenants/{id}                # Delete tenant (soft delete)

Tenant Settings:
  GET    /api/v1/tenants/{id}/settings       # Get all settings
  GET    /api/v1/tenants/{id}/settings/{cat} # Get category settings
  PUT    /api/v1/tenants/{id}/settings       # Update settings
  DELETE /api/v1/tenants/{id}/settings/{key} # Delete setting

Subscription Management:
  GET    /api/v1/tenants/{id}/subscription   # Get subscription details
  PUT    /api/v1/tenants/{id}/subscription   # Update subscription
  GET    /api/v1/tenants/{id}/usage          # Get usage statistics
  GET    /api/v1/tenants/{id}/billing        # Get billing information

Domain Management:
  POST   /api/v1/tenants/{id}/domains        # Add custom domain
  PUT    /api/v1/tenants/{id}/domains/{id}   # Update domain
  DELETE /api/v1/tenants/{id}/domains/{id}   # Remove domain
```

---

## 3. 👥 User Management Module

### Purpose & Scope
**Comprehensive User Lifecycle**: Handles user authentication, authorization, profile management, role-based access control, and multi-tenant user isolation.

### Database Schema Design

#### users
```sql
-- Multi-tenant user management
CREATE TABLE users (
    id UUID PRIMARY KEY,
    tenant_id UUID NOT NULL COMMENT 'Tenant isolation',
    
    -- Authentication
    email VARCHAR(320) NOT NULL COMMENT 'RFC5322 compliant email',
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL COMMENT 'Hashed password',
    remember_token VARCHAR(100) NULL,
    
    -- Profile Information
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    display_name VARCHAR(200) NULL COMMENT 'Preferred display name',
    avatar_url VARCHAR(500) NULL,
    
    -- Contact Information
    phone VARCHAR(20) NULL COMMENT 'International format',
    phone_verified_at TIMESTAMP NULL,
    
    -- Professional Information
    job_title VARCHAR(200) NULL,
    organization VARCHAR(200) NULL,
    department VARCHAR(100) NULL,
    bio TEXT NULL COMMENT 'Professional biography',
    
    -- Preferences
    language_code CHAR(2) DEFAULT 'en' COMMENT 'Preferred language',
    timezone VARCHAR(50) DEFAULT 'UTC',
    date_format VARCHAR(20) DEFAULT 'Y-m-d',
    time_format ENUM('12h', '24h') DEFAULT '24h',
    
    -- Security
    two_factor_secret VARCHAR(255) NULL COMMENT 'Encrypted 2FA secret',
    two_factor_recovery_codes JSON NULL,
    two_factor_confirmed_at TIMESTAMP NULL,
    failed_login_attempts TINYINT UNSIGNED DEFAULT 0,
    locked_until TIMESTAMP NULL COMMENT 'Account lock expiration',
    
    -- Activity Tracking
    last_login_at TIMESTAMP NULL,
    last_active_at TIMESTAMP NULL,
    login_count INT UNSIGNED DEFAULT 0,
    
    -- Status
    status ENUM('active', 'inactive', 'suspended', 'pending_verification') DEFAULT 'pending_verification',
    is_admin BOOLEAN DEFAULT FALSE COMMENT 'Tenant admin flag',
    
    -- Audit
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    UNIQUE KEY unique_tenant_email (tenant_id, email),
    INDEX idx_tenant_status (tenant_id, status),
    INDEX idx_last_active (tenant_id, last_active_at),
    INDEX idx_email_lookup (email),
    FULLTEXT idx_user_search (first_name, last_name, email, organization)
) ENGINE=InnoDB COMMENT='Multi-tenant user management';
```

#### user_roles
```sql
-- Dynamic role and permission system
CREATE TABLE user_roles (
    id UUID PRIMARY KEY,
    tenant_id UUID NOT NULL,
    user_id UUID NOT NULL,
    
    -- Role Definition
    role_name VARCHAR(50) NOT NULL COMMENT 'Role identifier',
    role_type ENUM('system', 'tenant', 'conference', 'session') DEFAULT 'tenant',
    
    -- Scope and Context
    resource_type VARCHAR(50) NULL COMMENT 'Resource being accessed (conference, session)',
    resource_id UUID NULL COMMENT 'Specific resource ID',
    
    -- Permissions
    permissions JSON NOT NULL COMMENT 'Granular permissions array',
    
    -- Assignment Details
    assigned_by UUID NOT NULL COMMENT 'User who assigned the role',
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NULL COMMENT 'Role expiration (optional)',
    
    -- Status
    is_active BOOLEAN DEFAULT TRUE,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_by) REFERENCES users(id),
    
    INDEX idx_user_roles (user_id, is_active),
    INDEX idx_tenant_roles (tenant_id, role_name),
    INDEX idx_resource_roles (resource_type, resource_id),
    INDEX idx_expiring_roles (expires_at)
) ENGINE=InnoDB COMMENT='Dynamic role-based access control';
```

### Business Logic & Services

#### UserService Implementation
```php
<?php

namespace App\Modules\UserManagement\Services;

use App\Models\User;
use App\Modules\UserManagement\DTOs\UserRegistrationData;
use App\Modules\UserManagement\Events\UserRegistered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function __construct(
        private UserRepository $repository,
        private RoleService $roleService,
        private TwoFactorService $twoFactorService
    ) {}
    
    /**
     * Register new user with email verification
     */
    public function registerUser(UserRegistrationData $data): User
    {
        return DB::transaction(function() use ($data) {
            $user = $this->repository->create([
                'tenant_id' => $data->tenantId,
                'email' => $data->email,
                'password' => Hash::make($data->password),
                'first_name' => $data->firstName,
                'last_name' => $data->lastName,
                'display_name' => $data->displayName ?? $data->firstName . ' ' . $data->lastName,
                'phone' => $data->phone,
                'job_title' => $data->jobTitle,
                'organization' => $data->organization,
                'language_code' => $data->languageCode ?? 'en',
                'timezone' => $data->timezone ?? 'UTC',
            ]);
            
            // Assign default tenant user role
            $this->roleService->assignRole($user, 'tenant_user', $data->tenantId);
            
            // Send email verification
            event(new UserRegistered($user));
            
            return $user;
        });
    }
    
    /**
     * Authenticate user with rate limiting
     */
    public function authenticateUser(string $email, string $password, string $tenantId): ?User
    {
        $user = $this->repository->findByEmailAndTenant($email, $tenantId);
        
        if (!$user) {
            return null;
        }
        
        // Check account lock
        if ($user->locked_until && $user->locked_until > now()) {
            throw new AccountLockedException($user->locked_until);
        }
        
        // Verify password
        if (!Hash::check($password, $user->password)) {
            $this->handleFailedLogin($user);
            return null;
        }
        
        // Check account status
        if ($user->status !== 'active') {
            throw new AccountInactiveException($user->status);
        }
        
        // Update login tracking
        $this->updateLoginTracking($user);
        
        return $user;
    }
    
    /**
     * Setup two-factor authentication
     */
    public function setupTwoFactor(User $user): array
    {
        $secret = $this->twoFactorService->generateSecret();
        $qrCodeUrl = $this->twoFactorService->generateQrCode($user->email, $secret);
        $recoveryCodes = $this->twoFactorService->generateRecoveryCodes();
        
        $this->repository->update($user->id, [
            'two_factor_secret' => encrypt($secret),
            'two_factor_recovery_codes' => encrypt($recoveryCodes),
        ]);
        
        return [
            'secret' => $secret,
            'qr_code' => $qrCodeUrl,
            'recovery_codes' => $recoveryCodes,
        ];
    }
    
    /**
     * Verify two-factor authentication code
     */
    public function verifyTwoFactor(User $user, string $code): bool
    {
        if (!$user->two_factor_secret) {
            return false;
        }
        
        $secret = decrypt($user->two_factor_secret);
        
        if ($this->twoFactorService->verifyCode($secret, $code)) {
            if (!$user->two_factor_confirmed_at) {
                $this->repository->update($user->id, [
                    'two_factor_confirmed_at' => now(),
                ]);
            }
            return true;
        }
        
        // Check recovery codes
        if ($user->two_factor_recovery_codes) {
            $recoveryCodes = decrypt($user->two_factor_recovery_codes);
            
            if (in_array($code, $recoveryCodes)) {
                // Remove used recovery code
                $remainingCodes = array_filter($recoveryCodes, fn($c) => $c !== $code);
                
                $this->repository->update($user->id, [
                    'two_factor_recovery_codes' => encrypt(array_values($remainingCodes)),
                ]);
                
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Get user with roles and permissions
     */
    public function getUserWithPermissions(string $userId): array
    {
        $user = $this->repository->findWithRoles($userId);
        
        $permissions = $this->roleService->getUserPermissions($user);
        
        return [
            'user' => $user,
            'roles' => $user->roles,
            'permissions' => $permissions,
            'can' => $this->buildPermissionCheckers($permissions),
        ];
    }
    
    private function handleFailedLogin(User $user): void
    {
        $attempts = $user->failed_login_attempts + 1;
        $lockUntil = null;
        
        // Progressive lockout: 5 attempts = 15 min, 10 = 1 hour, 15 = 24 hours
        if ($attempts >= 15) {
            $lockUntil = now()->addDay();
        } elseif ($attempts >= 10) {
            $lockUntil = now()->addHour();
        } elseif ($attempts >= 5) {
            $lockUntil = now()->addMinutes(15);
        }
        
        $this->repository->update($user->id, [
            'failed_login_attempts' => $attempts,
            'locked_until' => $lockUntil,
        ]);
    }
    
    private function updateLoginTracking(User $user): void
    {
        $this->repository->update($user->id, [
            'last_login_at' => now(),
            'last_active_at' => now(),
            'login_count' => $user->login_count + 1,
            'failed_login_attempts' => 0,
            'locked_until' => null,
        ]);
    }
}
```

### API Endpoints

```yaml
Authentication:
  POST   /api/v1/auth/register              # User registration
  POST   /api/v1/auth/login                 # User login
  POST   /api/v1/auth/logout                # User logout
  POST   /api/v1/auth/refresh               # Refresh token
  POST   /api/v1/auth/forgot-password       # Password reset request
  POST   /api/v1/auth/reset-password        # Password reset confirm

Two-Factor Authentication:
  POST   /api/v1/auth/2fa/setup             # Setup 2FA
  POST   /api/v1/auth/2fa/confirm           # Confirm 2FA setup
  POST   /api/v1/auth/2fa/verify            # Verify 2FA code
  DELETE /api/v1/auth/2fa/disable           # Disable 2FA

User Profile:
  GET    /api/v1/users/profile              # Get current user profile
  PUT    /api/v1/users/profile              # Update profile
  PUT    /api/v1/users/password             # Change password
  POST   /api/v1/users/avatar               # Upload avatar

User Management (Admin):
  GET    /api/v1/users                      # List users
  POST   /api/v1/users                      # Create user
  GET    /api/v1/users/{id}                 # Get user details
  PUT    /api/v1/users/{id}                 # Update user
  DELETE /api/v1/users/{id}                 # Delete user

Role Management:
  GET    /api/v1/users/{id}/roles           # Get user roles
  POST   /api/v1/users/{id}/roles           # Assign role
  DELETE /api/v1/users/{id}/roles/{roleId}  # Remove role
  GET    /api/v1/roles                      # List available roles
```

---

I'll continue with the remaining modules. This comprehensive documentation provides detailed specifications for each module including database schema, business logic, services, and API endpoints. Each module is designed to be independent yet integrate seamlessly with others.

Would you like me to continue with the remaining modules (Conference Core, Interactive Features, etc.) or would you prefer me to update the other documentation files first? 