<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemLanguagesSeeder extends Seeder
{
    /**
     * Core multi-language system infrastructure
     * 5 Essential Languages: Turkish, English, German, Arabic, Russian
     */
    public function run(): void
    {
        $languages = [
            // Turkish - Primary Market
            [
                'code' => 'tr',
                'name' => 'Turkish',
                'native_name' => 'Türkçe',
                'is_rtl' => false,
                'flag_icon' => '🇹🇷',
                'is_active' => true,
                'sort_order' => 1,
                'metadata' => json_encode([
                    'priority' => 1,
                    'supported_countries' => ['TR', 'CY'],
                    'market_tier' => 'primary',
                    'locale' => 'tr_TR'
                ]),
            ],
            
            // English - International Standard
            [
                'code' => 'en',
                'name' => 'English',
                'native_name' => 'English',
                'is_rtl' => false,
                'flag_icon' => '🇬🇧',
                'is_active' => true,
                'sort_order' => 2,
                'metadata' => json_encode([
                    'priority' => 2,
                    'supported_countries' => ['GB', 'US', 'AU', 'CA', 'IE', 'NZ', 'ZA', 'IN', 'SG'],
                    'market_tier' => 'primary',
                    'locale' => 'en_US'
                ]),
            ],
            
            // German - European Market
            [
                'code' => 'de',
                'name' => 'German',
                'native_name' => 'Deutsch',
                'is_rtl' => false,
                'flag_icon' => '🇩🇪',
                'is_active' => true,
                'sort_order' => 3,
                'metadata' => json_encode([
                    'priority' => 3,
                    'supported_countries' => ['DE', 'AT', 'CH', 'LI'],
                    'market_tier' => 'primary',
                    'locale' => 'de_DE'
                ]),
            ],
            
            // Arabic - Middle East & North Africa
            [
                'code' => 'ar',
                'name' => 'Arabic',
                'native_name' => 'العربية',
                'is_rtl' => true,
                'flag_icon' => '🇸🇦',
                'is_active' => true,
                'sort_order' => 4,
                'metadata' => json_encode([
                    'priority' => 4,
                    'supported_countries' => ['SA', 'AE', 'EG', 'JO', 'LB', 'KW', 'QA', 'BH', 'OM', 'MA', 'TN', 'DZ', 'IQ', 'SY', 'YE', 'LY', 'SD', 'PS'],
                    'market_tier' => 'primary',
                    'locale' => 'ar_SA',
                    'rtl_support' => true
                ]),
            ],
            
            // Russian - CIS & Eastern Europe
            [
                'code' => 'ru',
                'name' => 'Russian',
                'native_name' => 'Русский',
                'is_rtl' => false,
                'flag_icon' => '🇷🇺',
                'is_active' => true,
                'sort_order' => 5,
                'metadata' => json_encode([
                    'priority' => 5,
                    'supported_countries' => ['RU', 'BY', 'KZ', 'KG', 'UZ', 'TJ', 'MD', 'AM', 'GE'],
                    'market_tier' => 'primary',
                    'locale' => 'ru_RU'
                ]),
            ],
        ];

        echo "🌍 Seeding Core System Languages (5 Languages)...\n";

        foreach ($languages as $language) {
            DB::table('system_languages')->insert([
                'code' => $language['code'],
                'name' => $language['name'],
                'native_name' => $language['native_name'],
                'is_rtl' => $language['is_rtl'],
                'flag_icon' => $language['flag_icon'],
                'is_active' => $language['is_active'],
                'sort_order' => $language['sort_order'],
                'metadata' => $language['metadata'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $rtl = $language['is_rtl'] ? ' (RTL)' : '';
            $countries_count = count(json_decode($language['metadata'], true)['supported_countries']);
            echo "   ✅ {$language['flag_icon']} {$language['native_name']} ({$language['code']}){$rtl} - {$countries_count} countries\n";
        }

        echo "\n📊 Core Language Summary:\n";
        echo "   • Total Languages: " . count($languages) . "\n";
        echo "   • RTL Support: Arabic ✅\n";
        echo "   • Primary Markets: Turkey, International, Germany, MENA, CIS\n";
        echo "   • Coverage: ~95 countries worldwide\n\n";
        echo "🎯 Essential multi-language infrastructure ready!\n\n";
    }
} 