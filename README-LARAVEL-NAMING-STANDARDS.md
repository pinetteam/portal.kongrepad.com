# 📚 Laravel Dosya İsimlendirme Standardı - KongrePad

> **KongrePad Projesi için kapsamlı Laravel dosya isimlendirme standartları ve en iyi uygulamalar**

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-blue.svg)](https://php.net)
[![KongrePad](https://img.shields.io/badge/KongrePad-Conference%20Management-green.svg)](#)

## 🎯 Genel Prensipler

### Temel Kurallar
- **📏 Tutarlılık**: Tüm projede aynı isimlendirme kurallarını kullanın
- **🔍 Açıklayıcı**: Dosya ismi içeriği hakkında net bilgi vermeli
- **⚡ Kısa ve Öz**: Gereksiz uzun isimlerden kaçının
- **🌍 İngilizce**: Tüm dosya isimleri İngilizce olmalı (Türkçe içerik hariç)
- **🏗️ RESTful**: Laravel convention'larına uygun olun
- **📂 Organize**: Mantıklı dizin yapısı kullanın

---

## 📁 Ana Dizin Yapısı

```
kongrepad/
├── app/
│   ├── Console/Commands/           # Artisan komutları
│   ├── Contracts/                  # Interface'ler
│   ├── DataTransferObjects/        # DTO sınıfları
│   ├── Enums/                      # Enum sınıfları
│   ├── Events/                     # Event sınıfları
│   ├── Exceptions/                 # Custom exception'lar
│   ├── Exports/                    # Excel/CSV export sınıfları
│   ├── Helpers/                    # Helper sınıfları
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/             # Admin paneli controller'ları
│   │   │   ├── Api/V1/            # API controller'ları
│   │   │   └── Auth/              # Authentication controller'ları
│   │   ├── Middleware/            # Custom middleware
│   │   ├── Requests/              # Form request validation
│   │   └── Resources/             # API resource'ları
│   ├── Imports/                    # Excel/CSV import sınıfları
│   ├── Jobs/                       # Queue job'ları
│   ├── Listeners/                  # Event listener'ları
│   ├── Mail/                       # Mailable sınıfları
│   ├── Models/                     # Eloquent model'ları
│   ├── Notifications/              # Notification sınıfları
│   ├── Observers/                  # Model observer'ları
│   ├── Policies/                   # Authorization policy'leri
│   ├── Providers/                  # Service provider'ları
│   ├── Repositories/               # Repository pattern
│   ├── Rules/                      # Custom validation rule'ları
│   ├── Services/                   # Service sınıfları
│   │   ├── Conference/            # Konferans servisleri
│   │   ├── Payment/               # Ödeme servisleri
│   │   └── Notification/          # Bildirim servisleri
│   ├── Traits/                     # PHP trait'leri
│   └── ViewModels/                 # Complex view logic
├── bootstrap/
├── config/                         # Configuration dosyaları
├── database/
│   ├── factories/                  # Model factory'leri
│   ├── migrations/                 # Database migration'ları
│   └── seeders/                    # Database seeder'ları
├── resources/
│   ├── js/                        # JavaScript dosyaları
│   ├── lang/                      # Dil dosyaları
│   │   ├── tr/                    # Türkçe çeviriler
│   │   ├── en/                    # İngilizce çeviriler
│   │   └── ar/                    # Arapça çeviriler (RTL)
│   ├── sass/                      # SCSS dosyaları
│   └── views/                     # Blade template'leri
├── routes/                        # Route dosyaları
├── storage/
└── tests/                         # Test dosyaları
    ├── Feature/                   # Feature test'leri
    └── Unit/                      # Unit test'leri
```

---

## 🏗️ Model İsimlendirme

### ✅ Model Dosyaları (Tekil, PascalCase)
```php
app/Models/Conference.php
app/Models/Participant.php
app/Models/Session.php
app/Models/Speaker.php
app/Models/Registration.php
app/Models/Payment.php
app/Models/ConferenceSession.php        // Nested resource
app/Models/ConferenceParticipant.php    // Pivot model
app/Models/SessionSpeaker.php           // Many-to-many relation
```

### ❌ Yanlış Örnekler
```php
app/Models/conferences.php              // Çoğul
app/Models/ConferenceModel.php          // Model suffix'i
app/Models/conference.php               // camelCase değil
app/Models/Conference_Model.php         // Underscore
```

### 🔗 İlişki Tabloları (Alfabetik sıralama)
```php
app/Models/ConferenceParticipant.php    // conferences <-> participants
app/Models/ConferenceSpeaker.php        // conferences <-> speakers
app/Models/ParticipantSession.php       // participants <-> sessions
app/Models/SessionSpeaker.php           # sessions <-> speakers
```

---

## 🎮 Controller İsimlendirme

### 📋 Resource Controller'ları
```php
// Web Controllers
app/Http/Controllers/ConferenceController.php
app/Http/Controllers/ParticipantController.php
app/Http/Controllers/SessionController.php
app/Http/Controllers/SpeakerController.php

// Admin Controllers (admin prefix ile)
app/Http/Controllers/Admin/ConferenceController.php
app/Http/Controllers/Admin/DashboardController.php
app/Http/Controllers/Admin/ReportController.php
app/Http/Controllers/Admin/SettingController.php

// API Controllers (version ile)
app/Http/Controllers/Api/V1/ConferenceController.php
app/Http/Controllers/Api/V1/ParticipantController.php
app/Http/Controllers/Api/V1/AuthController.php

// Authentication Controllers
app/Http/Controllers/Auth/LoginController.php
app/Http/Controllers/Auth/RegisterController.php
app/Http/Controllers/Auth/PasswordController.php
```

### ⚡ Single Action Controller'ları
```php
app/Http/Controllers/ConferenceRegistrationController.php
app/Http/Controllers/GenerateQrCodeController.php
app/Http/Controllers/DownloadCertificateController.php
app/Http/Controllers/ExportParticipantsController.php
app/Http/Controllers/ImportParticipantsController.php
app/Http/Controllers/SendBulkEmailController.php
```

---

## 📝 Request Validation İsimlendirme

### 🔍 Form Request Kuralları
```php
// Action + Resource + Request
app/Http/Requests/StoreConferenceRequest.php
app/Http/Requests/UpdateConferenceRequest.php
app/Http/Requests/RegisterParticipantRequest.php
app/Http/Requests/BulkImportParticipantsRequest.php
app/Http/Requests/ProcessPaymentRequest.php

// Nested Resources
app/Http/Requests/Conference/StoreSessionRequest.php
app/Http/Requests/Conference/UpdateSessionRequest.php
app/Http/Requests/Conference/AssignSpeakerRequest.php
app/Http/Requests/Participant/UpdateProfileRequest.php
```

---

## 🔄 Middleware İsimlendirme

```php
// Açıklayıcı ve spesifik isimler
app/Http/Middleware/CheckConferenceStatus.php
app/Http/Middleware/VerifyParticipantRegistration.php
app/Http/Middleware/EnsureConferenceOwnership.php
app/Http/Middleware/LogApiRequests.php
app/Http/Middleware/CheckPaymentStatus.php
app/Http/Middleware/VerifyQrCode.php
```

---

## 🗃️ Migration İsimlendirme

### 🆕 Tablo Oluşturma
```php
2024_01_15_120000_create_conferences_table.php
2024_01_15_120001_create_participants_table.php
2024_01_15_120002_create_sessions_table.php
2024_01_15_120003_create_speakers_table.php
2024_01_15_120004_create_registrations_table.php
2024_01_15_120005_create_payments_table.php
```

### 🔄 Tablo Güncelleme
```php
2024_02_01_140000_add_status_to_conferences_table.php
2024_02_01_140001_add_qr_code_to_participants_table.php
2024_02_01_140002_add_streaming_url_to_sessions_table.php
2024_02_01_140003_update_sessions_table_add_recording_fields.php
```

### 🔗 İlişki Tabloları (Pivot)
```php
2024_01_20_100000_create_conference_participant_table.php
2024_01_20_100001_create_conference_speaker_table.php
2024_01_20_100002_create_participant_session_table.php
2024_01_20_100003_create_session_speaker_table.php
```

---

## 🌱 Seeder & Factory İsimlendirme

### Seeder'lar
```php
database/seeders/ConferenceSeeder.php
database/seeders/UserSeeder.php
database/seeders/ParticipantSeeder.php
database/seeders/TestDataSeeder.php
database/seeders/ProductionDataSeeder.php
database/seeders/DevelopmentSeeder.php
```

### Factory'ler
```php
database/factories/ConferenceFactory.php
database/factories/ParticipantFactory.php
database/factories/SessionFactory.php
database/factories/SpeakerFactory.php

// State methods
ConferenceFactory::published()
ConferenceFactory::draft()
ConferenceFactory::withSessions(5)
ConferenceFactory::withParticipants(100)
```

---

## 📮 Mail & Notification İsimlendirme

### 📧 Mailable Sınıfları
```php
app/Mail/ConferenceRegistrationMail.php
app/Mail/PaymentConfirmationMail.php
app/Mail/SessionReminderMail.php
app/Mail/CertificateReadyMail.php
app/Mail/WelcomeToConferenceMail.php
app/Mail/ConferenceCancelledMail.php
```

### 🔔 Notification Sınıfları
```php
app/Notifications/ConferenceStartingNotification.php
app/Notifications/RegistrationApprovedNotification.php
app/Notifications/PaymentReceivedNotification.php
app/Notifications/SessionUpdatedNotification.php
```

---

## 🎯 Service & Repository İsimlendirme

### 🏗️ Service Sınıfları
```php
// Domain Services
app/Services/ConferenceService.php
app/Services/RegistrationService.php
app/Services/PaymentService.php
app/Services/CertificateService.php

// Feature Services
app/Services/Conference/ConferenceManagementService.php
app/Services/Conference/SessionSchedulingService.php
app/Services/Payment/PaymentProcessingService.php
app/Services/Notification/EmailNotificationService.php

// External API Services
app/Services/External/ZoomApiService.php
app/Services/External/MailgunService.php
app/Services/External/PaymentGatewayService.php
```

### 📚 Repository Sınıfları
```php
app/Repositories/ConferenceRepository.php
app/Repositories/ParticipantRepository.php
app/Repositories/SessionRepository.php

// Interface'ler
app/Contracts/ConferenceRepositoryInterface.php
app/Contracts/PaymentServiceInterface.php
```

---

## 🔧 Job & Event İsimlendirme

### ⚙️ Job Sınıfları
```php
app/Jobs/ProcessConferenceRegistration.php
app/Jobs/SendBulkEmailsJob.php
app/Jobs/GenerateConferenceCertificates.php
app/Jobs/CleanupExpiredSessions.php
app/Jobs/ProcessPaymentWebhook.php
app/Jobs/SyncWithExternalCalendar.php
```

### 🎭 Event & Listener Sınıfları
```php
// Events (Past Tense)
app/Events/ConferenceCreated.php
app/Events/ParticipantRegistered.php
app/Events/PaymentProcessed.php
app/Events/SessionStarted.php

// Listeners (Action + When + Event)
app/Listeners/SendWelcomeEmailWhenParticipantRegistered.php
app/Listeners/UpdateStatsWhenConferenceCreated.php
app/Listeners/NotifyAdminWhenPaymentFailed.php
app/Listeners/GenerateCertificateWhenConferenceCompleted.php
```

---

## 🎨 View & Asset İsimlendirme

### 🖼️ Blade Template'leri
```
resources/views/
├── layouts/
│   ├── app.blade.php
│   ├── admin.blade.php
│   ├── guest.blade.php
│   └── email.blade.php
├── pages/
│   ├── welcome.blade.php
│   ├── dashboard.blade.php
│   └── profile.blade.php
├── conferences/
│   ├── index.blade.php
│   ├── show.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── partials/
│       ├── conference-card.blade.php
│       ├── conference-stats.blade.php
│       └── session-list.blade.php
├── admin/
│   ├── dashboard/
│   │   └── index.blade.php
│   └── conferences/
│       ├── index.blade.php
│       └── show.blade.php
└── components/
    ├── button.blade.php
    ├── alert.blade.php
    ├── modal.blade.php
    └── forms/
        ├── input.blade.php
        └── select.blade.php
```

### 🎨 JavaScript & CSS
```
resources/
├── js/
│   ├── app.js
│   ├── bootstrap.js
│   ├── components/
│   │   ├── conference-calendar.js
│   │   ├── participant-list.js
│   │   └── qr-code-scanner.js
│   └── pages/
│       ├── conference-detail.js
│       ├── registration-form.js
│       └── admin-dashboard.js
└── sass/
    ├── app.scss
    ├── _variables.scss
    ├── components/
    │   ├── _buttons.scss
    │   ├── _cards.scss
    │   └── _forms.scss
    └── pages/
        ├── _conference.scss
        ├── _dashboard.scss
        └── _admin.scss
```

---

## 🧪 Test İsimlendirme

### 🔬 Unit Tests
```php
tests/Unit/Models/ConferenceTest.php
tests/Unit/Services/RegistrationServiceTest.php
tests/Unit/Services/PaymentServiceTest.php
tests/Unit/Helpers/QrCodeHelperTest.php
```

### 🎯 Feature Tests
```php
tests/Feature/ConferenceManagementTest.php
tests/Feature/ParticipantRegistrationTest.php
tests/Feature/PaymentProcessingTest.php
tests/Feature/Admin/ConferenceAdministrationTest.php
tests/Feature/Api/ConferenceApiTest.php
```

### 📋 Test Method'ları
```php
public function test_can_create_conference()
public function test_participant_can_register_for_conference()
public function test_cannot_register_for_past_conference()
public function test_admin_can_view_conference_statistics()
public function test_payment_is_processed_correctly()
```

---

## 🎯 Enum & DTO İsimlendirme

### 📊 Enum Sınıfları
```php
app/Enums/ConferenceStatus.php
app/Enums/PaymentStatus.php
app/Enums/ParticipantType.php
app/Enums/SessionType.php
app/Enums/RegistrationStatus.php

// Örnek içerik
enum ConferenceStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ONGOING = 'ongoing';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
}
```

### 📦 Data Transfer Objects
```php
app/DataTransferObjects/ConferenceData.php
app/DataTransferObjects/RegistrationData.php
app/DataTransferObjects/PaymentData.php
app/DataTransferObjects/ParticipantData.php
```

---

## 🛠️ Diğer Sınıf İsimlendirmeleri

### 🧩 Trait'ler
```php
app/Traits/HasConferences.php
app/Traits/CanRegisterParticipants.php
app/Traits/IsSearchable.php
app/Traits/HasUuid.php
app/Traits/LogsActivity.php
```

### ✅ Validation Rule'ları
```php
app/Rules/ValidConferenceDate.php
app/Rules/UniqueEmailPerConference.php
app/Rules/MaxParticipantsNotExceeded.php
app/Rules/ValidQrCode.php
```

### 🔌 API Resource'ları
```php
app/Http/Resources/ConferenceResource.php
app/Http/Resources/ParticipantResource.php
app/Http/Resources/SessionResource.php

// Collections
app/Http/Resources/ConferenceCollection.php
app/Http/Resources/ParticipantCollection.php
```

---

## ⚙️ Config & Environment

### 📄 Config Dosyaları (kebab-case)
```php
config/conference-settings.php
config/payment-gateways.php
config/notification-channels.php
config/external-apis.php

// Örnek içerik
return [
    'max_participants' => env('CONFERENCE_MAX_PARTICIPANTS', 1000),
    'early_bird_days' => env('CONFERENCE_EARLY_BIRD_DAYS', 30),
    'certificate_template' => env('CERTIFICATE_TEMPLATE_PATH'),
];
```

### 🌍 Environment Değişkenleri
```env
# Uygulama
APP_NAME="KongrePad"
APP_ENV=production
APP_TIMEZONE="Europe/Istanbul"

# Konferans Ayarları
CONFERENCE_MAX_PARTICIPANTS=5000
CONFERENCE_EARLY_BIRD_DISCOUNT=20
CONFERENCE_DEFAULT_CURRENCY=TRY

# Harici Servisler
ZOOM_API_KEY=xxx
MAILGUN_DOMAIN=xxx
PAYMENT_GATEWAY_KEY=xxx
QR_CODE_SERVICE_URL=xxx
```

---

## 🚀 Route İsimlendirme

### 🌐 Web Routes
```php
// RESTful resource routes
Route::resource('conferences', ConferenceController::class);
Route::resource('participants', ParticipantController::class);

// Named routes (dot notation)
Route::get('/conferences/{conference}/sessions', [SessionController::class, 'index'])
    ->name('conferences.sessions.index');

// Admin routes (prefix)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('conferences', Admin\ConferenceController::class);
});
```

### 🔌 API Routes (kebab-case URLs)
```php
Route::prefix('api/v1')->group(function () {
    Route::get('/conferences', [Api\V1\ConferenceController::class, 'index']);
    Route::post('/participant-registration', [Api\V1\RegistrationController::class, 'store']);
    Route::get('/conference-statistics', [Api\V1\StatisticsController::class, 'index']);
});
```

---

## 🌍 Çok Dilli Destek

### 📝 Dil Dosyaları
```
resources/lang/
├── tr/                             # Türkçe
│   ├── conference.php
│   ├── participant.php
│   ├── payment.php
│   ├── validation.php
│   └── auth.php
├── en/                             # İngilizce
│   ├── conference.php
│   ├── participant.php
│   ├── payment.php
│   ├── validation.php
│   └── auth.php
└── ar/                             # Arapça (RTL)
    ├── conference.php
    ├── participant.php
    ├── payment.php
    ├── validation.php
    └── auth.php
```

---

## ✅ Kalite Kontrol Listesi

### 📋 Dosya İsimlendirme Kontrolü
- [ ] Model isimleri tekil ve PascalCase mi?
- [ ] Controller isimleri Resource + Controller formatında mı?
- [ ] Migration isimleri timestamp + açıklayıcı mı?
- [ ] View dosyaları kebab-case ve organize mi?
- [ ] Test isimleri test_ prefix'i ile başlıyor mu?
- [ ] Service ve Repository isimleri tutarlı mı?
- [ ] Route isimleri RESTful ve dot notation mu?
- [ ] Enum değerleri snake_case mi?
- [ ] JavaScript/CSS dosyaları kebab-case mi?
- [ ] Config dosyaları kebab-case mi?

### 🏗️ Yapısal Kontrol
- [ ] Dizin yapısı mantıklı ve organize mi?
- [ ] İlişkili dosyalar aynı klasörde mi?
- [ ] Namespace'ler doğru tanımlanmış mı?
- [ ] Import statement'ları optimize mi?
- [ ] Docblock comment'ları eksiksiz mi?

### 🔒 Güvenlik Kontrolü
- [ ] Validation rule'ları uygun mu?
- [ ] Authorization policy'leri tanımlanmış mı?
- [ ] Middleware'ler doğru sırada mı?
- [ ] API endpoint'leri korunmuş mu?

---

## 🎓 KongrePad Özel Durumlar

### 📊 Dashboard & Reporting
```php
app/Services/Analytics/ConferenceAnalyticsService.php
app/Services/Reports/ParticipantReportService.php
app/Exports/ConferenceParticipantsExport.php
app/Charts/ConferenceStatisticsChart.php
```

### 🎫 QR Code & Certificate
```php
app/Services/QrCode/QrCodeGeneratorService.php
app/Services/Certificate/CertificateGeneratorService.php
app/Jobs/GenerateBulkCertificatesJob.php
app/Http/Controllers/DownloadCertificateController.php
```

### 💳 Payment Integration
```php
app/Services/Payment/PaymentGatewayService.php
app/Webhooks/PaymentWebhookController.php
app/Jobs/ProcessPaymentWebhookJob.php
app/Events/PaymentCompleted.php
```

---

## 🚀 Kullanım Örnekleri

### 📝 Yeni Feature Ekleme
```bash
# 1. Migration oluştur
php artisan make:migration create_conference_sponsors_table

# 2. Model oluştur
php artisan make:model ConferenceSponsor

# 3. Controller oluştur
php artisan make:controller Admin/ConferenceSponsorController --resource

# 4. Request oluştur
php artisan make:request StoreConferenceSponsorRequest
php artisan make:request UpdateConferenceSponsorRequest

# 5. Test oluştur
php artisan make:test ConferenceSponsorTest
```

### 🔧 Service Pattern Implementasyonu
```php
// Service oluştur
app/Services/ConferenceSponsorService.php

// Repository oluştur
app/Repositories/ConferenceSponsorRepository.php
app/Contracts/ConferenceSponsorRepositoryInterface.php

// Event & Listener
app/Events/SponsorAdded.php
app/Listeners/SendSponsorWelcomeEmail.php
```

---

## 📖 Kaynaklar

- [Laravel Documentation](https://laravel.com/docs)
- [PSR-4 Autoloading Standard](https://www.php-fig.org/psr/psr-4/)
- [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices)
- [KongrePad Project Documentation](./README.md)

---

**💡 Not**: Bu standartları takip ederek KongrePad projesi daha okunabilir, sürdürülebilir ve takım çalışmasına uygun hale gelecektir. Yeni ekip üyeleri için onboarding süreci de hızlanacaktır.

---

📅 **Son Güncelleme**: {{ date('Y-m-d') }}  
👨‍💻 **Hazırlayan**: KongrePad Development Team  
📝 **Versiyon**: 1.0.0 