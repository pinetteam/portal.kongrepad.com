<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Translate API Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Google Translate API settings. You can
    | obtain an API key from the Google Cloud Console.
    |
    */

    'api_key' => env('GOOGLE_TRANSLATE_API_KEY'),
    
    'project_id' => env('GOOGLE_CLOUD_PROJECT_ID'),
    
    'credentials' => env('GOOGLE_APPLICATION_CREDENTIALS'),
    
    /*
    |--------------------------------------------------------------------------
    | Default Language Mappings
    |--------------------------------------------------------------------------
    |
    | Map your application language codes to Google Translate language codes
    |
    */
    'language_mappings' => [
        'en' => 'en',
        'tr' => 'tr',
        'de' => 'de',
        'fr' => 'fr',
        'es' => 'es',
        'it' => 'it',
        'pt' => 'pt',
        'ru' => 'ru',
        'ar' => 'ar',
        'zh' => 'zh',
        'ja' => 'ja',
        'ko' => 'ko',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Translation Options
    |--------------------------------------------------------------------------
    |
    | Configure translation behavior and options
    |
    */
    'options' => [
        'format' => 'text', // 'text' or 'html'
        'model' => 'base', // 'base' or 'nmt'
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Fallback Translations
    |--------------------------------------------------------------------------
    |
    | Simple fallback translations when Google Translate is not available
    |
    */
    'fallback_translations' => [
        'en' => [
            'tr' => [
                'Dashboard' => 'Kontrol Paneli',
                'Users' => 'Kullanıcılar',
                'Settings' => 'Ayarlar',
                'Languages' => 'Diller',
                'Translations' => 'Çeviriler',
                'Export' => 'Dışa Aktar',
                'Import' => 'İçe Aktar',
                'Save' => 'Kaydet',
                'Cancel' => 'İptal',
                'Delete' => 'Sil',
                'Edit' => 'Düzenle',
                'Add' => 'Ekle',
                'Create' => 'Oluştur',
                'Update' => 'Güncelle',
                'Name' => 'Ad',
                'Code' => 'Kod',
                'Active' => 'Aktif',
                'Default' => 'Varsayılan',
                'Actions' => 'İşlemler',
                'Status' => 'Durum',
                'Yes' => 'Evet',
                'No' => 'Hayır',
                'Success' => 'Başarılı',
                'Error' => 'Hata',
                'Warning' => 'Uyarı',
                'Info' => 'Bilgi',
            ]
        ]
    ]
]; 