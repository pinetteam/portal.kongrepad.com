<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(SystemCountrySeeder::class);
        $this->call(SystemSettingVariableSeeder::class);
        $this->call(SystemRouteSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(CustomerSettingSeeder::class);
        $this->call(UserRoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MeetingSeeder::class);
        $this->call(DocumentSeeder::class);
        $this->call(ScoreGameSeeder::class);
        $this->call(ScoreGameQrCodeSeeder::class);
        $this->call(MeetingParticipantSeeder::class);
        $this->call(MeetingHallSeeder::class);
        $this->call(MeetingHallProgramSeeder::class);
        $this->call(MeetingHallProgramSessionSeeder::class);
    }
}
