<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Production-ready seeding order for KongrePad Conference System
     */
    public function run(): void
    {
        echo "🚀 Starting KongrePad Database Seeding...\n\n";
        
        // STEP 1: Core System Infrastructure
        echo "📋 STEP 1: Core System Infrastructure\n";
        $this->call([
            SystemCountriesSeeder::class,   // 163 countries, 5-language support
            SystemLanguagesSeeder::class,   // 5 essential languages (TR, EN, DE, AR, RU)
        ]);
        
        echo "\n✅ Core system infrastructure ready!\n";
        echo "   • 163 countries with full locale support\n";
        echo "   • 5 essential languages with RTL support\n";
        echo "   • Multi-tenant foundation prepared\n\n";
        
    }
}
